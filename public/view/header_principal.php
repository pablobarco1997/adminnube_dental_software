
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

</head>
<style>

    *{
        font-family: 'Varela Round', sans-serif ;
        /*font-size: 0.8rem !important;*/
    }

    h3{
        font-family: 'Varela Round', sans-serif ;
    }

    h5{
        font-family: 'Varela Round', sans-serif ;
    }

    div{
        font-family: 'Varela Round', sans-serif ;
    }


</style>
<body class="skin-blue sidebar-mini sidebar-collapse">

<!--LOADDING HTML CSS -->
<div id="loaddinContent" class="conten-load" style="display: none;">
    <div class="loadding"></div>
</div>
<!--END LOADDIN HTML CSCS-->


