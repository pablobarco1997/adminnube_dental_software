<?php

session_start();

require_once '../../../../config/lib.global.php';
require_once DOL_DOCUMENT .'/application/config/main.php';
require_once DOL_DOCUMENT .'/application/system/pacientes/class/class_paciente.php';


$paciente = new Pacientes($db); //se declara la clase de pacientes

//$db->set_charset("utf8");
//mysqli_set_charset($db, );

if(isset($_GET['ajaxSend']) || isset($_POST['ajaxSend']))
{
    $accion = GETPOST('accion');

    switch($accion)
    {

        case 'updatePaciente':

            $error = "";
            $logo  = "";
            $nameIcon = "";
            $name = "";
            $id = GETPOST('id');

            if(isset($_FILES['file_icon']) && $_FILES['file_icon']['name'] != ""){
                $logo = $_FILES['file_icon'];

                $type = "";
                switch ($logo['type'])
                {
                    case 'image/png':
                        $type = '.png';
                        break;
                }

                $name = "icon_paciente-datos_personales-$id".$type;

                $rs = UploadFicherosLogosEntidadGlob($name, $type, $logo['tmp_name']);

                if($rs == false){
                    $error = "La información se actualizo, pero Ocurrió un problema al subir el icono del paciente";
                }

            }

//            print_r($_FILES['file_icon']['name']); die();

            $paciente->nombre       = GETPOST('nombre');
            $paciente->apellido     = GETPOST('apellido');
            $paciente->rud_dni      = GETPOST('rud_dni');
            $paciente->email        = GETPOST('email');
            $paciente->convenio     = GETPOST('convenio');
            $paciente->n_interno    = GETPOST('n_interno');
            $paciente->sexo         = GETPOST('sexo');
            $paciente->fech_nacimit = GETPOST('fech_nacimit');
            $paciente->ciudad       = GETPOST('ciudad');
            $paciente->comuna       = GETPOST('comuna');
            $paciente->direcc       = GETPOST('direcc');
            $paciente->t_fijo       = GETPOST('t_fijo');
            $paciente->t_movil      = GETPOST('t_movil');
            $paciente->act_profec   = GETPOST('act_profec');
            $paciente->empleado     = GETPOST('empleado');
            $paciente->obsrv        = GETPOST('obsrv');
            $paciente->apoderado    = GETPOST('apoderado');
            $paciente->refer        = GETPOST('refer');
            $paciente->icon         = $name; #icon de la imagen del paciente

            $error = $paciente->UpdatePaciente($id);

            if(!empty($error))
            {
                $error = 'Ocurrió un problema con la Operación, contacte con soporte tecnico';
            }

            $output = [ 'error' => $error ];

            echo json_encode($output);

            break;

        case 'fetchPaciente':

            $resp  = array();
            $data  = array();

            $error = '';
            $id = GETPOST('id');

            if(!empty($id)){

                $resp = $paciente->fectch_pacientes($id);

                if(count($resp) == 0)
                {
                    $error = 'Ocurrio un error No se Encontraron datos de este paciente, Consulte con soporte';
                }else{

                    $data = $resp[0];
                }

            }else{
                $error = 'Ocurrio un error no se pudo obtener los datos - no se encuentra el id';
            }


            $output = [
              'error' =>  $error,
              'data'  =>  $data ,
            ];

            echo json_encode($output);

            break;

        case 'cargaFamiliares_list':

            $data = array();

            $rs = "";

            $output = [
                'data' => $data
            ];

            echo json_encode($output);
            break;

        case 'Ficheros_pacientes':

            $data = array();

            $idpaciente = GETPOST('idpaciente');
            $sql = "select
                    c.rowid ,
                    fecha_creat,
                    titulo ,
                    (select nombre_doc from tab_odontologos where rowid = c.fk_doc) as nom,
                    comment 
                    from tab_fichero_pacientes_cab c where c.rowid > 0";

            if(!empty($idpaciente)){
                $sql .= " and c.fk_paciente = ".$idpaciente;
            }

            $rs  = $db->query($sql);

            if($rs->rowCount() > 0)
            {
                while ($obj = $rs->fetchObject())
                {

                    $row = array();

//                    $DOL_HTTP/fichero_entidad/$obj2->name_direct/$obj2->ruta_fichero

                        //detalles fichero_entidad 4

                        $sql2 = "select * from tab_fichero_pacientes_det where fk_fichero_paciente_cab = $obj->rowid ;";
                        $rs12 = $db->query($sql2);

                        if($rs12->rowCount() > 0)
                        {
                            $html2 = "";
                            $html2 .= "";

                                while($obj2 =  $rs12->fetchObject())
                                {
                                    switch($obj2->type) //compruebo el type del fichero
                                    {

                                        case '.jpeg':

                                            $html2 .= "
                                                        <a href='".DOL_HTTP."/fichero_entidad/$obj2->name_direct/$obj2->ruta_fichero' target='_blank' >
                                                        <img width='50px' height='50px' src='".DOL_HTTP."/fichero_entidad/$obj2->name_direct/$obj2->ruta_fichero'  >
                                                        &nbsp;   
                                                        &nbsp;
                                                        $obj->titulo
                                                        </a>         
                                                       ";

                                            break;

                                        case '.png':

                                            $html2 .= "
                                                       <a  href='".DOL_HTTP."/fichero_entidad/$obj2->name_direct/$obj2->ruta_fichero' target='_blank' >
                                                       <img width='50px' height='50px' src='".DOL_HTTP."/fichero_entidad/$obj2->name_direct/$obj2->ruta_fichero'  >         
                                                       &nbsp;   
                                                       &nbsp;
                                                       $obj->titulo
                                                       </a>";

                                            break;

                                        case '.pdf':

                                            $html2 .= "
                                                       <a href='".DOL_HTTP."/fichero_entidad/$obj2->name_direct/$obj2->ruta_fichero' target='_blank' >
                                                       <img width='50px' height='50px' src='".DOL_HTTP."/logos_icon/logo_default/pdf.png'  >       
                                                       &nbsp;   
                                                       &nbsp;
                                                       $obj->titulo
                                                       </a>";

                                            break;

                                    }

                                }

                            $html2 .= "";

                            $formgroupImg =
                                "<div class='form-group col-md-10 col-xs-10 btnhover'>
                                        $html2
                                </div>";

//                            $row[] = $formgroupImg;
                        }

                    $row[] = $formgroupImg;
//                    $row[] = $obj->nom;
                    $row[] = $obj->comment;
                    $row[] = date("Y/m/d", strtotime($obj->fecha_creat));
                    $row[] = "<a class='btn btn-sm'  onclick='del_ficheropaciente($obj->rowid)' style='background-color: #cc4b4c; color: #ffffff;' title='ELIMINAR'>ELIMINAR</a>";

                    $data[] = $row;

                }
            }


            $output = [
                'data' => $data
            ];

//            print_r($output);
//            die();

            echo json_encode($output);
            break;

        case 'FicheroPacienteInsert':

            $error = '';
            $errores_ficheros = '';

            $datostextcab = array();

            $datostextcab = array( GETPOST('doctor') , GETPOST('fechaFichero'), GETPOST('observacion'), GETPOST('tituloFichero'), GETPOST('idpaciente') );

            //declaro el nombre de la carpeta
            $nombreCarpeta = 'carpeta_entidad_'.$conf->EMPRESA->ENTIDAD;

            $direct = DOL_DOCUMENT .'/fichero_entidad/'.$nombreCarpeta; //Accedo a a raiz de la carpeta de esta empresa

            $carpeta = "";

            if(!is_dir($direct)) //compruebo si la carpeta exite , si no existe la creo
            {
                mkdir($direct,0777, true);

            }else{
                $error = 'Ocurrió un error con el servidor al crear la carpeta para esta clínica, contacte con soporte técnico';
            }

            if(isset($_FILES['files'])){

                #No se encontro ningun fichero
                if( $_FILES['files']['error'][0] == 4){
                    $errores_ficheros = "No se econtro ningun fichero";
                }
            }
//            print_r($_FILES['files']); die();
            if(file_exists($direct))//compruebo si existe la carpeta
            {

                $acuF = 0;
                $sqlnF = "SELECT ifnull(MAX(rowid),1) as nfichero FROM tab_fichero_pacientes_det";
                $r=$db->query($sqlnF);
                $numeroFichero = $r->fetchObject()->nfichero;

                $datostextdet = array();
                $acuF = $numeroFichero;

                foreach($_FILES['files']['name'] as $key => $val)
                {
                    $tmp_name = $_FILES["files"]["tmp_name"][$key];
                    // basename() puede evitar ataques de denegación de sistema de fichero_entidad;

                    $type = "";
//                    print_r($_FILES['files']['type'][$key]);
                    switch ($_FILES['files']['type'][$key])
                    {
                        case 'image/png':
                            $type = '.png';
                            break;

                        case 'image/jpeg':
                            $type = '.jpeg';
                            break;

                        case 'application/pdf':
                            $type = '.pdf';
                            break;

                        default;
                            $error = 'Ocurrió un problema con la Operación, Contacte a con soporte Técnico';
                            break;

                    }

                    $puedopasar = false;
                    if(!empty($type))
                    {

                        $name_fichero = 'ficheros_pacientes-'.$acuF.'-'.$conf->EMPRESA->ENTIDAD.$type; //name de fichero
//                        print_r($name_fichero);
//                        die();
                        if( move_uploaded_file($tmp_name, $direct.'/'.$name_fichero) )
                        {
                            $datostextdet[] = array("name" => $name_fichero , "type" => $type);

                            $puedopasar = true;

                        }else{

                            $puedopasar = false;
                            $error = 'Ocurrió, un problema con la Operación, Contacte a con soporte Técnico';
                        }

                    }else{

                        $acuF++;
                    }

//                    print_r($datostextdet);
                }
//                die();

                $rs = 0;
                if( $puedopasar == true){
                    $rs = CrearInsertDirecFicheroPaciente($datostextcab, $datostextdet, $nombreCarpeta);
                }else{
                    $error = 'Ocurrió, un problema con la Operación, Contacte a con soporte Técnico';
                }
            }

            if($rs > 0)
            {
                $error = '';
            }
            if($errores_ficheros != ''){
                $error = $errores_ficheros;
            }

            $output = [
                'error' => $error
            ];

            echo json_encode($output);

            break;

        case 'delete_fichero_paciente':

            $error = '';

            $id = GETPOST("id");
            $sql1 = "select * from tab_fichero_pacientes_cab where rowid = $id";
            $rsF1 = $db->query($sql1);

            $sql2 = "select * from tab_fichero_pacientes_det where fk_fichero_paciente_cab = $id limit 1";
            $rsF2 = $db->query($sql2);

//            print_r($rsF2->rowCount()); die();
            if($rsF1->rowCount() == $rsF2->rowCount()){

                $objFichero        = $rsF2->fetchObject();
                $bakFichero        = $objFichero->ruta_fichero;
                $directorioEntidad = $objFichero->name_direct;

                $sqldelcab = "DELETE FROM tab_fichero_pacientes_cab WHERE rowid  = $id";
                $rscab = $db->query($sqldelcab);

                $sqldel = "DELETE FROM tab_fichero_pacientes_det WHERE rowid > 0 and fk_fichero_paciente_cab = $id";
                $rsdel = $db->query($sqldel);
                if(!$rsdel){
                    $error = 'Ocurrio un error con la Operación Eliminar Ficheros';
                }

                if($rsdel)
                {
                    if( $bakFichero != "")
                    {
                        unlink(DOL_DOCUMENT .'/fichero_entidad/'.$directorioEntidad.'/'.$bakFichero);
                    }
                }

            }else{
                $error = 'Ocurrio un error con la Operación Eliminar Ficheros la dimención de los ficheros no coinciden consulte con soporte tecnico';
            }

            $output = [
                'error' => $error
            ];

            echo json_encode($output);
            break;

        case "comecent_doct_paciente":

            $error = "";
            $numeroFilas = 0;
            $data = array();

            $ultimo_id_mysql = 0;
            $last_msg    = false;


            $ultimo_id   = GETPOST("id_ultimo");

            $text        = GETPOST("text");
            $idPaciente  = GETPOST("idPaciente");
            $subaccion   = GETPOST('subaccion');
            $iddocSesion = $_SESSION['id_user'];

            if($subaccion == "agregar") //cuando se ingresa un comentario
            {
                $sql = "INSERT INTO tab_comentarios_odontologos (`fk_odontologos`, `comentario`, `fk_paciente`) VALUES ($iddocSesion, '$text', $idPaciente);";
                $rs = $db->query($sql);

                if($rs)
                {
                    $sql1   = "SELECT c.tms as date, c.rowid, (select concat(o.nombre_doc , ' ' , o.apellido_doc) FROM tab_odontologos o where o.rowid = c.fk_odontologos) doc , 
                                  (select icon FROM tab_odontologos o where o.rowid = c.fk_odontologos) as icon ,
                                  c.comentario
                                  FROM tab_comentarios_odontologos c WHERE c.fk_paciente = $idPaciente order by  c.rowid asc ";
                    $acce   = $db->query($sql1);

                    if($acce->rowCount() > 0)
                    {
                        while ($obj = $acce->fetchObject())
                        {
                            $data[] = array(
                                "icon"   => DOL_HTTP.'/logos_icon/'.$conf->NAME_DIRECTORIO.'/'.$obj->icon,
                                "doctor" => $obj->doc,
                                "text"   => ($obj->comentario == "") ? "" : $obj->comentario,
                                "fecha"  => $obj->date
                            );
                        }

                        $numeroFilas = $acce->rowCount();
                    }

                    $error = "";
                }else{
                    $error = "Ocurrio un error no se pudo guardar el comentario, consulte con soporte";
                }

            }

            if($subaccion == "consultar") #consulto ultimo en caso ya se guardo
            {
                $sql1   = "SELECT c.tms as date, c.rowid,  (select concat(o.nombre_doc , ' ' , o.apellido_doc) FROM tab_odontologos o where o.rowid = c.fk_odontologos) doc , 
                                  (select icon FROM tab_odontologos o where o.rowid = c.fk_odontologos) as icon ,
                                  c.comentario
                                  FROM tab_comentarios_odontologos c WHERE c.fk_paciente = $idPaciente order by  c.rowid asc ";
                $acce   = $db->query($sql1);

                if($acce->rowCount() > 0)
                {
                    while ($obj = $acce->fetchObject())
                    {
                        $data[] = array(
                            "icon"       => DOL_HTTP.'/logos_icon/'.$conf->NAME_DIRECTORIO.'/'.$obj->icon,
                            "doctor"     => $obj->doc,
                            "text"       => ($obj->comentario == "") ? "" : $obj->comentario,
                            "ultimo_id"  => $obj->rowid,
                            "fecha"      => GET_DATE_SPANISH( $obj->date ) ,
                        );
                    }

                    $numeroFilas = $acce->rowCount();
                    $error = '';
                }

                #consulto el ultimo id
                $sqlUltimoId = "SELECT MAX(rowid) as ultimo_id FROM tab_comentarios_odontologos WHERE fk_paciente = $idPaciente limit 1";
                $rsultimo    = $db->query($sqlUltimoId);
                if($rsultimo->rowCount() > 0)
                {
                    $ultimo_id_mysql = $rsultimo->fetchObject()->ultimo_id;
                    if($ultimo_id_mysql > $ultimo_id ) #el id principal es mayor que el ultimo entonces se ingreso uno nuevo
                    {
                        $last_msg = true;
                    }
                }
            }


//            print_r($data);
//            die();

            $output = [
                'error'  => $error       ,
                'data'   => $data        ,
                'numero' => $numeroFilas ,
                'ultimo' => $last_msg    ,
                'ultimoid' => $ultimo_id_mysql    ,
            ];

            echo json_encode($output);

            break;

        case "list_informacion_doc":

            $data = array();

            $idpaciente = GETPOST('idpaciente');

            $respobj = info_type_document_pacient( $idpaciente );


            $output = [
                "data" => $respobj,
            ];

            echo json_encode($output);
            break;

        case "obj_document_clinico":

            $error=false;
            $dataPrincipal = array();
            $id = GETPOST("idClinico");

            $sql = "SELECT * FROM tab_documentos_ficha_clinica where rowid = " . $id;
            $rs  = $db->query($sql);

            if($rs->rowCount() > 0)
            {
                $error=true;
                while ($Obj = $rs->fetchObject())
                {
                    $dataPrincipal = $Obj;
                }
            }

            $output = [
                "error" => $error,
                "data"  => $dataPrincipal
            ];

            echo json_encode($output);
            break;

        case "list_citas_admin":

            $idPaciente  = GETPOST('idpaciente');
            $fechaInicio = GETPOST('fechaini');
            $fechafin    = GETPOST('fechafin');

            $resp = listcitas_admin($idPaciente, $fechaInicio, $fechafin);

            $output = [
              'data' => $resp,
            ];

            echo json_encode($output);

            break;

        case 'consultar_numero_odontograma':

            $numero = "";

            $sql = "SELECT 
                IFNULL(MAX(rowid), 1) AS numero
            FROM
                tab_odontograma_paciente_cab";
            $resul = $db->query($sql)->fetchObject();
            $numero = "Odontograma - " . str_pad($resul->numero, 4, "0", STR_PAD_LEFT);

            echo json_encode($numero);
            break;

        case 'nuevoUpdateOdontograma':

            $error = '';
            $puedoPasar = 0;

            $url_location = ""; #para redirigir al odontograma creado

            $fk_tratamiento = GETPOST('fk_tratamiento');
            $descript       = GETPOST('descrip');
            $numero         = 0;
            $idpaciente     = GETPOST("fk_paciente");


            $sql = "SELECT * FROM tab_odontograma_paciente_cab WHERE fk_tratamiento = $fk_tratamiento and fk_paciente = $idpaciente";
            $rs = $db->query($sql);

            if( $rs->rowCount() > 0 ){
                $puedoPasar++;
                $error = 'Ya se encuentra este plan de tratamiento asociado a un odontograma';

            }

            #consulto el ultmo id
            $sql1       = "SELECT max(rowid) as rowid FROM tab_odontograma_paciente_cab";
            $numero     = $db->query($sql1)->fetchObject()->rowid;
            $ultimo_id_odontgram = (double)( $numero + 1 ); #ultimo id mas el + 1

//            print_r($error); die();

            if( $puedoPasar == 0 && $error == ''){

                $paciente->fk_plantratamiento = $fk_tratamiento;
                $paciente->numero             = $numero;
                $paciente->odontodescripcion  = $descript;
                $paciente->fk_usuario         = $user->id;
                $paciente->fk_paciente        = $idpaciente;

                $error = $paciente->createOdontogramaCab();

            }

//            print_r($paciente);  die();
            $output = [
              'error' => $error
            ];

            echo json_encode($output);
            break;

        case 'list_odontograma':

            $data = array();

            $idpaciente = GETPOST('idpaciente');

            $sql = "SELECT
                        dc.fecha,
                        dc.rowid, 
                        dc.numero,
                        dc.descripcion,
                        dc.fk_tratamiento, 
                        dc.estado_odont , 
                        (select ifnull(edit_name, concat('Plan de tratamiento # ', numero)) as editnum
                            from tab_plan_tratamiento_cab tc where tc.rowid = dc.fk_tratamiento) as labeltram
                    FROM tab_odontograma_paciente_cab dc where dc.rowid > 0 ";

            if(!empty($idpaciente)){
                $sql .= " and dc.fk_paciente = ".$idpaciente;
            }

            $resul = $db->query($sql);

            if($resul->rowCount() > 0){

                while ( $ob = $resul->fetchObject() )
                {
                    $row = array();

                    $itemAsociarOdontograma = "";
                    if($ob->fk_tratamiento == 0)
                    {

                        $itemAsociarOdontograma = "<p>
                            <b>Asociar Odontograma</b>
                        </p>";

                    }

                    #FK_PLAN DE TRATAMIENTO QUE ESTA ASOCIADO A ESTE ODONTOGRAMA
                    $URL_idplantramiento = '&idplantram='.$ob->fk_tratamiento;

                    $url_updateOdont = DOL_HTTP.'/application/system/pacientes/pacientes_admin/?view=odot&key='.KEY_GLOB.'&id='.tokenSecurityId($idpaciente).'&v=fordont'.$URL_idplantramiento;

                    $opciones = "<div class='form-group col-md-12 col-lg-6 col-xs-12 col-sm-12'>
                                     <a href='$url_updateOdont' class='btnhover btn btn-sm ' style='font-weight: bolder'> <i class='fa fa-edit'></i> ACTUALIZAR </a>     
                                 </div>
                                 <div class='form-group col-md-12 col-lg-6 col-xs-12 col-sm-12'>
                                     <a href='#' class='btnhover btn btn-sm ' style='font-weight: bolder; color: red' > <i class='fa fa-trash'></i> ELIMINAR </a> 
                                 </div>";

                    $row[] = date('Y/m/d', strtotime($ob->fecha));
                    $row[] = 'Odontograma N.'.$ob->numero .' - '.'<img src="'.DOL_HTTP.'/logos_icon/logo_default/diente.png'.'" width="12px" height="14px" >';
                    $row[] = $ob->descripcion;
                    $row[] = $ob->labeltram; #PLAN DE TRATAMIENTO NOMBRE
                    $row[] = $opciones;

                    #ID
                    $row[] = $ob->fk_tratamiento;

                    $data[] = $row;
                }
            }


            $output = [
              'data' => $data,
            ];

            echo json_encode($output);
            break;

        case 'fetchnewtratamiento':

            $objetoCab = array();
            $objetoDet = array();

            $error='';
            $subaccion  = GETPOST('subaccion');

            $idpaciente        = GETPOST('idpaciente');
            $idtratamiento     = GETPOST('idtratamiento');

            //                  $numero_tratamiento = ''.str_pad($rse->numero, 7, "0", STR_PAD_LEFT);

            #informacion plan de tratamiento cabezera
            $sqltrancab = "SELECT 
                    tc.numero numero,
                    tc.abonos abonos,
                    tc.fk_doc fkdoc,
                    ifnull((SELECT CONCAT(od.nombre_doc, ' ', od.apellido_doc)  FROM tab_odontologos od WHERE tc.fk_doc = od.rowid), 'No asignado') nombre_doc,
                    tc.fk_paciente,
                    CONCAT(ap.nombre, ' ', ap.apellido) nombre,
                    tc.fk_convenio,
                    
                    IFNULL((SELECT 
                                    cf.nombre_conv
                                FROM
                                    tab_conf_convenio_desc cf
                                WHERE
                                    cf.rowid = tc.fk_convenio),
                            'convenio no asignado') convenio,
                            
                    IFNULL((SELECT 
                                    cf.valor
                                FROM
                                    tab_conf_convenio_desc cf
                                WHERE
                                    cf.rowid = tc.fk_convenio),
                            0) valorConvenio ,
                            
                    tc.edit_name as edit_name , 
                    
                    -- ABONADO
                    (SELECT round(sum(pd.amount),2) saldo FROM tab_pagos_independ_pacientes_det pd where pd.fk_plantram_cab = tc.rowid and pd.fk_paciente = $idpaciente) abonado_cab , 
                    
                    tc.observacion, 
                    tc.estados_tratamiento
                    
                FROM
                    tab_plan_tratamiento_cab tc,
                    tab_admin_pacientes ap,
                    tab_odontologos od
                WHERE
                    tc.fk_paciente = ap.rowid
                        AND tc.rowid = ".$idtratamiento."
                        AND tc.fk_paciente = ". $idpaciente ." limit 1";

//            print_r($sqltrancab);
            $rscab = $db->query($sqltrancab);
            if($rscab && $rscab->rowCount() > 0 ){

                while ($obcab = $rscab->fetchObject()){
                    $objetoCab[] = $obcab;

                }
            }else{
                $error = 'Ocurrio un error , consulte con soporte Tecnico';
            }

            #informacion plan de tratamiento detalle
            $sqltransdet = "SELECT 
                        pd.rowid, 
                        pd.fk_plantratam_cab ,
                        pd.fk_diente AS diente,
                        cp.descripcion AS prestacion,
                        pd.fk_prestacion AS fk_prestacion,
                        format(pd.sub_total, 2) AS subtotal,
                        pd.cantidad , 
                        pd.desc_convenio AS descconvenio,
                        pd.desc_adicional AS descadicional,
                        pd.json_caras,
                        pd.total,
                        pd.estadodet , 
                        pd.fk_usuario , 
                        ifnull((SELECT usuario FROM tab_login_users s where s.fk_doc = pd.fk_usuario limit 1),'') as usuario_creator , 
                        ifnull((SELECT usuario FROM tab_login_users s where s.fk_doc = pd.realizada_fk_dentista limit 1),'') as usuario_realizado , 
                        pd.estado_pay as estado_pago
                    FROM
                        tab_plan_tratamiento_det pd,
                        tab_conf_prestaciones cp
                    WHERE
                        pd.fk_prestacion = cp.rowid
                        AND pd.fk_plantratam_cab = ".$idtratamiento." order by pd.rowid desc";
            $rsd = $db->query($sqltransdet);

            if($rsd->rowCount() > 0 ){
                while ($obdet = $rsd->fetchObject()){

                    $objetoDet[] = $obdet;
                }

            }else{
//                $error = 'Ocurrio un error , consulte con soporte Tecnico';
            }

            $output = [
              'error'      => $error,
              'objetoCab'  => $objetoCab,
              'objetoDet'  => $objetoDet,

            ];

            echo json_encode($output);
            break;


        case 'fetch_prestaciones':

            $productos = array();
            $idprest   = GETPOST('idprest');

            $sql = "SELECT 
                    c.rowid,
                    c.descripcion,
                    c.valor,
                    IFNULL((SELECT 
                                    d.nombre_conv
                                FROM
                                    tab_conf_convenio_desc d
                                WHERE
                                    d.rowid = c.fk_convenio),
                            '') AS convenio,
                    IFNULL((SELECT 
                                    d.valor
                                FROM
                                    tab_conf_convenio_desc d
                                WHERE
                                    d.rowid = c.fk_convenio),
                            0) convenio_valor
                FROM
                    tab_conf_prestaciones c where  rowid > 0";

            if(!empty($idprest)){
                $sql .= " and c.rowid = $idprest";
            }

            $rs = $db->query($sql);
            if ($rs->rowCount()>0)
            {
                while ($obj = $rs->fetchObject()){

                    $productos = $obj;
                }
            }

            echo json_encode($productos);
            break;

        case 'list_tratamiento':

            $idplantmiento = GETPOST('idplantmiento');
            $idpaciente = GETPOST('idpaciente');
            $estadotram = GETPOST('mostrar_anulados');
            $estadoMostrarFinalizados = GETPOST('mostrar_finalizados');

            $dataprincipal = array();

            $sql = "SELECT 
                        tc.rowid,
                        tc.numero,
                        tc.fk_paciente,
                        CONCAT(ap.nombre, ' ', ap.apellido) nombre,
                        tc.fk_paciente,
                        tc.fk_doc fkdoc,
                        
                        IFNULL((SELECT 
                                        CONCAT(od.nombre_doc, ' ', od.apellido_doc)
                                    FROM
                                        tab_odontologos od
                                    WHERE
                                        od.rowid = tc.fk_doc),
                                'No asignado') AS nombre_doc,
                                
                        tc.estados_tratamiento,
                        tc.ultima_cita,
                        tc.situacion,
                        tc.edit_name AS edit_name,
                        tc.fk_paciente AS idpaciente,
                        tc.fk_cita AS idCitas,
                        tc.fecha_create
                        
                        FROM tab_plan_tratamiento_cab tc , tab_admin_pacientes ap
                        where 
                        tc.fk_paciente = ap.rowid 
                   ";
            $sql .= " and tc.fk_paciente = ".$idpaciente." ";

            if(!empty($estadotram) || !empty($estadoMostrarFinalizados))
            {
                if( $estadotram == 'si'){
                    $sql .= " and tc.estados_tratamiento = 'E' ";
                }
                if( $estadoMostrarFinalizados== 'si'){
                    $sql .= " and tc.estados_tratamiento = 'F' ";
                }
            }

            if($estadotram=='no' && $estadoMostrarFinalizados == 'no'){
                $sql .= " and tc.estados_tratamiento in('A', 'S')";
            }

            if(!empty($idplantmiento))
            {
                $sql .= " and tc.rowid = $idplantmiento";
            }

//            echo '<pre>';
//            print_r($sql);
//            die();

            $rul = $db->query($sql);

            if($rul->rowCount()>0){

                while ($ob = $rul->fetchObject()){

                    $row = array();
                    $estado = "";

                    if($ob->estados_tratamiento == 'A'){
                        $estado = 'Activo';
                    }else{
                        $estado = 'Inactivo';
                    }

                    $nombre_tratamiento = null;

                    if($ob->edit_name != ""){
                        $nombre_tratamiento = $ob->edit_name;
                    }else{
                        $nombre_tratamiento = "Plan de Tratamiento: # $ob->numero ";
                    }


                    $url_planform = DOL_HTTP .'/application/system/pacientes/pacientes_admin/?view=plantram&key='.KEY_GLOB.'&id='.tokenSecurityId($ob->idpaciente).'&v=planform&idplan='.tokenSecurityId($ob->rowid);

                    $row[] = "<a  href='$url_planform' style='font-weight: bold; font-size: 1.6rem' class='text-center btn btnhover'>  $nombre_tratamiento  </a>"; #descripcion o numero de tratamiento
//                    $row[] = "<a  href='".DOL_HTTP."/application/system/pacientes/admin_paciente/?view=form_plan_tratamiento&id=".$ob->fk_paciente."&ope=mod&idtratam=".$ob->rowid."' style='font-weight: bold; font-size: 1.6rem' class='text-center btn btnhover'>  $nombre_tratamiento  </a>"; #descripcion o numero de tratamiento
                    $row[] = $ob->nombre_doc;  #nombre Doctor
                    $row[] = $estado;
                    $row[] = date('Y/m/d', strtotime($ob->ultima_cita));
                    $row[] = date('H:i:s', strtotime($ob->ultima_cita));
                    $row[] = $ob->situacion;
                    $row[] = $ob->rowid; #id plan de tratamiento
                    $row[] = $ob->idCitas; #id plan de cita asociada

                    $row[] = $ob->estados_tratamiento; #estado plan de tratamiento
                    $row[] = $ob->fecha_create; #fecha de creacion del plan de tratamiento
                    $row[] = $ob->estados_tratamiento; #estado plan de tratamiento

                    $dataprincipal[] = $row;

                }
            }

            $output = [
                'data' => $dataprincipal
            ];

            echo json_encode($output);
            break;

        case 'invalic_prestacion_diente':

            $error = '';

            $subaccion     = GETPOST('subaccion'); #Subaccion Diente o Prestacion
            $idplantram    = GETPOST('idplantram');
            $idprestacion  = GETPOST('prestacion');

            if($subaccion == 'diente'){

                $diente = GETPOST('diente');

                $sql1 = "SELECT * FROM tab_plan_tratamiento_det d WHERE d.fk_plantratam_cab = ".$idplantram." and d.fk_prestacion = $idprestacion and fk_diente = ". $diente." limit 1";
                $rs1  = $db->query($sql1);
                if($rs1->rowCount() > 0){
                    $error = 'Esta Prestación ya esta asiganada junto con la pieza: ' . $diente;
                }
            }

            if( $subaccion == 'prestacion'){

                $sql1 = "SELECT * FROM tab_plan_tratamiento_det d WHERE d.fk_plantratam_cab = ".$idplantram." and d.fk_prestacion = $idprestacion and fk_diente = 0 limit 1";
                $rs1  = $db->query($sql1);
                if($rs1->rowCount() > 0){
                    $error = 'Esta Prestación ya esta asiganada';
                }

            }


//            print_r($error);
//            die();
            $output = [
              'error' => $error
            ];
            echo  json_encode($output);
            break;


        case 'realizarPrestacion':

            $error = '';

            $idCabPlant      = GETPOST('idcabplantram');
            $idDetPlant      = GETPOST('iddetplantram');
            $idpaciente      = GETPOST('idpaciente');
            $iddiente        = GETPOST('iddiente');
            $iddoct          = GETPOST('fk_doct');
            $observacion     = GETPOST('observacion');
            $estadoDiente    = GETPOST('fk_estadodiente');

            $tieneOdontograma = ''; #esta variable comprueba si el plan de tratamiento tiene odontogrma
            $datosRealizarPrestacion = [];


            $sql = "SELECT * FROM tab_plan_tratamiento_det where rowid = $idDetPlant and fk_plantratam_cab = $idCabPlant limit 1";
            $resul = $db->query($sql);
            if($resul && $resul->rowCount() > 0)
            {
                $objtratm = $resul->fetchObject();

                $labellist = []; #aux caras
                $listcaras = []; #cadena de caras

                if($objtratm->json_caras != "")
                {
                    $labellist = json_decode( $objtratm->json_caras );

                    if($labellist->vestibular == "true")
                    { $listcaras[] = "vestibular"; }
                    if($labellist->distal == "true")
                    { $listcaras[] = "distal";  }
                    if($labellist->palatino == "true")
                    { $listcaras[] = "palatino"; }
                    if($labellist->oclusal == "true")
                    { $listcaras[] = "oclusal"; }
                    if($labellist->mesial == "true")
                    { $listcaras[] = "mesial"; }
                    if($labellist->lingual == "true")
                    { $listcaras[] = "lingual"; }

                }

                $datosRealizarPrestacion = (object)[
                    'fk_paciente'        =>  $idpaciente ,
                    'fk_plantram_cab'    =>  $idCabPlant ,
                    'fk_plantram_det'    =>  $idDetPlant ,
                    'observacion'        =>  $observacion ,
                    'json_caras'         =>  $objtratm->json_caras ,
                    'estadodiente'       =>  $estadoDiente,
                    'fk_doctor'          =>  $iddoct,
                    'idlogin'            =>  $conf->login_id,
                    'iddiente'           =>  $iddiente,

                    'AxulisttaCaras'     =>  implode(',', $listcaras),
                ];


            }else{
                $error = 'Ocurrio un error no se encontraron datos para ejecutar el proceso Realizar prestación';
            }

//            echo '<pre>';
//            print_r($datosRealizarPrestacion);
//            print_r( json_decode( $datosRealizarPrestacion->json_caras ) );
//            die();

            if( $iddiente != 0 && $error == '') //Se actualiza el odontograma en caso de tener asociado
            {
                $sqlodont = "SELECT * FROM tab_odontograma_update od where od.fk_tratamiento = $idCabPlant and  od.fk_diente = $iddiente";
                $rsodont  = $db->query($sqlodont);
                if($rsodont && $rsodont->rowCount() > 0)
                {
                    if($estadoDiente!=0){ //solo se actualiza si el estado es diferente de 0

                        $updateOdont1 = "UPDATE `tab_odontograma_update` SET `fk_estado_pieza`= $estadoDiente , json_caras = '". $datosRealizarPrestacion->json_caras ."' WHERE `rowid`>0 and fk_tratamiento = $idCabPlant and fk_diente = $iddiente;";
                        $rsultUpdate = $db->query($updateOdont1);

                        #Se actualiza el odontograma detalle
                        $InsertOdont2  = "INSERT INTO `tab_odontograma_paciente_det` (`fk_diente`, `json_caras`, `fk_estado_diente`, `fk_tratamiento`, `obsrvacion`, `list_caras`, `fecha`, `estado_anulado`)";
                        $InsertOdont2 .= "VALUES (";
                        $InsertOdont2 .= "  $datosRealizarPrestacion->iddiente , ";
                        $InsertOdont2 .= " '$datosRealizarPrestacion->json_caras'  , ";
                        $InsertOdont2 .= " '$datosRealizarPrestacion->estadodiente' , ";
                        $InsertOdont2 .= "  $datosRealizarPrestacion->fk_plantram_cab ,";
                        $InsertOdont2 .= " '$datosRealizarPrestacion->observacion' ,";
                        $InsertOdont2 .= " '$datosRealizarPrestacion->AxulisttaCaras' ,";
                        $InsertOdont2 .= " ' " . date("Y-m-d") . " ' ";
                        $InsertOdont2 .= " 'A' ";
                        $InsertOdont2 .= " ) ";

                        /*
                        $updateOdont2  = " UPDATE `tab_odontograma_paciente_det` SET  `list_caras`= '". $datosRealizarPrestacion->AxulisttaCaras ."' , ";
                        $updateOdont2 .= " `json_caras`= '". $datosRealizarPrestacion->json_caras ."' ,";
                        $updateOdont2 .= " `fk_estado_diente`= '". $datosRealizarPrestacion->estadodiente ."' ,";
                        $updateOdont2 .= " `obsrvacion`= '". $datosRealizarPrestacion->observacion ."' ";
                        $updateOdont2 .= " WHERE `rowid` > 0  and fk_tratamiento = ".$datosRealizarPrestacion->fk_plantram_cab." and fk_diente =  ".$datosRealizarPrestacion->iddiente." "; */

                        $db->query($InsertOdont2);

//                        echo '<pre>';
//                        print_r($updateOdont1);
//                        die();
                    }

                }else{

                    $tieneOdontograma = " <br> <img src='". DOL_HTTP."/logos_icon/logo_default/tooth-solid.svg' width='14px' height='14px' alt=''> <b> Este Plan de tratamiento no tiene Asociado un Odontograma </b>";
                }
            }


            if( $error == '' )
            {
                $rlcr = realizarPrestacionupdate( $datosRealizarPrestacion );

                if( $rlcr == '' ){
                    $error = $rlcr;
                }
            }

            $output = [
                'error' => $error,
                'tieneOdontograma' => $tieneOdontograma
            ];

//            print_r($output);
//            die();

            echo  json_encode($output);

            break;


        case 'eliminar_prestacion_plantram':

            $error = '';
            $iddetplant = GETPOST('iddetplantram');
            $idCabplant = GETPOST('idplanCab');
            $idpaciente = GETPOST('idpaciente');

            $sql = "SELECT 
                        dt.fk_prestacion , 
                        dt.estado_pay , 
                        dt.estadodet , 
                        (select cfp.descripcion from tab_conf_prestaciones cfp WHERE cfp.rowid = dt.fk_prestacion) as prestacion ,
                        round(dt.total, 2) as total
                    FROM
                        tab_plan_tratamiento_det dt,
                        tab_plan_tratamiento_cab cb
                    WHERE
                        dt.fk_plantratam_cab = $idCabplant and 
                        cb.rowid = $idCabplant  
                        and dt.rowid = $iddetplant
                        and cb.fk_paciente = $idpaciente
                        limit 1 ";

//            echo '<pre>'; print_r($sql); die();
            $rsDel = $db->query($sql);
            if($rsDel && $rsDel->rowCount() > 0)
            {
                $obj = $rsDel->fetchObject();

                if( $obj->estado_pay == 'PA')  #COMPRUEBO EL ESTADO PAGADO DE LA PRESTACION
                {
                    $error = 'No puede Eliminar esta prestación <b>' .$obj->prestacion .'</b> se encuentra <i class="fa fa-dollar"></i> pagada';
                }
                if( $obj->estado_pay == 'PS')  #COMPRUEBO EL ESTADO EN ESTA PRESTACION TIENE SALDO - O  ABONADO
                {
                    $error = 'No puede Eliminar esta prestación <b>' .$obj->prestacion .'</b> tiene <i class="fa fa-dollar"></i> saldo asociado comprueba en el modulo de pagos de este plan de tratamiento ';
                }
                if( $obj->estadodet == 'R') #REALIZADA
                {
                    $error = 'No puede Eliminar esta prestación <b>' .$obj->prestacion .'</b> se encuentra Realizada';
                }

                if( $error == '' ){

                    if( $obj->estadodet == 'A' && $obj->estado_pay  == 'PE') #PENDIENTE PE o A
                    {
                        $sqldelUp = "DELETE FROM tab_plan_tratamiento_det WHERE rowid ='$iddetplant' and fk_plantratam_cab = $idCabplant;";
                         $rsDelUp  = $db->query($sqldelUp);

                    }else{
                        $error = '<p style="color:  red; font-weight: bolder"> Ocurrio un error no se puede eliminar esta prestacion compruebe en que estado se encuentra la prestación , o consulte con Soporte Tecnico</p> ';
                    }
                }

            }else{
                $error = 'Ocurrio un error no se puede Eliminar esta prestacion, Consulte con soporte Tecnico';
            }


//            die();
            $output = [
                'error' => $error,
            ];
            echo  json_encode($output);
            break;

        //FINALIZAR EL PLAN DE TRATAMIENTO
        case 'finalizar_plantramento':

            $consultar = "";
            $error     = "";
            #un de plan de tratamiento solo se puede finalizar si esta tiene todas las  prestaciones pagadas
            $subaccion   = GETPOST('subaccion');
            $idpaciente  = GETPOST('idpaciente');
            $idplantram  = GETPOST('idplant');

            if($subaccion == 'consultarfinalizado')
            {

            }

            if($subaccion == 'finalizar_plantram')
            {
                $sql2 = "SELECT 
                        c.rowid,
                        (SELECT 
                                cp.descripcion
                            FROM
                                tab_conf_prestaciones cp
                            WHERE
                                cp.rowid = d.fk_prestacion) AS labelprestacion,
                                
                        d.estado_pay,
                        
                        (SELECT 
                                SUM(pd.amount)
                            FROM
                                tab_pagos_independ_pacientes_det pd
                            WHERE
                                pd.fk_plantram_cab = c.rowid
                                    AND pd.fk_plantram_det = d.rowid
                                    AND pd.fk_paciente = c.fk_paciente
                                    AND pd.fk_prestacion = d.fk_prestacion) AS cancelado_saldo , 
                        d.estadodet
                                    
                    FROM
                        tab_plan_tratamiento_cab c,
                        tab_plan_tratamiento_det d
                    WHERE
                        c.rowid = d.fk_plantratam_cab
                            AND c.rowid = $idplantram
                            AND c.fk_paciente = $idpaciente; ";
                $rs2 = $db->query($sql2);

//                echo '<pre>';  print_r($sql2);  die();
                $puedeFinalizar = "";
                $invalic = 0;
                $prestaciones_pendientes = []; #PRESTACIONES QUE AUN NO ESTAN PAGADAS
                $prestaciones_saldo      = []; #PRESTACIONES QUE TIENE SALDO ( OSEA UNA PARTE PAGADA )
                $prestacion_Norealizada  = []; #PRESTACIONES QUE AUN NO ESTAN REALIZADA

                if($rs2 && $rs2->rowCount()>0)
                {
                    while ( $obprestFinal = $rs2->fetchObject() )
                    {
                        if($obprestFinal->estado_pay == 'PS'){
                            $prestaciones_saldo[] = $obprestFinal->labelprestacion. " &nbsp;<i class='fa fa-dollar'></i> &nbsp;" .$obprestFinal->cancelado_saldo;
                            $invalic++;
                        }
                        if($obprestFinal->estado_pay == 'PE'){
                            $prestaciones_pendientes[] = $obprestFinal->labelprestacion;
                            $invalic++;
                        }

                        #prestaciones que aun no estan realizadas
                        if($obprestFinal->estadodet == 'A'){
                            $prestacion_Norealizada[] = $obprestFinal->labelprestacion; #prestaciones que aun no estan realizada
                            $invalic++;
                        }
                    }
                }else{
                    $error = "No hay prestaciones";

                }
//die();
                if($invalic > 0){

                    $error = 'no puede finalizar este tratamiento';

                    $puedeFinalizar .= '<b>No puede finalizar este Plan de tratamiento </b>';
                    $consultar .= '<br>'.$puedeFinalizar;

                    if(count($prestaciones_pendientes) > 0)
                    {
                        $prestacionesPend = implode(',', $prestaciones_pendientes);
                        $consultar .= '<p>
                                            <b>Prestaciones Pendientes</b>
                                            <br>'. (str_replace(',', '<br>', $prestacionesPend)) .'
                                        </p>';
                    }

                    if(count($prestaciones_saldo) > 0)
                    {
                        $prestacionesSaldo = implode(',', $prestaciones_saldo);
                        $consultar .= '<p>
                                            <b>Prestaciones Abonadas</b>
                                            <br>'. (str_replace(',', '<br>', $prestacionesSaldo)) .'
                                        </p>';
                    }

                    if(count($prestacion_Norealizada) > 0)
                    {
                        $prestacionesNorealizada = implode(',', $prestacion_Norealizada);
                        $consultar .= '<p>
                                            <b>Prestaciones No realizadas</b>
                                            <br>'. (str_replace(',', '<br>', $prestacionesNorealizada)) .'
                                        </p>';
                    }

                }else{

                    if( $error == '' )
                    {
                        $error     = '';
                        $consultar = '';

                        #Si todo esta ok se actualiza el plan de tratamiento a estado finalizado
                        $sqlUpdPlantCab = "UPDATE `tab_plan_tratamiento_cab` SET `estados_tratamiento`='F' WHERE `rowid`='$idplantram';";
                        $rsCanFinl = $db->query($sqlUpdPlantCab);

                        if(!$rsCanFinl){ $error = 'Ocurrio un error con el servidor con crear el proceso intentelo de nuevo';  }

                    }else{

                        $consultar = "<p style='font-weight: bolder; color: red'> Este plan de traramiento no contiene prestaciones asociadas</p>";

                    }
                }
            }

            $output = [
                'error'     => $error,
                'consultar' => $consultar
            ];

            echo  json_encode($output);
            break;


        case 'fecht_odontograma':

            $error = '';
            $dataPrincipal = array();
            $idpaciente    = GETPOST('idpaciente');
            $idtratamiento = GETPOST('idtratamiento');

            if($idpaciente != "" && $idtratamiento != "")
            {

                $sql = "SELECT * FROM tab_odontograma_update u WHERE u.fk_tratamiento = $idtratamiento and u.fk_paciente = $idpaciente ";
                $resul = $db->query($sql);

//                print_r($sql);
                if($resul->rowCount()>0){

                    while ($ob = $resul->fetchObject()){
                        $dataPrincipal[] = $ob;
                    }
                }
            }else{
                $error = 'Ocurró un error inesperado, consulte con soporte Técnico';
            }


            $output = [
                'dataprincipal' => $dataPrincipal,
                'error' => $error,
            ];

            echo  json_encode($output);
            break;

        case "list_detalles_odont_estados":

            $data = array();

            $idtratamiento = GETPOST("idtratamiento");

            # lista de estado pertenesientes a ese tratamiento
            $sql = "SELECT 
                    d.rowid,
                    d.fk_diente , 
                    (select s.descripcion from tab_odontograma_estados_piezas s where s.rowid = d.fk_estado_diente) as estado,
                    d.list_caras,
                    d.fecha,
                    d.obsrvacion,
                    d.estado_anulado
                    FROM tab_odontograma_paciente_det d where rowid > 0 ";

            if(!empty($idtratamiento)){
                $sql .= " and  d.fk_tratamiento = $idtratamiento ";
            }
            $sql .= " order by d.rowid desc";
            $rs = $db->query($sql);
            if($rs->rowCount() > 0){

                while ($obj = $rs->fetchObject()){

                    $row = array();

                    $observacion = "";

                    if(!empty($obj->obsrvacion))
                    {
                        $observacion = ''.' ( ' . $obj->obsrvacion.' )';
                    }

                    if($obj->estado_anulado == 'A'){
                        $row[] = date("Y/m/d", strtotime($obj->fecha));
                        $row[] = $obj->fk_diente;
                        $row[] = $obj->list_caras  ;
                        $row[] = $obj->estado .''.$observacion;
                        $row[] = "<a class='btn ' style='padding: 4px 8px; background-color: #a55759; color:#ffffff ' onclick='anular_estado_update($obj->rowid)'  >Anular</a>";
                    }

                    if($obj->estado_anulado == 'E'){
                        $row[] = "<strike>".date("Y/m/d", strtotime($obj->fecha))."</strike>";
                        $row[] = "<strike> ".$obj->fk_diente." </strike>";
                        $row[] = "<strike>".$obj->list_caras."</strike>"  ;
                        $row[] = "<strike>".$obj->estado ." ".$observacion."</strike>";
                        $row[] = "<a class='btn disabled_link3' style='padding: 4px 8px; background-color: #a55759; color:#ffffff '  >Anular</a>";
                    }


                    $data[] = $row;
                }
            }

            $output = [
                'data' => $data
            ];

            echo json_encode($output);
            break;

        case 'nuevo_odontograma_detalle':

            $error= '';

            $informacion_detalle = GETPOST('info');

            $datos['fk_diente']         = $informacion_detalle['fk_diente'];
            $datos['caras_json']        = $informacion_detalle['datosPiezas'];
            $datos['fk_estadoDiente']   = $informacion_detalle['fk_estadoDiente'];
            $datos['fk_trataminto']     = $informacion_detalle['fk_trataminto'];
            $datos['observacion']       = $informacion_detalle['observacion'];
            $datos['labelCaras']        = explode(' ', $informacion_detalle['labelCaras']);

//            print_r($datos['caras_json'] ); die();

            $paciente->fk_diente                = $datos['fk_diente'];
            $paciente->json_caras               = $datos['caras_json'];
            $paciente->fk_estadosdientes        = $datos['fk_estadoDiente'];
            $paciente->observacionOdont         = $datos['observacion'];
            $paciente->listCaras                = implode(',', array_filter($datos['labelCaras'], 'strlen'));
            $paciente->fk_plantratamiento       = $datos['fk_trataminto'];
            $paciente->fechaDet                 = "now()";

            $error = $paciente->createOdontogramaDet();

            $output = [
                'error' => $error
            ];

            echo json_encode($output);
            break;

        case "odontograma_update":

            $error = '';

            $datos = array();
            $datos  = GETPOST("piezas");

            $fk_plantratamiento    =   GETPOST('fk_tratamiento');
            $fk_paciente           =   GETPOST('idpaciente');

//            print_r($datos); die();
            $sql1 = "SELECT * FROM tab_odontograma_update WHERE fk_tratamiento = $fk_plantratamiento and fk_paciente = $fk_paciente";
            $rs1 = $db->query($sql1);

//            print_r($datos); die();
            #si es mayor a 0 ose hay datos , eliminos los datos anteriores y ingreso los nuevo datos

            if($rs1->rowCount()>0)
            {
                $sql2 = "DELETE FROM `tab_odontograma_update` WHERE rowid > 0 and fk_tratamiento = $fk_plantratamiento and fk_paciente = $fk_paciente";
                $rs2  = $db->query($sql2);

                if($rs2){

                    for ($i =0; $i <= count($datos['piezas']) -1; $i++){

                        $val = $datos['piezas'][$i];

                        $fkdiente       = $val['diente'];
                        $json_caras     = $val['caras'];
                        $fk_estadopieza = $val['estado_diente'];

                        $sql3 = "INSERT INTO `tab_odontograma_update` (`fk_diente`, `json_caras`, `type_hermiarcada`, `fk_estado_pieza`, `fk_tratamiento`, `fk_paciente`)";
                        $sql3 .= "VALUES(";
                        $sql3 .= "'$fkdiente' , ";
                        $sql3 .= "'".json_encode($json_caras)."' , ";
                        $sql3 .= "'no hay momentaneo' , ";
                        $sql3 .= "'$fk_estadopieza' , ";
                        $sql3 .= "'$fk_plantratamiento' , ";
                        $sql3 .= "'$fk_paciente' ";
                        $sql3 .= ")";
//                      print_r($val);
                        $rs3 = $db->query($sql3);

                        if(!$rs3){
                            $error += "Ocurrió un problema con la Operación, contacte con soporte tecnico";
                        }
                    }

                }else{
                    $error += "Ocurrió un problema con la Operación, contacte con soporte tecnico";
                }

            }else{ #caso contrario ingreso por primera vez

                for ($i =0; $i <= count($datos['piezas']) ; $i++){

                    $val = $datos['piezas'][$i];

                    $fkdiente       = $val['diente'];
                    $json_caras     = $val['caras'];
                    $fk_estadopieza = $val['estado_diente'];

                    $sql3 = "INSERT INTO `tab_odontograma_update` (`fk_diente`, `json_caras`, `type_hermiarcada`, `fk_estado_pieza`, `fk_tratamiento`, `fk_paciente`)";
                    $sql3 .= "VALUES(";
                    $sql3 .= "'$fkdiente' , ";
                    $sql3 .= "'".json_encode($json_caras)."' , ";
                    $sql3 .= "'no hay momentaneo' , ";
                    $sql3 .= "'$fk_estadopieza' , ";
                    $sql3 .= "'$fk_plantratamiento' , ";
                    $sql3 .= "'$fk_paciente' ";
                    $sql3 .= ")";
//                    print_r($val);
                    $rs3 = $db->query($sql3);

                    if(!$rs3){
                        $error += "Ocurrió un problema con la Operación, contacte con soporte tecnico";
                    }
                }

            }

//            print_r($json_caras); die();

            $output = [
                'error' => $error
            ];

            echo json_encode($output);
            break;

        case 'anular_estado_odontogramadet':

            $error = '';
            $id = GETPOST('id');
            $sql = "UPDATE tab_odontograma_paciente_det set estado_anulado = 'E'  WHERE rowid = $id ";
            $rrs = $db->query($sql);
            if(!$rrs){
                $error = 'Ocurrió un error con la Operación Anular, Consulte con soporte Técnico';
            }

            $output = [
                'error' => $error
            ];

            echo json_encode($output);
            break;

        case 'editnametratamiento':

            $error = '';
            $id = GETPOST('id');
            $nametratamiento = GETPOST('name');

            if($id != 0){
                $sql = "UPDATE tab_plan_tratamiento_cab set edit_name = '$nametratamiento'  WHERE rowid = $id ";
                $rrs = $db->query($sql);
                if(!$rrs){
                    $error = 'Ocurrió un error con la Operación cambiar nombre del tratamiento, Consulte con soporte Técnico';
                }
            }else{
                $error = 'Ocurrió un error con la Operación cambiar nombre del tratamiento, Consulte con soporte Técnico';
            }

            $output = [
                'error' => $error
            ];

            echo json_encode($output);

            break;

        case 'confirm_eliminar_plantratamiento':

            $subaccion  = GETPOST('subaccion');
            $idplantcab = GETPOST('idplan');
            $idpaciente = GETPOST('idpaciente');

            $acierto = 0;

            $msgConfirm = "";
            $error = 0;
            $errores = '';

            if($subaccion == 'eliminar_plantcab_preguntar')
            {
                $sql1 = "SELECT  rowid,
                            fk_cita,
                            estados_tratamiento,
                            CONCAT('Plan de Tratamiento: #', '', numero) numero,
                            edit_name, 
                            
                            (SELECT 
                                    SUM(pg.amount) AS amount
                                FROM
                                    tab_pagos_independ_pacientes_det pg
                                WHERE
                                    pg.fk_plantram_cab = p.rowid
                                        AND pg.fk_paciente = p.fk_paciente) AS saldo
                
                         FROM tab_plan_tratamiento_cab p where p.rowid = $idplantcab and p.fk_paciente = $idpaciente limit 1;";
                $rs1 = $db->query($sql1);

//                print_r($sql1);
//                die();
                if( $rs1->rowCount() > 0 )
                {
                    $objectplantram = $rs1->fetchObject();

                    if( $objectplantram->estados_tratamiento == 'E' ) #ANULADO O ELIMINADO
                    {
                        $error++;
                        $errores = 'Este plan de tratamiento ya se encuentra ANULADO';
                    }

                    if( $objectplantram->estados_tratamiento == 'A' || $objectplantram->estados_tratamiento == 'S')
                    {
                        $nametram = ($objectplantram->edit_name == null) ? $objectplantram->numero : $objectplantram->edit_name;

                        if( $objectplantram->fk_cita  > 0 ) #asociado a una cita
                        {
                            $msgConfirm = "<b>Confimar:</b> Este <b>" . $nametram . "</b> esta asociado a una cita <br>
                                                <b>continuar con la eliminación</b><br>
                                                <small><b>Si plan de tratamiento esta asociado a un Odontograma Este tambien se eliminara</b></small>";
                        }

                        if( $objectplantram->fk_cita  == 0 ) #asociado a una cita
                        {
                            $msgConfirm = "<b>Confimar:</b> Desa eliminar este <b>" . $nametram . "</b> <br>
                                                <b>continuar con la eliminación</b><br>
                                                <small><b>Si plan de tratamiento esta asociado a un Odontograma Este tambien se eliminara</b></small>";
                        }
                    }

                }else{

                    $error++;
                    $errores = 'Ese plan de tratamiento no existe';
                }
            }

            if($subaccion == 'confirm_eliminar')
            {

                #COMPRUEBO SI EN EL PLAN D ETRATAMIENTO  TIENE PRESTACIONES ASOCIADAS O SALDO
                $sqlplantrCab = "SELECT p.rowid,
                                p.fk_cita,
                                p.estados_tratamiento,
                                CONCAT('Plan de Tratamiento: #', '', p.numero) numero,
                                p.edit_name,
                                (SELECT 
                                        SUM(pg.amount) AS amount
                                    FROM
                                        tab_pagos_independ_pacientes_det pg
                                    WHERE
                                        pg.fk_plantram_cab = p.rowid
                                            AND pg.fk_paciente = p.fk_paciente) AS saldo , 
                                            
                                (select count(*) from tab_plan_tratamiento_det d where d.fk_plantratam_cab = p.rowid and d.estadodet = 'R') as prestaciones_realizadas
                                
                                FROM 
                                tab_plan_tratamiento_cab p where p.rowid = $idplantcab and p.fk_paciente = $idpaciente limit 1";
                $rsplanCab = $db->query($sqlplantrCab);
                if( $rsplanCab && $rsplanCab->rowCount() > 0 ){

                    $objPlanCab = $rsplanCab->fetchObject();

                    $puedeAnular = 0;
                    $prestacionesRealizadas = "";
                    $tieneSaldo = "";

                    if( $objPlanCab->prestaciones_realizadas > 0 ){
                        $puedeAnular++;
                        $prestacionesRealizadas .= " tiene ". $objPlanCab->prestaciones_realizadas ." prestaciones realizadas";
                    }
                    if( $objPlanCab->saldo > 0 ){
                        $puedeAnular++;
                        $tieneSaldo .= " tiene saldo asociado <i class='fa fa-dollar'> </i> ".$objPlanCab->saldo ;
                    }

                    if($puedeAnular > 0){

                        $acierto = 0; #negativo no se puede eliminar
                        $msgConfirm = "<div class='form-group col-lg-12 col-xs-12'>
                                                <b>Error:</b> <br>
                                                    <p>No se puede <b>anular</b> este plan de tratamiento  ". $prestacionesRealizadas ." ". $tieneSaldo ."</p>    
                                            </div>";
                    }

                    if( $puedeAnular == 0)
                    {

                        $acierto++;  //positivo se puede eliminar

                        #UPDATE ESTADO ANULADO
                        $sqlupdatPlant = "UPDATE `tab_plan_tratamiento_cab` SET `estados_tratamiento`='E' WHERE `rowid`='$idplantcab';";
                        $delUpd = $db->query($sqlupdatPlant);
                        if(!$delUpd)
                        {
                            $error++;
                            $errores = "Ocurrio un error con la eliminación Consulte con soporte";

                        }

                        #ELIMINACION DE PLAN DE TRATAMIENTO
                        /*
                        $sqldelcab = "DELETE FROM `tab_plan_tratamiento_cab` WHERE `rowid`='$idplantcab' and fk_paciente = $idpaciente;";
                        $delrcab = $db->query($sqldelcab);

                        if($delrcab){

                            $sqldeldet = "DELETE FROM `tab_plan_tratamiento_det` WHERE `rowid` > 0 and fk_plantratam_cab = $idplantcab ;";
                            $db->query($sqldeldet);

                        }else{
                            $error++;
                            $errores = "Ocurrio un error con la eliminación Consulte con soporte";
                        }*/


                    }
                }

            }


            $output = [
                'error' => $error , 'errores' => $errores , 'msgConfirm' => $msgConfirm, 'acierto'=> $acierto
            ];

            echo json_encode($output);
            break;


        case 'update_observacion':

            $error = '';
            $idplantcab = GETPOST('idplantram');
            $comment = GETPOST('observacion');

            if(!empty($idplantcab)){

                $sqlupdateObserv = "UPDATE `tab_plan_tratamiento_cab` SET `observacion`='$comment' WHERE `rowid`='$idplantcab'";
                $db->query($sqlupdateObserv);

            }else{
                $error = 'Ocurrio un error no se puede guardar el comentario';
            }

            $output = [
                'error' => $error ,
            ];

            echo json_encode($output);
            break;


        case 'evolucion_listprincpl':

            $error = '';

            $idpaciente = GETPOST('idpaciente');
            $idplantram = GETPOST('idplant');

            $datos['idpaciente'] = $idpaciente;
            $datos['idplan']     = $idplantram;

            $respuesta = evoluc_listprincpl( $datos );

//            print_r($respuesta); die();
            $output = [
                'data' => $respuesta ,
            ];

            echo json_encode($output);
            break;


    }
}

