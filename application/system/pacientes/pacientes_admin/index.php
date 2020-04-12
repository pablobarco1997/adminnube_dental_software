<?php

require_once '../../../config/lib.global.php';
session_start();
if(!isset($_SESSION['is_open']))
{
    header("location:".DOL_HTTP."/application/system/login");
}

require_once '../../../../application/config/main.php';


#declaro las variables globales
$VIEW_GLOB_ADMIN_PACIENTES =  ""; #VISTA DEL VIEW
$DIRECTORIO_ADMIN          =  ""; #BUSCAR DIRECTORIO
$_JS_DOCMENT               =  ""; #BUSCAR JAVASCRIPT
$NAME_MODULO               =  "";

$idPaciente = 0;  #ID PACIENTES ----------------------------------------------------------------------------------------

if(isset($_GET['id']))
{

    PERMISO_ACCESO_ADMIN_PACIENTES(GETPOST('key'));  #permisos

    $idPaciente  = decomposeSecurityTokenId($_GET['id']); #id del paciente

    #VISTAS FORMULARIOS ----------
    include_once 'view/vistas_mod.php';


}else{

    echo 'Error No se encontraron paramatros esenciales Consultar con soporte';
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
                    <h3 id="tituloInfo"><?= $NAME_MODULO ?>  -  <?= getnombrePaciente($idPaciente)->nombre .' ' .getnombrePaciente($idPaciente)->apellido ?></h3>
                </div>
                <div class="box-body">
                        <div class="form-group col-md-12 col-xs-12">
                            <ul class="list-inline">
                                <li>
                                    <a href="#menu_admin" data-toggle="modal"  class="btn btnhover" style="font-weight: bolder; color: #333333">  <i class="fa fa-bars"></i>&nbsp;&nbsp; MOSTRAR MENU  </a>
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
    $keyGlobal                 = "<?=  GETPOST('key') ?>"; //KEY GLOBAL

</script>

<?php include_once DOL_DOCUMENT.'/public/view/modal_search_paciente.php'?>
<?php include_once DOL_DOCUMENT .'/public/view/footer_principal.php';?>

<!--modales glob admin pacientes-->
<?php include_once  DOL_DOCUMENT .'/application/system/pacientes/pacientes_admin/view/menu_admin.php'; ?>

<!--import los script js  modulos independientes -->
<?php include_once  'view/script_javascrip_mod.php'; ?>

