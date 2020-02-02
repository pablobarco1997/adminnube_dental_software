<?php

session_start();
require_once '../../../config/lib.global.php';
require_once DOL_DOCUMENT. '/application/config/main.php'; //el main contiene la sesion iniciada
require_once DOL_DOCUMENT.'/application/config/conneccion_entidad.php'; //Coneccion entidad

global   $db, $conf, $user, $global;

if(isset($_GET['ajaxSend']) || isset($_POST['ajaxSend']))
{
    $accion = GETPOST('accion');

    switch ($accion)
    {

//        GESTION DE ODONTOLOGOS ================================================

        case 'crear_odontologo':

            $error = '';

            $subaccion  = GETPOST('subaccion');
            $objeto     = GETPOST('datos');
            $datos      = json_decode($objeto);

//            print_r($datos);
//            die();

            $nombre         = $datos->nombre;
            $apellido       = $datos->apellido;
            $telefono       = $datos->telefono;
            $direccion      = $datos->direccion;
            $celular        = $datos->celular;
            $email          = $datos->email;
            $ciudad         = $datos->ciudad;
            $especialidad   = $datos->especialidad;


            if($subaccion == 'nuevo'){
                $rs  = nuevoUpdateOdontologos($nombre, $apellido, $celular, $telefono, $email, $direccion, $ciudad, $especialidad);

                if($rs == false){
                    $error = "Ocurrió un error con la Operación";
                }

                $ultimo_id = $db->lastInsertId('tab_odontologos');
                $name_icon = "";

                if( $rs == true )
                {
                    if(isset($_FILES['icon']))
                    {
                        $type = "";
                        if($_FILES['icon']['type'] == 'image/png'){
                            $type = ".png";
                        }

                        if($type != ""){
                            $name_icon = 'conf_odont_icon_'.$ultimo_id.'_'.$conf->EMPRESA->ENTIDAD.$type; #name del fichero SE MUEVA A LA CARPETA QUE SE CREA POR DEFAUL PARA ESTA EMPRESA
                            $urlFile = UploadFicherosLogosEntidadGlob($name_icon, $_FILES['icon']['type'], $_FILES['icon']['tmp_name']);
                            if($urlFile != false){
                                if(file_exists($urlFile)){
                                    $sqlUpdateIcon = "UPDATE `tab_odontologos` SET `icon`='$name_icon' WHERE `rowid`= $ultimo_id;";
                                    $rUp = $db->query($sqlUpdateIcon);
                                    if(!$rUp){
                                        $error = "Ocurrió un error con la Operación - No se pudo subir el icon";
                                    }
                                }
                            }
                        }


                    }
                }

            }
            if($subaccion == 'modificar'){

                $id = GETPOST('id');
//                print_r($ciudad);
                $rs = UpdateOdontologos($nombre, $apellido, $celular, $telefono, $email, $direccion, $ciudad, $especialidad, GETPOST('id'));
                if($rs == false){
                    $error = "Ocurrió un error con la Operación";
                }

                if( $rs == true )
                {
                    if(isset($_FILES['icon']))
                    {
                        $type = "";
                        if($_FILES['icon']['type'] == 'image/png'){
                            $type = ".png";
                        }

                        if($type != ""){
                            $name_icon = 'conf_odont_icon_'.$id.'_'.$conf->EMPRESA->ENTIDAD.$type; #name del fichero SE MUEVA A LA CARPETA QUE SE CREA POR DEFAUL PARA ESTA EMPRESA
                            $urlFile = UploadFicherosLogosEntidadGlob($name_icon, $_FILES['icon']['type'], $_FILES['icon']['tmp_name']);
                            if($urlFile != false){
                                if(file_exists($urlFile)){
                                    $sqlUpdateIcon = "UPDATE `tab_odontologos` SET `icon`='$name_icon' WHERE `rowid`= $id;";
                                    $rUp = $db->query($sqlUpdateIcon);
                                    if(!$rUp){
                                        $error = "Ocurrió un error con la Operación - No se pudo subir el icon";
                                    }
                                }
                            }
                        }


                    }
                }

            }
//            die();
            $output = [
                'error' => $error
            ];

            echo json_encode($output);
            break;

        case 'list_odontologos':

            $error = '';

            $estado = GETPOST('estado');

            $error = list_odontolosGention($estado);

            $output = [
                'data' => $error
            ];

            echo json_encode($output);
            break;

        case 'fetch_odontologos':

            $error = '';

            $obj = getnombreDentiste(GETPOST('id'));

//            print_r($obj);

            $output = [
                'error' => $obj
            ];
            echo json_encode($output);
            break;

        case 'actualizar_estados':

            $error = '';

            $estado = GETPOST('estado');
            $id     = GETPOST('id'); #id odontologos

            $sql = 'UPDATE `tab_odontologos` SET `estado` = TRIM(\''.$estado.'\') WHERE (`rowid` = '.$id.');';
            $rs = $db->query($sql);

            if($rs){

                $sqllogi2 = "UPDATE `tab_login_users` SET `estado`='$estado' WHERE `rowid`>0 and fk_doc =".$id." ;";
                $rs12 = $db->query($sqllogi2);

                if($rs12){

                    #verifica si doctor(a) tiene login asociado
                    $sqllogin = "SELECT * FROM tab_login_users WHERE fk_doc =".$id." limit 1";
                    $rs1  = $db->query($sqllogin);
                    if($rs1->rowCount() > 0){

                        #se actualiza el login glob
                        $idUsuario = $rs1->fetchObject()->rowid;
                        $Entidad_Login = new CONECCION_ENTIDAD();
                        $Entidad_Login->login_status($estado, $idUsuario, $conf->EMPRESA->ID_ENTIDAD);
                    }

                }else{
                    $error = 'Ocurrió un error con la Operación, consulte con soporte Técnico';
                }

            }

            if(!$rs){
                $error = 'Ocurrió un error con la Operación, consulte con soporte Técnico';
            }

            $output = [
                'error' => $error
            ];
            echo json_encode($output);
            break;

        case 'consultar_usuario':

            $error = "";
            $subaccion = GETPOST('subaccion');
            $sql = "SELECT * FROM tab_login_users WHERE rowid > 0 ";

            if($subaccion == 'doct_usuario'){ #doctor con usuario
                $sql .= " and fk_doc = ". GETPOST('iddoctor') ." ";
            }
            if($subaccion == 'usuario_rep'){ #usuario repetido
                $sql .= " and usuario = '".GETPOST('usuario') ."'";
            }
            $rs = $db->query($sql);

            if($rs->rowCount()>0){ #si encuentro Usuario

                if($subaccion=='doct_usuario'){
                    $error = "Este Doctor ya tiene asociado un Usuario";
                }
                if($subaccion=='usuario_rep'){
                    $error = "Este Usuario ya se encuentra en Uso, Ingrese un Usuario que no este en Uso";

                    $Entidad_Login = new CONECCION_ENTIDAD(); //OBTENGO LAS FUNCIONES DE LA FUNCION PRINCIPAL
                    $error = $Entidad_Login->COMPROBAR_USUARIO_REPETIDO( GETPOST('usuario') );  #compruebo el usuario global
                }

            }
            if(!$rs){
                $error = 'Ocurrió un error con la Operación, consulte con soporte Técnico';
            }
            $output = [
                'error' => $error
            ];

            echo json_encode($output);
            break;

        case 'fech_usuariodoct':

            $error ='';
            $idusuario = GETPOST('id');

            $error = getnombreUsuario( $idusuario ); #obtengo un objeto

            echo json_encode($error);
            break;

        case 'nuevoUpdateUsuario':

            $error='';

            $subaccion = GETPOST('subaccion');

            $doctor         = GETPOST('doctor');
            $usuario        = GETPOST('usuario');
            $passd          = explode('-', GETPOST('passwords'));
            $tipoUsuario    = GETPOST('tipoUsuario');
            $permisos       = GETPOST('permisos');

//            die();
            if($subaccion == 'nuevo'){

                $sqlinvalic = "SELECT * FROM tab_login_users where fk_doc = $doctor";
                $rsinvalic  = $db->query($sqlinvalic);

                #si tiene un usuario asignado
                if($rsinvalic->rowCount() > 0){
                    $error = 'Ya tiene Usuario asignado';
                }else

                    $sql = "INSERT INTO `tab_login_users` (`usuario`, `passwords` ,`fk_doc`, `permisos`, `tipo_usuario`, `passwor_abc`) ";
                    $sql .= "VALUES(";
                    $sql .= "'$usuario',";
                    $sql .= " md5('".$passd[1]."'),"; #encrypt md5
                    $sql .= "'$doctor',";
                    $sql .= "'".json_encode($permisos)."',";
                    $sql .= "'$tipoUsuario',";
                    $sql .= "'".$passd[0]."' "; #encryt base64
                    $sql .= ");";
                    $rs = $db->query($sql);

    //                print_r($sql);
                    if(!$rs){
                        $error = 'Ocurrió un error con la Operación crear Usuario, consulte con soporte Técnico';
                    }
                    if($rs){

                        $datos = [];


                        $idusuarioCreado = $db->lastInsertId('tab_login_users');
                        $ob = getnombreDentiste($doctor);

                        $datos['nombre']       = $ob->nombre_doc;
                        $datos['apellido']     = $ob->apellido_doc;
                        $datos['celular']      = $ob->celular;
                        $datos['pass']         = $passd[1];
                        $datos['email']        = $ob->email;
                        $datos['usuario']      = $usuario;
                        $datos['id_usuario']   = $idusuarioCreado;

                        $error = GenerarUsuarioGlob($datos, $subaccion);
                    }
            }
            if($subaccion == 'modificar'){

                $idUsuariolink = GETPOST('idUsuario'); #id usuario de la tab_login_users

                if( $idUsuariolink != ""  || $idUsuariolink != "0"){

                    $sql1  = " UPDATE `tab_login_users` SET ";
                    $sql1 .= "`usuario`='$usuario' ,";
                    $sql1 .= "`passwor_abc`='".$passd[0]."' ,";
                    $sql1 .= "`passwords`= md5('".$passd[1]."') ,";
                    $sql1 .= "`permisos`= '".json_encode($permisos)."' ,";
                    $sql1 .= "`tipo_usuario`='".$tipoUsuario."' ";

                    $sql1 .= " WHERE `rowid`= '$idUsuariolink'";
                    $rs1 = $db->query($sql1);

                    if(!$rs1){
                        $error = 'Ocurrió un error con la Operación Modificar el Usuario, consulte con soporte Técnico';;
                    }

                    if($rs1){

                        $datos = [];
                        $ob = getnombreDentiste($doctor); #obtengo el dastos del dentista

                        $datos['nombre']       = $ob->nombre_doc;
                        $datos['apellido']     = $ob->apellido_doc;
                        $datos['celular']      = $ob->celular;
                        $datos['pass']         = $passd[1]; #pass se encrypt md5
                        $datos['email']        = $ob->email;
                        $datos['usuario']      = $usuario;
                        $datos['id_usuario']   = $idUsuariolink;

//                        print_r($datos); die();
                        $error = GenerarUsuarioGlob($datos, $subaccion);
                    }
//                    print_r($sql1);

                }else{
                    $error = 'Ocurrió un error con la identidad del Usuario al modificar, consulte con soporte Técnico';
                }

            }
            $output = [
                'error' => $error
            ];

            echo json_encode($output);
            break;

        case 'nuevo_update_especialidad':

            $error = '';
            $nomespecialidad = GETPOST('especialidad');
            $descrip         = GETPOST('descrip');

            $sql = "INSERT INTO `tab_especialidades_doc` (`nombre_especialidad`, `fk_user`, `descripcion`) VALUES ('$nomespecialidad', '$user->id', '$descrip');";
            $rs = $db->query($sql);
            if(!$rs){
                $error = 'Ocurrió un error al crear la especialidad, consulte con Soporte Técnico';
            }
            $output = [
                'error' => $error
            ];

            echo json_encode($output);
            break;

        case 'list_especialidades':

            $data = array();
            $sql = "SELECT * FROM tab_especialidades_doc";
            $rs = $db->query($sql);

            if($rs->rowCount()>0)
            {
                while ($ob = $rs->fetchObject()){

                    $row = array();
                    $row[] = date('Y/m/d', strtotime($ob->tms));
                    $row[] = $ob->nombre_especialidad;
                    $row[] = $ob->descripcion;
                    $row[] = "<a  class='btn' style='font-size: 1.7rem; color: #9f191f;' title='eliminar' onclick='eliminar_especialidad($ob->rowid)'>  <i class='fa  fa-trash'></i> </a> ";

                    $data[] = $row;
                }
            }

            $output = [
                'data' => $data
            ];

            echo json_encode($output);

            break;

        case 'delete_especialidad':

            $error= '';

            $id  = GETPOST('id');

            $sql = "DELETE FROM tab_especialidades_doc WHERE `rowid`='$id';";
            $rs = $db->query($sql);

            if($rs){
                $iddoct = array();
                $sql1 = "Select * from tab_odontologos where fk_especialidad = $id";
                $rs1 = $db->query($sql1);
                if($rs1->rowCount()>0){

                    while ($ob1 = $rs1->fetchObject()){
                        $iddoct[] = $ob1->rowid; #obtengo cadenas de id del doctor con esta especialidad
                    }
                }

                if(count($iddoct)>0){

                    $sql2 = "UPDATE `tab_odontologos` SET `fk_especialidad`= 0 WHERE `rowid` in( ". implode(',', $iddoct) ." );";
                    $db->query($sql2);
                }
            }
            if(!$rs){
                $error = 'Ocurrió un error con la Operación Eliminar especialidad, Consulte con Soporte Técnico';
            }
            $output = [
                'error' => $error
            ];

            echo json_encode($output);
            break;

//            PRESTACION ============================================

        case 'nuevoUpdatePrestacion':

            $error = '';
            $prestacion          = GETPOST('label_prestacion');
            $cat_prestacion      = GETPOST('cat_prestacion');
            $cantprestacion      = GETPOST('cat_prestacion');
            $costo_prestacion    = GETPOST('costo_prestacion');
            $convenio            = !empty(GETPOST('convenio')) ? GETPOST('convenio') : 0;
            $subaccion           = GETPOST('subaccion');

            if($subaccion == 'nuevo'){

                $sql = "INSERT INTO `tab_conf_prestaciones` (`descripcion`, `tms` ,`fk_user`, `fk_convenio`, `fk_categoria`, `fk_laboratorio`, `valor`)";
                $sql .= "VALUES(";
                $sql .= "'$prestacion',";
                $sql .= "now(),";
                $sql .= "'$user->id',";
                $sql .= "'".$convenio."',";
                $sql .= "'$cat_prestacion',";
                $sql .= "0,"; #laboratorio
                $sql .= "$costo_prestacion";
                $sql .= ")";
                $rs = $db->query($sql);


                if(!$rs){
                    $error = "Ocurrió un error , con la Operación crear Prestación";
                }
//                echo '<pre>';
//                print_r($sql);
            }

            if($subaccion == 'modificar'){

                $id = GETPOST('id');

                $con = !empty($convenio) ? $convenio : 0;
                $Update = 'UPDATE tab_conf_prestaciones ';
                $Update .= 'SET descripcion = '."'$prestacion' , ";
                $Update .= 'fk_user = '.$user->id.', ';
                $Update .= 'valor = '.$costo_prestacion.', ';
                $Update .= 'fk_categoria = '.$cat_prestacion .' , ';
                $Update .= 'fk_convenio = '.$con.' WHERE `rowid`='.$id;

                $rs1 = $db->query($Update);

                if(!$rs1){
                    $error = "Ocurrió un error , con la Operación Actualizar Prestación";
                }
            }
            $output = [
                'error' => $error
            ];

            echo json_encode($output);
            break;

        case 'list_prestaciones':

            $data = array();

            $sql = "SELECT 
                    d.rowid,
                    d.descripcion,
                    d.tms AS fecha,
                    IFNULL((SELECT 
                                    c.nombre_conv
                                FROM
                                    tab_conf_convenio_desc c
                                WHERE
                                    c.rowid = d.fk_convenio),
                            'no asignado') AS convenio,
                    IFNULL((SELECT 
                                    ct.nombre_cat
                                FROM
                                    tab_conf_categoria_prestacion ct
                                WHERE
                                    ct.rowid = d.fk_categoria),
                            'no asignado') AS cat,
                            d.valor
                FROM
                    tab_conf_prestaciones d";
            $rs = $db->query($sql);
            if( $rs ){
                while ($ob = $rs->fetchObject()){

                    $row = array();

                    $row[] = date('Y/m/d', strtotime($ob->fecha));
                    $row[] = $ob->descripcion;
                    $row[] = $ob->cat;
                    $row[] = $ob->convenio;
                    $row[] = $ob->valor;

                    $row[] = " <a href='".DOL_HTTP."/application/system/configuraciones/index.php?view=form_prestaciones&act=mod&id=$ob->rowid' ><i class='fa fa-edit'></i></a>
                               <a onclick='eliminar_prestacion($ob->rowid)' style='cursor: pointer; color: #9f191f'><i class='fa fa-trash'></i></a>  ";
                    $row[] = $ob->rowid;

                    $data[] = $row;
                }
            }

            $output = [
                'data' => $data
            ];

            echo json_encode($output);
            break;

        case 'fecth_update_prestacion':

            $objeto  = array();
            $id = GETPOST('id');
            $prestacion = array();

            $sql = "SELECT  *  FROM
                        tab_conf_prestaciones
                    WHERE
                        rowid = $id";
            $rs = $db->query($sql);

            if($rs->rowCount()>0){

                while ($ob = $rs->fetchObject()){
                    $objeto[] = $ob;
                }
            }
            $output = [
                'obj' => $objeto
            ];

            echo json_encode($output);
            break;

        case 'eleminar_prestacion':

            $error = '';
            $idprestacion = GETPOST("id");
            $tieneAsociado = 0;

            $sqlConsult = "SELECT * FROM tab_plan_tratamiento_det WHERE fk_prestacion = $idprestacion";
            $rsConsult = $db->query($sqlConsult);

            if($rsConsult->rowCount() > 0){
                $tieneAsociado++;
            }

            if( $tieneAsociado == 0){
                $sql = "DELETE FROM `tab_conf_prestaciones` WHERE `rowid`='$idprestacion';";
                $rs = $db->query($sql);
                if(!$rs){
                    $error = 'Ocurrió un error, con la Operación Eliminar';
                }
            }else{
                if( $tieneAsociado > 0 ){
                    $error = 'Esta prestación ya esta Asociada a un plan de Tratamiento';
                }
            }

            $output = [
                'error' => $error
            ];

            echo json_encode($output);
            break;

        case 'nuevoCategoriaPrestacion':

            $error     ='';
            $idCat     = GETPOST('idCat');
            $nombeCat  = GETPOST('label');
            $descrip   = GETPOST('descrip');
            $subaccion = GETPOST('subaccion');

//            print_r($subaccion); die();
            if($subaccion == 'nuevo'){

                if(!empty(trim($nombeCat))){
                    $sql = "INSERT INTO `tab_conf_categoria_prestacion` (`nombre_cat`, `descrip`) VALUES ('$nombeCat', '$descrip');";
                    $rs = $db->query($sql);
                    if(!$rs){
                        $error = 'Ocurrio un error con la Operacion crear Categoria';
                    }
                }else{
                    $error = 'Ocurrio un error, no recibo ningun nombre de la categoria';
                }

            }


            if($subaccion == 'modificar'){

                if(!empty(trim($nombeCat))){
                    $sql = "UPDATE `tab_conf_categoria_prestacion` SET `nombre_cat`='$nombeCat', `descrip`='$descrip' WHERE `rowid`='$idCat';";
                    $rs = $db->query($sql);
                    if(!$rs){
                        $error = 'Ocurrio un error con la Operacion Modificar Categoria';
                    }
                }else{
                    $error = 'Ocurrio un error, no recibo ningun nombre de la categoria ';
                }
            }

            $datos = array();
            if($subaccion == 'consultar'){

                $sql = "SELECT * FROM tab_conf_categoria_prestacion WHERE rowid = $idCat";
                $rs  = $db->query($sql);

                if($rs && $rs->rowCount() > 0){

                    while ($obj = $rs->fetchObject()){
                        $datos = $obj;
                    }

                }

                if(!$rs){
                    $error = 'Ocurrio un error al consultar la categoria , a Modificar';
                }

            }

            $output = [
                'error' => $error,
                'datos' => $datos
            ];

            echo json_encode($output);
            break;

        case 'eliminar_conf_categoria_desc':

            $error = '';
            $subaccion = GETPOST('subaccion');

            #id categoria
            #id descuento convenio
            $id = GETPOST('id');

            if($subaccion != "" && $id != ""){

                if($subaccion = 'categoria'){

                    $estaAsociado = 0;
                    $sqlconsult = "select * from tab_conf_prestaciones where fk_categoria = $id";
                    $rsconsult = $db->query($sqlconsult);
                    if($rsconsult->rowCount() > 0 ){
                        $estaAsociado++;
                        $error = 'Error, Esta Categoría se encuentra Asociada con una prestación, solo puede modificarla';
                    }

                    #si asociado es 0 puede eliminar caso contrario no ?
                    if($estaAsociado==0){

                        $sql = "DELETE FROM `tab_conf_categoria_prestacion` WHERE `rowid`= '$id' ;";
                        $rs  = $db->query($sql);

                        if(!$rs){
                            $error = 'Error, con la Operación Eliminar, Consulte con soporte Técnico';
                        }
                    }

//                    print_r($subaccion);
//                    die();
                }

                if($subaccion == ''){

                }

            }else{
                $error = 'Error, no se encuentran los parametros, Consulte con Soporte Técnico';
            }

            $output = [
                'error' => $error
            ];

            echo json_encode($output);
            break;

        case 'nuevoConvenio':

            $error = '';

            $subaccion  = GETPOST('subaccion');

            $nombre     = GETPOST("nombre");
            $valor      = GETPOST("valor");
            $descri     = GETPOST("descrip");

            if($subaccion == 'nuevo'){

                $sql = "INSERT INTO `tab_conf_convenio_desc` (`nombre_conv`, `descrip`, `valor`)";
                $sql .= "VALUES (";
                $sql .= "'$nombre' ,";
                $sql .= "'$descri' ,";
                $sql .= "'$valor'  ";
                $sql .= ");";
                $rs = $db->query($sql);
                if(!$rs){
                    $error = 'Ocurrrió un error con la Operación , crear convenio';
                }
            }

            if($subaccion == 'modificar'){

                $sqlM = "UPDATE `tab_conf_convenio_desc` SET `nombre_conv`='$nombre', `descrip`='$descri', `valor`='$valor' WHERE `rowid`=".GETPOST('id');
                $rs = $db->query($sqlM);
                if(!$rs){
                    $error = 'Ocurrrió un error con la Operación , Modificar Convenio';
                }
            }
//            print_r($sqlM); die();

            $output = [
                'error' => $error
            ];

            echo json_encode($output);
            break;

        case 'list_convenios':

            $resp = list_convenios("", false);

            $output = [
              'data' => $resp
            ];
            echo json_encode($output);
            break;

        case 'fetch_modificar_convenio':

            $error = "";
            $respuesta = [];
            $id = GETPOST('id');

            if($id != ""){
                $respuesta['datos'] = list_convenios($id, true);
            }

            #print_r($resp); die();

            if(count($respuesta['datos']) == 0 ){
                $error = 'Ocurrió un error , Consulte con soporte Técnico';
            }

//            print_r($respuesta);
//            die();
            $output = [
                'error'     => $error,
                'respuesta' => $respuesta['datos']
            ];
            echo json_encode($output);
            break;
    }


}

