<div class="row">
    <div class="col-md-12">
            <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3>Registrar Nuevo Paciente</h3>
                    </div>

                    <div class="box-body">
                            <div class="row">
                                <div class="col-lg-12 margenTopDiv">

<!--                                    <div class="col-md-6 col-sm-6 margenTopDiv">-->
<!--                                        <div style="background-color: #E5E8E8; border-radius: 3px; padding: 3px; width: 100%" >comportamientos 1</div>-->
<!--                                    </div>-->
<!---->
<!--                                    <div class="col-md-6 col-sm-6 margenTopDiv">-->
<!--                                        <div style="background-color: #E5E8E8; border-radius: 3px; padding: 3px; width: 100%">Comportamientos 2</div>-->
<!--                                    </div>-->


<!--                        FORM DE REGISTRO PACIENTE-->
                        <div class="col-md-12  col-sm-12 margenTopDiv">
                            <div style="background-color: #E5E8E8; border-radius: 3px; padding: 3px; width: 100%">

                                <div class="center-block" style="width: 70%">
                                        <form action="" style="padding: 20px">

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
                                                        <label for="">convenio</label>
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
                                                        <input type="date" class="form-control" id="fech_nacimit">
                                                        <small id="noti_date_nacimiento" style="color: red"></small>
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
                                                        <label for="">Teléfono Fijo</label>
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
                                                        <input type="button" class="btn btn-success" value="Guardar" id="guardar" style="float: right">
                                                    </div>
                                        </form>
                                    <br>
                                </div>

                            </div>
                        </div>

<!--                                        END FORM PACIENTE -->

                                    </div>
                            </div>
                    </div>

            </div>
    </div>
</div>