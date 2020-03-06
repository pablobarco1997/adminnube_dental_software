<?php

session_start();

include_once '../../../../../config/lib.global.php';
require_once DOL_DOCUMENT .'/application/config/main.php';

global  $db , $conf;

if(isset($_GET['ajaxSend']) || isset($_POST['ajaxSend']))
{

    $accion = GETPOST('accion');

    switch ($accion)
    {
        case 'listpagos_indepent':

            $idpaciente = GETPOST('idpaciente');

            $respuestas_pagos = list_pagos_independientes($idpaciente);

            $Output = [
                'data' => $respuestas_pagos
            ];

            echo json_encode($Output);

            break;


        case 'listaprestaciones_apagar':

            $idpaciente = GETPOST('idpaciente');
            $idplantram = GETPOST('idplantram');

            $respuestas_pagos = listPrestacionesApagar($idpaciente, $idplantram);

            $Output = [
                'data' => $respuestas_pagos
            ];

            echo json_encode($Output);
            break;


        case 'realizar_pago_independiente':

            $datos           = GETPOST('datos');
            $tipo_pago       = GETPOST('tipo_pago');
            $n_fact_bolet    = GETPOST('n_fact_bolet');
            $amount_total    = GETPOST('amount_total');
            $observa         = GETPOST('observ');
            $idpaciente      = GETPOST('idpaciente');
            $idplancab      = GETPOST('idplancab');

            $datosp['datos']        = $datos;
            $datosp['t_pagos']      = $tipo_pago;
            $datosp['nfact_boleto'] = $n_fact_bolet;
            $datosp['amoun_t']      = $amount_total;
            $datosp['observ']       = $observa;

            $respuesta = realizar_PagoPacienteIndependiente( $datosp, $idpaciente, $idplancab );

            $Output = [
                'error' => $respuesta
            ];

            echo json_encode($Output);
            break;
    }




}


function list_pagos_independientes($idpaciente = 0)
{

    global  $db , $conf;

    $data = array();

    $sqlpagos = "SELECT 

                cast(ct.fecha_create as date) fecha_create,       
                ct.rowid  as idplantratamiento, 
                -- NUMERO DE PLAN DE TRATAMIENTO
                ifnull(ct.edit_name, concat('Plan de Tratamiento N.' , ' ', ct.numero)) as name_tratamm, 
                -- CITAS ASOCIADAS
                (select numero from tab_pacientes_citas_det c where c.rowid = ct.fk_cita limit 1) cita  , 
                -- TOTAL DE PRESTACIONES
                (SELECT 
                        ifnull(round(SUM(dt.total), 2), 0) AS totalprestaciones
                    FROM
                        tab_plan_tratamiento_det dt
                    WHERE
                        dt.fk_plantratam_cab = ct.rowid
                ) AS totalprestaciones    , 
                
                
                -- TOTAL DE LAS PRESTACIONES REALIZADAS
                (SELECT 
                        ifnull(round(SUM(dt.total), 2), 0) AS totalprestaciones
                    FROM
                        tab_plan_tratamiento_det dt
                    WHERE
                        dt.fk_plantratam_cab = ct.rowid and dt.estadodet = 'R'
                ) AS totalprestaciones_realizadas ,
                
                -- TOTAL PAGADO - y las que tenga saldo
                (SELECT round(sum(pd.amount),2) saldo FROM tab_pagos_independ_pacientes_det pd where pd.fk_plantram_cab = ct.rowid and pd.fk_paciente = ct.fk_paciente) as totalpresta_pagadasSaldo 
                        
                        FROM
                            tab_plan_tratamiento_cab ct where  ct.estados_tratamiento in('A', 'S')  and ct.fk_paciente = $idpaciente";

//    ECHO '<PRE>';
//    print_r($sqlpagos); die();

    $rspagos = $db->query($sqlpagos);

    if( $rspagos && $rspagos->rowCount() > 0 )
    {
        while( $objpagos = $rspagos->fetchObject() )
        {
            $row = array();

            $pay_dom = ""; 
            if(1 == 1)
            {
                $pay_dom = "<div class='form-group col-md-12 col-xs-12'> 
                                <a href='". DOL_HTTP ."/application/system/pacientes/pacientes_admin/?view=pagospaci&key=". KEY_GLOB ."&id=". tokenSecurityId($idpaciente) ."&v=paym_pay&idplantram=". $objpagos->idplantratamiento ." ' class='btn btnhover'> <img src='". DOL_HTTP ."/logos_icon/logo_default/ahorrar-dinero.png' class='img-sm img-rounded' alt=''> </a>
                            </div>";

            }

            $row[] = $pay_dom;
            $row[] = $objpagos->fecha_create;
            $row[] = $objpagos->name_tratamm;
            $row[] = "<img  src='". DOL_HTTP. "/logos_icon/logo_default/cita-medica.png' class='img-sm img-rounded'  > - " . (($objpagos->cita == "") ? "No asignada" : $objpagos->cita);
            $row[] = "<span class='' style='padding: 5px; border-radius: 5px; font-weight: bolder; background-color: #66CA86'> <i class='fa fa-dollar'></i> $objpagos->totalprestaciones </span>  ";
            $row[] = "<span class='' style='padding: 5px; border-radius: 5px; font-weight: bolder; background-color: #ffcc00'> <i class='fa fa-dollar'></i> $objpagos->totalprestaciones_realizadas </span>  ";

            #pago o saldo ++
            $row[] = "<span class='' style='padding: 5px; border-radius: 5px; font-weight: bolder; background-color: #66CA86'> <i class='fa fa-dollar'></i> ". (($objpagos->totalpresta_pagadasSaldo==null) ? "0.00" : $objpagos->totalpresta_pagadasSaldo) ." </span>  ";

            $row[] = "";

            $data[] = $row;
        }
    }

    return $data;
}


