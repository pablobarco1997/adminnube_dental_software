<!--NOTIFICACIONES -->

<?php //echo '<pre>';  print_r($conf->NOTIFICACIONES->Glob_Notificaciones); die();  ?>


<li class="dropdown messages-menu">
    <!-- Menu toggle button -->
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-bell-o"></i>
        <span class="label label-warning" id="N_noti"></span>
    </a>

    <ul class="dropdown-menu " id="menuNotificacion" style="width: 400px ;height: 400px; overflow-y: auto">

        <li class="header">  <b id="N_Notificaciones"></b>  NOTIFICACIONES </li>

        <li>
            <!-- Inner Menu: contains the notifications -->
            <ul class="no-margin no-padding" style="width: 100%; height: 100% !important; list-style: none">

                    <li class="notificacion_list" style="padding: 1px;  ">
                        <ul class="notiflist" style="list-style: none; padding-left: 0px; ">

                        </ul>
                    </li>
            </ul>
        </li>
<!--        <li class="footer"><a href="#">View all</a></li>-->
    </ul>

</li>