function CrearInsertDirecFicheroPaciente($cabezera = array(), $detalle = array(), $nombreCarpeta)
{

    global $db;

//    print_r($cabezera); die();

    $n = 0;
    if(count($cabezera) > 0)
    {

        $fk_doc      = $cabezera[0];
        $comment     = $cabezera[2];
        $titulo      = $cabezera[3];
        $fk_paciente = $cabezera[4];

        $sql = "INSERT INTO `tab_fichero_pacientes_cab` 
            (`fecha_creat`, `fk_doc`, `fk_paciente`, `titulo`, `comment`) 
            VALUES (now(), '$fk_doc',$fk_paciente,'$titulo','$comment' );";

        $db->query($sql);

        $n++;
    }

    $id = $db->lastInsertId('tab_fichero_pacientes_cab');

    if( !empty($id) )
    {
        if(count($detalle) > 0)
        {
            for ($i = 0; $i<= count($detalle)-1; $i++)
            {
                $fichero = $detalle[$i]['name']; //nombre del fichero
                $tipo    = $detalle[$i]['type']; // typo fichero

                $sql = "INSERT INTO `tab_fichero_pacientes_det` (`fk_fichero_paciente_cab`, `ruta_fichero`, `name_direct`, `type` ) VALUES ($id, '$fichero', '$nombreCarpeta', '$tipo');";
                $db->query($sql);
            }
        }


        $n++;
    }

    return $n;

}


