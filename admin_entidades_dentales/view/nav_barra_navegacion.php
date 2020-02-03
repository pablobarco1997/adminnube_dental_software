
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




$arrayhome = (object)[
    'url'    => DOL_HTTP.'/admin_entidades_dentales/index.php?view=inicio' ,
    'active' => ($view == 'inicio') ?  'active' : '',
];

$arrayCreateClinica = (object)[
    'url'    => DOL_HTTP.'/admin_entidades_dentales/index.php?view=create_clinica' ,
    'active' => ($view == 'create_clinica') ?  'active' : '',
];


?>


<nav class="navbar navbar-default" style="">
    <div class="container-fluid">

        <div class="navbar-header">
            <a class="navbar-brand" href="<?= DOL_HTTP.'/admin_entidades_dentales/index.php?view=inicio' ?>">INICIO</a>
        </div>

        <ul class="nav navbar-nav listnav">

            <li class="<?= $arrayhome->active ?>"><a href="<?= $arrayhome->url ?>">INICIO</a></li>
            <li class="<?= $arrayCreateClinica->active ?>"><a href="<?= $arrayCreateClinica->url ?>">CREAR CLINICA</a></li>

        </ul>

    </div>
</nav>