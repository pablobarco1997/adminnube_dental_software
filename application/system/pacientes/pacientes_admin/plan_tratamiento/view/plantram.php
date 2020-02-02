
<?php

    #ID PLAN DE TRATAMIENTO DECLARADO
    $idplantram = 0;
    if(isset($_GET['idplan']) && $_GET['idplan'] != 0 )
    {

        $idplantram = decomposeSecurityTokenId($_GET['idplan']);

    }

    $accion = "principal";
    if(isset($_GET['v']) && $_GET['v'] == 'planform')
    {
        $accion = 'addplan'; #cuando se add plan de tratamiento

    }


?>

<style>


    #listtratamientotable  tbody tr td > div{
        background-color: #ffffff;
        transition-duration: 0.2s;
    }
    #listtratamientotable  tbody tr td > div:hover{
        box-shadow:0 2px 5px 0 rgba(0, 0, 0, 0.225);
        border:0;
    }

</style>


<script>


    //ID DEL PLAN DE TRATAMIENTO
    $ID_PLAN_TRATAMIENTO =  <?= $idplantram ?>;
    $accion              = "<?= $accion ?>";


</script>

<div class="form-group col-md-12 col-xs-12">



    <?php

    if(isset($_GET['v']) && $_GET['v'] == 'planform')
    {
        ?>

        <?php

            include_once DOL_DOCUMENT.'/application/system/pacientes/pacientes_admin/plan_tratamiento/view/add_plan_tratam.php';

        ?>


    <?php

    }else{

        ?>


<!--        OPCIONES CREACION DE PLANDES DE TRATAMIENTO-->
        <div class="form-group col-md-12 col-xs-12">
            <ul class="list-inline">
                <li>
                    <a href="#" class="btnhover btn btn-sm " id="createPlanTratamientoCab"> <b>  <i class="fa fa-file-text"></i> Crear Plan de Tratamiento Independiente </b> </a>
                </li>

                <li>
                    <a href="#modal_plantrem_citas" data-toggle="modal" class="btnhover btn btn-sm " onclick="attrChangAsociarCitas(null)"> <b>  <i class="fa fa-clone"></i>  Crear Plan de tratamiento desde cita de paciente  </b> </a>
                </li>

            </ul>
        </div>
<!--       END OPCIONES CREACION DE PLANDES DE TRATAMIENTO-->


        <div class="form-group col-xs-12 col-md-12">
            <div class="table-responsive">
                <table class="table" id="listtratamientotable">
                    <thead>
                        <tr>
                            <th>PLANES DE TRATAMIENTO</th>
                        </tr>
                    </thead>
                </table>
                <br>
            </div>
        </div>



        <!--    MODAL CREAR PLAN DE TRATAMIENTO INDEPENDIENTE  -------------------------------------------------------->
        <div id="modal_plantrem_citas" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header modal-diseng">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Plan de tratamiento desde cita de paciente  </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-xs-12">
                                <div class="form-group col-xs-6 col-md-6 col-sm-6 no-margin">
                                    <p class="text-left">SELECCIONE UNA CITA</p>
                                </div>
                                <div class="form-group col-xs-6 col-md-6 col-sm-6 no-margin">
                                    <p class="text-right" id="nuPlanTratamiento" data-id="0"></p>
                                </div>
                                <div class="form-group col-xs-12">
                                    <small>Seleccione una cita - Esta cita se asociara con el Plan de Tratamiento</small>
                                </div>
                                <br>
                                    <select name="" id="citasPaciente" class="form-control select2_max_ancho">
                                        <option value=""></option>
                                        <?php

                                            $sqlListCitas = "SELECT 
                                                                d.fk_especialidad,
                                                                
                                                                IFNULL((SELECT 
                                                                        s.nombre_especialidad
                                                                    FROM
                                                                        tab_especialidades_doc s
                                                                    WHERE
                                                                        s.rowid = d.fk_especialidad), 'General') AS especialidad,
                                                                d.fk_doc,
                                                                
                                                                (SELECT 
                                                                        CONCAT(o.nombre_doc, ' ', o.apellido_doc)
                                                                    FROM
                                                                        tab_odontologos o
                                                                    WHERE
                                                                        o.rowid = d.fk_doc) AS odontologo,
                                                                        
                                                                d.rowid AS id_cita_det
                                                            FROM
                                                                tab_pacientes_citas_det d,
                                                                tab_pacientes_citas_cab c
                                                            WHERE
                                                                d.fk_pacient_cita_cab = c.rowid
                                                                    AND c.fk_paciente = $idPaciente";

                                                $resul = $db->query($sqlListCitas);

                                                if($resul->rowCount()>0){

                                                    while ($obv = $resul->fetchObject()){

                                                        $numero = str_pad($obv->id_cita_det, 6, "0", STR_PAD_LEFT);
                                                        echo "<option value='$obv->id_cita_det' data-idcita='$obv->id_cita_det' data-iddoct='$obv->fk_doc'> CITA - $numero  &nbsp; Doc(a) $obv->odontologo &nbsp; ESPACIALIDAD: $obv->especialidad</option>";

                                                    }
                                                }

                                        ?>

                                    </select>

                                <br>
                                <br>

                                <small id="error_asociarCitas" style="color: red;"></small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btnhover" style="font-weight: bolder; color: green" id="CrearPlanTratamientoPlantram">Guardar</a>
                        <a href="#" class="btn btnhover" data-dismiss="modal" style="font-weight: bolder">Close</a>
                    </div>
                </div>

            </div>
        </div>

    <?php }?>

</div>
