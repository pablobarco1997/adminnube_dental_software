
<?php

//require_once  DOL_DOCUMENT  .'/application/config/conneccion_entidad.php'; //Informcion de la entidad Clinica - sesion
require_once  DOL_DOCUMENT .'/application/system/conneccion/conneccion.php';    //Coneccion de Empresa
require_once  DOL_DOCUMENT .'/public/lib/mpdf60/mpdf.php';
require_once  DOL_DOCUMENT .'/application/controllers/controller.php';


/**SE CREA LAS VARIABLES DE INICIO**/
$cn = new ObtenerConexiondb();                    //Conexion global Empresa Fija
$db = $cn::conectarEmpresa($_SESSION['db_name']); //coneccion de la empresa variable global

//$InformacionEntity = $entidades::INFORMACION_EMPRESA_GLOB($_SESSION["id_Entidad"]);


?>