<!-- Navbar Right Menu -->
<div class="navbar-custom-menu">

    <ul class="nav navbar-nav">

        <!-- Notifications Menu -->


        <?php include_once  DOL_DOCUMENT .'/public/view/notificaciones_lib.php'?>

<!--        end notificaciones-->

        <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->
                <img src="<?php echo $conf->PERFIL->icon ?>" class="user-image" alt="User Image">
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="hidden-xs"><?php echo $conf->PERFIL->nombre ?></span>
            </a>

            <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header" style="background-color: #212f3d">
                    <img src="<?php echo $conf->PERFIL->icon ; ?>" class="img-circle" alt="User Image">

                    <p>
                        <?php echo $conf->PERFIL->nombre ?>
<!--                        <small>Member since Nov. 2012</small>-->
                    </p>
                </li>
                <!-- Menu Body -->
                <li class="user-body">
                    <div class="row">

                    </div>
                    <!-- /.row -->
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <div class="pull-left">
<!--                        <a href="#" class="btn btn-default btn-flat">Profile</a>-->
                    </div>
                    <div class="pull-right">
                        <a href="<?= DOL_HTTP .'/application/system/login/controller/controller_login.php?accion=CerraSesion&ajaxSend=ajaxSend'?>" class="btn btn-default btn-flat">
                            Salir &nbsp; <i class="fa fa-sign-out"></i>
                        </a>
                    </div>
                </li>
            </ul>
        </li>
        <!-- Control Sidebar Toggle Button -->
        <li>
            <a href="#" data-toggle="control-sidebar" class="hide"><i class="fa fa-gears"></i></a>
        </li>
    </ul>


</div>