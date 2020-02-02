<li class="dropdown messages-menu">
    <!-- Menu toggle button -->
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-bell-o"></i>
        <span class="label label-warning" id="nume_notificacion"><?= count($conf->NOTIFICACIONES_CITAS) ?></span>
    </a>
    <ul class="dropdown-menu">

        <li class="header"> TIENES <?= count($conf->NOTIFICACIONES_CITAS) ?> NOTIFICACIONES </li>
        <li>
            <!-- Inner Menu: contains the notifications -->
            <ul class="menu">

                <?php

                    $notifi_citas = $conf->NOTIFICACIONES_CITAS;

                    foreach ($notifi_citas as $key => $v)
                    {

                        $hora_desde_A = substr($v->hora_inicio, 0, 5 ) ." A " . substr($v->hora_fin, 0, 5 ); //Corto
                ?>

                <li class="notificacion_list"><!-- start notification -->

                    <a href="#ModalInfoamcionNotificaicion" data-toggle="modal" data-idCita="<?= $v->id_detalle_cita ?>" onclick="ObtenerInformacionNotificaion($(this),<?= $v->id_detalle_cita ?>)">
                        <div class="pull-left">
                            <img src="<?php echo DOL_HTTP .'/dist/img/user2-160x160.jpg'; ?>" class="img-circle" alt="User Image">
                        </div>
                        <h4 class="text-nowrap"  id="notifi_nombre" data-hora="<?= $hora_desde_A ?>" title="<?= $v->nombre ?>" data-nomb="<?= $v->nombre ?>" data-coment="<?= $v->comentario ?>">
                            <?= substr($v->nombre , 0, 15)?>
                            <small id="notifi_hora"><i class="fa fa-clock-o"></i> <?= $hora_desde_A ?></small>
                        </h4>

                        <p class="trunc text-coment-ontificacion" style="width: 190px!important; overflow:  hidden" title="<?= $v->comentario ?>" id="notifi_comentario"> <?= $v->comentario ?> </p>
<!--                        <i class="fa fa-users text-aqua"></i> 5 new members joined today-->
                    </a>

                </li>
                <!-- end notification -->
                <?php }?>

            </ul>
        </li>
        <li class="footer"><a href="#">View all</a></li>

    </ul>
</li>