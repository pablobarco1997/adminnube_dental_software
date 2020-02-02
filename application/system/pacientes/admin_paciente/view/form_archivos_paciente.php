<div class="row" style="padding: 16px">

    <div class="col-md-12 col-lg-12 col-sm-12 margenTopDiv">

        <div class="row margin-bottom">
            <div class="col-md-3" style="float: right">
                <button class="btn btn-success btn-block btn-sm" data-toggle="modal" data-target="#modal_add_fichero" >AGREGAR</button>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-lg-12 col-sm-12 margenTopDiv">
        <div class="table-responsive">
            <table class="table" width="100%" id="table_ficheros_paciente">

                <thead style="background-color: #FDFEFE">
                    <tr>
                        <th width="12%">FECHA</th>
                        <th width="21%">FICHEROS</th>
                        <th width="21%">TITULO</th>
                        <th width="21%">DOCTOR</th>
                        <th width="21%">COMENTARIO</th>
                    </tr>
                </thead>

            </table>
        </div>
    </div>

</div>

<!--//Modals-->

<!--add fichero al paciente-->

<!-- Modal -->
<div class="modal fade" id="modal_add_fichero" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header modal-diseng">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">FICHEROS</h4>
            </div>

                <div class="modal-body">
                    <div style="width: 100%">
                        <form action="" id="formFicheros">
                            <table class="table" width="100%">

                                <thead>
                                    <tr>
                                        <th width="50%">Archivo</th>
                                        <th width="50%">Detalle</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="file_box">
                                                        <div class="text-center">

                                                            <div class="row">

                                                                <div class="col-md-6 col-xs-12">
                                                                    <div style="margin-top: 75px">
                                                                        <input type="file" name="files[]" id="file-5" class="inputfile inputfile-4" style="display: none" data-multiple-caption="{count} Archivos Seleccionados" multiple />
                                                                        <label for="file-5" style="cursor: pointer">
                                                                            <i class="fa fa-3x fa-upload"></i>&nbsp;&nbsp;
                                                                            <span>Seleccione Archivo&hellip;</span>
                                                                        </label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6 col-xs-12">
                                                                    <div style="margin-top: 30px">
                                                                        <img id="iconviewblock" width="150px" height="150px" src="<?= DOL_HTTP .'/logos_icon/logo_default/viewnoblock.png'?>" alt="">
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <br>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="row">
                                                <div class="col-sm-12 margenTopDiv">
                                                    <input type="text" class="form-control" placeholder="Titulo" id="ficheroTitulo" name="tituloFichero">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 margenTopDiv">
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
                                                <div class="col-sm-6 margenTopDiv">
                                                    <input class="form-control disabled_link3" name="fechaFichero" value="<?= date('Y/m/d')?>">
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                   <textarea  class="form-control" name="observacion" id="ficheroobservacion"></textarea>
                                                </div>
                                            </div>

                                            <br>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <button class="btn btn-success btn-block">Guardar</button>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>

                                </tbody>

                            </table>
                        </form>
                    </div>
                </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

        </div>


    </div>
</div>