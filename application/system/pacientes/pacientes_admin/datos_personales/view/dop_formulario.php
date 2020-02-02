<div class="row">

    <div class="col-md-12">

        <form id="form_update_paciente" name="form_update_paciente" enctype="multipart/form-data" style="padding: 20px">

            <div class="form-group col-xs-12 col-md-4 col-lg-4">
                <div style="width: 100%">
                    <label for="file_icon" id="imgpaciente">
                        <i id="fileIcon" style="font-size: 15rem" class="fa fa-2x  fa-user "></i>
                        <input type="file" id="file_icon" name="file_icon" style="display: none">
                    </label>
                </div>
            </div>

            <div class="form-group col-xs-12 col-md-8 col-lg-8">
                <label for="">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre">
            </div>

            <div class="form-group col-xs-12 col-md-8 col-lg-8">
                <label for="">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido">
            </div>

            <div class="form-group col-xs-12 col-md-12">
                <label for="">Rut/cedula</label>
                <input type="number" maxlength="10" class="form-control" id="rud_dni" name="rud_dni">
            </div>

            <div class="form-group col-xs-12 col-md-12">
                <label for="">E-mail</label>
                <input type="text" class="form-control" id="email" name="email">
            </div>

            <div class="form-group  col-xs-12 col-md-12">
                <label for="">convenio</label>
                <select name="convenio" id="convenio" class="form-control">
                    <option value="0">Ninguno</option>
                    <?php

                    $sql = "select * from tab_conf_convenio_desc;";
                    $rs = $db->query($sql);
                    if($rs->rowCount()>0)
                    {
                        while ($row = $rs->fetchObject())
                        {
                            echo "<option value='$row->rowid'> $row->nombre_conv </option>";
                        }
                    }

                    ?>
                </select>
            </div>

            <div class="form-group  col-xs-12 col-md-12">
                <label for="">Numero interno</label>
                <input type="number" maxlength="10" class="form-control" id="n_interno" name="n_interno">
            </div>

            <div class="form-group  col-xs-12 col-md-12">
                <label for="">Sexo</label>
                <select name="sexo" id="sexo" class="form-control" >
                    <option value="masculino">masculino</option>
                    <option value="femenino">femenino</option>
                </select>
            </div>

            <div class="form-group  col-xs-12 col-md-12">
                <label for="">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="fech_nacimit" name="fech_nacimit">
            </div>

            <div class="form-group  col-xs-12 col-md-12">
                <label for="">Ciudad</label>
                <input type="text" class="form-control" id="ciudad" name="ciudad">
            </div>

            <div class="form-group  col-xs-12 col-md-12">
                <label for="">Comuna</label>
                <input type="text" class="form-control" id="comuna" name="comuna">
            </div>

            <div class="form-group  col-xs-12 col-md-12">
                <label for="">Direccion</label>
                <input type="text" class="form-control" id="direcc" name="direcc">
            </div>

            <div class="form-group  col-xs-12 col-md-12">
                <label for="">Teléfono Fijo</label>
                <input type="number" class="form-control" id="t_fijo" name="t_fijo">
            </div>

            <div class="form-group  col-xs-12 col-md-12">
                <label for="">Teléfono Movil</label>
                <input type="number" class="form-control" id="t_movil" name="t_movil">
            </div>

            <div class="form-group  col-xs-12 col-md-12">
                <label for="">Actividad Profecional</label>
                <input type="text" class="form-control" id="act_profec" name="act_profec">
            </div>

            <div class="form-group  col-xs-12 col-md-12">
                <label for="">Empleador</label>
                <input type="text" class="form-control" id="empleado" name="empleado">
            </div>

            <div class="form-group  col-xs-12 col-md-12">
                <label for="">Observacion</label>
                <textarea name="obsrv"  cols="30"
                          rows="5" class="form-control" id="obsrv"></textarea>
            </div>

            <div class="form-group  col-xs-12 col-md-12">
                <label for="">Apoderado</label>
                <input type="text" class="form-control" id="apoderado" name="apoderado">
            </div>

            <div class="form-group  col-xs-12 col-md-12">
                <label for="">Referencia</label>
                <input type="text" class="form-control" id="refer" name="refer">
            </div>

            <div class="form-group  col-xs-12 col-md-12">
                <button id="submit" class="btn btnhover btn-block" style="font-weight: bolder; color: green" >Guardar</button>
            </div>
        </form>

    </div>

</div>