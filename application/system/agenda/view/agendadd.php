
<?php


$duracion = "
    <option value=\"15\">  15 .min</option>
    <option value=\"30\">  30 .min</option>
    <option value=\"45\">  45 .min</option>
    <option value=\"60\">  60 .min</option>
    <option value=\"75\">  75 .min</option>
    <option value=\"90\">  90 .min</option>
    <option value=\"105\">105 .min</option>
    <option value=\"120\">120 .min</option>
    <option value=\"135\">135 .min</option>
    <option value=\"150\">150 .min</option>";

$horaCita = "
    <option value=\"08:00\">08:00</option>
    <option value=\"08:15\">08:15</option>
    <option value=\"08:30\">08:30</option>
    <option value=\"08:45\">08:45</option>
    <option value=\"09:00\">09:00</option>
    <option value=\"09:15\">09:15</option>
    <option value=\"09:30\">09:30</option>
    <option value=\"09:45\">09:45</option>
    <option value=\"10:00\">10:00</option>
    <option value=\"10:15\">10:15</option>
    <option value=\"10:30\">10:30</option>
    <option value=\"10:45\">10:45</option>
    <option value=\"11:00\">11:00</option>
    <option value=\"11:15\">11:15</option>
    <option value=\"11:30\">11:30</option>
    <option value=\"11:45\">11:45</option>
    <option value=\"12:00\">12:00</option>
    <option value=\"12:15\">12:15</option>
    <option value=\"12:30\">12:30</option>
    <option value=\"12:45\">12:45</option>
    <option value=\"13:00\">13:00</option>
    <option value=\"13:15\">13:15</option>
    <option value=\"13:30\">13:30</option>
    <option value=\"13:45\">13:45</option>
    <option value=\"14:00\">14:00</option>
    <option value=\"14:15\">14:15</option>
    <option value=\"14:30\">14:30</option>
    <option value=\"14:45\">14:45</option>
    <option value=\"15:00\">15:00</option>
    <option value=\"15:15\">15:15</option>
    <option value=\"15:30\">15:30</option>
    <option value=\"15:45\">15:45</option>
    <option value=\"16:00\">16:00</option>
    <option value=\"16:15\">16:15</option>
    <option value=\"16:30\">16:30</option>
    <option value=\"16:45\">16:45</option>
    <option value=\"17:00\">17:00</option>
    <option value=\"17:15\">17:15</option>
    <option value=\"17:30\">17:30</option>
    <option value=\"17:45\">17:45</option>
    <option value=\"18:00\">18:00</option>
    <option value=\"18:15\">18:15</option>
    <option value=\"18:30\">18:30</option>
    <option value=\"18:45\">18:45</option>";



$opcionPacientes = "";
$sql = "SELECT * FROM tab_admin_pacientes;";
$rs = $db->query($sql);
if($rs->rowCount() > 0)
{
    while ($obj = $rs->fetchObject())
    {
        $opcionPacientes .= "<option value='$obj->rowid'>$obj->nombre  $obj->apellido</option>";
    }
}

$opcionEspecialidad = "";
$sql = "SELECT * FROM tab_especialidades_doc;";
$rs = $db->query($sql);
if($rs->rowCount() > 0)
{
    while ($obj = $rs->fetchObject())
    {
        $opcionEspecialidad .= "<option value='$obj->rowid'>$obj->nombre_especialidad</option>";
    }
}

$opcionOdont = "";
$sql = "SELECT * FROM tab_odontologos;";
$rs = $db->query($sql);
if($rs->rowCount() > 0)
{
    while ($obj = $rs->fetchObject())
    {
        $opcionOdont .= "<option value='$obj->rowid'>$obj->nombre_doc  $obj->apellido_doc</option>";
    }
}

?>


<style>

    table{
        margin-bottom: 50px !important;
    }

</style>