function listPrestacionesApagar($idpaciente, $idplantram)
{
    global  $db, $conf;

    $data = array();

    $sql = "SELECT            
                dt.rowid iddetplantram,
                ct.rowid idcabplantram,   
                dt.fk_prestacion , 
                ct.fk_paciente as paciente,  
                dt.fk_diente as diente,           
                
                dt.estado_pay , 
                -- PRESTACION
                cp.descripcion prestacion ,  
                
                dt.estadodet , 
                
                IF(dt.estadodet = 'R',
                    'Realizada',
                    'Pendiente') AS estadoprestacion,
                
                -- TOTAL    
                ROUND(dt.total, 2) AS totalprestacion , 
                
                 -- ABONADO
                 (select ifnull(round(sum(pd.amount),2),0) from tab_pagos_independ_pacientes_det pd 
                      where 
                    pd.fk_plantram_cab = ct.rowid and 
                    pd.fk_plantram_det = dt.rowid
                 ) as abonado 
                
            FROM
            
                tab_conf_prestaciones cp    ,
                tab_plan_tratamiento_cab ct ,
                tab_plan_tratamiento_det dt
                
            WHERE
            
                ct.rowid = dt.fk_plantratam_cab
                AND cp.rowid = dt.fk_prestacion
                
                    AND ct.fk_paciente = $idpaciente
                    
                    AND ct.rowid = $idplantram 
                    -- muestra las pagasdas PE   and   las que tienen saldo PS
                    AND dt.estado_pay IN('PE', 'PS') 
                    order by dt.rowid desc";

//    echo '<pre>';
//    print_r($sql); die();
    $resul = $db->query($sql);

    if($resul && $resul->rowCount() > 0)
    {
        $i = 0;
        while($objPrest =   $resul->fetchObject() )
        {

            $row = array();

            $estadoDetPresta = "";
            #R => REALIZADO
            if($objPrest->estadodet == 'R'){
                $estadoDetPresta = '
                    <span class="" style="padding: 5px; border-radius: 5px; font-weight: bolder; background-color: #33C4FF">    
                             '. $objPrest->estadoprestacion .'    </a> 
                    </span>';
            }
            #A => PENDIENTE
            if($objPrest->estadodet == 'A'){
                $estadoDetPresta = '
                    <span class="" style="padding: 5px; border-radius: 5px; font-weight: bolder; background-color: #DCF36D">    
                             '. $objPrest->estadoprestacion .'    </a> 
                    </span>';
            }

            $apagar = '<span class="" style="padding: 5px; border-radius: 5px; font-weight: bolder; background-color: #66CA86">    
                            <i class="fa fa-dollar"></i> 
                            <a style="color: #333333 !important;" class="total_apagar"> '. $objPrest->totalprestacion .' </a> 
                       </span>
                            ';

            $row[] = '<span class="custom-checkbox-myStyle">
                            <input type="checkbox" onchange="IngresarValorApagar($(this), \'checkebox\');" class="check_prestacion" id="checkeAllCitas-'.$i.'">
                            <label for="checkeAllCitas-'.$i.'"></label>
                    </span> ';


            $row[] = "<p class='prestaciones_det' data-idprest='$objPrest->fk_prestacion' data-iddetplantram='$objPrest->iddetplantram' data-idcabplantram='$objPrest->idcabplantram'> $objPrest->prestacion 
                            &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp; <img src='".DOL_HTTP."/logos_icon/logo_default/diente.png' width='17px' height='17px'>    $objPrest->diente           
                        </p>";

            $val_pendiente = number_format(( $objPrest->totalprestacion - $objPrest->abonado ), 2, '.', '');

            $row[] = $apagar; //total de la prestacion del tratamiento
            $row[] = '<a style="color: #333333 !important;" class="Abonado"> '. $objPrest->abonado .' </a>'; //ABONADO
            $row[] = '<a style="color: #333333 !important;" class="Pendiente"> '. $val_pendiente .' </a>'; //PENDIENTE
            $row[] = $estadoDetPresta; //estado prestacion
            $row[] = "<input type='text' value='0.00' class='form-control input-sm Abonar' onkeyup='moneyPagosInput($(this))'  onfocus='moneyPagosInput($(this))'  style='background-color: #f0f0f0; border-radius: 5px; font-weight: bolder; font-size: 1.3rem; color: black'>
                        <small style='color: red; display: block' class='error_pag'></small> ";

            $data[] = $row;

            $i++;
        }
    }

    return $data;
}


