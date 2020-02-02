<?php

require_once '../../../config/lib.global.php';

session_start();

//print_r($_SESSION['is_open']); die();
if(!isset($_SESSION['is_open']))
{

    header("location:".DOL_HTTP."/application/system/login");

}



require_once '../../../../application/config/main.php'; //el main contiene la sesion iniciada


$view = "";
$id = "0"; //id del paciente
$Active = "";
if( isset($_GET['view']) )
{
    $view = $_GET['view'];
    $Active = 'pacientes';
}
if( isset($_GET['id']) ) //ID PACIENTE
{
    $id = $_GET['id']; #id paciente
}

?>

<style>
    .margenTopDiv{
        margin-top: 10px;
    }
    .lipaddi{
        text-align: left;

        /*transition: 0.3ms linear;*/
    }
    .lista{
        color: #2C3E50;
        display: block;
        padding: 5px;
    }
    .lista a{
        padding: 3px 8px;
        font-size: 1.3rem;
        border-left: 1.5px solid black;
    }

    .lista:hover{
        background-color: #2C3E50;
        color: #FDFEFE;
        /*padding: 5px;*/
        /*border-radius: 5px;*/
    }

    .ActivaLista a{
        padding: 5px;
        background-color: #2C3E50;
        color: #FDFEFE;
        /*padding: 5px;*/
        /*border-radius: 5px;*/
    }

    #tablePlanTratamiento1 td, #tablePlanTratamiento1 th {
        border: 1px solid #ddd;
        /*padding: px;*/
    }
    #table-prestaciones_1 td, #table-prestaciones_1 th {
        border: 1px solid #ddd;
        /*padding: px;*/
    }

    /*#table-documentos-clinicos1 td, #table-documentos-clinicos1 th {*/
        /*border: 1px solid #ddd;*/
        /*!*padding: px;*!*/
    /*}*/

    .pieza td {
        /*font-size: 0.3px;*/
    }
    .boderTd{
        border: 1px solid black;
        padding: 7px;
        cursor: pointer;
    }

    .activeCara{
        background-color: #9f191f;
    }

    .pieza .boderTd:hover{
        background-color: #9f191f;
    }

    .INVALIC_ERROR{
        border: 1px solid #9f191f;
    }

    /*Odontograma*/
    .piezaSeleccionada{

        box-shadow: 0 0 6px rgba(35, 173, 255, 1);

    }


</style>

<link rel="stylesheet" href="<?php echo DOL_HTTP .'/application/system/pacientes/admin_paciente/css/input_file.css';?>">

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
                <div class="row">

                        <div class="col-md-12">
                                <div class="box box-solid">

                                    <div class="box-header with-border">
                                        <h3 id="tituloInfo"></h3>
                                    </div>

                                    <div class="box-body">

                                        <div class="form-group col-md-12" style="padding: 0px">
                                            <button class="btn btn-default" data-toggle="modal" data-target="#menu_admin"><i class="fa fa-bars"></i>&nbsp;&nbsp; MOSTRAR MENU</button>
                                        </div>

                                        <div class="row">

                                                    <div  class="col-md-12 col-sm-12  margenTopDiv">
                                                        <div style="width: 100%; background-color: #E5E8E8; border-radius: 3px;">

                                                            <?php

                                                                    if(isset($view))
                                                                    {

                                                                        switch($view)
                                                                        {

                                                                            case 'form_datos_personales':

                                                                                include_once DOL_DOCUMENT.'/application/system/pacientes/admin_paciente/view/form_datos_paciente.php';

                                                                                break;

                                                                            case 'form_carga_familiares':

                                                                                include_once DOL_DOCUMENT.'/application/system/pacientes/admin_paciente/view/form_carga_familiares.php';

                                                                                break;

                                                                            case 'form_archivos':

                                                                                include_once DOL_DOCUMENT.'/application/system/pacientes/admin_paciente/view/form_archivos_paciente.php';

                                                                                break;

                                                                            case 'comentarios_pacientes':

                                                                                include_once DOL_DOCUMENT.'/application/system/pacientes/admin_paciente/view/comentarios_pacientes.php';

                                                                                break;

                                                                            case 'form_plan_tratamiento':

                                                                                include_once DOL_DOCUMENT.'/application/system/pacientes/admin_paciente/view/form_plan_tratamiento.php';

                                                                                break;

                                                                            case 'documentos_clinicos':

                                                                                include_once DOL_DOCUMENT.'/application/system/pacientes/admin_paciente/view/documentos_clinicos.php';

                                                                                break;

                                                                            case 'form_odontograma':

                                                                                include_once DOL_DOCUMENT.'/application/system/pacientes/admin_paciente/view/form_odontograma.php';

                                                                                break;

                                                                            case 'form_citas':

                                                                                include_once DOL_DOCUMENT.'/application/system/pacientes/admin_paciente/view/form_citas.php';

                                                                                break;

                                                                        }
                                                                    }

                                                            ?>

                                                        </div>
                                                    </div>


                                        </div>

                                    </div>

                                </div>

                        </div>

                </div>
        </section>
    </div>

