<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="#Informacion_clinica_modal" data-toggle="modal" class="logo" style="background-color: #212F3D!important;">
        <span class="logo-lg">
            <small><?= $conf->EMPRESA->INFORMACION->nombre ?></small>&nbsp;<img width="48px" src="<?= !empty($conf->EMPRESA->INFORMACION->logo) ? DOL_HTTP.'/logos_icon/'.$conf->NAME_DIRECTORIO.'/'.$conf->EMPRESA->INFORMACION->logo :  DOL_HTTP .'/logos_icon/logo_default/icon_software_dental.png'?>" alt="">
        </span>
        <span class="logo-mini">
            <img width="50px" src="<?= !empty($conf->EMPRESA->INFORMACION->logo) ? DOL_HTTP.'/logos_icon/'.$conf->NAME_DIRECTORIO.'/'.$conf->EMPRESA->INFORMACION->logo :  DOL_HTTP .'/logos_icon/logo_default/icon_software_dental.png'?>" alt="">
        </span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation" style="background-color: #212F3D!important;">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-form navbar-left" role="search">
            <div class="form-group" style="">
                <input type="text" class=" input-sm" id="navbar-search-input" placeholder="buscar" style="background-color: #ffffff; border-radius: 0px !important; width: 300px">
            </div>
        </div>

        <?php include_once $DOL_DOCUMENT.'/public/view/dropdown.php'; ?>

    </nav>
</header>