

<?php

    #SELECT DE PRESTACIONES  -------------------------------------------------------------------------------------------

    $prestacion    = "<option></option>";
    $sqlprestacion = " SELECT * FROM tab_conf_prestaciones ";
    $rsprestacion  =  $db->query($sqlprestacion);
    if($rsprestacion->rowCount() > 0)
    {
        while ($pr = $rsprestacion->fetchObject())
        {
            $prestacion .= "<option value='".$pr->rowid."'>".$pr->descripcion."</option>";
        }
    }


?>

<style>


</style>
<!-- Modal Add Plan tratamiento-->
<div id="detdienteplantram" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style="width: 80% ">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-diseng">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">AGREGAR PRESTACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-xs-12 col-md-12" style="margin: 0px">
                        <ul class="list-inline" >
                            <li >
                                <div class="checkbox btn btn-block btn-sm" style="border-left: 1.5px solid #202a33">
                                    <label>
                                        <input type="checkbox" id="detencionPermanente">
                                        <img  src=" <?= DOL_HTTP .'/logos_icon/logo_default/diente.png';?>" width="12px" height="14px" alt=""> &nbsp;
                                        &nbsp;DENTICIÓN PERMANENTE
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="checkbox btn btn-block btn-sm" style="border-left: 1.5px solid #202a33">
                                    <label>
                                        <input type="checkbox" id="detencionTemporal">
                                        <img  src=" <?= DOL_HTTP .'/logos_icon/logo_default/diente.png';?>" width="12px" height="14px" alt=""> &nbsp; &nbsp;
                                        DENTICIÓN TEMPORAL
                                    </label>
                                </div>
                            </li>
                            <!--                            id del detalle de plan de tratamiento-->
                            <li>
                                <p id="detallemod" data-iddet="0"></p>
                            </li>
                        </ul>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div class="table-responsive">
                            <?php
                                    #caras pieza animaciones
                                    include_once DOL_DOCUMENT.'/application/system/pacientes/pacientes_admin/plan_tratamiento/view/plan_odontograma.php';
                            ?>
                        </div>
                    </div>
                </div>

<!--                PRESTACIOANES CATEGORIZADA  -->
                <hr>
                <div class="row">
                    <div class="col-md-4 col-xs-12">
                        <div class="box_prestaciones">
                            <label for="prestacion_planform">Todas las prestaciones</label>
                            <select id="prestacion_planform" class="form-control select2_max_ancho">
                                <?= $prestacion;  ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12">
                        <label style="display: block">&nbsp;</label>
                        <a href="#" class="btnhover btn" id="addprestacionPlantram"> <small> <i class="fa fa-plus"></i> &nbsp; AGREGAR PRESTACIÓN</small> </a>
                    </div>
                    <div class="col-md-5 col-xs-12">
                        <label style="display: block">&nbsp;</label>
                        <small style="color: red" id="errores_msg_addplantram"></small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-xs-12">

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="5%"></th>
                                        <th title="DESCRIPCION DE LA PRESTACIÓN">PRESTACIÓN</th>
                                        <th title="SUB-TOTAL">SUBTOTAL</th>
                                        <th title="DESCUENTO DE CONVENIO">DESC. CONVENIO</th>
                                        <th title="CANTIDAD DE LA PRESTACIÓN">CANTIDA</th>
                                        <th title="DESCUENTO DE ADICIONAL">DESC. ADICIONAL</th>
                                        <th title="TOTAL">TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody id="detalle-prestacionesPlantram">
                                    <tr rowspan="5">
                                        <td class="text-center" colspan="6">NO HAY DETALLE</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btnhover" style="font-weight: bolder; color: green" id="guardarPrestacionPLantram">Guardar</a>
                <a href="#" class="btn btnhover" data-dismiss="modal" style="font-weight: bolder">Close</a>
<!--                <button type="button" class="btn btn" data-dismiss="modal">Close</button>-->
            </div>
        </div>

    </div>
</div>