</div>

<?php include_once  DOL_DOCUMENT.'/public/view/modal_search_paciente.php'?>
<?php include_once DOL_DOCUMENT .'/application/system/pacientes/admin_paciente/view/menus_adminpacientes.php'; ?>

<?php include_once  DOL_DOCUMENT .'/public/view/footer_principal.php';?>

<script src="<?php echo  DOL_HTTP .'/application/system/pacientes/admin_paciente/js/input_file.js';?>"></script>

<script>

    $id_paciente               = "<?php echo  $id ?>";
    $DOCUMENTO_URL_HTTP        = "<?php echo DOL_HTTP ?>"; //URL  HTTP DOCUMENTO
    $HTTP_DIRECTORIO_ENTITY    = "<?php echo $conf->NAME_DIRECTORIO ?>";  //ENTIDAD DE LA EMPRESA PARA JAVASCRIPT


</script>

<!--admin pacientes javascrip sub-mod Datos personales - carga Familiares - Imagenes y Archivos-->



<?php

    $name_mod = "";

    switch ($view)
    {
        case 'form_datos_personales':
            echo "<script src=' ".DOL_HTTP." /application/system/pacientes/admin_paciente/js/pacientesdatos.js'       ></script>";
            $name_mod = "DATOS PERSONALES DEL PACIENTE";
            break;

        case "form_carga_familiares":
            echo "<script src=' ".DOL_HTTP." /application/system/pacientes/admin_paciente/js/carga_familiares.js'       ></script>";
            $name_mod = "CARGA FAMILIARES DEL PACIENTE";
            break;

        case "form_archivos":
            echo "<script src=' ".DOL_HTTP." /application/system/pacientes/admin_paciente/js/adm_pacientes_ficheros.js'></script>";
            $name_mod = "ARCHIVOS DEL PACIENTE";
            break;

        case "comentarios_pacientes":
            echo "<script src=' ".DOL_HTTP." /application/system/pacientes/admin_paciente/js/comment.js'       ></script>";
            $name_mod = "COMENTARIOS DEL PACIENTE";
            break;

        case "form_plan_tratamiento":
            echo "<script src=' ".DOL_HTTP."/application/system/pacientes/admin_paciente/js/plan_tratamiento.js'       ></script>";
            $name_mod = "PLANES DE TRATAMIENTO DEL PACIENTE";
            break;

        case "documentos_clinicos":
            echo "<script src=' ".DOL_HTTP."/application/system/pacientes/admin_paciente/js/document_clinicos.js'       ></script>";
            $name_mod = "DOCUMENTOS ASOCIADOS DEL PACIENTE";
            break;

        case "form_odontograma":
            echo "<script src=' ".DOL_HTTP."/application/system/pacientes/admin_paciente/js/odontograma.js'           ></script>";
            $name_mod = "ODONTOGRAMA DEL PACIENTE";
            break;

        case "form_citas":
            echo "<script src=' ".DOL_HTTP." /application/system/pacientes/admin_paciente/js/paciente_citas.js'       ></script>";
            $name_mod = "CITAS CLINICAS DEL PACIENTE";
            break;
    }

?>


<script>

    //ready
    switch ("<?= $view ?>")
    {

         case "documentos_clinicos":

            CargarSelect2ClinicoDocument();
            list_documentos_clinicos();

                if($create_documento != "" && idClinicoDocumento != "") //COMPRUEBO SI EL DOCUMENTO ESTA PARA MODIFICAR
                {
                    ObtenerDatosDocumentosFichaClinica($create_documento, idClinicoDocumento);

                }else {

                    var $detalle_info_paciente = <?= json_encode($conf->ObtenerPaciente($db, $_GET["id"], true)) ?> ;
                    console.log($detalle_info_paciente);
                    Obj_default_doctClinico($detalle_info_paciente)
                }

            break;

    }

    if("<?= $name_mod ?>" != ""){

        $("#tituloInfo").text("<?= $name_mod ?>");
    }

</script>

