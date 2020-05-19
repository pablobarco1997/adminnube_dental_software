<!--NOTIFICACIONES -->

<?php //echo '<pre>';  print_r($conf->NOTIFICACIONES->Glob_Notificaciones); die();  ?>


<li class="dropdown messages-menu">
    <!-- Menu toggle button -->
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-bell-o"></i>
        <span class="label label-warning" id="nume_notificacion"><?= $conf->NOTIFICACIONES->Numero->NumeroNotificaciones ?></span>
    </a>

    <ul class="dropdown-menu " id="menuNotificacion" style="width: 400px ;height: 400px; overflow-y: auto">

        <li class="header">  <?= $conf->NOTIFICACIONES->Numero->NumeroNotificaciones ?> NOTIFICACIONES </li>

        <li>
            <!-- Inner Menu: contains the notifications -->
            <ul class="no-margin no-padding" style="width: 100%; height: 100% !important; list-style: none">

                    <li class="notificacion_list" style="padding: 1px;  ">
                        <ul class="notiflist" style="list-style: none; padding-left: 0px; ">

                            <?php

                                foreach ($conf->NOTIFICACIONES->Glob_Notificaciones as $key => $v)
                                {

                                    if( $v->tipo_notificacion == 'NOTIFICAIONES_CITAS_PACIENTES' )
                                    {

                                        $hora_desde_A = substr($v->horaIni, 0, 5 ) ." A " . substr($v->horafin, 0, 5 ); //Corto

                                        $HTML_CITAS_PACIENTES = "
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
                                                                    <button class='btn-xs btn btn-block btnhover' onclick='Actulizar_notificacion_citas($v->id_detalle_cita)' style='font-weight: bolder; color: green'>EN SALA DE ESPERA</button>
                                                                </h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                
                                        ";

                                        echo $HTML_CITAS_PACIENTES; #imprime la lista de citas
                                        #end citas notificacion
                                    }


                                    #notificaiones x pacientes - confirmaciones de pacientes via email
                                    if( $v->tipo_notificacion == 'NOTIFICACION_CONFIRMAR_PACIENTE' )
                                    {
                                            $HTML_NOTIFICACION_X_PACIENTES_EMAIL = "
                                                <li style='margin-bottom: 2px; padding: 5px' class='listNotificacion' >
                                                    <div class='form-group col-md-12 col-xs-12 no-margin no-padding'>
                                                        <div class='media'>
                                                            <a class='pull-left'> <img src='".DOL_HTTP."/logos_icon/".$conf->NAME_DIRECTORIO."/".$v->icon_paciente."' class='img-rounded img-md' alt=''> </a>    
                                                            <div class='media-body'>
                                                                <h5 class='media-heading'>
                                                                    <b>Paciente:</b> &nbsp;&nbsp;   $v->paciente <br>
                                                                    <b>información adicional:</b> &nbsp;&nbsp;   $v->accion <br>
                                                                    <button class='btn-xs btn btn-block btnhover'  onclick='to_accept_noti_confirmpacient($v->id)' style='font-weight: bolder; color: green'>ACEPTAR</button> 
                                                                </h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            ";

                                            echo $HTML_NOTIFICACION_X_PACIENTES_EMAIL;
                                    }

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

<!--NOTIFICACIONES EN TIEMPO REAL-->
<script>

    $( window ).on("load", function() {

        // console.log('ready done');

        $(function() {

            var timeOut  = 1000;
            var timeReal = 3000;

            var url   = $DOCUMENTO_URL_HTTP + "/application/controllers/controller_peticiones_globales.php";
            var paramt = { 'ajaxSend':'ajaxSend', 'accion':'notification_'};

            setTimeout(function() {

                $.get(url, paramt )
                    .done(function(data) {
                        console.log(data);
                    });

            },timeOut);

            setInterval(function () {

                $.get(url, paramt , function(data){
                    console.log(data);
                });

            },timeReal);

        });

    });

</script>