<?php

session_start();

require_once '../../../config/lib.global.php';
require_once DOL_DOCUMENT. '/application/config/main.php'; //el main contiene la sesion iniciada
require_once DOL_DOCUMENT .'/application/system/agenda/class/class_agenda.php';


global  $db , $conf;

$agenda = new admin_agenda($db);

if(isset($_GET['ajaxSend']) || isset($_POST['ajaxSend']))
{
    $accion = GETPOST('accion');

    switch ($accion)
    {
        case 'create_cita_paciente':


            $error = "";

            $row = GETPOST('datos');

            $agenda->fk_paciente    = $row['fk_paciente'];
            $agenda->comentario     = $row['comment'];
            $agenda->fk_login_users = $conf->login_id; #USUARIO LOGEADO
            $agenda->detalle        = $row['detalle'];

//            print_r($agenda); die();
            $error = $agenda->GenerarCitas();

            $output = [
              'error' => $error
            ];

            echo json_encode($output);

            break;


        case 'listCitas':

            $estados = GETPOST("estados");
            $doctor  = GETPOST("doctor");
            $fecha   = GETPOST("fecha");
            $MostrarCitasCanceladasEliminadas = GETPOST('eliminada_canceladas');

            $fechaInicio ="";
            $fechaFin    ="";
            if(!empty($fecha))
            {
                $fecha   = explode('-',GETPOST("fecha"));
                $fechaInicio = date("Y-m-d", strtotime( str_replace("/", "-", trim($fecha[0]))));
                $fechaFin    = date("Y-m-d", strtotime( str_replace("/", "-", trim($fecha[1]))));
            }

//            print_r($fechaFin.'   '. $fechaInicio); die();
            $numerosEstados="";
            if(is_array($estados)){
                $numerosEstados = implode(',', $estados);
            }

            $rows = list_citas($doctor,$numerosEstados, $fechaInicio, $fechaFin, $MostrarCitasCanceladasEliminadas );

            $output = [
                'data' => $rows,
            ];

            echo json_encode($output);

            break;

        case 'EstadoslistCitas':


            $idestado   = GETPOST('idestado'); //ID ESTADO
            $idcita_det = GETPOST('idcita'); // ID DE LA CITA
            $textEstado = GETPOST('estadoText'); //text estado

            $error = "";

            $sqlUpdateEstado = "UPDATE `tab_pacientes_citas_det` SET `fk_estado_paciente_cita` = $idestado WHERE (`rowid` = $idcita_det);";
            $rs = $db->query($sqlUpdateEstado);

            if($rs)
            {
                $error = "Estado $textEstado: información Actualizada";
            }

            $output = [
                'resp' => $error,
            ];

            echo json_encode($output);
            break;

        case 'validacionFechasCitas':

            $resp = true;

            $fecha = "";
            $duracion = "";
            $hora = "";
            $fk_doc = "";
            $fechaFin = "";
            $fechaInicio = "";
            $horaFin = "";
            $horaInicio = "";

            $fecha     = date("Y-m-d", strtotime(str_replace('/','-', GETPOST("fecha"))));
            $hora      = GETPOST("hora");
            $duracion  = GETPOST("duracion");
            $fk_doc    = GETPOST("fk_doc");

            $fechaInicio = "$fecha $hora:00";
            $fechaFin    = strtotime("+$duracion minute", strtotime($fechaInicio));

            $horaFin     = date("H:i:s", $fechaFin);
            $horaInicio  = $hora.":00";

//            print_r($fecha ." == ".$horaFin .' == '.$horaInicio);


            $sql = "SELECT fk_doc, fecha_cita, hora_cita, hora_inicio, hora_fin 
                    FROM tab_pacientes_citas_det WHERE fk_doc = $fk_doc 
                    and fecha_cita   = '$fecha'
                    and hora_inicio <= '$horaFin'
                    and hora_fin    >= '$horaInicio' ";

//            echo '<br><pre>';
//            print_r($sql);
//            die();

            $rs = $db->query($sql);

            if($rs->rowCount() > 0) //ESTE PACIENTE TIENE ASIGANADA YA ESTA FECHA Y HORA DE CITA
            {
                $resp = false;
            }

            echo json_encode($resp);

            break;

        case "Numero_Citas":

            $numero=0;

            #NUMEROS DE CITAS PARA LA FECHA ACTUAL CON ESTADO NO CONFIRMADO - ID DEL ESTADO == 2
            $sqlCount = "select 
                            count(*) as nu
                        from 
                        tab_pacientes_citas_cab c , tab_pacientes_citas_det d ,  tab_pacientes_estado_citas s 
                        where  c.rowid = d.fk_pacient_cita_cab and d.fk_estado_paciente_cita = s.rowid and c.rowid > 0 ";
            $sqlCount .= " and d.fk_estado_paciente_cita = 2 and d.fecha_cita = '".date('Y-m-d')."' ";
            $sqlCount .= " limit 1";

            $rs1 = $db->query($sqlCount);

            if($rs1->rowCount() > 0)
            {
                $numero = $rs1->fetchObject()->nu;
            }

//            print_r($sqlCount);
//            die();

            echo json_encode($numero);
            break;

        case "consul_hora_fecha_listglobal":

            $puedo   = false;
            $detalle = [];

            #se declara las fechas y horas
            $fecha   = GETPOST("fecha");
            $hora    = GETPOST("hora");
            $doctor  = GETPOST("doctor");
            $estados = !empty(GETPOST("estados")) ? GETPOST("estados") : [];

            $error = fecth_diariaHorasGlobal($fecha, $hora, $doctor, false, $estados);

            $output = [
                'data' => $error
            ];

            echo json_encode($output);
            break;


            /* CREAR PLAN DE TRATAMIENTO */
        case "nuevoUpdatePlantratamiento":

            $msg  = '';
            $error = '';
            $idtratamiento = 0;

            $idpaciente = GETPOST('idpaciente');

            #ASOCIAR CITA A UN PLAN DE TRATAMIENTO
            #CUANDO LA CITA SEA
            $idcita                = ( GETPOST('idcitadet') == "") ? 0: GETPOST('idcitadet'); #EL ID DE LA CITA PUEDE SER 0 O MAYOR A 0
            $iddoctor              = GETPOST('iddoct');
            $idplantramAsociarCita = GETPOST('idplantramAsociar');  #PARA ASOCIAR CITA DE UN PLAN DE TRATAMIENTO YA REALIZADO

            $subaccion = GETPOST('subaccion');

//            print_r('doctor - ');
//            print_r($iddoctor);
//            echo '<br>';
//            print_r('cita - ');
//            print_r($idcita);
//            die();

            #SE VALIDA LA CITA EN CASO DE REPETIR LA ASOCIACION AL PLAN DE TRATAMIENTO
            if($idcita != 0)
            {
                # 0 NO ESTA ASOCIADA A NINGUN PLAN DE TRATAMIENTO
                # SI LA CITA ES MAYOR A 0 ESTA ASOCIADA A PLAN DE TRATAMIENTO
                $list_plantramAsociados = [];
                $sqlCitaAsociada = "SELECT * FROM tab_plan_tratamiento_cab where fk_cita = $idcita";
                $rslCita = $db->query($sqlCitaAsociada);
                if($rslCita->rowCount() > 0)
                {

                    while($objtram = $rslCita->fetchObject())
                    {
                        $label = "";
                        if( $objtram->edit_name != "" ){

                            $label = $objtram->edit_name.  "\n";
                        }else{
                            $label = "Plan de Tratamiento ". $objtram->numero. "\n";
                        }

                        $list_plantramAsociados[] = $label;

                    }

                    $error = "<p> Esta Cita ya se encuentra asociada con el plan de tratamiento  numero : <b>" . implode(',', $list_plantramAsociados) ."</b> </p>";
                }

            }

            if($subaccion == 'ASOCIAR_CITAS' && empty($error))
            {
                $sqlP = "UPDATE `tab_plan_tratamiento_cab` SET `fk_doc`= $iddoctor, `fk_cita`= $idcita WHERE `rowid`= $idplantramAsociarCita;";
                $rsP = $db->query($sqlP);
                if(!$rsP){
                    $error = 'Ocurrio un error no se pudo asociar la cita a este plan de tratamiento';
                }



            }

            #CREA EL PLAN DE TRATAMIENTO SEA CON UNA CITA ASOCIADA O INDEPENDIENTE
            if($subaccion == "CREATE")
            {

                if($error == ''){

                    $sql1 = "SELECT ifnull(MAX(rowid) + 1, 1) as numero FROM tab_plan_tratamiento_cab";
                    $rs = $db->query($sql1)->fetchObject();

                    $obj1 = $conf->ObtenerPaciente($db, $idpaciente, true);

                    $numero = str_pad($rs->numero, 6, "0", STR_PAD_LEFT);

                    $agenda->tratam_numero  = $numero;
                    $agenda->tratam_fk_doc  = ( $iddoctor == 0 ) ? 0 : $iddoctor;
                    $agenda->tratam_fk_cita = ( $idcita == 0 ) ? 0 : $idcita; #CITA ID
                    $agenda->tratam_fk_paciente = $idpaciente;
                    $agenda->tratam_fk_convenio = $obj1->fk_convenio;
                    $agenda->tratam_ultimacita = "now()"; //FECHA DE CREACION DE LA CITA POR EL MOMENTO
                    $agenda->tratam_detencion = '';
                    $agenda->tratam_estado_tratamiento = 'A'; #ESTADO DEL TRATAMIENTO ACTIVO O INACTIVO
                    $agenda->tratam_situaccion = 'DIAGNÓSTICO';

                    $error = $agenda->create_plantratamientocab();

                    if($error == ''){

                        $idtratamiento = $db->lastInsertId('tab_plan_tratamiento_cab');

                    }

                }
            }


//            echo '<pre>';
//            print_r($idtratamiento);
//            print_r($idcita);
//            die();


            $output = [
                'error'         => $error,
                'idtratamiento' => tokenSecurityId(($idplantramAsociarCita == 0) ? $idtratamiento : $idplantramAsociarCita), #convert id token plan de tratamiento
                'idpacientetoken' => tokenSecurityId($idpaciente)
            ];

//            print_r($output);
//            die();

            echo json_encode($output);
            break;

        /*CREAR PLAN DE TRATAMIENTO DETALLE*/
        case "nuevoUpdatePlanTratamientoDetalle":

            $error = '';
            #id del plan de tratamiento cabezera
            $idplantratamiento = GETPOST("idtratamiento");

            #parametros
            $iddetalleplan     = GETPOST('nuevoUpdatedetId'); #id del detalle del tratamiento
            $idpaciente        = GETPOST('idpaciente');
            $datos             = (object)GETPOST('datos');
            $subaccion         = GETPOST('subaccion');
            $detencion         = GETPOST('detencion');


            if( $idplantratamiento != "" || $idplantratamiento > 0 && $idpaciente != 0)
            {
//                print_r($idplantratamiento);
//                echo '<br>';
//                print_r($idpaciente);
//                die();

                #nuevo detalle
                if( $subaccion == 'create' ){

                    foreach ($datos as $key => $item)
                    {

                        $agenda->tramdet_fk_tramcab = $idplantratamiento;
                        $agenda->tramdet_fk_prestacion  = $item['prestacion'];
                        $agenda->tramdet_fk_diente      = $item['iddiente']; # id diente
                        $agenda->tramdet_jsoncaras      = $item['pieza']; # caras seleccionadas matris de caras seleccionadas
                        $agenda->tramdet_subtotal    = $item['subtotal'];
                        $agenda->tramdet_desconvenio = $item['descConvenio'];
                        $agenda->tramdet_descadicional  = $item['descAdicional'];
                        $agenda->tramdet_total          = $item['total'];
                        $agenda->tramdet_cantidad   = $item['cantidad'];
                        $agenda->tramdet_detencion  = $detencion; #DETENCION TEMPORAL O PERMANENTE
                        $agenda->tramdet_fk_usuario = $conf->login_id; #EL USUARIO QUE LA CREO

//                        print_r($agenda);
//                        die();

                        $error = $agenda->create_plantratamientodet();

                    }

//                    die();

                }

//                die();
                #modificar detalle
                if( $iddetalleplan > 0){

                    foreach ($datos as $key => $item){

                        $agenda->tramdet_fk_tramcab = $idplantratamiento;
                        $agenda->tramdet_fk_prestacion  = $item['prestacion'];
                        $agenda->tramdet_fk_diente      = $item['pieza']['diente'];
                        $agenda->tramdet_jsoncaras      = $item['pieza']['caras']; #matris de caras seleccionadas
                        $agenda->tramdet_subtotal    = $item['subtotal'];
                        $agenda->tramdet_desconvenio = $item['descConvenio'];
                        $agenda->tramdet_descadicional  = $item['descAdicional'];
                        $agenda->tramdet_total          = $item['total'];
                        $agenda->tramdet_cantidad  = $item['cantidad'];


                        $error = $agenda->Updateplantratmdetalle($iddetalleplan);
                    }

                }


            }else{
                $error = 'Ocurrió un error , no se pudo obtener los parametros asignados para crear el detalle de este tratamiento, Consulte con soporte Técnico';
            }

//            print_r($error); die();

            $output = [
                'error'         => $error,
            ];

            echo json_encode($output);
            break;

        case 'envio_email_notificacion':

            $error = '';

            $idpaciente     = GETPOST("idpaciente");
            $idcita         = GETPOST('idcita');  #id de la cita detalle
            $asunto         = GETPOST("asunto");
            $from           = GETPOST("from");
            $to             = GETPOST("to");
            $subject        = GETPOST("subject");
            $message        = GETPOST("message");


            $sqlCitadet     = "SELECT * FROM tab_pacientes_citas_det WHERE rowid = $idcita limit 1";
            $rsuCita = $db->query($sqlCitadet)->fetchObject();

            #Obtengo el objeto conpleto de la cita
            $rowCitasObject = $rsuCita;

            #GENERAR TOKEN E INFORMACION DE LA CLINICA

            /*
            'name_db'      => $conf->EMPRESA->INFORMACION->nombre_db_entity  , 0
            'entity'       => $conf->EMPRESA->INFORMACION->numero_entity        , 1
            'name_clinica' => $conf->EMPRESA->INFORMACION->nombre            , 2
            'logo'         => $conf->EMPRESA->INFORMACION->logo              , 3*/

            $create_token_confirm_citas = [$idcita,$conf->EMPRESA->INFORMACION->nombre_db_entity,$conf->EMPRESA->INFORMACION->numero_entity,$conf->EMPRESA->INFORMACION->nombre,$conf->EMPRESA->INFORMACION->logo];



            $token = tokenSecurityId(json_encode($create_token_confirm_citas));
            $buttonConfirmacion = ConfirmacionEmailHTML( $token );


            $datos = (object)array(
               'idpaciente' =>   !empty($idpaciente) ? $idpaciente : 0,
               'idcita'    => !empty($idcita) ? $idcita : 0,
               'asunto' =>   $asunto,
               'from' =>   $from,
               'to' =>   $to,
               'subject' =>   $subject,
               'message' =>   $message,

                'feche_cita' => $rowCitasObject->fecha_cita ,
                'horaInicio' => $rowCitasObject->hora_inicio ,

                /*INFORMACION DE LA CLINICA*/

                'email'        => $conf->EMPRESA->INFORMACION->email             ,
                'direccion'    => $conf->EMPRESA->INFORMACION->direccion         ,
                'celular'      => $conf->EMPRESA->INFORMACION->celular           ,
            );

//            echo '<pre>';
//            print_r($datos); die();

            $error = notificarCitaEmail($datos, $buttonConfirmacion);

            echo json_encode($error);

            break;

        case 'UpdateComentarioAdicional':

            $error = '';
            $iddetcita       = GETPOST('iddetcita');
            $comment_addicnl = GETPOST('commentAdicional');

            $sql = "UPDATE `tab_pacientes_citas_det` SET `comentario_adicional`='$comment_addicnl' WHERE `rowid`='$iddetcita';";
            $rs = $db->query($sql);

            if(!$rs)
            {
                $error = 'Ocurrio un error al momento de agregar el comentario Adicional';
            }

            $output = [
                'error'         => $error,
            ];

            echo json_encode($output);
            break;
    }

}

