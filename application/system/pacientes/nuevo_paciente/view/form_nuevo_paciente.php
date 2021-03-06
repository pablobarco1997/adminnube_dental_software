<div class="row">
    <div class="col-md-12">
            <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3>REGISTRAR NUEVO PACIENTE</h3>
                    </div>

                    <div class="box-body">
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-xs-12">


<!--                                    LISTA DE COMPORTAMIENTOS-->

                                    <div class="form-group col-xs-12 col-md-12">

                                        <div class="form-group">

                                            <label for="">LISTA DE COMPORTAMIENTOS</label>

                                            <ul class="list-inline pull-right col-md-12 col-xs-12" style="border-bottom: 0.6px solid #333333; padding: 3px">

                                                <li> <a class="btnhover btn btn-sm " id="carga_masv_pasiente" style="color: #333333"> <small> <b> <img src="<?= DOL_HTTP.'/logos_icon/logo_default/Excel_2013_23480.png' ?>" width="18px" height="18px"> CARGAR PACIENTES MASIVO</b> </small> </a> </li>
                                                <li> <a href="<?= DOL_HTTP.'/application/system/pacientes/nuevo_paciente/export/carga_masiva_pasientes.xlsx' ?>" data-target="_blank" class="btnhover btn btn-sm " style="color: #333333"> <small> <b> <img src="<?= DOL_HTTP.'/logos_icon/logo_default/Excel_2013_23480.png' ?>" width="18px" height="18px"> DESCARGAR PLANTILLA</b> </small> </a> </li>

                                            </ul>

                                            <input type="file" id="subida_masiva_pasiente" style="display: none">

                                        </div>

                                    </div>

<!--                        FORM DE REGISTRO PACIENTE-->
                                            <div class="form-group col-md-12  col-sm-12 ">


                                                    <div class="form-group col-md-8 col-sm-12 col-xs-12 col-lg-8 col-centered">

                                                            <form action="" >

                                                                        <div class="form-group">
                                                                            <label for="">Nombre</label>
                                                                            <input type="text" class="form-control" id="nombre" >
                                                                            <small id="noti_nombre" style="color: red"></small>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="">Apellido</label>
                                                                            <input type="text" class="form-control" id="apellido">
                                                                            <small id="noti_apellido" style="color: red"></small>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="">Ruc/cedula</label>
                                                                            <input type="number" class="form-control" id="rud_dni">
                                                                            <small id="noti_ruddni" style="color: red"></small>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="">E-mail</label>
                                                                            <input type="text" class="form-control" id="email">
                                                                         </div>

                                                                        <div class="form-group">
<!--                                                                            Descuento o convenio-->
                                                                            <label for="">Descuento</label>
                                                                            <select name="convenio" id="convenio" class="form-control">
                                                                                <option value="0"> Ninguno </option>
                                                                                <?php

                                                                                    $sql = "select * from tab_conf_convenio_desc";
                                                                                    $rs  = $db->query($sql);

                                                                                    if($rs->rowCount()>0)
                                                                                    {
                                                                                        while ($rowxs = $rs->fetchObject())
                                                                                        {
                                                                                            echo "<option value='$rowxs->rowid'> $rowxs->nombre_conv </option>";
                                                                                        }
                                                                                    }

                                                                                ?>
                                                                            </select>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="">Numero interno</label>
                                                                            <input type="number" class="form-control" id="n_interno">
                                                                         </div>

                                                                        <div class="form-group">
                                                                            <label for="">Genero</label>
                                                                            <select name="" id="sexo" class="form-control" >
                                                                                <option value="masculino">masculino</option>
                                                                                <option value="femenino">femenino</option>
                                                                            </select>
                                                                            <small id="noti_sexo" style="color: red"></small>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="">Fecha de Nacimiento</label>

                                                                            <div class="input-group date" data-provide="datepicker" >
                                                                                <input type="text" class="form-control" id="fech_nacimit"  readonly>
                                                                                <div class="input-group-addon">
                                                                                    <span class="fa fa-calendar"></span>
                                                                                </div>
                                                                                <small id="noti_date_nacimiento" style="color: red"></small>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="">Ciudad</label>
                                                                            <input type="text" class="form-control" id="ciudad">
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="">Comuna</label>
                                                                            <input type="text" class="form-control" id="comuna">
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="">Dirección</label>
                                                                            <input type="text" class="form-control" id="direcc">
                                                                            <small id="noti_direccion" style="color: red"></small>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="">Teléfono convencional</label>
                                                                            <input type="number" class="form-control" id="t_fijo">
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="">Teléfono Movil</label>
                                                                            <input type="number" class="form-control" id="t_movil">
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="">Actividad Profecional</label>
                                                                            <input type="text" class="form-control" id="act_profec">
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="">Empleador</label>
                                                                            <input type="text" class="form-control" id="empleado">
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="">Observacion</label>
                                                                            <textarea name=""  cols="30"
                                                                                      rows="5" class="form-control" id="obsrv"></textarea>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="">Apoderado</label>
                                                                            <input type="text" class="form-control" id="apoderado">
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="">Referencia</label>
                                                                            <input type="text" class="form-control" id="refer">
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <input type="button" class="btn btnhover btn-block" style="font-weight: bolder; color: green" id="guardar" value="Guardar">
                                                                        </div>
                                                            </form>

                                                        <br>

                                                    </div>

                                            </div>

<!--                                        END FORM PACIENTE -->

                                    </div>
                            </div>
                    </div>

            </div>
    </div>
</div>