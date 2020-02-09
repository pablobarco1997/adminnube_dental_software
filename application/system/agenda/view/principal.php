<style>
    .callbox{
        border-left: 2px solid #212f3d;
    }
</style>



<div class="row">
    <div class="col-md-12">

        <div class="box box-solid">
            <div class="box-header with-border">
                <h3>AGENDA</h3>
            </div>

            <div class="box-body">


                <div class="row" >
                    <div class="form-group col-lg-12 col-md-12">
                        <div class="col-md-4 col-lg-4 col-xs-12">
                            <div class="info-box">
                                <div class="info-box-icon bg-aqua" style="background-color: #212f3d!important;">
                                    <i class="fa fa-calendar" style="margin-top: 20px"></i>
                                </div>
                                <div class="info-box-content">
                                    <span class="info-box-text">NÚMERO DE CITAS PARA HOY </span>
                                    <span class="info-box-number" style="font-size: 2em" id="numCitas">0</span>
                                    <span><?= date("Y/m/d")?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" >

                    <div class="form-group col-md-12 col-lg-12">
                        <div class="col-md-6 col-sm-6  <?= $permisos->consultar  ?>">
                            <ul class="list-inline">
                                <li>
                                    <div class="callbox">
                                        <div class="form-group">
                                            <div class="checkbox <?= $permisos->consultar  ?>">
                                                <a style="color: #333333" href="<?= DOL_HTTP .'/application/system/agenda/index.php?view=principal&list=diaria' ?>" class="btn btnhover <?= $permisos->consultar  ?>">
                                                    DIARIA
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="callbox">
                                        <div class="form-group">
                                            <div class="checkbox  <?= $permisos->consultar  ?>">
                                                <a style="color: #333333" href="<?php echo DOL_HTTP.'/application/system/agenda/index.php?view=principal&list=diariaglob'?>" class="btn btnhover <?= $permisos->consultar  ?>">
                                                    DIARIA GLOBAL
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="callbox">
                                        <div class="form-group">
                                            <div class="checkbox <?= $permisos->consultar  ?>">
                                                <a href="#agendaModCitas" data-toggle="modal" style="color: #333333" class="btn btnhover addCitas  <?= $permisos->agregar  ?>">
                                                    AGENDAR UNA CITA &nbsp;&nbsp;<i class="fa fa-calendar"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-12 col-md-12">

                        <div class="form-group col-md-4 col-xs-12">
                            <label for="">Fecha</label>
                            <div class="input-group form-group rango" style="margin: 0">
                                <input type="text" class="form-control filtroFecha <?= $permisos->consultar  ?> " id="startDate" value="">
                                <span class="input-group-addon" style="border-radius: 0"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>


                        <div class="form-group  col-md-4 col-xs-12">
                            <label for="">Doctor</label>
                            <select name="" id="filtro_doctor" class="filtrar_doctor select2_max_ancho <?= $permisos->consultar  ?>" >
                                <option value=""></option>
                                <?php
                                $sql = "SELECT * FROM tab_odontologos;";
                                $rs = $db->query($sql);
                                if($rs->rowCount() > 0)
                                {
                                    while ($obj = $rs->fetchObject())
                                    {
                                        echo "<option value='$obj->rowid'>$obj->nombre_doc  $obj->apellido_doc</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>


                        <div class="form-group col-md-4 col-xs-12">
                            <label for="">Estados</label>
                            <select name="" id="filtroEstados" class="select2_max_ancho filtrar_estados <?= $permisos->consultar  ?>" multiple>
                                <option value=""></option>
                                <?php
                                $sql = "SELECT * FROM tab_pacientes_estado_citas;";
                                $rs = $db->query($sql);
                                if($rs->rowCount() > 0)
                                {
                                    while ($obj = $rs->fetchObject())
                                    {
                                        echo "<option value='$obj->rowid' >$obj->text</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group col-md-4 pull-right">
                            <ul class="list-inline pull-right">
                                <li>  <button class="aplicar btn btnhover <?= $permisos->consultar  ?>" style="float: right; padding: 3px" > &nbsp; <i class="fa fa-search" ></i> &nbsp;buscar &nbsp;</button> </li>
                                <li>  <button class="limpiar btn btnhover <?= $permisos->consultar  ?>" style="float: right; padding: 3px" > &nbsp; &nbsp; Limpiar &nbsp; &nbsp;</button> </li>
                            </ul>
                        </div>

                    </div>
                </div>

                <div class="form-group col-md-12 col-xs-12">
                    <!--                Lista diaria-->
                    <div class="list-diaria">

                        <?php

                        if(isset($_GET['list']) && $_GET['list'] == 'diaria')
                        {
                            include_once DOL_DOCUMENT .'/application/system/agenda/view/list_diaria.php';
                        }

                        ?>
                    </div>
                    <!--                Lista global-->
                    <div class="list-diariaGlobal">
                        <?php

                        if(isset($_GET['list']) && $_GET['list'] == 'diariaglob')
                        {
                            include_once DOL_DOCUMENT .'/application/system/agenda/view/list_globaldiaria.php';
                        }

                        ?>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

<!--<====================================================================MODAL==============================================-->
<!--Modal add Citas  Mod Agenda-->
<div id="agendaModCitas" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg modal-diseng" style="width: 90% !important;">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-diseng">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">DAR CITA (agendar)  <?= date('Y/m/d') ?></h4>
            </div>
            <div class="modal-body">

                <div class="message_box center-block" style="width: 100%; width: 600px">

                </div>

               <div class="center-block" style="width: 50%">

                   <ul class="nav nav-tabs" role="tablist" style="background-color: #EBEDEF">
                       <li role="presentation" class="active"> <a href="#pacientetabs" aria-controls="pacientetabs" role="tab" data-toggle="tab"> <i class="fa fa-users"></i> &nbsp; Paciente</a></li>
                       <li role="presentation" class=""><a href="#addpacientetabs" aria-controls="addpacientetabs" role="tab" data-toggle="tab"> <i class="fa fa-plus"></i> &nbsp; Agregar Paciente</a></li>
                   </ul>

                   <!-- Tab panes -->
                   <div class="tab-content">
<!--                       Pacientes-->
                       <div role="tabpanel" class="tab-pane active" id="pacientetabs">
                               <div style="padding: 15px">
                                   <div class="form-group col-md-6">
                                       <label for="">Paciente</label>
                                       <select name="" id="pacienteCita" class="select2_max_ancho input-sm form-control">
                                           <option value=""></option>
                                               <?php
                                                   $sql = "SELECT * FROM tab_admin_pacientes;";
                                                   $rs = $db->query($sql);
                                                   if($rs->rowCount() > 0)
                                                   {
                                                       while ($obj = $rs->fetchObject())
                                                       {
                                                           echo "<option value='$obj->rowid'>$obj->nombre  $obj->apellido</option>";
                                                       }
                                                   }
                                               ?>
                                       </select>
                                   </div>

                                   <div class="form-group col-md-6">
                                       <label for="">Comentario</label>
                                       <textarea id="comentario_cita" class="form-control"></textarea>
                                   </div>

                               </div>
                       </div>
<!--                       Agregar Nuevo Pacientes-->
                       <div role="tabpanel" class="tab-pane" id="addpacientetabs">
                               <div style="padding: 15px; height: 200px; overflow-y: scroll;">
                                   <div class="row">

                                       <div class="col-md-6">

                                               <div class="form-group">
                                                   <label for="">Nombre</label>
                                                   <input type="text" class="form-control input-sm" id="nombre" >
                                               </div>

                                               <div class="form-group">
                                                   <label for="">Teléfono Movil</label>
                                                   <input type="number" class="form-control input-sm" id="t_movil">
                                               </div>
                                               <div class="form-group">
                                                   <label for="">Fecha de Nacimiento</label>
                                                   <input type="date" class="form-control input-sm" id="fech_nacimit">
                                               </div>
                                               <div class="form-group">
                                                   <label for="">Direccion</label>
                                                   <input type="text" class="form-control input-sm" id="direcc">
                                               </div>


                                       </div>

                                       <div class="col-md-6">

                                           <div class="form-group">
                                               <label for="">Apellido</label>
                                               <input type="text" class="form-control input-sm" id="apellido">
                                           </div>
                                           <div class="form-group">
                                               <label for="">Rut/cedula</label>
                                               <input type="number" class="form-control input-sm" id="rud_dni">
                                           </div>
                                           <div class="form-group">
                                               <label for="">E-mail</label>
                                               <input type="text" class="form-control input-sm" id="email">
                                           </div>
                                           <div class="form-group">
                                               <label for="">Observacion</label>
                                               <textarea name=""  cols="30"
                                                         rows="5" class="form-control input-sm" id="obsrv"></textarea>
                                           </div>

                                       </div>

                                   </div>

                                   <div class="row">
                                       <div class="col-md-12">
                                           <button class="btn btn-xs btn-success btn-block" id="nuevo_fat_paciente" >GUARDAR</button>
                                       </div>
                                   </div>
                               </div>
                       </div>
                   </div>

               </div>

                <div class="form-group col-md-12">
                    <ul style="list-style: none; float: left">
                        <li><label for="" class="btn btn-xs add_detalle_cita disabled_link3" title="Puede Agregar varias citas con diferentes especializades">  <i class="fa fa-plus-circle"></i>&nbsp;&nbsp; AGREGAR  </label> </li>
                    </ul>
<!--                   <p  style="cursor: pointer; display: inline-block; margin: 0px; padding: 5px"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp; AGREGAR</p>-->
                    <ul style="list-style: none; float: right">
                        <li>
                            <div class="checkbox" style="margin: 0px; ">
                                <label class="btn btn-xs" id="ActivarMultipleCitas">
                                    <input type="checkbox" id="ActivarMasCitasChecked">
                                    Activar Multiple Citas
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="table-responsive" style="width: 100%">

                    <table class="table dt-responsive" width="100%">

                   <thead>
                        <tr>
                            <th width="16.67%">ESPECIALIDAD</th>
                            <th width="16.67%">DOCTOR</th>
<!--                            <th width="16.67%">RECURSOS</th>-->
                            <th width="16.67%">DURACIÓN</th>
                            <th width="16.67%">FECHA CITA</th>
                            <th width="16.67%">HORA CITA</th>
                            <th width="5%">&nbsp;</th>
                        </tr>
                    </thead>

                    <tbody>

<!--                Template -->
                    <tr id="template-detalle-cita" class="select-detalles-citas hide template-detalle-cita">
                            <td>
                                <select id="template-especialidad" class="select2_max_ancho input-sm form-control select2_especialidad ">
                                    <option value=""></option>
                                    <?php
                                    $sql = "SELECT * FROM tab_especialidades_doc;";
                                    $rs = $db->query($sql);
                                    if($rs->rowCount() > 0)
                                    {
                                        while ($obj = $rs->fetchObject())
                                        {
                                            echo "<option value='$obj->rowid'>$obj->nombre_especialidad</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <select id="template-doctor" class=" select2_max_ancho input-sm form-control select2_doctor ">
                                    <option value=""></option>
                                    <?php
                                    $sql = "SELECT * FROM tab_odontologos;";
                                    $rs = $db->query($sql);
                                    if($rs->rowCount() > 0)
                                    {
                                        while ($obj = $rs->fetchObject())
                                        {
                                            echo "<option value='$obj->rowid'>$obj->nombre_doc  $obj->apellido_doc</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
<!--                            <td>-->
<!--                                <select  id="template-recurso" class="select2_max_ancho input-sm form-control ">-->
<!--                                    <option value=""></option>-->
<!--                                    <option value="0">billon</option>-->
<!--                                </select>-->
<!--                            </td>-->
                            <td>
                                <select  id="template-duracion" class="select2_max_ancho input-sm form-control select2_duraccion">
                                    <option value=""></option>
                                    <option value="15">  15 .min</option>
                                    <option value="30">  30 .min</option>
                                    <option value="45">  45 .min</option>
                                    <option value="60">  60 .min</option>
                                    <option value="75">  75 .min</option>
                                    <option value="90">  90 .min</option>
                                    <option value="105">105 .min</option>
                                    <option value="120">120 .min</option>
                                    <option value="135">135 .min</option>
                                    <option value="150">150 .min</option>
                                </select>
                            </td>
                            <td style="width: 160px">
                                <!--                                <label for="">&nbsp;&nbsp;</label>-->
                                <div class="input-group date" >
                                    <input id="template-fechaCita" type="date" class="form-control inputFecha " value="<?= date("d/m/Y")?>">
                                    <div class="input-group-addon" >
                                        <span class=""><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <select  id="template-hora"  class="select2_max_ancho input-sm form-control select2_hora">
                                    <option value=""></option>
                                    <option value="08:00">08:00</option>
                                    <option value="08:15">08:15</option>
                                    <option value="08:30">08:30</option>
                                    <option value="08:45">08:45</option>
                                    <option value="09:00">09:00</option>
                                    <option value="09:15">09:15</option>
                                    <option value="09:30">09:30</option>
                                    <option value="09:45">09:45</option>
                                    <option value="10:00">10:00</option>
                                    <option value="10:15">10:15</option>
                                    <option value="10:30">10:30</option>
                                    <option value="10:45">10:45</option>
                                    <option value="11:00">11:00</option>
                                    <option value="11:15">11:15</option>
                                    <option value="11:30">11:30</option>
                                    <option value="11:45">11:45</option>
                                    <option value="12:00">12:00</option>
                                    <option value="12:15">12:15</option>
                                    <option value="12:30">12:30</option>
                                    <option value="12:45">12:45</option>
                                    <option value="13:00">13:00</option>
                                    <option value="13:15">13:15</option>
                                    <option value="13:30">13:30</option>
                                    <option value="13:45">13:45</option>
                                    <option value="14:00">14:00</option>
                                    <option value="14:15">14:15</option>
                                    <option value="14:30">14:30</option>
                                    <option value="14:45">14:45</option>
                                    <option value="15:00">15:00</option>
                                    <option value="15:15">15:15</option>
                                    <option value="15:30">15:30</option>
                                    <option value="15:45">15:45</option>
                                    <option value="16:00">16:00</option>
                                    <option value="16:15">16:15</option>
                                    <option value="16:30">16:30</option>
                                    <option value="16:45">16:45</option>
                                    <option value="17:00">17:00</option>
                                    <option value="17:15">17:15</option>
                                    <option value="17:30">17:30</option>
                                    <option value="17:45">17:45</option>
                                    <option value="18:00">18:00</option>
                                    <option value="18:15">18:15</option>
                                    <option value="18:30">18:30</option>
                                    <option value="18:45">18:45</option>
<!--                                    <option value="fueraHorario">Fuera de Horario</option>-->
                                </select>
                            </td>

                            <td>
                                <a class="btn btn-social-icon btn-danger delete-detalle-cita"><i class="fa fa-x2 fa-trash"></i> </a>
                            </td>
                    </tr>

<!--                ORIGINAL-->
                    <tr id="detalle-0" class="detalleIndex-0 select-detalles-citas row_detalleCitas">
                            <td>
                                <select  name="especialidad[0].detalle" class="select2_max_ancho input-sm form-control select2_especialidad">
                                    <option value=""></option>
                                    <?php
                                        $sql = "SELECT * FROM tab_especialidades_doc;";
                                        $rs = $db->query($sql);
                                        if($rs->rowCount() > 0)
                                        {
                                            while ($obj = $rs->fetchObject())
                                            {
                                                echo "<option value='$obj->rowid'>$obj->nombre_especialidad</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <select name="doctor[0].detalle" class=" select2_max_ancho input-sm form-control select2_doctor">
                                    <option value=""></option>
                                    <?php
                                        $sql = "SELECT * FROM tab_odontologos;";
                                        $rs = $db->query($sql);
                                        if($rs->rowCount() > 0)
                                        {
                                            while ($obj = $rs->fetchObject())
                                            {
                                                echo "<option value='$obj->rowid'>$obj->nombre_doc  $obj->apellido_doc</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </td>
<!--                            <td>-->
<!--                                <select name="recursos[0].detalle" id="" class="select2_max_ancho input-sm form-control select2_recurso">-->
<!--                                    <option value=""></option>-->
<!--                                    <option value="0">billon</option>-->
<!--                                </select>-->
<!--                            </td>-->
                            <td>
                                <select name="duraccion[0].detalle" id="" class="select2_max_ancho input-sm form-control select2_duraccion">
                                    <option value=""></option>
                                    <option value="15">  15 .min</option>
                                    <option value="30">  30 .min</option>
                                    <option value="45">  45 .min</option>
                                    <option value="60">  60 .min</option>
                                    <option value="75">  75 .min</option>
                                    <option value="90">  90 .min</option>
                                    <option value="105">105 .min</option>
                                    <option value="120">120 .min</option>
                                    <option value="135">135 .min</option>
                                    <option value="150">150 .min</option>
                                </select>
                            </td>
                            <td style="width: 160px">
<!--                                <label for="">&nbsp;&nbsp;</label>-->
                                <div class="input-group date" >
                                    <input name="fechacita[0].detalle" type="date" class="form-control inputFecha " value="<?= date("d/m/Y")?>">
                                    <div class="input-group-addon" >
                                        <span class=""><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <select name="hora[0].detalle" id=""  class="select2_max_ancho input-sm form-control select2_hora">
                                    <option value=""></option>
                                    <option value="08:00">08:00</option>
                                    <option value="08:15">08:15</option>
                                    <option value="08:30">08:30</option>
                                    <option value="08:45">08:45</option>
                                    <option value="09:00">09:00</option>
                                    <option value="09:15">09:15</option>
                                    <option value="09:30">09:30</option>
                                    <option value="09:45">09:45</option>
                                    <option value="10:00">10:00</option>
                                    <option value="10:15">10:15</option>
                                    <option value="10:30">10:30</option>
                                    <option value="10:45">10:45</option>
                                    <option value="11:00">11:00</option>
                                    <option value="11:15">11:15</option>
                                    <option value="11:30">11:30</option>
                                    <option value="11:45">11:45</option>
                                    <option value="12:00">12:00</option>
                                    <option value="12:15">12:15</option>
                                    <option value="12:30">12:30</option>
                                    <option value="12:45">12:45</option>
                                    <option value="13:00">13:00</option>
                                    <option value="13:15">13:15</option>
                                    <option value="13:30">13:30</option>
                                    <option value="13:45">13:45</option>
                                    <option value="14:00">14:00</option>
                                    <option value="14:15">14:15</option>
                                    <option value="14:30">14:30</option>
                                    <option value="14:45">14:45</option>
                                    <option value="15:00">15:00</option>
                                    <option value="15:15">15:15</option>
                                    <option value="15:30">15:30</option>
                                    <option value="15:45">15:45</option>
                                    <option value="16:00">16:00</option>
                                    <option value="16:15">16:15</option>
                                    <option value="16:30">16:30</option>
                                    <option value="16:45">16:45</option>
                                    <option value="17:00">17:00</option>
                                    <option value="17:15">17:15</option>
                                    <option value="17:30">17:30</option>
                                    <option value="17:45">17:45</option>
                                    <option value="18:00">18:00</option>
                                    <option value="18:15">18:15</option>
                                    <option value="18:30">18:30</option>
                                    <option value="18:45">18:45</option>
                                    <option value="fueraHorario">Fuera de Horario</option>
                                </select>
                            </td>
                        </tr>

                    </tbody>
                </table>

                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success <?= $permisos->agregar ?>" id="guardar_cita">Guardar</button>
            </div>

        </div>

    </div>
</div>


<!--MODALES-->

<div id="modalWhapsapp" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Confirmar por whatsapp</h4>
                <span>Telefono Movil: &nbsp;</span> <span id="number_whasap"></span>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <div class="center-block" style="width: 100px">
                            <img src="https://img.icons8.com/plasticine/2x/whatsapp.png" alt="" style="width: 100%">
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="">Mensaje</label>
                        <textarea name="" id="mensajetext" class="form-control" cols="20" rows="5"></textarea>
                    </div>
                    <div class="form-group col-md-12">
                        <a href="https://wa.me/593987722863?text=hola mundo" target="_blank" id="sendwhap" class="btn btn-block btn-xs" style=" color: black;background-color: #60be92"><i class="fa fa-whatsapp"></i> ENVIAR MENSAJE</a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<!--modal email-->
<?php
    include_once DOL_DOCUMENT .'/application/system/agenda/view/status_modal.php';
?>