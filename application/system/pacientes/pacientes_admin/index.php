<?php

require_once '../../../config/lib.global.php';
session_start();
if(!isset($_SESSION['is_open']))
{
    header("location:".DOL_HTTP."/application/system/login");
}

require_once '../../../../application/config/main.php'; //el main contiene la sesion iniciada


#declaro las variables globales
$VIEW_GLOB_ADMIN_PACIENTES =  ""; #VISTA DEL VIEW
$DIRECTORIO_ADMIN          =  ""; #BUSCAR DIRECTORIO
$_JS_DOCMENT               =  ""; #BUSCAR JAVASCRIPT
$NAME_MODULO               =  "";

$idPaciente = 0;  #ID PACIENTES ----------------------------------------------------------------------------------------

if(isset($_GET['id']))
{

    PERMISO_ACCESO_ADMIN_PACIENTES(GETPOST('key'));

    $idPaciente  = decomposeSecurityTokenId($_GET['id']); #id del paciente
    $VISTAS      = $_GET['view'];

    #VISTAS FORMULARIOS
    switch($VISTAS)
    {
        case "dop": #DATOS PEROSNALES
            $VIEW_GLOB_ADMIN_PACIENTES   = "dop_formulario";    #view formulario
            $DIRECTORIO_ADMIN            = "datos_personales";  #directorio
            $_JS_DOCMENT                 = "pacientesdatos";    #doc javascript
            $NAME_MODULO                 = "DATOS PERSONALES";
        break;

        case "arch": #ARCHIVOS
            $VIEW_GLOB_ADMIN_PACIENTES   = "form_ficheros_pacientes";    #view formulario
            $DIRECTORIO_ADMIN            = "archivos_ficheros";          #directorio
            $_JS_DOCMENT                 = "ficherosp";                  #doc javascript
            $NAME_MODULO                 = "ARCHIVOS PACIENTE";
        break;

        case "commp": #COMMENTARIO
            $VIEW_GLOB_ADMIN_PACIENTES   = "commentp";                    #view formulario
            $DIRECTORIO_ADMIN            = "comment_pacientes";           #directorio
            $_JS_DOCMENT                 = "commentp";                    #doc javascript
            $NAME_MODULO                 = "COMENTARIOS ADMINISTRATIVOS";
            break;

        case "plantram": #PLAN DE TRATAMIENTO
            $VIEW_GLOB_ADMIN_PACIENTES   = "plantram";                    #view formulario
            $DIRECTORIO_ADMIN            = "plan_tratamiento";            #directorio
            $_JS_DOCMENT                 = "plant";                       #doc javascript
            $NAME_MODULO                 = "PLAN DE TRATAMIENTO";
            break;

        case "odot": #ODONTOGRAMA ACTUAL
            $VIEW_GLOB_ADMIN_PACIENTES   = "principal_odontograma";   #view formulario
            $DIRECTORIO_ADMIN            = "odontograma_paciente";         #directorio
            $_JS_DOCMENT                 = "odont";                        #doc javascript
            $NAME_MODULO                 = "ODONTOGRAMA";
            break;

    }


}else{

    echo 'Error No se encontraron paramatros esenciales';
    die();

}

//print_r($idPaciente);



?>

<!--header principal-->
<?php include_once DOL_DOCUMENT .'/public/view/header_principal.php';?>

<div class="wrapper">
    <!-- Main Header -->
    <?php include_once DOL_DOCUMENT.'/public/view/header.php'?>
    <?php include_once DOL_DOCUMENT.'/public/view/menu.php'?>

    <div class="content-wrapper">
        <section class="content-header">
        </section>

        <section class="content container-fluid">

            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 id="tituloInfo"><?= $NAME_MODULO ?></h3>
                </div>
                <div class="box-body">
                        <div class="form-group col-md-12 col-xs-12">
                            <ul class="list-inline">
                                <li>
                                    <a href="#menu_admin" data-toggle="modal"  class="btn btnhover">  <i class="fa fa-bars"></i>&nbsp;&nbsp; MOSTRAR MENU  </a>
                                </li>
                            </ul>
                            <hr>
                        </div>

                        <div class="form-group col-xs-12 col-md-12">
                            <?php

                                if(!empty($VIEW_GLOB_ADMIN_PACIENTES))
                                {
                                    include_once DOL_DOCUMENT.'/application/system/pacientes/pacientes_admin/'.$DIRECTORIO_ADMIN.'/view/'.$VIEW_GLOB_ADMIN_PACIENTES.'.php';
                                }
                                else{
                                    echo "OCURRIO UN ERROR";
                                }

                            ?>
                        </div>
                </div>
            </div>
        </section>

    </div>
</div>

<script>


    $id_paciente               = "<?=  $idPaciente ?>"; //ID DE PACIENTE
    $DOCUMENTO_URL_HTTP        = "<?=  DOL_HTTP ?>"; //URL  HTTP DOCUMENTO
    $HTTP_DIRECTORIO_ENTITY    = "<?=  $conf->NAME_DIRECTORIO ?>";  //ENTIDAD DE LA EMPRESA PARA JAVASCRIPT
    $keyGlobal                 = "<?= GETPOST('key') ?>"; //KEY GLOBAL

</script>

<?php include_once DOL_DOCUMENT.'/public/view/modal_search_paciente.php'?>
<?php include_once DOL_DOCUMENT .'/public/view/footer_principal.php';?>

<!--modales glob admin pacientes-->
<?php include_once  DOL_DOCUMENT .'/application/system/pacientes/pacientes_admin/view/menu_admin.php'; ?>

<script src="<?= DOL_HTTP.'/application/system/pacientes/pacientes_admin/'.$DIRECTORIO_ADMIN.'/js/'.$_JS_DOCMENT.'.js' ?>"></script>

<?php
#FUNCIONES ESPECIALES JAVASCRIP

switch ($VISTAS)
{
    case 'arch': #Modulo Ficheros
        echo "<script src='".DOL_HTTP."/application/system/pacientes/pacientes_admin/archivos_ficheros/js/input_file.js'></script>";
        break;
}
?>