function listcitas_admin($idPaciente, $fechaInicio, $fechafin)
{


    global $db, $conf, $user;

    $fecha_hoy = date('Y-m-d');

    $data = array();

    $sql = "select 

                    date_format(d.fecha_cita, '%Y-%m-%d')  as fecha_cita,
                    c.rowid as id_cita_cab ,
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
                    IFNULL((select es.nombre_especialidad FROM tab_especialidades_doc es where es.rowid = d.fk_especialidad), 'No asignada') as especialidad,
                    (select IFNULL(tc.edit_name, concat('Plan de tratamiento #',tc.numero)) from tab_plan_tratamiento_cab tc where tc.fk_cita = c.rowid limit 1) as plantratamiento ,
                    (select p.telefono_movil from tab_admin_pacientes p where p.rowid = c.fk_paciente) as telefono_movil ,
                    
                    -- citas atrazada con estado no confirmado
                    if( cast(d.fecha_cita as date) < '".$fecha_hoy."' && d.fk_estado_paciente_cita = 2 , concat('cita agendada atrazada - NO CONFIRMADO - ', date_format(d.fecha_cita, '%Y/%m/%d') , ' - hora ' , d.hora_inicio ) , '') as cita_atrazada
         
         from 
         
             tab_pacientes_citas_cab c , tab_pacientes_citas_det d
             where c.rowid = d.fk_pacient_cita_cab ";

    if(!empty($idPaciente)){
        $sql .= "  and c.fk_paciente = $idPaciente";
    }

//    print_r($sql);
//    die();

    $res = $db->query($sql);

    if($res->rowCount()>0){

        while ($obj = $res->fetchObject()){

            $row = array();
            $label = "";
            $diasTranscurridos = date('Y-m-d');

//            if($diasTranscurridos  == date('Y-m-d', strtotime($obj->fecha_cita))) //cita Hoy
//            {
//                $label = "Esta cita es para Hoy";
//                $label = " <small style='padding: 1px; background-color: #48cc58; border-radius: 5px;  color: #f0f0f0'> $label </small>";
//            }

            //CITAS A TRAZADAS
            $citas_atrazadas = "";
            if( $obj->cita_atrazada != "")
            {
                $citas_atrazadas = "<small style='display: block; color: red' class='label text-center'> ". $obj->cita_atrazada ." </small>";
            }


            #FECHA Y HORA DE LA CITAS
            $row[] = "<div title='hora y fecha de entrada'>
                            <p>". $obj->fecha_cita ."</p>
                            <p>". $obj->hora_inicio ."</p>
                      </div>";

            $row[] = $obj->especialidad;

            $row[] = "<p title='número de cita'> <img  src='". DOL_HTTP. "/logos_icon/logo_default/cita-medica.png' class='img-sm img-rounded'  > - " . str_pad($obj->id_cita_cab, 6, "0", STR_PAD_LEFT) ."</p>";

            $row[] =  "" . (($obj->comentario == "") ? "" : $obj->comentario) . "" .$citas_atrazadas;

            $row[] = ($obj->plantratamiento == "") ? "" : $obj->plantratamiento;

            $row[] = "<label class='label' style='background-color: $obj->color !important; font-size: 1.5rem; color: #333333'> $obj->estado </label>";

            $row[] = "";

            $data[] = $row;
        }
    }

    return $data;
}

