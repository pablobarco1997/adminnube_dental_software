<?php

    global   $db, $conf, $user, $global, $permisos, $dateZoneCurrent;

    require_once  DOL_DOCUMENT .'/application/config/conneccion_entidad.php';       //Connecion de Entidad
    require_once  DOL_DOCUMENT .'/application/system/conneccion/conneccion.php';    //Coneccion de Empresa


    $cn = new ObtenerConexiondb();                    //Conexion global Empresa Fija
    $db = $cn::conectarEmpresa($_SESSION['db_name']); //coneccion de la empresa variable global


    require_once DOL_DOCUMENT  .'/application/config/configuration.php';              //inicializas la clas configuracion

    $entity   = new CONECCION_ENTIDAD();
    $conf     = new configuration();
    $permisos = (object)[];#Obtiene los permisos asignados

    //usuario
    $user             = (object)array("id" => $_SESSION['id_user'], "name" => $_SESSION['usuario'], "id_entidad_login" => $_SESSION["login_entidad"] );

    //conf
    $conf->Entidad    = $_SESSION['entidad'];
    $conf->db_schema  = $_SESSION['db_name'];
    $conf->login_user = $_SESSION['usuario'];
    $conf->login_id   = $_SESSION['id_user'];

    #obtengo todo un (obj) de los pacientes que tiene esta clinica
//    $conf->ObtenerPaciente($db, null, false);

    $conf->EMPRESA =    (object)array(
        "ID_ENTIDAD"    => $_SESSION["id_Entidad"],
        "ENTIDAD"       => $conf->Entidad,
        "SCHEMA"        => $conf->db_schema,
        "INFORMACION"   => $entity::INFORMACION_EMPRESA_GLOB($_SESSION["id_Entidad"]) //INFORMACION DE LA ENTIDAD GLOB
    );

    $conf->ObtnerNoficaciones($db, false);

    $conf->DIRECTORIO = DOL_DOCUMENT.'/logos_icon/icon_logos_'.$_SESSION['entidad']; //RUTA DE DIRECTORIO GLOBAL
    $conf->NAME_DIRECTORIO = 'icon_logos_'.$_SESSION['entidad']; //NAME DE LA CARPETA DEL DIRECTORIO

    $conf->perfil($db, $user->id, DOL_HTTP, $conf->NAME_DIRECTORIO );

    require_once  DOL_DOCUMENT .'/application/controllers/controller.php';           //se declara funciones de php globales

    # OBTENGO LA FECHA Y HORA ACTUAL CON MYSQL
    $sqlCurrentDatezone = "SELECT NOW() datezpnecurrent;";
    $dateZoneCurrent    = $db->query($sqlCurrentDatezone)->fetchObject()->datezpnecurrent;


    # OPTENGO LOS PERMISOS
    $sqllogin = "SELECT permisos FROM tab_login_users WHERE usuario = '$user->name' and fk_doc = '$user->id' limit 1";
    $login  = $db->query($sqllogin)->fetchObject();

    $objPermisos = json_decode($login->permisos);

    #Tipo de Usuario
    # 1 = Super Administrador
    # 2 = Usuario normal

    $permisos        = (object)array(
        "consultar"   => ($objPermisos->consultar  == "true") ? ""   : "disabled_link3" ,
        "agregar"     => ($objPermisos->agregar    == "true") ? ""   : "disabled_link3" ,
        "modificar"   => ($objPermisos->modificar  == "true") ? ""   : "disabled_link3" ,
        "eliminar"    => ($objPermisos->eliminar   == "true") ? ""   : "disabled_link3" ,
    );

    /*
    echo '<pre>';
    print_r($dateZoneCurrent); die();*/

?>