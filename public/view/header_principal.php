
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>DENTAL SOTFWARE</title>

    <link rel="shortcut icon" href="<?= !empty($conf->EMPRESA->INFORMACION->logo) ? DOL_HTTP.'/logos_icon/'.$conf->NAME_DIRECTORIO.'/'.$conf->EMPRESA->INFORMACION->logo :  DOL_HTTP .'/logos_icon/logo_default/icon_software_dental.png'?>" type = "image/x-icon">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!--    bootstrap-->
    <link rel="stylesheet" href="<?php echo  DOL_HTTP.'/public/bower_components/bootstrap/dist/css/bootstrap.css' ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo DOL_HTTP .'/public/bower_components/font-awesome/css/font-awesome.min.css'?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo DOL_HTTP .'/public/bower_components/Ionicons/css/ionicons.min.css'?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo DOL_HTTP .'/public/css/AdminLTE.min.css'?>">
    <link rel="stylesheet" href="<?php echo DOL_HTTP .'/public/css/skins/skin-blue.min.css'?>">

    <link rel="stylesheet" href="<?php echo DOL_HTTP .'/public/css/css_global/lib_glob_style.css'?>">
    <link rel="stylesheet" href="<?php echo DOL_HTTP .'/public/css/css_global/breadcrumb.css'?>">

<!--    datatable-->
    <link rel="stylesheet" href="<?php echo DOL_HTTP .'/public/bower_components/datatable/datatables.net-bs/css/dataTables.bootstrap.css'?>">

    <!--    select2-->
    <link rel="stylesheet" href="<?php echo DOL_HTTP .'/public/bower_components/select2/select2-bootstrap.css' ?>" >
    <link rel="stylesheet" href="<?php echo DOL_HTTP .'/public/bower_components/select2/select2.css' ?>" >


<!--    sweetarlert2 -->
    <link rel="stylesheet" href=" <?php echo DOL_HTTP .'/public/lib/sweetalert2/sweetalert2.css'?> ">
<!--    input search css-->
    <link rel="stylesheet" href=" <?php echo DOL_HTTP .'/public/css/inputSearch.css'?> ">
<!--Datepicker js-->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<!--    font google-->
<!--    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">-->
<!--    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">-->

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">




    <!-- REQUIRED JS SCRIPTS ===========================================================================================-->

    <!-- jQuery 3 -->
    <script src="<?php echo DOL_HTTP.'/public/bower_components/jquery/dist/jquery.js'?>"></script>
    <!-- Bootstrap 3.4 -->
    <script src="<?php echo DOL_HTTP .'/public/bower_components/bootstrap/dist/js/bootstrap.js'?>"></script>
<!--    <script src="--><?php //echo DOL_HTTP .'/public/bower_components/bootstrap/js/popover.js'?><!--"></script>-->
    <!-- AdminLTE App -->
    <script src="<?php echo DOL_HTTP .'/public/js/adminlte.min.js'?>"></script>
    <!--datatable-->
    <script src="<?php echo DOL_HTTP .'/public/bower_components/datatable/datatables.net/js/jquery.dataTables.js'?>"></script>
    <script src="<?php echo DOL_HTTP .'/public/bower_components/datatable/datatables.net-bs/js/dataTables.bootstrap.js'?>"></script>

    <!--select2-->
    <script src="<?php echo DOL_HTTP .'/public/bower_components/select2/select2.js'?>"></script>
    <script src="<?php echo DOL_HTTP .'/public/bower_components/select2/select2_locale_es.js'?>"></script>
<!--    <script src="--><?php //echo DOL_HTTP .'/public/bower_components/select2-4.1.0beta/dist/js/select2.full.min.js'?><!--"></script>-->

    <!-- sweetalert2 -->
    <script src="<?php echo DOL_HTTP .'/public/lib/sweetalert2/sweetalert2.all.js'?>" ></script>
    <!--    mask-->
    <script src="<?php echo DOL_HTTP .'/public/lib/jquery.mask.min.js'?> "></script>
    <script src="<?php echo DOL_HTTP .'/public/lib/jquery.maskMoney.js'?> "></script>
    <!--javascript global-->
    <script src="<?php echo DOL_HTTP .'/public/js/lib_glob.js' ?>"></script>

    <!--daterangepicker-->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <!--Auto complete Bootstrap Typeahead JS-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>-->
    <script src="<?php echo DOL_HTTP .'/public/js/bootstrap3-typeahead.min.js' ?>"></script>

    <!--Notificaiones lib-->
    <script src="<?php echo DOL_HTTP .'/public/js/notificaciones___lib.js' ?>"></script>

<!--    font google para breadcrumb-->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400&display=swap" rel="stylesheet">

</head>
<style>

    *{
        /*font-family: 'Varela Round', sans-serif ;*/
        /*font-size: 0.8rem !important;*/
        font-family: 'Roboto', sans-serif;
    }

    h3{
        /*font-family: 'Varela Round', sans-serif ;*/
        font-family: 'Roboto', sans-serif;
    }

    h5{
        /*font-family: 'Varela Round', sans-serif ;*/
        font-family: 'Roboto', sans-serif;
    }

    div{
        /*font-family: 'Varela Round', sans-serif ;*/
        font-family: 'Roboto', sans-serif;
    }

    .table  tr {
         font-size: 1.4rem !important;
     }


</style>
<body class="skin-blue sidebar-mini sidebar-collapse">

<!--LOADDING HTML CSS -->
<div id="loaddinContent" class="conten-load" style="display: none;">
    <div class="loadding"></div>
</div>
<!--END LOADDIN HTML CSCS-->


