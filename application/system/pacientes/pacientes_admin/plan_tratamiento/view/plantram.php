<?php
    #Opciones de Filtro
    $optionPlamtramFiltro  = "<option></option>";
    $sqlOptionPlantCab = "SELECT 
                            c.rowid , 
                            ifnull(c.edit_name, concat('Plan de Tratamiento ', 'N. ', c.numero)) plantram ,
                            concat('Doc(a) ', ' ', ifnull( (select concat( od.nombre_doc , ' ', od.apellido_doc ) as nomb from tab_odontologos od where od.rowid = c.fk_doc), 'No asignado')) as encargado
                          FROM tab_plan_tratamiento_cab c where c.fk_paciente = $idPaciente";

    $rsOption = $db->query($sqlOptionPlantCab);
    if($rsOption && $rsOption->rowCount()>0){
        while ($obOption = $rsOption->fetchObject()){
            $optionPlamtramFiltro .= "<option value='$obOption->rowid'> $obOption->plantram  &nbsp;&nbsp; $obOption->encargado </option>";
        }
    }
?>


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


    #breadcrumbs  -----------------------------------------------
    $url_breadcrumbs = "";
    $titulo = "";
    $modulo = "";
    if(isset($_GET['v'])){

        if($_GET['v']=='planform'){
            $url_breadcrumbs = $_SERVER['REQUEST_URI'];
            $titulo = "Agregar prestaciones";
            $modulo = false;
        }

    }else{
        $url_breadcrumbs = $_SERVER['REQUEST_URI'];
        $titulo = "Planes de Tratamiento";
        $modulo = true;
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


<!--        breadcrumbs-->
        <div class="form-group col-md-6 col-xs-12 col-lg-6 pull-left">
            <?= Breadcrumbs_Mod($titulo, $url_breadcrumbs, $modulo); ?>
        </div>

<!--        OPCIONES CREACION DE PLANDES DE TRATAMIENTO-->
        <div class="form-group col-md-12 col-xs-12">
            <label for="">LISTA DE COMPORTAMIENTOS</label>
            <ul class="list-inline" style="border-bottom: 0.6px solid #333333; padding: 3px">
                <li><a data-toggle="collapse"  data-target="#contentFilter" class="btnhover btn btn-sm " style="color: #333333" > <b>   ▼  Filtrar  </b>  </a> </li>
                <li>
                    <a href="#" style="color: #333333" class="btnhover btn btn-sm " id="createPlanTratamientoCab"> <b>  <i class="fa fa-file-text"></i> Crear Plan de Tratamiento Independiente </b> </a>
                </li>

                <li>
                    <a href="#modal_plantrem_citas" style="color: #333333" data-toggle="modal" class="btnhover btn btn-sm " onclick="attrChangAsociarCitas(null)"> <b>  <i class="fa fa-clone"></i>  Crear Plan de tratamiento desde cita de paciente  </b> </a>
                </li>

                <li>
                    <div class="checkbox btn btnhover no-margin btn-sm">
                        <label for="mostrarAnuladosPlantram">
                            <b><input type="checkbox" id="mostrarAnuladosPlantram">
                                <i  class="fa fa-trash-o"></i>
                                Mostrar Planes de tratamiento Anulados</b>
                        </label>
                    </div>
                </li>

                <li>
                    <div class="checkbox btn btnhover no-margin btn-sm">
                        <label for="mostaraFinalizados">
                            <b><input type="checkbox" id="mostaraFinalizados">
                                <i  class="fa fa-flag"></i>
                                Mostrar Planes de tratamiento Finalizados</b>
                        </label>
                    </div>
                </li>

            </ul>
            <br>
        </div>

<!--        OTRAS OPCIONES DE FILTRO  -->
        <div class="form-group col-xs-12 col-md-12 col-lg-12 collapse" id="contentFilter">

            <div class="form-group col-xs-12 col-md-4 col-sm-6">
                <label for="">Fecha - range</label>
                <div class="input-group form-group rango" style="margin: 0">
                    <input type="text" class="form-control filtroFecha  " readonly id="startDate" value="">
                    <span class="input-group-addon" style="border-radius: 0"><i class="fa fa-calendar"></i></span>
                </div>
            </div>

            <div class="form-group col-xs-12 col-md-4 col-sm-6">
                <label for="filtrPlantram|">Plan de Tramamiento</label>
                <select id="filtrPlantram" class="form-control select2_max_ancho">
                    <?= $optionPlamtramFiltro ; ?>
                </select>
            </div>

            <div class="form-group col-md-12 col-xs-12">
                <a  class="btn btnhover btn-block" id="filtrar_evoluc" style="font-weight:  bolder; color: green">Buscar</a>
            </div>
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



        <!--    MODAL CREAR PLAN DE TRATAMIENTO ASOCIADO A UNA CITA  -------------------------------------------------------->
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



        <!--MENSAJE DE CONFIRMACION DE ELIMINACION DE PLAN DE TRATAMIENTO-->
        <div id="confirm_eliminar_plantram" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header modal-diseng">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Confirmar</h4>
                    </div>
                    <div class="modal-body">
                        <label for="">Eliminar Plan de tratamiento</label>
                        <p id="msg_eliminar_plantram"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="font-weight: bolder; color: green" class="btn btnhover" id="delete_plantram_confirm" >Confirm</button>
                        <button type="button" style="font-weight: bolder;" class="btn btnhover" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>

        <!--MENSAJE DE CONFIRMACION DE ELIMINACION DE PLAN DE TRATAMIENTO-->
        <div id="confirm_finalizar_plantramiento" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header modal-diseng">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Confirmar</h4>
                    </div>
                    <div class="modal-body">
                        <label for="">Finalizar Plan de tratamiento</label>
                        <br>
                        &nbsp;&nbsp;&nbsp;&nbsp; <label for="">
                            Un plan de tratamiento se finalizar siempre y cuando  contenga todas las prestaciones Pagadas y realizadas &nbsp;<i class="fa fa-dollar"></i>
                            <br> <small style="color: #eb9627"> <i class="fa fa-info-circle"></i> Un vez finalizado el Plan de tratamiento no podra Modificarlo </small>
                        </label>
                        <p id="mg_finalizar_plantramiento"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="font-weight: bolder; color: green" class="btn btnhover" id="finalizar_plantramiento" >Confirm</button>
                        <button type="button" style="font-weight: bolder;" class="btn btnhover" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>

    <?php }?>

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