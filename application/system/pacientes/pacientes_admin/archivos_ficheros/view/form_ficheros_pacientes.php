
<div class="form-group col-xs-12 col-md-12">
    <div class="col-xs-6">
        <a href="#" class="btn btnhover" style="background-color: #e5e8e8" data-target="#add_fichero" data-toggle="collapse" >AGREGAR FICHERO</a>
    </div>
    <div class="col-xs-12 collapse" id="add_fichero" >
        <br>
        <h3>FICHEROS</h3>

        <div class="col-xs-12 col-md-12 center-block" >
            <form action="" id="formFicheros">
                <div class="table-responsive">
                    <table class="table" width="100%">
                        <thead>
                        <tr>
                            <th width="100%">FICHERO - DETALLE</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>

                                <div class="form-group col-md-6 col-xs-12">
                                    <div class="form-group col-xs-12 col-md-12">
                                        <div class="form-group col-md-12 col-xs-12">
                                            <img id="iconviewblock" class="center-block" width="150px" height="150px" src="<?= DOL_HTTP .'/logos_icon/logo_default/file.png'?>" alt="">
                                        </div>

                                        <div class="form-group col-md-12 col-xs-12" style="margin-bottom: 0px">
                                            <input type="file" name="files[]" id="file-5" class="inputfile inputfile-4" style="display: none" data-multiple-caption="{count} Archivos Seleccionados" multiple />
                                            <label for="file-5" style="cursor: pointer; width: 300px" class="center-block btn btnhover">
                                                <i class="fa fa-3x fa-upload"></i>&nbsp;&nbsp;
                                                <span>Seleccione Archivo&hellip;</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-6 col-xs-12">
                                    <div class="form-group col-xs-12 col-md-12">
                                        <div class="form-group col-xs-12 col-md-12">
                                            <input type="text" class="form-control" placeholder="Titulo" id="ficheroTitulo" name="tituloFichero">
                                        </div>
                                        <div class="form-group col-xs-6 col-md-6">
                                            <select name="doctor" id="doctor" class="select2_max_ancho">
                                                <option value=""></option>
                                                <?php
                                                $sql = "SELECT concat( nombre_doc, ' ', apellido_doc ) as doc , rowid FROM tab_odontologos";
                                                $rs = $db->query($sql);

                                                if($rs->rowCount() > 0)
                                                {
                                                    while($r = $rs->fetchObject())
                                                    {
                                                        echo "<option value='$r->rowid'>$r->doc</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-xs-6 col-md-6">
                                            <input class="form-control" disabled name="fechaFichero" value="<?= date('Y/m/d')?>">
                                        </div>
                                        <div class="form-group col-xs-12 col-md-12">
                                            <textarea  class="form-control" name="observacion" id="ficheroobservacion" placeholder="Ingrese un commentario"></textarea>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <button  style="font-weight: bolder; color: green;" class="btn  btnhover btn-block">Guardar</button>
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="form-group col-md-12 col-xs-12">
    <div class="col-xs-12 col-md-12">
        <div class="table-responsive">
            <table class="table" width="100%" id="table_ficheros_paciente">
                <thead>
                <tr>
                    <th width="50.33%">Nombre</th>
                    <th width="40.33%">Descripción</th>
                    <th width="20.33%">Fecha</th>
                    <th width="5%"></th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

</div>