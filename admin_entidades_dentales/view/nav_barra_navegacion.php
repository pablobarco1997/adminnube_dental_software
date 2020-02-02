
<?php

$view = "";

if(isset($_GET['view']) && $_GET['view'] == 'inicio')
{
    $view   = $_GET['view'];
}




$arrayhome = (object)[
    'url'    => DOL_HTTP.'/admin_entidades_dentales/index.php?view=inicio' ,
    'active' => ($view == 'inicio') ?  'active' : '',
];


?>


<nav class="navbar navbar-default" style="">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?= DOL_HTTP.'/admin_entidades_dentales/index.php' ?>">Inicio</a>
        </div>
        <ul class="nav navbar-nav listnav">
            <li class="<?= $arrayhome->active ?>"><a href="<?= $arrayhome->url ?>">inicio</a></li>
            <li class=""><a href="#" class="blanco">Page 1</a></li>
            <li class=""><a href="#" class="blanco">Page 2</a></li>
            <li class=""><a href="#" class="blanco">Page 3</a></li>
        </ul>
    </div>
</nav>