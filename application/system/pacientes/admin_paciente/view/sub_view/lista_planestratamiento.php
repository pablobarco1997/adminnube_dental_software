<style>

    #listtratamientotable  tbody tr td > div{
        background-color: #ffffff;
        transition-duration: 0.5s;
    }
     #listtratamientotable  tbody tr td > div:hover{
         box-shadow: 5px 4px 4px 2px #888888;
    }

</style>

<br>
<div class="form-group col-md-6 col-xs-12">
    <div style="background-color: #F8C471; padding: 5px">
        <small title="info ! Los planes de tratamiento solo podran ser eliminados si estos no contienen ninguna prestación asociada">
            <strong>info !</strong> Los planes de tratamiento solo podran ser eliminados si estos no contienen ninguna prestación asociada
        </small>
    </div>
</div>
<div class="form-group col-md-6 col-xs-12">
    <ul class="list-inline pull-right">
        <li> <a href="#citasModal" data-toggle="modal" class="btn btn-sm btnhover" style="font-weight: bold"> <i class="fa fa-clone"></i> Crear Plan de tratamiento desde cita de paciente </a> </li>
        <li> <a href="#" class="btn btn-sm btnhover" style="font-weight: bold">  <i class="fa fa-file-text" ></i> Crear Plan de Tratamiento Independiente </a></li>
    </ul>
</div>

<div class="form-group col-md-12 col-xs-12" style="padding: 0px">
    <div class="table-responsive">
        <table class="table" id="listtratamientotable" width="100%">
            <thead>
                <tr>
                    <th>PLANES DE TRATAMIENTO</th>
                </tr>
            </thead>
        </table>
        <br>
        <br>
    </div>
</div>


<!--MODAL-->
<!-- Modal asociar sitas al plan de tratamieto -->
<div class="modal fade" id="citasModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-diseng">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">SELECCIONAR UNA CITA</h4>
            </div>
            <div class="modal-body">

                <div class="row">

                   <div class="col-sm-12 col-md-12">

                       <label for="" style="display: block">Seleccionar Citas del Paciente</label>
                       <small>Seleccione una cita - Esta cita se asociara con el Plan de Tratamiento </small>
                       <select name="citaTratamiento" id="citaTratamiento" class="select2_max_ancho form-control">
                           <option value=""></option>

                           <?php
                           $sql110 = "select  
                                            d.fk_especialidad , (select s.nombre_especialidad from tab_especialidades_doc s where s.rowid = d.fk_especialidad) as especialidad ,
                                            d.fk_doc , (select concat(o.nombre_doc , ' ', o.apellido_doc) from tab_odontologos o where o.rowid = d.fk_doc ) as odontologo ,
                                            d.rowid as id_cita_det
                                            from tab_pacientes_citas_det d , tab_pacientes_citas_cab c where d.fk_pacient_cita_cab = c.rowid and c.fk_paciente = ". $id;
                           $resul = $db->query($sql110);

                           if($resul->rowCount()>0){

                               while ($obv = $resul->fetchObject()){

                                   $numero = str_pad($obv->id_cita_det, 6, "0", STR_PAD_LEFT);
                                   echo "<option value='$obv->id_cita_det' data-iddoct='$obv->fk_doc'>cita - $numero  &nbsp; Doc(a) $obv->odontologo &nbsp; especialidad: $obv->especialidad</option>";

                               }
                           }
                           ?>

                       </select>

                   </div>

               </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">cancelar</button>
                <button type="button" class="btn btn-success" id="createPlanTratamiento">Aceptar</button>
            </div>
        </div>

    </div>
</div>

<!--modal cambiar nombre plan de tratamiento-->

<div class="modal fade" id="modnombPlantratamiento" role="dialog">
    <div class="modal-dialog modal-sm">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-diseng">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" data-id="0" id="idplanTratamientotitulo">EDITAR NOMBRE PLAN DE TRATAMIENTO</h4>
            </div>
            <div class="modal-body">

                <div class="row">

                    <div class="col-md-12 col-sm-12">
                        <div class="form-group col-xs-12">
                            <label for="">Editar Nombre - Plan de tratamiento</label>
                            <input type="text" class="form-control" id="nametratamiento">
                        </div>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">cancelar</button>
                <button type="button" class="btn btn-success" id="acetareditNomPlanT">Aceptar</button>
            </div>
        </div>

    </div>
</div>