//lista de documentos filtrados
function info_type_document_pacient($idpaciente="")
{

    global  $db;

    $data = array();

    $sql = "
            SELECT 
                cl.rowid AS rowid,
                cl.tms AS fecha,
                cl.label AS label,
               
                -- loging del creador del documento
                (SELECT 
                        (SELECT 
                                    CONCAT(o.nombre_doc, ' ', apellido_doc)
                                FROM
                                    tab_odontologos o
                                WHERE
                                    o.rowid = s.fk_doc) AS labl
                    FROM
                        tab_login_users s
                    WHERE
                        s.rowid = cl.fk_usuario_logeado) AS login_creador_document,
                        
                        
                -- id tipo de documento
                cl.fk_document_clinico AS fk_documento,
                -- id del documento
                cl.fk_document_det
                
        FROM
            tab_documentos_clinicos_admin cl
        WHERE
            cl.rowid > 0 ";

    $sql .= " and cl.fk_paciente =".$idpaciente;

    $resul = $db->query($sql);

    if($resul->rowCount()>0)
    {
        while ($Fila = $resul->fetchObject())
        {
            $row = array();


            $row[] = date("Y/m/d", strtotime($Fila->fecha));
            $row[] = $Fila->label;
            $row[] = "Creado x Doc(a) " . (($Fila->login_creador_document=="") ? "No asignado": $Fila->login_creador_document);
            $row[] = "<div class='form-group col-md-12 col-xs-12'>
                        <ul class='list-inline pull-right'>
                           
                            <li class='btn lipdf'    data-idtipo='$Fila->fk_documento'  data-iddocument='$Fila->fk_document_det' id='impr_pdf'>
                                 <a href='#' class='impripdf' >  <img src='". DOL_HTTP ."/logos_icon/logo_default/pdf.png' alt='Export - pdf' class='img-rounded img-md'> </a> 
                            </li>
                            
                            <li class='btn liexcel '  data-idtipo='$Fila->fk_documento'  data-iddocument='$Fila->fk_document_det'> 
                                <a href='#' class='disabled_link3'> <img src='". DOL_HTTP ."/logos_icon/logo_default/xls.png' alt='Export - pdf' class='img-rounded img-md'> </a> 
                            </li>
                             
                            <li class='btn limodificar'  data-idtipo='$Fila->fk_documento'  data-iddocument='$Fila->fk_document_det'> 
                                <a href='" . DOL_HTTP . "/application/system/pacientes/pacientes_admin/?view=docummclin&key=". KEY_GLOB ."&id=". tokenSecurityId( $idpaciente ) ."&v=docum_clin&dt=". $Fila->fk_documento ."&iddocmnt=". $Fila->fk_document_det ."'> 
                                    <img src='". DOL_HTTP ."/logos_icon/logo_default/modificar-icon.png' alt='Export - pdf' class='img-rounded img-md'> 
                                </a> 
                            </li>
                            
                        </ul>
                      </div>";


            $row[] = $Fila->fk_documento; //id del documento
            $row[] = $Fila->fk_document_det; #id del documento detallado "tab_documentos_clinicos_admin"
            $row[] = $Fila->rowid; #Id de la cabezera principal tabla del documento tab_documentos_ficha_clinica o puede ser diferentes tablas

            $data[] = $row;
        }

    }

    return $data;

}


