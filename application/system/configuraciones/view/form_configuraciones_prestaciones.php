<?php

    $idprestacion = 0;
    $accion       = "nuevo"; #nueva prestacion

    if(isset($_GET['act']))
    {
        if( $_GET['act'] == 'mod') #modificar prestacion
        {
            $accion = 'modificar';
            $idprestacion = (isset($_GET['id'])) ? $_GET['id'] : 0; #id de la prestacion
        }
    }
?>
<!--VARIABLES GLOBALES DE LOS SUBMODULOS-->
<script>

    $accion_prestacion       = "<?= $accion ?>";
    $idprestacion_prestacion = "<?= $idprestacion ?>";

</script>

<style>

</style>

<div class="box box-solid">
        <div class="box-header with-border">
            <h3>Configuración</h3>
        </div>

        <div class="box-body">
            <br>


            <div class="center-block" style="width: 70%;">

                   <ul id="confulprest" style="width: 600px; float: right; list-style: none">
                       <?php if($accion == 'modificar'){ ?>
                        <li><a href="<?= DOL_HTTP ?>/application/system/configuraciones/index.php?view=form_prestaciones"  class="btn btnhover" >Nueva Prestación</a></li>
                       <?php }?>
                        <li>  <a href="#modal_list_prestacion" id="masInformacion" data-toggle="modal" class="btn btnhover" onclick="load_table_prestaciones()"> <i class="fa fa-info"></i> Información</a></li>
                    </ul>


                <br>
                <div class="row">

                        <div class="col-xs-12">
                            <label for="">Categoria de Prestaciones</label>

                            <div class="input-group">

                                <select name="" id="conf_cat_prestaciones" class="select2_max_ancho invalic_prestaciones">
                                    <option value=""></option>
                                    <?php

                                        $sql = "SELECT * FROM tab_conf_categoria_prestacion;";
                                        $rs = $db->query($sql);
                                        if($rs->rowCount() > 0 )
                                        {
                                            while ($row =  $rs->fetchObject())
                                            {
                                                echo "<option value='$row->rowid'>$row->nombre_cat</option>";
                                            }
                                        }

                                    ?>
                                </select>

                                <div class="input-group-addon" style="cursor: pointer" data-toggle="modal" data-target="#modal_conf_categoria" onclick="nuevoUpdateCategoria()">
                                    <i class="fa fa-plus"></i>
                                </div>
                                <div class="input-group-addon" style="cursor: pointer"  data-toggle="modal" data-target="#ModaleliminarConfCatDesc" onclick="eliminar_categoria_desc_prestacion('categoria')">
                                    <i class="fa fa-minus"></i>
                                </div>

                                <small style="color: red; display: block;" id="msg_categoria"></small>
                            </div>

                        </div>

                 </div>
                <hr>
                <br>

                <div class="row">

                    <div class="col-md-6">
                        <label for="">Prestación</label>
                        <input type="text" class="form-control invalic_prestaciones " id="prestacion_descr">
                        <small style="color: red;" id="msg_prestaciones"></small>
                    </div>

                    <div class="col-md-6 disabled_link3">
                        <label for="">Laboratorio</label>

                        <div class="input-group">
                            <select name="" id="laboratorioConf" class="select2_max_ancho">
                                <option value=""></option>
                            </select>

                            <div class="input-group-addon" style="cursor: pointer">
                                <i class="fa fa-plus"></i>
                            </div>
                            <div class="input-group-addon" style="cursor: pointer">
                                <i class="fa fa-minus"></i>
                            </div>
                            <small style="color: red;" id="msg_laboratorio"></small>
                        </div>

                    </div>

                </div>

                <br>

                <div class="row">

                    <div class="col-md-6">
                        <label for="">Valor de la Prestación $</label>
                        <input type="text" class="form-control invalic_prestaciones mask" id="valorPrestacion">
                        <small style="color: red;" id="msg_valor"></small>
                    </div>

                    <div class="col-md-6">
                        <label for="">Descuento de Convenio</label>

                        <div class="input-group">
                            <select name="" id="convenioConf" class="select2_max_ancho">
                                <option value=""></option>
                                <?php

                                $sql = "SELECT * FROM tab_conf_convenio_desc;";
                                $rs = $db->query($sql);
                                if($rs->rowCount() > 0 )
                                {
                                    while ($row =  $rs->fetchObject())
                                    {
                                        echo "<option value='$row->rowid'>$row->nombre_conv</option>";
                                    }
                                }

                                ?>
                            </select>

                            <div class="input-group-addon" style="cursor: pointer" data-toggle="modal" data-target="#modal_conf_convenio">
                                <i class="fa fa-plus"></i>
                            </div>
                            <div class="input-group-addon" style="cursor: pointer">
                                <i class="fa fa-minus"></i>
                            </div>
                        </div>

                    </div>

                </div>

                <br>
                <div class="row">
                    <div class="col-xs-12">
                        <button class="btn btn-success btn-block" id="guardar_prestacion">CARGAR INFORMACIÓN</button>
                    </div>
                </div>

            </div>
            <br>


        </div>
