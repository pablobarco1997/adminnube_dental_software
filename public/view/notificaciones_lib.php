<!--NOTIFICACIONES -->

<?php //echo '<pre>';  print_r($conf->NOTIFICACIONES->Glob_Notificaciones); die();  ?>


<li class="dropdown messages-menu">
    <!-- Menu toggle button -->
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-bell-o"></i>
        <span class="label label-warning" id="nume_notificacion"><?= $conf->NOTIFICACIONES->Numero->NumeroNotificaciones ?></span>
    </a>

    <ul class="dropdown-menu " style="width: 400px ;height: 400px; overflow-y: auto">

        <li class="header">  <?= $conf->NOTIFICACIONES->Numero->NumeroNotificaciones ?> NOTIFICACIONES </li>

        <li>
            <!-- Inner Menu: contains the notifications -->
            <ul class="no-margin no-padding" style="width: 100%; height: 100% !important; list-style: none">

                    <li class="notificacion_list" style="padding: 1px;  ">
                        <ul class="notiflist" style="list-style: none; padding-left: 0px; ">

                            <?php

                                foreach ($conf->NOTIFICACIONES->Glob_Notificaciones as $key => $v)
                                {

                                    if( $v->tipo_notificacion == 'notificacion_citas_paciente' )
                                    {

                                        $hora_desde_A = substr($v->horaIni, 0, 5 ) ." A " . substr($v->horafin, 0, 5 ); //Corto

                                        $htmlCitasList = "
                                                <li style='margin-bottom: 2px; padding: 5px' class='listNotificacion' >
                                                    <div class='form-group col-md-12 col-xs-12 no-margin no-padding'>
                                                        <div class='media'>
                                                            <a class='pull-left'> <img src='".DOL_HTTP."/logos_icon/logo_default/cita-medica.png' class='img-rounded img-md' alt=''> </a>
                                                            <div class='media-body'>
                                                                <h5 class='media-heading'>
                                                                    <b>Doctor:</b> &nbsp;&nbsp; $v->doctor_cargo <br>
                                                                    <b>Paciente:</b>&nbsp;&nbsp; $v->nombe_paciente <br>
                                                                    <b>Fecha:</b>&nbsp;&nbsp; $v->fecha <br>
                                                                    <b>Hora:</b>&nbsp;&nbsp; $hora_desde_A <br>
                                                                    <b>Comentario:</b>&nbsp;&nbsp; $v->comment
                                                                    <button class='btn-xs btn btn-block btnhover' style='font-weight: bolder; color: green'>EN SALA DE ESPERA</button>
                                                                </h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                
                                        ";

                                        echo $htmlCitasList; #imprime la lista de citas
                                    }

                                    #end citas notificacion


                                }

                            ?>

                            <li class="divider"></li>

                        </ul>
                    </li>



            </ul>

        </li>
<!--        <li class="footer"><a href="#">View all</a></li>-->
    </ul>

</li>