function list_citas($doctor, $estado = array(),  $fechaInicio, $fechaFin, $MostrarCitasCanceladasEliminadas)
{

    global $db, $permisos;

    $data = array();

    $fecha_hoy = date("Y-m-d");


    $sql = "select 
            d.fecha_cita  as fecha_cita,
            d.hora_inicio , 
            d.hora_fin ,
            d.rowid  as id_cita_det,
            
            (select concat(p.nombre ,' ',p.apellido) from tab_admin_pacientes p where p.rowid = c.fk_paciente) as paciente,
            (select rowid from tab_admin_pacientes p where p.rowid = c.fk_paciente) as idpaciente,
            (select telefono_movil from tab_admin_pacientes p where p.rowid = c.fk_paciente) as telefono_movil,
            
            (select concat(o.nombre_doc,' ', o.apellido_doc) from tab_odontologos o where o.rowid = d.fk_doc) as doct ,
            (select concat(s.text) from tab_pacientes_estado_citas s where s.rowid = d.fk_estado_paciente_cita) as estado,
            (select s.color from tab_pacientes_estado_citas s where s.rowid = d.fk_estado_paciente_cita) as color,
            d.fk_estado_paciente_cita , 
            c.comentario ,
            (select es.nombre_especialidad FROM tab_especialidades_doc es where es.rowid = d.fk_especialidad) as especialidad,
            
            (select p.telefono_movil from tab_admin_pacientes p where p.rowid = c.fk_paciente) as telefono_movil,
            
            d.fk_doc as iddoctor , 
            (select p.email from tab_admin_pacientes p where p.rowid = c.fk_paciente) as email, 
            d.comentario_adicional as comentario_adicional,
            c.fk_paciente as idpaciente  ,
            
             -- validaciones
             
             -- citas atrazados con estado no confirmado
              if( cast(d.fecha_cita as date) < '".$fecha_hoy."' && d.fk_estado_paciente_cita = 2 , concat('cita agendada atrazada - NO CONFIRMADO - ', date_format(d.fecha_cita, '%Y/%m/%d') , ' - hora ' , d.hora_inicio ) , '') as cita_atrazada
                        
         from 
             tab_pacientes_citas_cab c , tab_pacientes_citas_det d
             where c.rowid = d.fk_pacient_cita_cab ";

    if(!empty($doctor))
    {
        $sql .= " and d.fk_doc = ".$doctor;
    }

    if(!empty($estado))
    {
        $sql .= " and d.fk_estado_paciente_cita in($estado)";
    }

    if(!empty($fechaInicio) && !empty($fechaFin))
    {
        $sql .= " and cast(d.fecha_cita as date) between cast('$fechaInicio' as date) and cast('$fechaFin' as date) ";
    }

    if(!empty($MostrarCitasCanceladasEliminadas)) // Muestro la citas eliminadas y canceladas
    {
        $sql .= " and d.estado = 'E' or  d.fk_estado_paciente_cita = 9 ";
    }

    $sql .= " order by d.fecha_cita desc ";

    $sql .= " ".$permisos->consultar;

//    print_r($sql); die();

    $rs = $db->query($sql);

    if( $rs && $rs->rowCount() > 0 )
    {
        $iu = 0; #acumulador

        while ($acced = $rs->fetchObject())
        {

            $row = array();
            #checked box
            $row[] = "<span class='custom-checkbox-myStyle'>
								<input type='checkbox' id='checked-detalleCitas-$iu' class='checked_detalleCitas'>
								<label for='checked-detalleCitas-$iu' ></label>
                      </span>";



            $numeroCita = "<img  src='". DOL_HTTP. "/logos_icon/logo_default/cita-medica.png' class=' img-sm img-rounded'  >  -";
            $row[] = $numeroCita . str_pad($acced->id_cita_det, 5, "0", STR_PAD_LEFT);

            $html1 = "";
            $html1 .= "<p class='text-center' >".date('Y/m/d', strtotime($acced->fecha_cita))."</p>";
            $html1 .= "<div style='background-color: $acced->color; padding: 3px'>";
                $html1 .= "<p class='text-center'>$acced->hora_inicio</p>";
                $html1 .= "<p class='text-center'><i class='fa fa-arrow-circle-o-down'></i></p>";
                $html1 .= "<p class='text-center'>$acced->hora_fin</p>";
            $html1 .= "</div>";

            $row[] = $html1;

            //PACIENTES - JUNTO CON DROPDONW

            #ID IMPORTANTE YA QUE ES UN TOKEN CREADO COMO UN ID DE LA CITAS GENERADO EN UN BINARIO HEXADECIMAL
            $token = tokenSecurityId( $acced->idpaciente); #ME RETORNA UN TOKEN
            $view  = "dop"; #view vista de datos personales admin pacientes
            $Url_datospersonales = DOL_HTTP ."/application/system/pacientes/pacientes_admin?view=$view&key=".KEY_GLOB."&id=$token";

            $html2 = "";
            $html2 .= "<div class='form-group col-md-12 col-xs-12 col-lg-12 col-sm-12' >";

            $html2 .= "<div class='col-xs-10 col-md-10 '> <i class='fa fa-user'></i> $acced->paciente </div>";
                $html2 .= "
                        <div class='col-xs-2 col-md-2 no-padding pull-right '>
                            <div class='dropdown pull-right'>
                                <button class='btn btnhover  btn-xs dropdown-toggle' type='button' data-toggle='dropdown' style='height: 100%'> <i class='fa fa-ellipsis-v'></i> </button>
                                <ul class='dropdown-menu'>";

                                $tienePlanTratamiento = "";
                                $tieneComentarioadicional = "";

                                $sql2 = "SELECT * FROM tab_plan_tratamiento_cab where fk_cita =  $acced->id_cita_det";
                                $rs2 = $db->query($sql2);
                                if($rs2->rowCount()>0){
                                    $tienePlanTratamiento = "disabled_link3";
                                }

                                if($acced->comentario_adicional != ""){
                                    $tieneComentarioadicional = "disabled_link3";
                                }

                                $html2 .= "<li>   <a style='cursor: pointer; font-size: 1.1rem;' class='$tienePlanTratamiento' onclick='create_plandetratamiento($acced->idpaciente, $acced->id_cita_det, $acced->iddoctor , $(this));'  >Plan de Tratamiento</a> </li>";
                                $html2 .= "<li>   <a style='cursor: pointer; font-size: 1.1rem;' >Recaudación</a> </li>";
                                $html2 .= "<li>   <a style='cursor: pointer; font-size: 1.1rem;' href='". $Url_datospersonales ."' >Datos personales</a> </li>";
                                $html2 .= "<li>   <a style='cursor: pointer; font-size: 1.1rem;' >Cambiar  fecha/cita</a> </li>";

                                $html2 .= "<li>   <a  style='cursor: pointer; font-size: 1.1rem;' data-toggle=\"modal\" data-target=\"#modal_coment_adicional\" onclick='clearModalCommentAdicional($acced->id_cita_det, $(this))' class='$tieneComentarioadicional'  >Agregar Comentario Adicional</a> </li>";

                         $html2 .= "</ul>";
                    $html2 .= "</div> 
                            </div>";
            $html2 .= "</div>";

            #comentario y numero de telefonos
            $html4  = "";
            $html4 .= "<div class='form-group col-md-12 col-xs-12'>
                             <div class='col-xs-12 col-md-12'>";

            #COMENTARIOS OPCIONAL - PACIENTE
            if(!empty($acced->comentario))
            {

                $html4 .= '<span class="text-sm text-justify" title="' .$acced->comentario. '">  
                                <i class="fa fa-x3 fa-comment" style="cursor: pointer" ></i> '. $acced->comentario .'
                            </span> <br>';

            }

            #TELEFONO DEL PACIENTE
            if(!empty($acced->telefono_movil))
            {

                $html4 .= '<span> <i class="fa fa-phone-square" style="cursor: pointer" title=" '. $acced->telefono_movil .' "></i> '. $acced->telefono_movil .'  </span>';

            }

            #CITAS ATRAZADAS CON ESTADO NO CONFIRMADO - ID DEL ESTADO = 2
            if(!empty($acced->cita_atrazada))
            {
                $html4 .= '<small style="color: red; display: block"  class="" title="'. $acced->cita_atrazada .'"> '. $acced->cita_atrazada .' </small>';
            }

            $html4 .= "</div>
                </div>";

            $row[] = $html2 ."".$html4;

            //DOCTOR
            $html5 = "<div class='form-group col-md-12 col-xs-12 col-sm-12'>";
                $html5 .= "<span class='text-left'>Doc(a). $acced->doct</span>";
                $html5 .= "<span class='trunc'> <i class='fa fa-user-md'></i> &nbsp;&nbsp; $acced->especialidad </span>";

                if($acced->comentario_adicional){
                    $html5 .= "<br><small class=' text-sm' title='$acced->comentario_adicional'> <i class='fa fa-comment'></i> &nbsp;&nbsp; $acced->comentario_adicional </small>";
                }
            $html5 .= "</div>";
            $row[] = $html5;

            #DROPDOWN -------------------------------------------------------------------------------------------------
            $html3 = "";
            $html3 .= "<div class='form-group col-md-12 col-xs-12'>
                        <div class='col-xs-12 col-ms-10 col-md-10 no-padding'> 
                            <label for='estadoDropw' class='text-justify' title='$acced->estado' >$acced->estado</label> 
                        </div>";

            $html3 .= "<div class='col-xs-12 col-ms-2 col-md-2 no-padding no-margin'>
                            <div class='dropdown pull-right'>";
//            onclick='menuDropdownCita($(this), 0)'
                $html3 .= "    <button class='btn btnhover  dropdown-toggle btn-xs ' id='estadoDropw' type='button' data-toggle='dropdown' style='height: 100%'> <i class='fa fa-ellipsis-v'></i> </button>";
                        $html3 .= " <ul class='dropdown-menu pull-right'>";

                        $sqlMenuDrowpdown = "SELECT * FROM tab_pacientes_estado_citas";
                        $rsdrown = $db->query($sqlMenuDrowpdown);

                        if($rs->rowCount() > 0)
                        {
                            while ($rowxs = $rsdrown->fetchObject())
                            {
                                $todosdata = "";
                                $dataTelefono = "";
                                $dataEmailPaciente = "";
                                $addclases = "";

                                if($rowxs->rowid == 8) //whatsapp
                                {
                                    $telefono = substr($acced->telefono_movil, 1, 9);
                                    $dataTelefono = "data-telefono='593$telefono'";
                                }

                                if($rowxs->rowid == 1) //notificar por email
                                {
                                    $dataEmailPaciente = "data-email='$acced->email'";
                                }
                                if($rowxs->rowid == 10) //no debe verse el estado confirmado e-mail x paciente - este estado solo lo confirma el paciente
                                {
                                    $addclases .= " hide "; //oculto este estado
                                }

                                    $todosdata .= " ".
                                    $dataTelefono." ".
                                    $dataEmailPaciente." ";

                                if($acced->fk_estado_paciente_cita == $rowxs->rowid )//muestra la cita con el estado seleccionado
                                {
                                    $html3 .= "<li> <a class='activeEstadoCita' $todosdata   style='cursor: pointer; font-size: 1.1rem;' >$rowxs->text</a> </li>";
                                }
                                else{

                                    $html3 .= "<li> <a class=' $addclases '  data-text='$rowxs->text' $todosdata  onclick='EstadosCitas($rowxs->rowid, $acced->id_cita_det, $(this), $acced->idpaciente)' style='cursor: pointer; font-size: 1.1rem;' >$rowxs->text</a> </li>";

                                }
                            }
                        }

                         $html3 .= " </ul>"; #dropdown end

                $html3 .= "</div>";
            $html3 .= "</div> 
            </div>";

            #END DROPDOWN-----------------------------------------------------------------------------------------------
            $row[] = $html3;


            #DIAGNOSTICO O OTROS ESTADOS

            $html6 = "<div class='col-md-12 col-xs-12'>
                        <p class='text-bold'  style='text-align: center !important; color: #333333; font-size: 1.4rem; background-color: #E5E7E9; padding: 3px; border-radius: 3px'> Diagnostico </p>
                    </div>";

            $row[] = $html6;

            $data[] = $row;

            $iu++; #recorrido
        }

    }

    return $data;
}