function nuevoUpdateOdontologos($nombre, $apellido, $celular, $telefo_conve, $email, $direccion, $ciudad, $especialidad)
{
    global $db, $conf;

    $error = false;

    $sql  = "INSERT INTO `tab_odontologos` (`nombre_doc`, `apellido_doc`, `celular`, `telefono_convencional`, `email`, `ciudad`, `direccion`, `fk_especialidad` ) ";
    $sql .= "VALUES (";
    $sql .= "'$nombre',";
    $sql .= "'$apellido',";
    $sql .= "'$celular',";
    $sql .= "'$telefo_conve',";
    $sql .= "'$email',";
    $sql .= "'$ciudad',";
    $sql .= "'$direccion',";
    $sql .= " ".!empty($especialidad) ? 0 : $especialidad ." ";
    $sql .= ")";

    $rs = $db->query($sql);

    if($rs){ $error = true;  }

    return $error;
}

function UpdateOdontologos($nombre, $apellido, $celular, $telefo_conve, $email, $direccion, $ciudad, $especialidad, $id)
{
    global  $db;

    $error = false;

    $fk_especi = !empty($especialidad) ? $especialidad : 0 ;
    $sql1  = " UPDATE `tab_odontologos` SET `nombre_doc` = '$nombre', `apellido_doc` = '$apellido', `celular` = '$celular', ";
    $sql1 .= "`telefono_convencional` = '$telefo_conve', `email` = '$email', `ciudad` = '$ciudad', `direccion` = '$direccion', `fk_especialidad` = $fk_especi WHERE (`rowid` = '$id')";
    $rs = $db->query($sql1);

//    print_r($sql1); die();

    if($rs){
        $error= true;

        $Entidad_login = new CONECCION_ENTIDAD();
        $datos = [];


        $sqlusu = "SELECT * FROM tab_login_users WHERE fk_doc = $id limit 1";
        $usu = $db->query($sqlusu);
        if($usu->rowCount()>0)
        {
            $us = $usu->fetchObject();
            $ob = getnombreDentiste($id); #obtengo el dastos del dentista ultima actualizacion

            $datos['nombre']       = $ob->nombre_doc;
            $datos['apellido']     = $ob->apellido_doc;
            $datos['celular']      = $ob->celular;
            $datos['pass']         = '';
            $datos['email']        = $ob->email;
            $datos['usuario']      = $us->usuario;
            $datos['id_usuario']   = $us->rowid;

            $resul = GenerarUsuarioGlob($datos, 'modificar');

            if($resul != ""){ $error = $resul ; }
        }

    }

    return $error;

}

