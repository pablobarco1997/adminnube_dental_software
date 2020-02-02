<style>

</style>

<script>
    // SE DECLARA VARIABLES GLOBALES PARA ESTE SUB MODULO
    $tratamientoOperacion = '';
    $idCitaGlob = '';
    $idplantratamiento = '';

</script>

<div class="row">

        <div class="form-group col-md-12">

            <div class="panel-group" id="accordion">

               <div class="form-group col-md-12 col-xs-12">

                   <?php

                       if(!isset($_GET['ope'])){
                           include_once DOL_DOCUMENT .'/application/system/pacientes/admin_paciente/view/sub_view/lista_planestratamiento.php';
                       }

                   ?>

                    <?php

                           #nuevo tratamiento
                           if(isset($_GET['ope']) && $_GET['ope'] == 'new'){
                                    include_once DOL_DOCUMENT .'/application/system/pacientes/admin_paciente/view/sub_view/new_plan_tratamiento.php';

                           }

                           #modificar tratamiento
                           if(isset($_GET['ope']) && $_GET['ope'] == 'mod'){
                               include_once DOL_DOCUMENT .'/application/system/pacientes/admin_paciente/view/sub_view/new_plan_tratamiento.php';
                           }

                    ?>

                </div>

            </div>

        </div>

</div>


<!--MODAL DE PLAN DE TRATAMIENTO-->

<div class="modal fade" id="ModalTratamiento_1" role="dialog">
    <div class="modal-dialog" style="width: 90%">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-diseng">

                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <div class="modal-title"> <h4 style="margin: 0px ">Odóntograma</h4> </div>

            </div>

            <div class="modal-body">

<!--                ODONTOGRAMA-->
                <div class="row">
                </div>

                <div class="row">

                    <div class="form-group col-xs-12 col-md-12">
                        <ul class="list-inline" >
                            <li >
                                <div class="checkbox btn btn-block btn-sm" style="border-left: 1.5px solid #202a33">
                                    <label>
                                        <input type="checkbox" id="detencionPermanente">
                                        <img  src=" <?= DOL_HTTP .'/logos_icon/logo_default/diente.png';?>" width="12px" height="14px" alt=""> &nbsp;
                                        &nbsp;Dentinción permanente
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="checkbox btn btn-block btn-sm" style="border-left: 1.5px solid #202a33">
                                    <label>
                                        <input type="checkbox" id="detencionTemporal">
                                        <img  src=" <?= DOL_HTTP .'/logos_icon/logo_default/diente.png';?>" width="12px" height="14px" alt=""> &nbsp; &nbsp;
                                        Dentinción Temporal
                                    </label>
                                </div>
                            </li>
<!--                            id del detalle de plan de tratamiento-->
                            <li>
                                <p id="detallemod" data-iddet="0"></p>
                            </li>
                        </ul>
                    </div>

                    <div class="form-group col-md-12" id="conten-odontograma">
                        <div class="table-responsive">

<!--                                PLAN DE TRATAMIENTO SELECCION DE PIESAS DETENCION PERMANENTE -->
                            <?php

                                include_once DOL_DOCUMENT .'/application/system/pacientes/admin_paciente/view/sub_view/plantratamiento_odontograma_detalle.php' ;

                            ?>

                        </div>
                    </div>

                </div>

                <br>
<!--                PRESTACIONES-->
                <div class="row">

                    <div class="col-md-7 col-xs-12">
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <label for="">Prestaciones</label>
                            <select name="" id="prestacionestratamiento" class="select2_max_ancho">
                                <option value=""></option>
                                <?php

                                    $sql = "SELECT * FROM tab_conf_prestaciones";
                                    $rs = $db->query($sql);
                                    if($rs->rowCount()>0){

                                        while ($ob = $rs->fetchObject()){

                                            echo '<option value="'.$ob->rowid.'">'.$ob->descripcion.'</option>';

                                        }

                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <label for="">&nbsp;</label>
                            <button class="btn btn-success btn-block" id="addplantratamientodetalle">AGREGAR</button>
                        </div>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="table-responsive" style="padding: 3px">
                        <table class="table detallprestaciones" id="table-prestaciones_1" width="100%">
                            <thead>
                                <tr>
                                    <th width="30%">Prestacción</th>
                                    <th width="10%">Subtotal</th>
                                    <th width="10%">Descto. Convenio</th>
                                    <th width="10%">Descto. Adicional</th>
                                    <th width="10%">Total</th>
                                </tr>
                            </thead>
                            <tbody id="listdetallenuew">

                            </tbody>
                        </table>
                    </div>
                </div>


            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success"  id="guardar_detalle_plantratamiento">Guardar Información</button>
            </div>
        </div>

    </div>
</div>