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
                                "text"   => $obj->comentario,
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
                            "text"       => $obj->comentario,
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

        case "nuevoUpdate_documento_clinico":

            $error = false;
            $dataPrincipal = GETPOST("principal");
            $hay_id = GETPOST("hay_id"); //Si hay id se modifica eliminando el anterior
            $hay_id_cabezera = GETPOST("hay_id_cab"); //id de la cabezra que se update

            $idpaciente = GETPOST("idpaciente");

            if(GETPOST("subaccion") == "ficha_clinica_general")
            {
                if(!empty($hay_id) && !empty($hay_id_cabezera)) //si es diferente a vacio eliminando el doc anterior y actualizando el nuevo
                {

//                    die()
                    #UPDATE LA FICHA CLINICA DE ESTE DOCUMENTO
                    $sqlDel = "DELETE FROM `tab_documentos_ficha_clinica` WHERE (`rowid` = '$hay_id');";
                    $db->query($sqlDel);

                    $error = nuevoUpdateFichaClinicaGeneral((object)$dataPrincipal); //Se crea uno nuevo
                    $id_docuemnt_det = $db->lastInsertId("tab_documentos_ficha_clinica"); #obtengo el id del documento q se acaba de crear actualizando la cabezera con este id

                    if($error==true)
                    {
                        #update tab_documentos_clinicos_admin
                        #el Type es el tipo de documento
                        $error = documentosClinicosAdministrativos(1,"Ficha Clinica", 1, 'update', $id_docuemnt_det, $hay_id_cabezera, $idpaciente);
                    }

                }
                else{

//                    die();
                    $error = nuevoUpdateFichaClinicaGeneral((object)$dataPrincipal);
                    $id_docuemnt_det = $db->lastInsertId("tab_documentos_ficha_clinica");

                    if($error==true)
                    {
                        #inserta tab_documentos_clinicos_admin
                        $error = documentosClinicosAdministrativos(1,"Ficha Clinica", 1, 'nuevo', $id_docuemnt_det, 0, $idpaciente);
                    }

                }

            }

            $output = [
              "error" => $error
            ];

            echo json_encode($output);
            break;

        case "list_informacion_doc":

            $data = array();

            $idpaciente = GETPOST('idpaciente');

            $sql = "SELECT 
                    cl.rowid  as rowid , 
                    cl.tms as fecha , 
                    cl.label as label ,
                    (select (select concat(o.nombre_doc, ' ', apellido_doc) from tab_odontologos o where o.rowid = s.fk_doc) as labl from tab_login_users s where s.rowid = cl.fk_usuario_logeado) as login ,
                    cl.fk_document_clinico as fk_documento ,
                    cl.fk_document_det
                    FROM tab_documentos_clinicos_admin cl WHERE cl.rowid > 0";

            $sql .= " and cl.fk_paciente =".$idpaciente;

            $resul = $db->query($sql);

            if($resul->rowCount()>0)
            {
                while ($Fila = $resul->fetchObject())
                {
                    $row = array();

                    $row[] = "<input type='checkbox' class='selectChecked' data-idtipo='$Fila->fk_documento'  data-iddocument='$Fila->fk_document_det'  >";
                    $row[] = date("Y/m/d", strtotime($Fila->fecha));

                    $numero = "DOCT-" . str_pad($Fila->rowid, 7, "0", STR_PAD_LEFT);

                    $row[] = $Fila->label." ".$numero;
                    $row[] = "Doc(a) " . $Fila->login;
                    $row[] = $Fila->fk_documento; //id del documento

                    $row[] = $Fila->fk_document_det; #id del documento detallado "tab_documentos_clinicos_admin"
                    $row[] = $Fila->rowid; #Id de la cabezera principal tabla del documento tab_documentos_ficha_clinica o puede ser diferentes tablas

                    $data[] = $row;
                }

            }

            $output = [
                "data" => $data,
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

            $sql1   = "SELECT max(rowid) as rowid FROM tab_odontograma_paciente_cab";
            $rs1    = $db->query($sql1);
            $numero = (double)( $rs1->fetchObject()->rowid + 1 ); #ultimo id mas el + 1

//            print_r($numero); die();
            if( $puedoPasar == 0){

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

            $sql = "select 
                    dc.fecha,
                    dc.rowid, 
                    dc.numero,
                    dc.descripcion,
                    dc.fk_tratamiento
                    from tab_odontograma_paciente_cab dc where dc.rowid > 0";

            if(!empty($idpaciente)){
                $sql .= " and dc.fk_paciente = ".$idpaciente;
            }
            $resul = $db->query($sql);

            if($resul->rowCount()>0){

                while ( $ob = $resul->fetchObject() )
                {
                    $row = array();

                    $itemAsociarOdontograma = "";
                    if($ob->fk_tratamiento == 0){

                        $itemAsociarOdontograma = "<p>
                            <b>Asociar Odontograma</b>
                        </p>";

                    }


                    $row[] = '';
                    $row[] = date('Y/m/d', strtotime($ob->fecha));
                    $row[] = 'Odontograma N.'.$ob->numero;
                    $row[] = $ob->descripcion;
                    $row[] = "N. Tratamiento ". str_pad($ob->fk_tratamiento, 6, "0", STR_PAD_LEFT);
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
                    CONCAT(od.nombre_doc, ' ', od.apellido_doc) nombre_doc,
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
                            
                    tc.edit_name as edit_name
                FROM
                    tab_plan_tratamiento_cab tc,
                    tab_admin_pacientes ap,
                    tab_odontologos od
                WHERE
                    tc.fk_paciente = ap.rowid
                        AND tc.fk_doc = od.rowid 
                        AND tc.rowid = ".$idtratamiento." limit 1";

            $rscab = $db->query($sqltrancab);
            if($rscab->rowCount() > 0 ){

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
                        pd.desc_convenio AS descconvenio,
                        pd.desc_adicional AS descadicional,
                        pd.json_caras,
                        pd.total,
                        pd.estadodet
                    FROM
                        tab_plan_tratamiento_det pd,
                        tab_conf_prestaciones cp
                    WHERE
                        pd.fk_prestacion = cp.rowid
                        AND pd.fk_plantratam_cab = ".$idtratamiento." ";
            $rsd = $db->query($sqltransdet);

            if($rsd->rowCount()>0){
                while ($obdet = $rsd->fetchObject()){

                    $objetoDet[] = $obdet;
                }

            }else{
                $error = 'Ocurrio un error , consulte con soporte Tecnico';
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

            $idpaciente = GETPOST('idpaciente');

            $dataprincipal = array();

            $sql = "SELECT 
                    tc.rowid , tc.numero , 
                    tc.fk_paciente , concat(ap.nombre , ' ', ap.apellido) nombre ,
                    tc.fk_paciente , 
                    tc.fk_doc fkdoc , concat(od.nombre_doc, ' ', od.apellido_doc) nombre_doc ,
                    tc.estados_tratamiento , 
                    tc.ultima_cita , tc.situacion , 
                    tc.edit_name as edit_name ,
                    tc.fk_paciente as idpaciente
                    FROM 
                    tab_plan_tratamiento_cab tc , tab_admin_pacientes ap , tab_odontologos od 
                    where tc.fk_paciente = ap.rowid and tc.fk_doc = od.rowid";
            $sql .= " and tc.fk_paciente = ".$idpaciente." ";

//            print_r($idpaciente);
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
                    $row[] = $ob->rowid;

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

            $sql = "";

            $output = [
              'error' => $error
            ];
            break;

        case 'fecht_odontograma':

            $error = '';
            $dataprincipal = array();
            $idpaciente    = GETPOST('idpaciente');
            $idtratamiento = GETPOST('idtratamiento');

            if($idpaciente != "" && $idtratamiento != ""){

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
//                    print_r($val);
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

function nuevoUpdateFichaClinicaGeneral($dataPrincipal = array())
{

    global $db, $conf;

    $error = false;

//    print_r($dataPrincipal); die();

    $sqlNuevoUpdate = "INSERT INTO tab_documentos_ficha_clinica(";
    $sqlNuevoUpdate .= "   nombre_apellido";
    $sqlNuevoUpdate .= " , cedula_pasaporte";
    $sqlNuevoUpdate .= " , fecha_nacimiento";
    $sqlNuevoUpdate .= " , lugar_nacimiento";
    $sqlNuevoUpdate .= " , estado_civil";
    $sqlNuevoUpdate .= " , n_hijos";
    $sqlNuevoUpdate .= " , sexo";
    $sqlNuevoUpdate .= " , edad";
    $sqlNuevoUpdate .= " , ocupacion";
    $sqlNuevoUpdate .= " , direccion_domicilio";
    $sqlNuevoUpdate .= " , emergencia_call_a";
    $sqlNuevoUpdate .= " , emergencia_telefono";
    $sqlNuevoUpdate .= " , telefono_convencional";
    $sqlNuevoUpdate .= " , operadora";
    $sqlNuevoUpdate .= " , celular";
    $sqlNuevoUpdate .= " , email";
    $sqlNuevoUpdate .= " , twiter";
    $sqlNuevoUpdate .= " , lugar_trabajo";
    $sqlNuevoUpdate .= " , telefono_trabajo";
    $sqlNuevoUpdate .= " , posee_seguro";
    $sqlNuevoUpdate .= " , motivo_consulta";
    $sqlNuevoUpdate .= " , tiene_enfermedades";
    $sqlNuevoUpdate .= " , otras_enfermedades";

    $sqlNuevoUpdate .= " , esta_algun_tratamiento_medico";
    $sqlNuevoUpdate .= " , cual_tratamiento_medico";

    $sqlNuevoUpdate .= " , tiene_problema_hemorragico";
    $sqlNuevoUpdate .= " , cual_problema_hemorragico";

    $sqlNuevoUpdate .= " , alergico_medicamento";
    $sqlNuevoUpdate .= " , cual_alergico_medicamento";

    $sqlNuevoUpdate .= " , toma_medicamento";
    $sqlNuevoUpdate .= " , cual_toma_medicamento";

    $sqlNuevoUpdate .= " , esta_embarazada";
    $sqlNuevoUpdate .= " , cual_esta_embarazada";

    $sqlNuevoUpdate .= " , enfermedades_hereditarias";
    $sqlNuevoUpdate .= " , cual_enfermedades_hereditarias";

    $sqlNuevoUpdate .= " , que_toma_ult_24horass";
    $sqlNuevoUpdate .= " , resistente_medicamento";
    $sqlNuevoUpdate .= " , hemorragia_bucales";
    $sqlNuevoUpdate .= " , complicacion_masticar";
    $sqlNuevoUpdate .= " , habitos_consume";

    $sqlNuevoUpdate .= ")";
    $sqlNuevoUpdate .= "VALUES(";

    $sqlNuevoUpdate .= "  '$dataPrincipal->doc_nombre_apellido'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_cedula'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_fecha_nc'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_lugar_n'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_estado_civil'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_hijos_n'";
    $sqlNuevoUpdate .= ", '".json_encode($dataPrincipal->sexo)."'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_edad'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_ocupacion'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_domicilio'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_emergencia_call_a'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_emergencia_telef'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_telef_convencional'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_operadora'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_celular'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_email'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_twiter'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_lugar_trabajo'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_telef_trabajo'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_q_seguro_posee'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_motivo_consulta'";

    $sqlNuevoUpdate .= ", '".json_encode($dataPrincipal->enfermedades)."'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_otras_enferm'";

    $sqlNuevoUpdate .= ", '". json_encode($dataPrincipal->segui_tratamiento) ."'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_tratmient_descrip'";

    $sqlNuevoUpdate .= ", '". json_encode($dataPrincipal->problemas_hemorragicos) ."'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_descrip_hemorragicos'";

    $sqlNuevoUpdate .= ", '". json_encode($dataPrincipal->alergico_medicamento) ."'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_descrip_alergia'";

    $sqlNuevoUpdate .= ", '". json_encode($dataPrincipal->toma_medicamento_frecuente) ."'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_descrip_medicamento'";

    $sqlNuevoUpdate .= ", '". json_encode($dataPrincipal->embarazada) ."'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_descrip_embarazada'";

    $sqlNuevoUpdate .= ", '". json_encode($dataPrincipal->enferm_hederitarias) ."'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_descript_hederitaria'";

    $sqlNuevoUpdate .= ", '$dataPrincipal->q_medicina_tomo_24h_ultima'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_resistente_medicamento'";

    $sqlNuevoUpdate .= ", '". json_encode($dataPrincipal->hemorragias_bocales) ."'";

    $sqlNuevoUpdate .= ", '". json_encode($dataPrincipal->complicaciones_masticar) ."'";

    $sqlNuevoUpdate .= ", '". json_encode($dataPrincipal->abitos_consume) ."'";


    $sqlNuevoUpdate .= ")";

    $rs = $db->query($sqlNuevoUpdate);

    if($rs) { $error = true; }


    return $error;

}

function documentosClinicosAdministrativos( $type, $label, $type_documento, $nuevoUpdate, $id_document_det , $hay_cabezra, $idpaciente)
{

    global $db, $conf;

    $error = false;

    if($type==1) //FICHA CLINICA
    {
        switch ($nuevoUpdate)
        {
            case 'nuevo':

                $sql = "INSERT INTO `tab_documentos_clinicos_admin` (`label`, `fk_document_clinico`, `fk_usuario_logeado`, `fk_document_det`, `fk_paciente`) VALUES ('$label','$type_documento', '$conf->login_id', '$id_document_det', '$idpaciente');";
                $rs = $db->query($sql);

                if($rs){

                    $error = true;
                }

                break;

            case 'update':

                $sqlUpdate = "UPDATE tab_documentos_clinicos_admin SET `fk_document_det` = '$id_document_det' WHERE (`rowid` = '$hay_cabezra');";
                $rs = $db->query($sqlUpdate);

                if($rs){

                    $error = true;
                }

                break;
        }
    }

    return $error;
}

function listcitas_admin($idPaciente, $fechaInicio, $fechafin){

    global $db, $conf, $user;

    $data = array();

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
            
            					(select p.telefono_movil from tab_admin_pacientes p where p.rowid = c.fk_paciente) as telefono_movil
                
         from 
             tab_pacientes_citas_cab c , tab_pacientes_citas_det d
             where c.rowid = d.fk_pacient_cita_cab ";

    if(!empty($idPaciente)){
        $sql .= "  and c.fk_paciente = $idPaciente";
    }

//    print_r($sql);
    $res = $db->query($sql);

    if($res->rowCount()>0){

        while ($obj = $res->fetchObject()){

            $row = array();
            $numeroTratamiento = "TRTAMIENTO-0001";

            $label = "";
            $diasTranscurridos = date('Y-m-d');

            if($diasTranscurridos  == date('Y-m-d', strtotime($obj->fecha_cita))) //cita Hoy
            {
                $label = "Esta cita es para Hoy";
                $label = " <small style='padding: 1px; background-color: #48cc58; border-radius: 5px;  color: #f0f0f0'> $label </small>";

            }

            $row[] = $numeroTratamiento;
            $row[] = $obj->doct;
            $row[] = "<p style='margin: 0px'> ".date('Y/m/d', strtotime($obj->fecha_cita))."</p>$label";
            $row[] = $obj->especialidad;
            $row[] = $obj->estado;

            $data[] = $row;
        }
    }

    return $data;
}

function fetchplantratamiento($datos = array()){

}

?>