//Validar fechas
function hourIsBetween($from, $to, $input)
{
    $dateFrom = DateTime::createFromFormat('!H:i', $from);
    $dateTo = DateTime::createFromFormat('!H:i', $to);
    $dateInput = DateTime::createFromFormat('!H:i', $input);
    if ($dateFrom > $dateTo) $dateTo->modify('+1 day');
    return ($dateFrom <= $dateInput && $dateInput <= $dateTo) || ($dateFrom <= $dateInput->modify('+1 day') && $dateInput <= $dateTo);

}

function fecth_diariaHorasGlobal($fecha, $hora, $doctor, $export, $estados)
{
    global $db, $permisos;

    $detalle = array();

    $fechaInicio = date("Y-m-d", strtotime($fecha));

    $sql = "SELECT 
        
        (SELECT 
                CONCAT(p.nombre, ' ', p.apellido)
            FROM
                tab_admin_pacientes p
            WHERE
                p.rowid = c.fk_paciente) AS paciente,
        (SELECT 
                CONCAT(o.nombre_doc, ' ', o.apellido_doc)
            FROM
                tab_odontologos o
            WHERE
                o.rowid = d.fk_doc) AS doctor,
        (SELECT 
                p.rut_dni
            FROM
                tab_admin_pacientes p
            WHERE
                p.rowid = c.fk_paciente) AS rudcedula,
        (SELECT 
                p.telefono_movil
            FROM
                tab_admin_pacientes p
            WHERE
                p.rowid = c.fk_paciente) AS telefonoMobil,
        c.comentario AS observacion,
        d.duracion,
        d.fecha_cita,
        d.hora_cita,
        d.hora_fin,
        (SELECT 
                s.nombre_especialidad
            FROM
                tab_especialidades_doc s
            WHERE
                s.rowid = d.fk_especialidad) AS especialidad
        FROM
        tab_pacientes_citas_det d,
        tab_pacientes_citas_cab c
        WHERE
        d.fk_pacient_cita_cab = c.rowid  
        ";

    if( $fecha != ''){
        $sql .= " and date_format(d.fecha_cita, '%Y-%m-%d') = '$fechaInicio' ";
    }

    if($doctor != ''){
        $sql .= " and d.fk_doc = $doctor";
    }

    if(count($estados) > 0 || !empty($estados)){
        $sql .= " and d.fk_estado_paciente_cita in( ". implode(',', $estados) . ") ";
    }

//    print_r($estados);
    $sql .= " ".$permisos->consultar;
    $rs = $db->query($sql);
//    print_r($sql);
    if($rs && $rs->rowCount()>0)
    {
        while ($row = $rs->fetchObject())
        {
            if($export==true)
            {
                $detalle[] = $row;
            }else{

                $row12 = array();

                $row12[] = $row->hora_cita;
                $row12[] = $row->doctor;
                $row12[] = $row->paciente;
                $row12[] = $row->rudcedula;
                $row12[] = $row->telefonoMobil;
                $row12[] = $row->especialidad;

                $info = "";
                if($row->observacion != ""){
                    $info = "<a href='#' style='display:inline-block' title='información'> <i class='fa fa-info-circle'></i>";
                }
                $row12[] = "<p class='trunc' style='width: 220px; display:inline-block'> $info </a> $row->observacion</p>" ;

                $detalle[] = $row12;
            }

        }

    }

    return $detalle;
}

