
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
    <link rel="stylesheet" href="<?php echo  DOL_HTTP.'/public/bower_components/bootstrap/dist/css/bootstrap.min.css' ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo DOL_HTTP .'/public/bower_components/font-awesome/css/font-awesome.min.css'?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo DOL_HTTP .'/public/bower_components/Ionicons/css/ionicons.min.css'?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo DOL_HTTP .'/public/css/AdminLTE.min.css'?>">
    <link rel="stylesheet" href="<?php echo DOL_HTTP .'/public/css/skins/skin-blue.min.css'?>">
    <link rel="stylesheet" href="<?php echo DOL_HTTP .'/public/css/css_global/form_control_input.css'?>">
<!--    datatable-->
    <link rel="stylesheet" href="<?php echo DOL_HTTP .'/public/bower_components/datatable/datatables.net-bs/css/dataTables.bootstrap.css'?>">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
    <!--    select2-->
    <link rel="stylesheet" href="<?php echo DOL_HTTP .'/public/bower_components/select2/select2-bootstrap.css' ?>" >
    <link rel="stylesheet" href="<?php echo DOL_HTTP .'/public/bower_components/select2/select2.css' ?>" >
<!--    sweetarlert2 -->
    <link rel="stylesheet" href=" <?php echo DOL_HTTP .'/public/lib/sweetalert2/sweetalert2.css'?> ">
<!--    input search css-->
    <link rel="stylesheet" href=" <?php echo DOL_HTTP .'/public/css/inputSearch.css'?> ">
<!--    alertify-->
    <link rel="stylesheet" href=" <?php echo DOL_HTTP .'/public/lib/alertify/css/alertify.rtl.css'?> ">

</head>
<style>
    *{
        font-family: 'Open Sans', sans-serif;

    }
    table tbody tr td{
        font-size: 1.4rem !important;
    }
</style>
<!--loadding -->
<body class="skin-blue sidebar-mini sidebar-collapse">


<h2 class="loadding-text text-center" id="loaddin-text" style="display: none">CARGANDO...</h2>

