<?php

    include_once '../application/config/lib.global.php';

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <!-- jQuery 3 -->
    <script src="<?php echo DOL_HTTP.'/public/bower_components/jquery/dist/jquery.js'?>"></script>


    <!--    bootstrap-->
    <link rel="stylesheet" href="<?php echo  DOL_HTTP.'/public/bower_components/bootstrap/dist/css/bootstrap.min.css' ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo DOL_HTTP .'/public/bower_components/font-awesome/css/font-awesome.min.css'?>">

    <!--    datatable-->
    <link rel="stylesheet" href="<?php echo DOL_HTTP .'/public/bower_components/datatable/datatables.net-bs/css/dataTables.bootstrap.css'?>">
    <!--    select2-->
    <link rel="stylesheet" href="<?php echo DOL_HTTP .'/public/bower_components/select2/select2-bootstrap.css' ?>" >
    <link rel="stylesheet" href="<?php echo DOL_HTTP .'/public/bower_components/select2/select2.css' ?>" >

    <!--datatable-->
    <script src="<?php echo DOL_HTTP .'/public/bower_components/datatable/datatables.net/js/jquery.dataTables.js'?>"></script>
    <script src="<?php echo DOL_HTTP .'/public/bower_components/datatable/datatables.net-bs/js/dataTables.bootstrap.js'?>"></script>

    <!--datatable-->
    <script src="<?php echo DOL_HTTP .'/public/bower_components/datatable/datatables.net/js/jquery.dataTables.js'?>"></script>
    <script src="<?php echo DOL_HTTP .'/public/bower_components/datatable/datatables.net-bs/js/dataTables.bootstrap.js'?>"></script>

    <!--select2-->
    <script src="<?php echo DOL_HTTP .'/public/bower_components/select2/select2.js'?>"></script>
    <script src="<?php echo DOL_HTTP .'/public/bower_components/select2/select2_locale_es.js'?>"></script>


    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo  DOL_HTTP.'/admin_entidades_dentales/css/estilos1.css' ?>">


</head>

<body>

<!--    BARRA DE NAVEGACION-->
    <?php include_once DOL_DOCUMENT .'/admin_entidades_dentales/view/nav_barra_navegacion.php'?>

    <br>
    <div class="container">

        <?php

            if(!empty($view ))
            {
                include_once DOL_DOCUMENT.'/admin_entidades_dentales/view/'.$view.'.php';

            }else{

            }

        ?>
    </div>

</body>
</html>