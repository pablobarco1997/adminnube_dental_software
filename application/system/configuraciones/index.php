<?php

include_once '../../config/lib.global.php';

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
    $Active = "configuraciones";
}else{ $Active = "configuraciones"; }

?>

<style>
    .margenTopDiv{
        margin-top: 5px;
    }
    
    .itemConf li{
        cursor: pointer;
    }

    .itemConf li:hover{
        background-color: rgba(128, 139, 150,0.2);
    }

    table tbody tr td{
        font-size: 1.3rem;
    }

    #confulprest li{
        float: right;
        margin-left: 3px;
    }

</style>

    <!--header principal-->
<?php include_once $DOL_DOCUMENT .'/public/view/header_principal.php'; ?>

<div class="wrapper">

    <!-- Main Header -->
    <?php include_once $DOL_DOCUMENT.'/public/view/header.php'?>
         <?php include_once $DOL_DOCUMENT.'/public/view/menu.php'?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
        </section>
        <!-- Main content -->
        <section class="content container-fluid">

<!--            LISTA DE CONFIGURACIONES-->
            <?php
            if(empty($view))
            {
            ?>

                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3>Configuración</h3>
                    </div>

                        <div class="box-body">
                            <br>

                            <div class="row">
                                    <div class="form-group col-md-8 col-lg-9 col-sm-12 col-xs-12 col-centered">
                                        <?php include_once DOL_DOCUMENT . '/application/system/configuraciones/view/view_configuration.php';?>
                                    </div>
                            </div>

                        </div>
                </div>


            <?php }?>


            <?php

            if(!empty($view))
            {
                switch ($view)
                {
                    case 'form_prestaciones':

                        include_once DOL_DOCUMENT.'/application/system/configuraciones/view/form_configuraciones_prestaciones.php';

                        break;

                    case 'form_convenios_desc':

                        include_once DOL_DOCUMENT.'/application/system/configuraciones/view/form_convenios_desc.php';

                        break;

                    case 'form_laboratorios_conf':

                        include_once DOL_DOCUMENT.'/application/system/configuraciones/view/form_laboratorios_conf.php';

                        break;

                    case 'form_gestion_odontologos_especialidades':

                        include_once DOL_DOCUMENT.'/application/system/configuraciones/view/form_gestion_odontologos_especialidades.php';

                    break;

                    case 'document_assoct':

                        include_once DOL_DOCUMENT.'/application/system/configuraciones/view/document_assoct.php';

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
    $DOCUMENTO_URL_HTTP = "<?php echo DOL_HTTP ?>";
    $DIRECTORIO         = "<?php echo $conf->NAME_DIRECTORIO ?>"; //DIRECTORIO DE LA CARPETA ESPECIAL CREADA PARA ESTA ENTIDAD
</script>

<script src="<?= DOL_HTTP .'/application/system/configuraciones/js/configuraciones.js'; ?>"></script>

<?php if(isset($_GET['view']) && GETPOST("view") == 'form_prestaciones'){?>
    <script src="<?= DOL_HTTP .'/application/system/configuraciones/js/prestaciones.js'; ?>"></script>
<?php }?>

<?php if(isset($_GET['view']) && GETPOST("view") == 'form_gestion_odontologos_especialidades'){?>
    <script src="<?= DOL_HTTP .'/application/system/configuraciones/js/usuario_odontologos_espacialidades.js'; ?>"></script>
<?php }?>

<?php if(isset($_GET['view']) && GETPOST("view") == 'form_convenios_desc'){?>
    <script src="<?= DOL_HTTP .'/application/system/configuraciones/js/convenios_config.js'; ?>"></script>
<?php }?>
