<?php

include_once '../../../config/lib.global.php';

session_start();


if(!isset($_SESSION['is_open']))
{
    header('location:'.DOL_HTTP.'/application/system/login');
}

include_once DOL_DOCUMENT .'/application/config/main.php';


$view = "";
$Active = "";
if(isset($_GET['view']))
{
    $view = $_GET['view'];
    $Active = "pacientes";
}

?>

<style>
    .margenTopDiv{
        margin-top: 5px;
    }

    #table_direc tr:hover{
        background-color: #E5E8E8;
    }


</style>

<script>
    $DOCUMENTO_URL_HTTP        = "<?php echo DOL_HTTP ?>";
    $HTTP_DIRECTORIO_ENTITY    = "<?php echo $conf->NAME_DIRECTORIO ?>";
    $keyGlobal                 = "<?php echo KEY_GLOB   ?>"; //KEY GLOBAL
</script>

<!--header principal-->
<?php include_once DOL_DOCUMENT .'/public/view/header_principal.php';?>

<div class="wrapper">
    <!-- Main Header -->
        <?php include_once DOL_DOCUMENT.'/public/view/header.php'?>
                 <?php include_once DOL_DOCUMENT.'/public/view/menu.php'?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <section class="content-header">
            </section>
            <!-- Main content -->
            <section class="content container-fluid">
                <?php

                if(!empty($view))
                {
                    switch ($view)
                    {
                        case 'directorio':

                            include_once DOL_DOCUMENT.'/application/system/pacientes/directorio_paciente/view/form_directorio.php';

                            break;
                    }
                }

                ?>
            </section>
        </div>

</div>
<?php include_once DOL_DOCUMENT.'/public/view/modal_search_paciente.php'?>
<?php include_once DOL_DOCUMENT .'/public/view/footer_principal.php';?>


<script>
    var permisosConsultar    = "<?php $permisos->consultar; ?>";
    var permisoModificar     = "<?php $permisos->modificar; ?>";
    var permisoAgreagar      = "<?php $permisos->agregar; ?>";
    var permisoEliminar      = "<?php $permisos->eliminar; ?>";
</script>

<script src="<?php echo DOL_HTTP .'/application/system/pacientes/directorio_paciente/js/direct_pacient.js';?>"></script>