function GenerarUsuarioGlob($datos = array(), $subaccion)
{

    global  $conf, $user;

    $error = '';
    $nombreUsuario   = $datos["nombre"];
    $apellidoUsuario = $datos["apellido"];
    $celularUsuario  = $datos["celular"];

    $passUsuario     = $datos["pass"]; #password
    $usuUsuario      = $datos["usuario"]; #Usuario

    $id_usuario      = $datos["id_usuario"];
    $email           = $datos["email"]; #Email

    $Entidad_Login = new CONECCION_ENTIDAD(); //OBTENGO LAS FUNCIONES DE LA FUNCION PRINCIPAL

    if($subaccion == "nuevo")
    {
        $error = $Entidad_Login::LOGIN_USUARIO_ENTITY("nuevo", $usuUsuario,$passUsuario, $email, $conf->EMPRESA->ID_ENTIDAD, $nombreUsuario, $apellidoUsuario, 0 , $id_usuario);
    }
    if($subaccion=="modificar")
    {
        $error = $Entidad_Login::LOGIN_USUARIO_ENTITY("modificar", $usuUsuario,$passUsuario, $email, $conf->EMPRESA->ID_ENTIDAD, $nombreUsuario, $apellidoUsuario, $user->id_entidad_login , $id_usuario);
    }

    if($error==1){
        return '';
    }else{
        return 'Ocurrió un problema con el proceso, consulte con soporte Técnico';
    }

}