</div>

<!--MODAL CONFIGURACION CONVENIO-->
<div id="modal_conf_convenio" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-diseng">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">AGREGAR CONVENIO</h4>
            </div>
            <div class="modal-body">

                <div style="padding: 10px">

                    <div class="form-group">
                        <div class="alert-info alert">
                            <small>Tener en cuenta que al momento de crear un descuento la pagina web se refrescara automáticamente</small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Nombre</label>
                        <input type="text" id="nomb_conv" class="form-control input-sm">
                    </div>
                    <div class="form-group">
                        <label for="">Descripción</label>
                        <textarea name="" class="form-control input-sm" id="descrip_conv" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">valor</label>
                        <input type="number" id="valor_conv" class="form-control input-sm">
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="guardar_convenio_conf" onclick="nuevoUpdateConvenio()">Aceptar</button>
            </div>
        </div>

    </div>
</div>

<!-- MODAL CONFIGURACION CATEGORIA -->
<div id="modal_conf_categoria" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-diseng">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" >AGREGAR CATEGORIA PRESTACIÓN</h4>
            </div>
            <div class="modal-body">

                <div style="padding: 10px">
                    <div class="form-group">
                        <div class="alert-info alert">
                            <small>Tener en cuenta que al momento de crear una categoría la pagina web se refrescara automáticamente</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Nombre</label>
                        <input type="text" id="nomb_cat" class="form-control input-sm">
                    </div>
                    <div class="form-group">
                        <label for="">Descripción</label>
                        <textarea name="" class="form-control input-sm" id="descrip_cat" rows="3"></textarea>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="guardar_categoria_conf">Aceptar</button>
            </div>
        </div>

    </div>
</div>


<!-- LISTA INFORMATIVA DE LAS PRESTACIONES -->
<div id="modal_list_prestacion" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-diseng">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">LISTA DE PRESTACIONES</h4>
            </div>
            <div class="modal-body">

                <div style="padding: 10px">

                   <div class="form-group">
                       <div class="table-responsive">
                           <table class="table" id="listprestacionestable" width="100%">
                               <thead style="background-color: #E5E8E8">
                                    <tr>
                                        <th>FECHA</th>
                                        <th>PRESTACIÓN</th>
                                        <th>CATEGORIA</th>
                                        <th>CONVENIO</th>
                                        <th>VALOR $</th>
                                        <th></th>
                                    </tr>
                               </thead>
                           </table>
                       </div>
                   </div>

                </div>

            </div>

        </div>

    </div>
</div>

<!--MODAL ELIMINAR-->
<!-- Modal -->
<div class="modal fade" id="ModaleliminarConfCatDesc" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-diseng">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="tomar" data-id="0" data-subaccion="">ELIMNAR</h4>
            </div>
            <div class="modal-body">
                <p>Seguro desea <b>Eliminar este registro seleccionado ?</b> </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" data-dismiss="modal" id="eliminarConfCategoriaDescuento">Aceptar</button>
            </div>
        </div>

    </div>
</div>