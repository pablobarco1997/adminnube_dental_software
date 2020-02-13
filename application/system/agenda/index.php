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

$url_breadcrumb = $_SERVER['REQUEST_URI'];
//print_r($url_breadcrumb); die();

$view = "";
$Active = "";
if(isset($_GET['view']))
{
    $view = $_GET['view'];
    $Active = 'agenda';
}

?>


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

            <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3>AGENDA</h3>
                        </div>
                        <div class="box-body">

                            <?php

                            if(!empty($view))
                            {
                                switch ($view)
                                {
                                    case 'principal':

                                        if(isset($_GET['list'])){

                                            require_once DOL_DOCUMENT.'/application/system/agenda/view/principal.php';

                                        }else{

                                            #Este es cuando modifican la url
                                            echo '<h2 style="color: red; font-weight: bolder; text-align: center"> No se encontro la vista , Consulte con soporte tecnico </h2>';
                                            die();
                                        }

                                        break;

                                    case 'agendadd':

                                        require_once DOL_DOCUMENT.'/application/system/agenda/view/agendadd.php';

                                        break;

                                    default:
                                        #Este es cuando modifican la url
                                        echo '<h2 style="color: red; font-weight: bolder; text-align: center"> No se encontro la vista , Consulte con soporte tecnico </h2>';
                                        die();
                                        break;
                                }
                            }

                            ?>

                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>

</div>
<?php include_once DOL_DOCUMENT.'/public/view/modal_search_paciente.php'?>
<?php include_once DOL_DOCUMENT .'/public/view/footer_principal.php';?>

<!--SCRIPT-->
<script>

    $DOCUMENTO_URL_HTTP        = "<?= DOL_HTTP ?>";
    $keyGlobal                 = "<?= KEY_GLOB ?>"; //KEY GLOBAL

</script>

<script src="<?php echo DOL_HTTP .'/application/system/agenda/js/lista_diaria_global.js';?>"></script>

<!--INGRESO DE SCRIPTS-->
<?php

    #lista de agendas
    if(isset($_GET['list']))
    {
        echo ($_GET['list']=="diaria") ? '<script src="'.DOL_HTTP.'/application/system/agenda/js/agent.js"></script>' : '';
    }

    #agendar citas
    if($view == 'agendadd')
    {
        echo '<script src="'.DOL_HTTP.'/application/system/agenda/js/agentcreate.js"></script>';
    }

?>