function IconOdontologo($id, $Icon)
{
    global  $db, $conf;


    $type="";
    $datos = [];

    switch ($Icon['type'])
    {
        case 'image/png':
            $type = '.png';
            break;

        case 'image/jpeg':
            $type = '.jpeg';
            break;

    }

    $tmp_name = $Icon["tmp_name"]; #ruta temporal del fichero
    $name_archv = "conf_odont_icon_$id"."_".$conf->EMPRESA->ENTIDAD."".$type; #label del fichero

    $datos["nomb_archv"] = $name_archv;

    $link = UploadFicherosLogosEntidadGlob($name_archv, $type, $tmp_name);

    if($link!=false)
    {
        //datos es mayor a 0 guardo
        if(count($datos)>0)
        {
            $sqlUp = "UPDATE `tab_odontologos` SET `icon` = '".$datos['nomb_archv']."' WHERE (`rowid` = '$id')";
            $rs = $db->query($sqlUp);
            if (!$rs)
            {
                unlink($link); //elimino en caso no se llega a guardar
            }
        }
    }

    return 1;

//    print_r($conf->DIRECTORIO);
//    die();
}

function list_odontolosGention($estado){

    global $db, $conf, $user;

    $data = array();

    $sql = "SELECT 
            s.nombre_doc,
            s.apellido_doc,
            s.celular,
            s.direccion,
            s.email,
            s.direccion,
            s.rowid,
            s.estado,
            IFNULL((SELECT 
                            e.nombre_especialidad
                        FROM
                            tab_especialidades_doc e
                        WHERE
                            e.rowid = s.fk_especialidad),
                    0) especialidad
        FROM
            tab_odontologos s
        WHERE
            s.rowid > 0";

    if(!empty($estado)){
        $sql .= " and s.estado = '$estado' ";
    }

    $sql .= " and s.rowid != $user->id";

//    print_r($sql);
    $res = $db->query($sql);

    if($res->rowCount() > 0){

        while ($obj = $res->fetchObject()){

            $row = array();

            $tieneUsuario = 0; #obtendre el id del Usuario Creado

            $htmlUsuario = '';
            $sqlUsu = "SELECT rowid FROM tab_login_users s WHERE s.fk_doc = $obj->rowid";
            $rs = $db->query($sqlUsu);
            if($rs->rowCount()>0){
                $ob = $rs->fetchObject();
                $tieneUsuario = $ob->rowid;

                $htmlUsuario = '<small style=" ;background-color: #e9edf2; " class="btn btn-xs" data-toggle="modal" data-target="#ModalCrearUsuario" onclick="ModificarUsuario('.$obj->rowid.','.$tieneUsuario.', 1)">&nbsp;<i class="fa fa-user"></i> Usuario</small>';
            }

            $row[] ='<a href="#modal_conf_doctor" data-toggle="modal" onclick="modificarOdontologo('.$obj->rowid.')">'. $obj->nombre_doc .' '. $obj->apellido_doc.' </a>' . $htmlUsuario;
            $row[] = $obj->celular;
            $row[] = $obj->direccion;
            $row[] = $obj->email;
            $row[] = ( $obj->especialidad == '0') ? 'General' :  $obj->especialidad;

            if($obj->estado == 'A'){
                $row[] = '<a class="btn" style="font-size: 1.7rem; color: #9f191f;" onclick="UpdateEstadoOdontologos('.$obj->rowid.', \'E\')"> <i class="fa  fa-trash"></i></a>';
            }
            if($obj->estado == 'E'){
                $row[] = '<a class="btn" style="font-size: 1.7rem; color: green" onclick="UpdateEstadoOdontologos('.$obj->rowid.', \'A\')"> <i class="fa  fa-check"></i></a>';
            }

            $row[] = $obj->rowid;
            $row[] = $obj->estado;

            $data[] = $row;
        }
    }

    return $data;
}

#list convenios
function list_convenios($id = "", $uno)
{

    global $db;

    $data = array();

    $sql = "SELECT rowid , nombre_conv , descrip , valor FROM tab_conf_convenio_desc WHERE rowid > 0";
    if($id != ""){
        $sql .= " and rowid = $id";
    }

    $sql .= " order by rowid desc";
    $rs  = $db->query($sql);
    if($rs){

        while ($obj = $rs->fetchObject()){

            $row = array();

            $row[] = $obj->nombre_conv;
            $row[] = $obj->descrip;
            $row[] = $obj->valor. " %";

            #pido con el id
            if($uno == true){
                return $row;
            }

            $row[] = "<a href='#modal_conf_convenio' data-toggle='modal' style='cursor: pointer; display: inline-block; text-align: right' onclick='fetch_modificar_convenio($obj->rowid)'><i class='fa fa-edit'></i></a> 
                      <a href='#' style='color: #9f191f;  display: inline-block; cursor: pointer; text-align: right'><i class='fa fa-trash'></i></a> ";

            $data[] = $row;

        }

    }

    return $data;
}

?>