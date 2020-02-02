

<div class="row">
    <br>
    <div class="form-group col-md-12" style="padding: 0px">

        <div class="col-md-12 col-xs-12">

            <div class="form-group col-md-3 col-xs-12">
                <select name="" id="odont_tratamiento" class="input-sm select2_max_ancho form-control">
                    <option value=""></option>
                </select>
            </div>
            <div class="form-group col-md-3 col-xs-12">
                <select name="" id="odont_odontograma" class="input-sm select2_max_ancho form-control">
                    <option value=""></option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <ul class="list-inline">
                    <li><button class="btn btn-success  " id="buscarOdontograma">Buscar</button></li>
                </ul>
            </div>
            <div class="form-group col-md-3 col-xs-12">
                <ul class="list-inline" style="float: right">
<!--                    <li>a</li>-->
                    <li>
                        <button class="btn btn-success" data-toggle="modal" data-target="#Modalcreateodontograma" onclick="concultarSecuencialOdontograma()"><i class="fa fa-file"></i>&nbsp;&nbsp; crear odontograma </button>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-md-12 col-xs-12">
            <div class="table-responsive" style="padding: 5px">
                <table class="table" width="100%" id="odontogramalist">
                    <thead style="background-color: #f4f4f4">
                        <tr>
                            <th></th>
                            <th width="25%">Fecha</th>
                            <th width="25%">Número</th>
                            <th width="25%">Descripción</th>
                            <th width="25%">Plan de tratamiento</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div>
</div>


<!--MODAL ODONTOGRAMA-->
<div class="modal fade" id="ModalOdontogramaActual" role="dialog">
    <div class="modal-dialog modal-lg" style="width: 90%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-diseng">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="idtratamientolabel" data-idtratamiento="0" >Odontograma Actual <?= date("Y/m/d")?></h4>

            </div>

            <div class="modal-body">
                <div class="row">

                    <div class="form-group col-md-12" style="padding: 0px">
                        <div class="col-md-12 col-xs-12" style="padding-left: 0px; padding-right: 0px">

                            <div class="col-md-12 col-xs-12 margin-bottom">
                                <a href="#informacionEstadoslist" id="informacionEstados" data-toggle="modal" class="btn" style="background-color: #f5b913;color: #ffffff"> <i class="fa fa-list-ol"></i> &nbsp; Información de Estados Actualizados</a>
                            </div>

                            <div class="form-group col-md-12">
                                <?php

                                include_once DOL_DOCUMENT .'/application/system/pacientes/admin_paciente/view/sub_view/dientes_odontograma_permanente.php';

                                ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--MODAL CREAR ODONTOGRAMA-->
<div class="modal fade" id="Modalcreateodontograma" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-diseng">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Crear Odontograma <small style="color:#ffffff"><?= date("Y/m/d")?></small> <b id="suencialOdontograma"></b> </h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-xs-12 col-md-12">
                        <div class="center-block" style="width: 500px">
                            <div class="alert alert-warning">
                                <strong>info !</strong> Debe seleccionar un plan de tratamiento, el cual va a estar vinculado a este Odontograma
                            </div>
                            <div class="row">
                                <div class="col-md-12 margin-bottom">
                                    <label for="">plan de tratamiento</label>
                                    <select name="" class="form-control select2_max_ancho" id="tratamientoSeled">
                                        <option value=""></option>
                                        <?php

                                            $sql1 = "SELECT * from tab_plan_tratamiento_cab where fk_paciente = ".$id;
                                            $rs1 = $db->query($sql1);
                                            if($rs1->rowCount() > 0)
                                            {
                                                while ($ob1 =  $rs1->fetchObject())
                                                {
                                                    echo '<option value="'.$ob1->rowid.'">Plan de Tratamiento # '.$ob1->numero.' Dr(a) '.getnombreDentiste($ob1->fk_doc)->nombre_doc.' '. getnombreDentiste($ob1->fk_doc)->apellido_doc . '</option>';
                                                }
                                            }

                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-12 margin-bottom">
                                    <label for="" >Descripcion</label>
                                    <textarea id="odontograDescrip" class="form-control" rows="3"></textarea>
                                </div>

                                <div class="col-xs-12 col-md-12">
                                    <button class="btn btn-sm btn-success" id="crear_odontograma">Aceptar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--DETALLE DE ESTADOS INFORMACION -->
<div id="informacionEstadoslist" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-diseng">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Información de Estados</h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="form-group col-md-12" style="margin-bottom: 0px">
                        <div class="form-group col-md-12" style="margin-bottom: 0px">
                            <div class="table-responsive">
                                <table class="table" width="100%" id="detalles_estados_odontograma">
                                    <thead>
                                        <tr style="width: 100%">
                                            <th width="20%">FECHA</th>
                                            <th width="20%">PIEZA</th>
                                            <th width="20%">CARAS</th>
                                            <th width="20%">ESTADOS</th>
                                            <th width="20%">ANULAR</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!--            <div class="modal-footer">-->
            <!--                <button type="button" class="btn btn-default" >Cerrar</button>-->
            <!--                <button type="button" class="btn btn-success AceptarUpdateOdontogram" id="AceptarUpdateOdontogram" >Guardar</button>-->
            <!--            </div>-->
        </div>

    </div>
</div>

<!--MODAL DEL ODONTOGRAMA AL MOMENTO DE GUARDAR O ACTUALIZAR LA INFORMACION -->
<div id="UpdateInformacionCommentOdontograma" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Información Adicional</h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="form-group col-md-12">
                        <div class="center-block" style="width: 500px">
                            <label for="">Observación  <small>(opcional)</small></label>
                            <textarea class="form-control" id="observacionOpcional"></textarea>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success AceptarUpdateOdontogram" id="AceptarUpdateOdontogram" >Guardar</button>
            </div>
        </div>

    </div>
</div>