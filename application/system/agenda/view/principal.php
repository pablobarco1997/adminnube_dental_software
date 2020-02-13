<style>
    .callbox{
        border-left: 2px solid #212f3d;
    }
</style>



<div class="row" >
    <div class="form-group col-lg-12 col-xs-12 col-md-12">
       <div class="col-md-6 col-xs-12 pull-left"></div>
       <div class="col-md-6 col-xs-12 pull-right">
           <h3 class="pull-right"><?= ($_GET['list'] == 'diaria') ? 'AGENDA DIARIA' : '' ?></h3>
       </div>
    </div>
    <div class="form-group col-lg-12 col-md-12">
        <div class="col-md-4 col-lg-4 col-xs-12">
            <div class="info-box">
                <div class="info-box-icon bg-aqua" style="background-color: #212f3d!important;">
                    <i class="fa fa-calendar" style="margin-top: 20px"></i>
                </div>
                <div class="info-box-content">
                    <span class="info-box-text">NÚMERO DE CITAS PARA HOY </span>
                    <span class="info-box-number" style="font-size: 2em" id="numCitas">0</span>
                    <span><?= date("Y/m/d")?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" >

    <div class="form-group col-md-12 col-lg-12">
        <div class="col-md-6 col-sm-6  <?= $permisos->consultar  ?>">
            <ul class="list-inline">
                <li>
                    <div class="callbox">
                        <div class="form-group">
                            <div class="checkbox <?= $permisos->consultar  ?>">
                                <a style="color: #333333" href="<?= DOL_HTTP .'/application/system/agenda/index.php?view=principal&list=diaria' ?>" class="btn btnhover <?= $permisos->consultar  ?>">
                                    DIARIA
                                </a>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="callbox">
                        <div class="form-group">
                            <div class="checkbox  <?= $permisos->consultar  ?>">
                                <a style="color: #333333" href="<?php echo DOL_HTTP.'/application/system/agenda/index.php?view=principal&list=diariaglob'?>" class="btn btnhover <?= $permisos->consultar  ?>">
                                    DIARIA GLOBAL
                                </a>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="callbox">
                        <div class="form-group">
                            <div class="checkbox <?= $permisos->consultar  ?>">
                                <a href="<?= DOL_HTTP .'/application/system/agenda/index.php?view=agendadd'?>"  style="color: #333333" class="btn btnhover addCitas  <?= $permisos->agregar  ?>">AGENDAR UNA CITA &nbsp;&nbsp;<i class="fa fa-calendar"></i></a>
                            </div>
                        </div>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</div>


<div class="row">
    <div class="form-group col-lg-12 col-md-12">

        <div class="form-group col-md-4 col-xs-12">
            <label for="">Fecha</label>
            <div class="input-group form-group rango" style="margin: 0">
                <input type="text" class="form-control filtroFecha <?= $permisos->consultar  ?> " id="startDate" value="">
                <span class="input-group-addon" style="border-radius: 0"><i class="fa fa-calendar"></i></span>
            </div>
        </div>


        <div class="form-group  col-md-4 col-xs-12">
            <label for="">Doctor</label>
            <select name="" id="filtro_doctor" class="filtrar_doctor select2_max_ancho <?= $permisos->consultar  ?>" >
                <option value=""></option>
                <?php
                $sql = "SELECT * FROM tab_odontologos;";
                $rs = $db->query($sql);
                if($rs->rowCount() > 0)
                {
                    while ($obj = $rs->fetchObject())
                    {
                        echo "<option value='$obj->rowid'>$obj->nombre_doc  $obj->apellido_doc</option>";
                    }
                }
                ?>
            </select>
        </div>


        <div class="form-group col-md-4 col-xs-12">
            <label for="">Estados</label>
            <select name="" id="filtroEstados" class="select2_max_ancho filtrar_estados <?= $permisos->consultar  ?>" multiple>
                <?php
                $sql = "SELECT * FROM tab_pacientes_estado_citas;";
                $rs = $db->query($sql);
                if($rs->rowCount() > 0)
                {
                    while ($obj = $rs->fetchObject())
                    {
                        echo "<option value='$obj->rowid' >$obj->text</option>";
                    }
                }
                ?>
            </select>
        </div>

        <div class="form-group col-md-4 pull-right">
            <ul class="list-inline pull-right">
                <li>  <button class="aplicar btn btnhover <?= $permisos->consultar  ?>" style="float: right; padding: 3px" > &nbsp; <i class="fa fa-search" ></i> &nbsp;buscar &nbsp;</button> </li>
                <li>  <button class="limpiar btn btnhover <?= $permisos->consultar  ?>" style="float: right; padding: 3px" > &nbsp; &nbsp; Limpiar &nbsp; &nbsp;</button> </li>
            </ul>
        </div>

    </div>
</div>

<?php $ContInvalic = 0; ?>

<div class="form-group col-md-12 col-xs-12">
    <!--                Lista diaria-->
    <div class="list-diaria">

        <?php

        if(isset($_GET['list']) && $_GET['list'] == 'diaria')
        {
            include_once DOL_DOCUMENT .'/application/system/agenda/view/list_diaria.php';
            $ContInvalic++;
        }

        ?>
    </div>
    <!--                Lista global-->
    <div class="list-diariaGlobal">
        <?php

        if(isset($_GET['list']) && $_GET['list'] == 'diariaglob')
        {
            include_once DOL_DOCUMENT .'/application/system/agenda/view/list_globaldiaria.php';
            $ContInvalic++;
        }

        ?>
    </div>

    <?php
    #Error no se encontro la vista - esto es cuando modifican la url
    if($ContInvalic==0){

        echo '<div class="alert alert-red">
                                       <h2 class="text-bold text-center" style="color: red;">Ocurrió un error no se encuentra la vista - consulte con soporte tecnico</h2>
                                   </div>';
        die();
    }

    ?>

</div>

<!--MODALES-->

<div id="modalWhapsapp" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Confirmar por whatsapp</h4>
                <span>Telefono Movil: &nbsp;</span> <span id="number_whasap"></span>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <div class="center-block" style="width: 100px">
                            <img src="https://img.icons8.com/plasticine/2x/whatsapp.png" alt="" style="width: 100%">
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="">Mensaje</label>
                        <textarea name="" id="mensajetext" class="form-control" cols="20" rows="5"></textarea>
                    </div>
                    <div class="form-group col-md-12">
                        <a href="https://wa.me/593987722863?text=hola mundo" target="_blank" id="sendwhap" class="btn btn-block btn-xs" style=" color: black;background-color: #60be92"><i class="fa fa-whatsapp"></i> ENVIAR MENSAJE</a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<!--modal email-->
<?php
    include_once DOL_DOCUMENT .'/application/system/agenda/view/status_modal.php';
?>