<div class="row">
    <div class="form-group col-lg-12 col-xs-12 col-md-12">
        <div class="col-md-6 col-xs-12 pull-left"></div>
        <div class="col-md-6 col-xs-12 pull-right">
            <h3 class="pull-right">AGENDAR CITA</h3>
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group col-lg-12 col-md-12">
        <div class="form-horizontal">
            <div class="form-group">
                <label for="" class="control-label col-sm-4 col-md-4 col-xs-12">nombre paciente</label>
                <div class="col-sm-5 col-md-5 col-xs-12">
                    <select  id="agndar_paciente" class="form-control select2_max_ancho">
                        <option value=""></option>
                        <?= $opcionPacientes ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="" class="control-label col-sm-4 col-md-4 col-xs-12">Observación</label>
                <div class="col-sm-5 col-md-5 col-xs-12">
                    <textarea  class="form-control" id="info-adicional" cols="30" rows="3"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-12 col-lg-12 col-xs-12">
        <div class="table-responsive">

            <div style="width: 1490px !important;">
                <table class="table table-striped" width="100%">
                    <thead>
                    <tr>
                        <th colspan="6">
                            <ul class="list-inline pull-left">
                                <li>  <a href="#" id="addCloneCitas" class="btn btnhover text-bold disabled" disabled style="color:#333333; background-color: #F8F9F9"> + agregar más de una cita </a></li>
                            </ul>

                            <ul class="list-inline pull-right">
                                <li>  <a href="#" id="masCitasPacient" class="btn btnhover text-bold"  style="color:#333333; background-color: #F8F9F9" title="ingresar mas citas para el mismo paciente">  ingresar mas citas para el mismo paciente </a></li>
                            </ul>

                        </th>
                    </tr>
                    <tr>
                        <th></th>
                        <th width="20%" class="text-center">ESPECIALIDAD</th>
                        <th width="20%" class="text-center">DOCTOR</th>
                        <th width="20%" class="text-center">DURACIÓN</th>
                        <th width="20%" class="text-center">FECHA CITA</th>
                        <th width="20%" class="text-center">HORA CITA</th>
                    </tr>
                    </thead>

                    <tbody>
                        <tr class="template-index hide " id="template-index">
                            <td > <span id="clone-eliminarow" style="padding: 5px"> <i class="fa fa-trash fa-2x"></i> </span> </td>
                            <td>
                                <select id="clone-especialidad" class="form-control optionSelect2 select2_max_ancho">
                                    <option value=""></option>
                                    <?= $opcionEspecialidad; ?>
                                </select>
                            </td>

                            <td>
                                <select id="clone-odont" class="form-control optionSelect2 select2_max_ancho">
                                    <option value=""></option>
                                    <?= $opcionOdont;?>
                                </select>
                            </td>
                            <td>
                                <select  id="clone-duraccion" class="form-control optionSelect2 select2_max_ancho">
                                    <option value=""></option>
                                    <?= $duracion; ?>
                                </select>
                            </td>
                            <td>
                                <div class="form-group date2">
                                    <div class="input-group date" data-provide="datepicker">
                                        <input type="text" class="form-control " id="clone-fecha" readonly="">
                                        <div class="input-group-addon">
                                            <span class="fa fa-calendar"></span>
                                        </div>
                                    </div>
                                    <small class="msg-error" style="color: red"></small>
                                </div>
                            </td>
                            <td>
                                <select  id="clone-hora" class="form-control optionSelect2 select2_max_ancho">
                                    <option value=""></option>
                                    <?= $horaCita;  ?>
                                </select>
                            </td>
                        </tr>
<!--------------------------------------------------------------------------------------------------------------------------->
                        <tr id="detalle-citas-index-0" class=" detalle_citas detalle-citas-index-0" data-id="0">
                            <td > <span name="eliminrow[0].det" style="padding: 5px"> <i  class="fa fa-trash fa-2x"></i> </span> </td>
                            <td>
                                <select id="" name="especialida[0].det" class="form-control optionSelect2 select2_max_ancho opcionEspecialidad">
                                    <option value=""></option>
                                    <?= $opcionEspecialidad; ?>
                                </select>
                            </td>

                            <td>
                                <select id="" name="odont[0].det" class="form-control optionSelect2 select2_max_ancho opcionOdont">
                                    <option value=""></option>
                                    <?= $opcionOdont;?>
                                </select>
                            </td>
                            <td>
                                <select  id="" name="duraccion[0].det" class="form-control optionSelect2 select2_max_ancho duracion">
                                    <option value=""></option>
                                    <?= $duracion; ?>
                                </select>
                            </td>
                            <td>
                                <div class="form-group date2">
                                    <div class="input-group date" data-provide="datepicker">
                                        <input type="text" class="form-control fechaIni" name="fecha[0].det" id="inputFecha" readonly="">
                                        <div class="input-group-addon">
                                            <span class="fa fa-calendar"></span>
                                        </div>
                                    </div>
                                    <small class="msg-error" style="color: red"></small>
                                </div>
                            </td>
                            <td>
                                <select  id="" name="hora[0].det" class="form-control optionSelect2 select2_max_ancho horaCita">
                                    <option value=""></option>
                                    <?= $horaCita;  ?>
                                </select>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="form-group col-xs-12 col-md-12">
        <div class="col-md-12 col-xs-12">
            <input type="button" class="btn btnhover btn-block" style="font-weight: bolder; color: green" id="guardar-citas" value="Guardar">
        </div>
    </div>
</div>