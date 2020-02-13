
<?php


$view = "";

if(isset($_GET['view']) && $_GET['view'] == 'inicio')
{
    $view   = $_GET['view'];
}
if(isset($_GET['view']) && $_GET['view'] == 'create_clinica')
{
    $view   = $_GET['view'];
}
if(isset($_GET['view']) && $_GET['view'] == 'create_querydb')
{
    $view   = $_GET['view'];
}




$arrayhome = (object)[
    'url'    => DOL_HTTP.'/admin_entidades_dentales/index.php?view=inicio' ,
    'active' => ($view == 'inicio') ?  'active' : '',
];

$arrayCreateClinica = (object)[
    'url'    => DOL_HTTP.'/admin_entidades_dentales/index.php?view=create_clinica' ,
    'active' => ($view == 'create_clinica') ?  'active' : '',
];

$arrayIngresoConsultas = (object)[
    'url'    => DOL_HTTP.'/admin_entidades_dentales/index.php?view=create_querydb' ,
    'active' => ($view == 'create_querydb') ?  'active' : '',
];


?>

<style>

    .borderlits{
        border-left: 1px solid #a5a5a5;
    }
</style>

<nav class="navbar navbar-default" style="">
    <div class="container-fluid">


        <div class="navbar-header">
            <a class="navbar-brand" href="<?= DOL_HTTP.'/admin_entidades_dentales' ?>">INICIO</a>
        </div>

        <ul class="nav navbar-nav listnav">

        <?php

            if($login == 1)
            {

        ?>

        <li class="borderlits <?= $arrayhome->active ?>"><a href="<?= $arrayhome->url ?>">INICIO</a></li>
        <li class="borderlits <?= $arrayCreateClinica->active ?>"><a href="<?= $arrayCreateClinica->url ?>">CREAR CLINICA</a></li>
        <li class="borderlits <?= $arrayIngresoConsultas->active ?>"><a href="<?= $arrayIngresoConsultas->url ?>">AGREGAR CONSULTAS A TODAS LA BASES &nbsp;<i class="fa fa-database"></i></a></li>
        <li class="borderlits"><a href="#" onclick="cerrarSesion()">CERRAR SESION</a></li>

        <?php  }else{ ?>

        <?php }?>

        </ul>

    </div>
</nav>





<script>

    function  cerrarSesion()
    {
        $.ajax({
            url: "<?= DOL_HTTP ?>" + "/admin_entidades_dentales/entidad_controller/controller.php",
            type: 'POST',
            data: {
                'ajaxSend': 'ajaxSend' ,
                'accion'  : 'cerrar_sesion'
            },
            dataType: 'json',
            async: false,
            success: function (resp)
            {
                location.reload();
            }
        });
    }

</script>