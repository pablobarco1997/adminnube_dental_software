<?php

require_once  '../../config/lib.global.php';
session_start();

if(!isset($_SESSION['is_open']))
{
    header("location:".DOL_HTTP."/application/system/login");
}

require_once '../../config/main.php';

require_once DOL_DOCUMENT.'/application/config/main.php';

$NAME_MODULO = "Documento clinicos asociados";
global $conf, $db;

$view = "";
if(isset($_GET['view'])){
    $view = $_GET['view'];
}
$Active="documento_clinicos";

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

            <section  class="content container-fluid">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 id="tituloInfo"><?= $NAME_MODULO ?></h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group form-group col-xs-12 col-md-12">
                            <?php
                                if(isset($view))
                                {
                                    if($view != ""){
                                        include_once DOL_DOCUMENT.'/application/system/documentos_clinicos/view/'.$view.'.php';;
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>


<script>
    $DOCUMENTO_URL_HTTP        = "<?=  DOL_HTTP ?>"; //URL  HTTP DOCUMENTO
    $HTTP_DIRECTORIO_ENTITY    = "<?=  $conf->NAME_DIRECTORIO ?>";  //ENTIDAD DE LA EMPRESA PARA JAVASCRIPT
    $keyGlobal                 = "<?=  GETPOST('key') ?>"; //KEY GLOBAL
</script>

<?php include_once DOL_DOCUMENT.'/public/view/modal_search_paciente.php'?>
<?php include_once DOL_DOCUMENT .'/public/view/footer_principal.php';?>

<!--LISTA PRINCIPAL VIEW == listdocumment-->
<?php if(isset($_GET['view']) && $_GET['view'] == 'listdocumment'){ echo '<script src="'.DOL_HTTP .'/application/system/documentos_clinicos/js/indx_documclin.js"></script>'; }; ?>