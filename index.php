<?php

//Ejecutamos la conexion
session_start();

require_once 'application/config/lib.global.php';

if(!isset($_SESSION['is_open']))
{
    header('location:'.DOL_HTTP.'/application/system/login');
}

require_once DOL_DOCUMENT.'/application/config/main.php';

$Active='';
if(isset($_GET['view']))
{
    $Active='inicio';
}


global $conf, $db;
?>

<!--header principal-->
<?php include_once DOL_DOCUMENT .'/public/view/header_principal.php';?>

<div class="wrapper">

    <!-- Main Header -->
    <?php include_once $DOL_DOCUMENT.'/public/view/header.php'?>
    <!-- Left side column. contains the logo and sidebar -->
    <?php include_once $DOL_DOCUMENT.'/public/view/menu.php'?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
        </section>
            <!-- Main content -->
            <section class="content container-fluid">
                <?php include_once DOL_DOCUMENT .'/public/view/home.php';?>
            </section>
    </div>

</div>

<!--    footer principal-->
<?php include_once DOL_DOCUMENT .'/public/view/footer_principal.php';?>

<script>

    $DOCUMENTO_URL_HTTP = "<?php echo DOL_HTTP ?>"; //URL  HTTP DOCUMENTO
    $HTTP_DIRECTORIO_ENTITY    = "<?php echo $conf->NAME_DIRECTORIO ?>";

</script>

<?php
    if(isset($_GET['view']) && trim($_GET['view']) == trim('inicio'))
    {
        print "<script src='".DOL_HTTP ."/public/js/home.js' ></script>";
    }
?>