function realizarPrestacionupdate($datos = array())
{
    global  $db , $conf;

    if( count($datos) != 0)
    {
        $sqlrealizar =  "INSERT INTO `tab_evolucion_plantramiento` (`fecha_create`, `fk_paciente`, `fk_plantram_cab`, `fk_plantram_det`, `observacion`, `fk_diente`, `json_caras`, `estado_diente`, `fk_doctor`, `id_login`)";
        $sqlrealizar .= "VALUES (";
        $sqlrealizar .= " now() ,";
        $sqlrealizar .= " $datos->fk_paciente , ";
        $sqlrealizar .= " $datos->fk_plantram_cab , ";
        $sqlrealizar .= " $datos->fk_plantram_det , ";
        $sqlrealizar .= " '$datos->observacion' , ";
        $sqlrealizar .= " $datos->iddiente , ";
        $sqlrealizar .= " '$datos->json_caras ', ";
        $sqlrealizar .= " $datos->estadodiente , ";
        $sqlrealizar .= " $datos->fk_doctor , ";
        $sqlrealizar .= " $datos->idlogin  ";
        $sqlrealizar .= " ) ";

        $rs = $db->query($sqlrealizar);

        if(!$rs){
            return 'Ocurrio un error no se realizar la evolución';

        }else{

            $sqlUpdattramm =  "UPDATE `tab_plan_tratamiento_det` SET";
            $sqlUpdattramm .= "  `estadodet`       = 'R'  ," ;
            $sqlUpdattramm .= "  `realizada_fk_dentista`    =  $conf->login_id  ," ;
            $sqlUpdattramm .= "  `evolucion_escrita`        ='$datos->observacion' , " ;
            $sqlUpdattramm .= "  `fk_estado_odontograma`    = $datos->estadodiente  " ;
            $sqlUpdattramm .= "   WHERE `rowid`= $datos->fk_plantram_det ";

            $rsUp = $db->query($sqlUpdattramm);
            if(!$rsUp){
                return 'Ocurrio un error no se pudo realizar la evulución de manera correcta';
            }
        }

    }

    return '';

}