function notificarCitaEmail($datos, $token_confirmacion)
{

    global $db, $conf, $user;

//    print_r($token_confirmacion); die();
    require_once DOL_DOCUMENT .'/public/lib/PHPMailer2/src/Exception.php';
    require_once DOL_DOCUMENT .'/public/lib/PHPMailer2/src/PHPMailer.php';
    require_once DOL_DOCUMENT .'/public/lib/PHPMailer2/src/SMTP.php';

    $error = '';

    $asunto     = $datos->asunto;
    $from       = $datos->from;
    $to         = $datos->to;
    $message    = $datos->message;
    $subject    = $datos->subject;

    $labelPaciente = getnombrePaciente($datos->idpaciente)->nombre.' '.getnombrePaciente($datos->idpaciente)->apellido;

//    echo '<pre>';
//    print_r($conf->EMPRESA->INFORMACION->conf_email);
//    print_r($conf->EMPRESA->INFORMACION->conf_password);
//    die();

    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

    #verifico si el email de acceso esta correcto
    if($conf->EMPRESA->INFORMACION->conf_email != ""){

        try{

            $mail->SMTPDebug = 0;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;

            // Enable SMTP authentication
            #acceso de envio
            $mail->Username   = trim($conf->EMPRESA->INFORMACION->conf_email);             // SMTP username
            $mail->Password   = trim($conf->EMPRESA->INFORMACION->conf_password);                               // SMTP password
            $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port       = 587;


            //Recipients
            $mail->setFrom($conf->EMPRESA->INFORMACION->conf_email, $conf->EMPRESA->INFORMACION->nombre);
            $mail->addAddress($to);     // Add a recipient

            /*$mail->addAddress('ellen@example.com');               // Name is optional
            $mail->addReplyTo('info@example.com', 'Information');
            $mail->addCC('cc@example.com');
            $mail->addBCC('bcc@example.com');*/

            /*
            // Attachments Enviar Archivos
            $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name */

            $messabody = "";
            if($message!=""){
                $messabody = "<br><b>Mensaje:</b>&nbsp; ". utf8_decode($message) ." <br>";
            }

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = utf8_decode($subject);
            $mail->Body    = "<div> <b>Estimado/a:</b>&nbsp;$labelPaciente  <br><br><br>
                                Le recordamos que tiene una cita agendada para la fecha - <b>". GET_DATE_SPANISH(date('Y-m-d', strtotime($datos->feche_cita))) ." - hora ". $datos->horaInicio . "</b>   
                                
                                      ". $messabody ."
                                
                                    <br>
                                    <br>
                                    <br>
                                    ". $token_confirmacion ."
                                    <br>
                                    <br>
                                    <br>
                                    <b>".utf8_decode('Dirección:')."</b>&nbsp; ". $datos->direccion ."
                                    <br>
                                    <b>".utf8_decode('Teléfono:')."</b>&nbsp;  ". $datos->celular ."
                                    <br>
                                    <br>
                                    
                                </div>"; #envio un formulariode confirmacion
            $mail->AltBody = "";

//            echo '<pre>';
//            print_r($mail); die();
            $error = $mail->send();

            //emael no enviado
            if($error == 0){
                $error = 'Ocurrio un problema con el servidor no pudo enviar el correo, intentelo de nuevo o consulte con soporte Tecnico';
            }

        }catch (Exception $e){
            $error = 'Ocurrio un error con la Operación " Notificar por e-mail " verifique el e-mail o Consulte con soporte Tecnico - ' . $mail->ErrorInfo .' - Error : Acceso de aplicaciones poco seguras - https://myaccount.google.com/u/1/lesssecureapps?rapt=AEjHL4MUc6sVgag8QGQq-fdisl2F5kETOCyzfQXY51-RqKtpVrpX3CsW1tPL-IWkXzK6LerTnHSPxirTQ3OrLtppXWFrXKwegg';
        }

    }else{

        $error = 'No esta asignado el acceso de e-mail';
    }

    $error_insert_notific_email = "";
    if($error == '' || $error == true){

        $sql = "INSERT INTO `tab_notificacion_email` (`asunto`, `from`, `to`, `subject`, `message`, `estado`, `fk_paciente`, `fk_cita`, `fecha`) ";
        $sql .= "VALUES (";
        $sql .= "'$asunto' ,";
        $sql .= "'$from' ,";
        $sql .= "'$to' ,";
        $sql .= "'$subject' ,";
        $sql .= "'$message' ,";
        $sql .= "'A' ,";
        $sql .= "'$datos->idpaciente' ,";
        $sql .= "'$datos->idcita' ,";
        $sql .= " now() ";
        $sql .= ");";

//        print_r($sql);
//        die();
        $rs = $db->query($sql);
        if(!$rs){
            $error_insert_notific_email = 'Ocurrio un error, el sistema no logro registrar el correo enviado';
        }

    }

    $Ouput = [

        'registrar'   => $error_insert_notific_email ,
        'error_email' => ($error == true) ? "" : $error

    ];

//    print_r($Ouput);
//    die();
    return $Ouput;

}

?>