function realizar_PagoPacienteIndependiente( $datos, $idpaciente, $idplancab )
{

    global  $db, $conf;

    $idpacgos = 0;
    $datosdet   = $datos['datos'];

    $t_pagos          = $datos['t_pagos'];
    $observacion      = !empty($datos['observ']) ? $datos['observ'] : "";
    $amoun_t          = $datos['amoun_t'];
    $nfact_boleto     = !empty($datos['nfact_boleto']) ? $datos['nfact_boleto'] : 0;

    $sql1  = " INSERT INTO `tab_pagos_independ_pacientes_cab` ( `fecha`, `fk_tipopago`, `observacion`, `monto`, n_fact_boleta, fk_plantram, fk_paciente, id_login)";
    $sql1 .= " VALUES( ";
    $sql1 .= " now() ,";
    $sql1 .= " $t_pagos ,";
    $sql1 .= " '$observacion' ,";
    $sql1 .= " $amoun_t ,";
    $sql1 .= " '$nfact_boleto',  ";
    $sql1 .= " $idplancab , ";
    $sql1 .= " $idpaciente , ";
    $sql1 .= " $conf->login_id  ";
    $sql1 .= ")";
//    echo '<pre>';
//    print_r($sql1); die();
    $rsPagos = $db->query($sql1);

    $idpacgos = $db->lastInsertId('tab_pagos_independ_pacientes_cab');

    if($rsPagos){

        for ( $i = 0; $i <= count($datosdet) -1; $i++ )
        {
            $sql2  = " INSERT INTO `tab_pagos_independ_pacientes_det` (`feche_create`, `fk_paciente`, `fk_usuario`, `fk_plantram_cab`, `fk_plantram_det`, `fk_prestacion`, `fk_tipopago`, `amount`, fk_pago_cab)";
            $sql2 .= " VALUES(";
            $sql2 .= " now(),";
            $sql2 .= " $idpaciente,";
            $sql2 .= " $conf->login_id,";
            $sql2 .= " ". $datosdet[$i]['idcabplantram'] .",";
            $sql2 .= " ". $datosdet[$i]['iddetplantram'] .",";
            $sql2 .= " ". $datosdet[$i]['fk_prestacion'] .",";
            $sql2 .= " $t_pagos ,";
            $sql2 .= " ". $datosdet[$i]['valorAbonar'] ." ,";
            $sql2 .= " $idpacgos ";
            $sql2 .= ")";

            $rs2 = $db->query($sql2);

            //UPDATE PAGOS tab_plan_tratamiento_det
            // PE => pago pendiente
            // PA => Pagado
            // PS => saldo

        }

        //Consulto los pagos que este y actualizo el estado si ya esta pagada o solo haya saldo
        $sql3 = "SELECT 
                 c.fk_paciente,
                 d.rowid iddetplantram ,
                 c.rowid idcabplantram ,
                 round(d.total, 2) as totalprestacion , 
                 
                 (select ifnull( round(sum(pd.amount), 2),0 ) from tab_pagos_independ_pacientes_det pd where pd.fk_paciente = $idpaciente 
                                and pd.fk_plantram_cab = c.rowid and pd.fk_plantram_det = d.rowid) as pagado ,
                 
                 if( round(d.total, 2) = (select ifnull( round(sum(pd.amount), 2),0 ) from tab_pagos_independ_pacientes_det pd where pd.fk_paciente = $idpaciente 
					and pd.fk_plantram_cab = c.rowid and pd.fk_plantram_det = d.rowid) 
					, 'pagado' , 
	
                 if((select ifnull( round(sum(pd.amount), 2),0 ) from tab_pagos_independ_pacientes_det pd where pd.fk_paciente = $idpaciente 
                            and pd.fk_plantram_cab = c.rowid and pd.fk_plantram_det = d.rowid) = 0 
                            , 'pendiente', 'saldo')		
                    ) as estado
                 
                FROM tab_plan_tratamiento_det d , tab_plan_tratamiento_cab c 
                where d.fk_plantratam_cab = c.rowid 
                and c.fk_paciente = $idpaciente
                and c.rowid = $idplancab";
        $rs3  = $db->query($sql3);
        if($rs3){

            while ( $ob3 = $rs3->fetchObject() ){

                if( $ob3->estado == 'pagado'){ //prestacion pagado

                    $sql3 = "UPDATE `tab_plan_tratamiento_det` SET `estado_pay`='PA' WHERE `rowid`= ". $ob3->iddetplantram ." and fk_plantratam_cab =  ". $ob3->idcabplantram ." ;";
                    $db->query($sql3);
                }
                if( $ob3->estado == 'saldo') //Saldo abonado
                {
                    $sql3 = "UPDATE `tab_plan_tratamiento_det` SET `estado_pay`='PS' WHERE `rowid`= ". $ob3->iddetplantram ." and fk_plantratam_cab =  ". $ob3->idcabplantram ." ;";
                    $db->query($sql3);
                }
            }


            #Esta variable si detecta un saldo o una prestacion que no se apagado aun entonces esta variable lo detecta
            $Apagar_plantram = 0;
            $hay_saldo       = 0;

            $sqlPagada  = "SELECT d.fk_prestacion , d.estado_pay as estado_pagado , round(d.total, 2) as total FROM tab_plan_tratamiento_cab c , tab_plan_tratamiento_det d where c.rowid = d.fk_plantratam_cab 
                              AND c.rowid = $idplancab and c.fk_paciente = $idpaciente";
            $rsPag      = $db->query($sqlPagada);

            if( $rsPag && $rsPag->rowCount()>0){
                while ( $pag = $rsPag->fetchObject() )
                {
                    if( $pag->estado_pagado == 'PE' ){ //Pago pendiente no hay saldo abonado
                        $Apagar_plantram++;
                        $hay_saldo++;
                    }

                    if( $pag->estado_pagado == 'PS' ){ //Saldo Abonado
                        $Apagar_plantram++;
                        $hay_saldo++;
                    }

                }
            }

            # PLAN DE TRATAMIENTO CABEZERA
            # A = PENDIENTE
            # N = ANULADO
            # S = SALDO

            //plan de tratamiento pagado completo
            /*if( $Apagar_plantram == 0)
            {
                $sqlComplePagTram = "UPDATE `tab_plan_tratamiento_cab` SET situacion = 'PAGADO' , estados_tratamiento = 'P' WHERE `rowid`='$idplancab';";
                $db->query($sqlComplePagTram);
            }*/

            if($hay_saldo > 0)
            {
                $sqlComplePagTram = "UPDATE `tab_plan_tratamiento_cab` SET situacion = 'SALDO' , estados_tratamiento = 'S' WHERE `rowid`='$idplancab';";
                $db->query($sqlComplePagTram);
            }
        }

        return 1;

    }else{
        return 'Ocurrio un error no se guardar el pago';
    }
}


?>