<?php

require_once '../../../config/lib.global.php';
session_start();
if(isset($_SESSION['id_user']))
{
//    echo 'sesion iniciada';
}else{
    header('location:'.$DOL_HTTP.'/application/system/login');
}

require_once DOL_DOCUMENT .'/application/config/main.php';

$view = "";
$Active = "";
if(isset($_GET['view']))
{
    $view   = $_GET['view'];
    $Active = 'pacientes';
}

?>

<style>
    .margenTopDiv{
        margin-top: 5px;
    }

    .INVALIC_ERROR{
        border: 1px solid #9f191f !important;
    }
</style>

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
                    case 'nuev_paciente':

                        include_once DOL_DOCUMENT.'/application/system/pacientes/nuevo_paciente/view/form_nuevo_paciente.php';

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
</script>

<script src="<?php echo DOL_HTTP .'/application/system/pacientes/nuevo_paciente/js/paciente.js';?>"></script>

