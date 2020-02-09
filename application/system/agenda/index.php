<?php

session_start();

require_once '../../config/lib.global.php';

if(!isset($_SESSION['is_open']))
{
    header('location:'.DOL_HTTP.'/application/system/login');
}

require_once DOL_DOCUMENT. '/application/config/main.php'; //el main contiene la sesion iniciada

//$cn = new ObtenerConexiondb();
//$db = $cn::conectarEmpresa($_SESSION['db_name']);

$view = "";
$Active = "";
if(isset($_GET['view']))
{
    $view = $_GET['view'];
    $Active = 'agenda';
}

?>

<style>
    .margenTopDiv{
        margin-top: 5px;
    }

    .chip-citas{
        cursor: pointer;
        display: inline-block;
        padding: 5px;
        margin: 0px;
        background-color: #E5E8E8;
        border-radius: 3px;
    }

    .opcionAgenda{
        cursor: pointer;
        display: inline-block;
        padding: 3px;
        /*margin: 0px;*/
        background-color: #E5E8E8;
        border-radius: 10px;
    }



    /* Ensure that the demo table scrolls */
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;
    }


</style>

<!--header principal-->
<?php include_once DOL_DOCUMENT .'/public/view/header_principal.php';?>
<link rel="stylesheet" href="<?= DOL_HTTP .'/application/system/agenda/css/dropdown_hovereffect.css'?>">

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
                    case 'principal':

                        require_once DOL_DOCUMENT.'/application/system/agenda/view/principal.php';

                        break;
                }
            }

            ?>

        </section>
    </div>

</div>
<?php include_once DOL_DOCUMENT.'/public/view/modal_search_paciente.php'?>
<?php include_once DOL_DOCUMENT .'/public/view/footer_principal.php';?>

<!--SCRIPT-->
<script>
    $DOCUMENTO_URL_HTTP = "<?php echo DOL_HTTP ?>";
</script>

<script src="<?php echo DOL_HTTP .'/application/system/agenda/js/agendaIndex_one.js';?>"></script>
<script src="<?php echo DOL_HTTP .'/application/system/agenda/js/lista_diaria_global.js';?>"></script>

<script>

    $(document).ready(function() {

        select2('active');
        Select2Run();
        loadtableAgenda();
        NOTIFICACION_CITAS_NUMEROS(0);

    });



</script>