#LIST EVOLUCIONES PRINCIPAL
function evoluc_listprincpl( $datos )
{
    global  $db;

    $data = array();

    $sqlevolucprip = "SELECT 
                        ifnull(c.edit_name, concat('Plan de Tratamiento ', 'N. ', c.numero)) plantram ,
                        ev.fecha_create fechaevul ,
                        cp.descripcion as presstacion, 
                        ev.fk_diente as diente , 
                        (select concat( o.nombre_doc , ' ', o.apellido_doc ) from tab_odontologos o where o.rowid = ev.fk_doctor) as doct , 
                        ev.observacion , 
                        ifnull((select odes.descripcion from tab_odontograma_estados_piezas odes where odes.rowid = ev.estado_diente), 'Estado no asignado' )as estadodiente , 
                        ev.json_caras
                    FROM
                        tab_evolucion_plantramiento ev , 
                        tab_plan_tratamiento_cab c , 
                        tab_plan_tratamiento_det d , 
                        tab_conf_prestaciones cp
                    WHERE
                        ev.fk_plantram_cab = c.rowid and 
                        ev.fk_plantram_det = d.rowid and 
                        d.fk_prestacion = cp.rowid and 
                    
                         ";
    $sqlevolucprip .= " ev.fk_paciente =  " . $datos['idpaciente'] . "  ";

    if( !empty( $datos['idplan'] ) ){

        $sqlevolucprip .= " and ev.fk_plantram_cab =  " . $datos['idplan'] . "  ";
    }

    $rsevol = $db->query($sqlevolucprip);

    if( $rsevol && $rsevol->rowCount() > 0){

        while ( $objevol =   $rsevol->fetchObject() )
        {

            $cadena_caras = array();
            $caras = json_decode($objevol->json_caras);

            $cadena_caras[] = ($caras->vestibular=="true") ? "vestibular" : "";
            $cadena_caras[] = ($caras->distal=="true") ? "distal" : "";
            $cadena_caras[] = ($caras->palatino=="true") ? "palatino" : "";
            $cadena_caras[] = ($caras->oclusal=="true") ? "oclusal" : "";
            $cadena_caras[] = ($caras->lingual=="true") ? "lingual" : "";

//            print_r( implode(',', array_filter( $cadena_caras )) );
//            die();

            $row   = array();
            $row[] = date('Y/d/m', strtotime( $objevol->fechaevul ) );
            $row[] = $objevol->plantram;
            $row[] = $objevol->presstacion;
            $row[] = $objevol->diente;
            $row[] = $objevol->estadodiente;
            $row[] = $objevol->doct;
            $row[] = $objevol->observacion;
            $row[] = "". (implode(',', array_filter( $cadena_caras ))) ; #lista de caras

            $data[] = $row;

        }
    }

//    print_r($data); die();
    return $data;

}


?>