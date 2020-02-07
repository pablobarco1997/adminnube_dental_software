<div id="add_odontograma" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-diseng">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">CREAR ODONTOGRAMA - <?= date('Y-m-d')?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-lg-12 col-md-12">
                        <small style="color: #e79627; font-weight: bolder"> <i class="fa fa-info-circle"></i> Debe seleccionar un plan de tratamiento, el cual va a estar vinculado a este Odontograma</small>
                    </div>
                    <div class="form-group col-md-12 col-lg-12">
                        <select name="" class="form-control select2_max_ancho" id="tratamientoSeled">
                            <option value=""></option>
                            <?php

                            $sql1 = "SELECT * , ifnull(edit_name, concat('Plan de tratamiento # ', numero)) as editnum from tab_plan_tratamiento_cab where fk_paciente = ".$idPaciente ." and estados_tratamiento = 'A' ";
                            $rs1 = $db->query($sql1);
                            if($rs1->rowCount() > 0)
                            {
                                while ($ob1 =  $rs1->fetchObject())
                                {
                                    $nomdoct =  getnombreDentiste($ob1->fk_doc)->nombre_doc.' '. getnombreDentiste($ob1->fk_doc)->apellido_doc;

                                    $doctor_asignado = "Dr(a) no asignado";

                                    if(trim($nomdoct) != '')
                                    {
                                        $doctor_asignado = "Dr(a) ".$nomdoct;
                                    }

                                    echo '<option value="'.$ob1->rowid.'">'.$ob1->editnum.' - '. $doctor_asignado .'  </option>';
                                }
                            }

                            ?>
                        </select>
                        <small style="color: red"></small>
                    </div>
                    <div class="form-group col-lg-12 col-md-12">
                        <label for="">Descripción (opcional)</label>
                        <textarea class="form-control" id="odontograDescrip"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btnhover" style="font-weight: bolder; color: green" id="crear_odontograma">Guardar</a>
                <a href="#" class="btn btnhover" data-dismiss="modal" style="font-weight: bolder">Close</a>
            </div>
        </div>

    </div>
</div>