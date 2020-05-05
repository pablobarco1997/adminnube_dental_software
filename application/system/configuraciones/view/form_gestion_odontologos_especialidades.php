<?php

$accionDoctorEspicialidad = "";
if(isset($_GET['v']))
{
    $accionDoctorEspicialidad = $_GET['v'];
}


$option1 = "<option></option>";
$sql = "SELECT * FROM tab_odontologos WHERE estado = 'A'";
$rs = $db->query($sql);
if($rs->rowCount()>0)
{
    while ($ob = $rs->fetchObject()){
        $option1 .= "<option value='$ob->rowid'> ".$ob->nombre_doc."  ".$ob->apellido_doc." </option>";
    }
}

?>

<script>
    //accion si es especialidad o Doctor     MODULO
    $accion = "<?= $accionDoctorEspicialidad ?>";
</script>

<div class="box box-solid">

    <div class="box-header with-border">
        <h3>  Gestión Odontólogos y Especialidades</h3>
    </div>

    <div class="box-body">

        <br>

        <div class="col-centered col-xs-12 col-md-9 col-lg-9">

            <div class="form-group col-md-12 " style="padding: 0px">
                <ul class="list-inline">
                    <li><a class="btn " href="<?= DOL_HTTP .'/application/system/configuraciones/index.php?view=form_gestion_odontologos_especialidades&v=dentist'; ?>" style="border-left: 2px solid #212f3d; color: #333333"> <i class="fa fa-user-md"></i> &nbsp; Odontólogos</a> </li>
                    <li>&nbsp;&nbsp;</li>
                    <li><a class="btn " href="<?= DOL_HTTP .'/application/system/configuraciones/index.php?view=form_gestion_odontologos_especialidades&v=specialties'; ?>" style="border-left: 2px solid #212f3d; color: #333333" > <i class="fa fa-align-center"></i> &nbsp; Especialidades</a></li>
                </ul>
            </div>

            <?php

            #DENTISTA   ---------------------------------------------------------------------------------------------------------------------------------------------------------------
            if(isset($_GET["v"]) && $_GET["v"] == "dentist")
            {

            ?>

            <div class="row">
                <div class="form-group col-md-12">
                    <ul class="list-inline" style="border-bottom: 1px solid #333333; padding-bottom: 1.5px">
                        <li><a  style="cursor: pointer; font-weight: bolder; color: #333333" class="btn btnhover  "  data-toggle="modal" data-target="#modal_conf_doctor"  onclick="cambiarattr()"> &nbsp;&nbsp;<i class="fa fa-user-md"></i> &nbsp;&nbsp; crear odontólogos</a></li>
                        <li><a style="cursor: pointer; font-weight: bolder; color: #333333" class="btn btnhover  " data-toggle="modal" data-target="#ModalCrearUsuario"  onclick="NuevoEditUsario(0,0,'0')" > &nbsp;&nbsp;<i class="fa fa-user"></i> &nbsp;&nbsp; Crear Usuario</a></li>
                        <li> <div class="checkbox btnhover" style="margin: 0px; padding: 5px; "><label for="desabilitado_doctores" style=" font-weight: bolder"><input type="checkbox" id="desabilitado_doctores"><i class="fa fa-user-times"></i> Ver lista de doctores desabilitados</label></div></li>
                    </ul>
                </div>

                <br>
                <br>

                <div class="col-md-12">
                    <div class="table-responsive">
                        <table width="100%" class="table table-striped" id="gention_odontologos_list">
                            <thead>
<!--                                <th width="5%"></th>-->
                                <th width="18%">NOMBRE APELLIDO</th>
                                <th width="15%">CELULAR</th>
                                <th width="15%">DIRECCIÓN</th>
                                <th width="18%">E-MAIL</th>
                                <th width="15%">ESPACIALIDAD</th>
                                <th width="5%"></th>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>

            <?php } ?>

            <?php

                #ESPECIALIDAD   <------------------------------------------------------------------------------------------------------------------------------------------------------------->
                if(isset($_GET["v"]) && $_GET["v"] == "specialties")
                {

            ?>

                <div class="form-group">
                    <ul class="list-inline" style="border-bottom: 1px solid #333333; padding-bottom: 2px">
                        <li><a class="btnhover btn"  data-toggle="modal" data-target="#ModalConfEspecialidades" style="font-weight: bolder; color: #333333"> <i class="fa fa-list"></i> &nbsp; crear especialidad </a> </li>
                    </ul>
                </div>

                <div class="form-group col-md-12">
                   <div class="form-group col-md-12 ">
                        <span style=" color: #eb9627">
                        <i class="fa fa-info-circle"></i>
                            Tener en cuenta que si elimina una especialidad, aquellos Odontólogos
                            relacionados con esta, se actualizaran a especialidad General incluyendo todas las citas asociadas con la especialidad
                            eliminada
                        </span>
                   </div>
                </div>

                <div class="form-group col-md-12">
                    <div class="table-responsive">
                        <table width="100%" class="table table-striped" id="gention_especialidades">
                            <thead>
                                <th width="30%">FECHA CREACION</th>
                                <th width="30%">ESPECIALIDAD</th>
                                <th width="30%">DESCRIPCIÓN</th>
                                <th ></th>
                            </thead>
                        </table>
                    </div>
                </div>

            <?php } ?>

        </div>

    </div>
</div>



<!--MODAL CREAR ODONTOLOGO ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
<div id="modal_conf_doctor" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-diseng">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> <span data-id="0" id="accion">NUEVO</span> ODONTÓLOGO </h4>
            </div>
            <div class="modal-body">

                <div class="margin">

                    <div class="tab-content">
                        <div class="row">
                            <div class="form-group col-md-12 no-margin">

                                <div class="form-group col-md-6">
                                    <p class="text-center" style="margin: 0px;">
                                        <label for="icon_doct">
                                            <img id="icon_usuario_doct" src="<?= DOL_HTTP .'/logos_icon/logo_default/doct-icon.png' ;?>" class="img-circle" width="100px" height="100px" alt="">
                                            <input type="file" id="icon_doct" style="display: none">
                                        </label>
                                        <span style="display: block"> </span>
                                    </p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">Nombre</label>
                                    <input type="text" id="nombre_doct" class="form-control input-sm">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">Apellido</label>
                                    <input type="text" name="" class="form-control input-sm" id="apellido_doct" >
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">celular</label>
                                    <input type="text" name="" class="form-control input-sm" id="celular_doct" >
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">Telefono</label>
                                    <input type="text" name="" class="form-control input-sm" id="TelefonoConvencional_doct" >
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">E-mail</label>
                                    <input type="text" name="" class="form-control input-sm" id="email_doct" >
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">Dirección</label>
                                    <input type="text" name="" class="form-control input-sm" id="direccion_doct" >
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">Ciudad</label>
                                    <input type="text" name="" class="form-control input-sm" id="ciudad_doct" >
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">Epecialidad</label>
                                    <select name="" id="especialidad_doct" class="form-control select2_max_ancho input-sm">
                                        <option value="0">General</option>
                                        <?php
                                        $sql35 = "select es.rowid,  es.tms as fecha ,es.nombre_especialidad , es.descripcion from tab_especialidades_doc es;";
                                        $rs35 = $db->query($sql35);
                                        if($rs35->rowCount()>0)
                                        {
                                            while ($rows35 = $rs35->fetchObject())
                                            {
                                                echo "<option value='$rows35->rowid'>$rows35->nombre_especialidad</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-12 no-margin">
                                    <div class="form-group no-margin pull-right">
                                        <a class="btn btnhover " style="font-weight: bolder" data-dismiss="modal" > Cerrar </a>
                                        <a class="btn btnhover " style="font-weight: bolder; color: green" id="guardar_informacion_odontologos" > Aceptar </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--CREAR USUARIO CON SUS PERMISOS ================================================================================= -->
<div id="ModalCrearUsuario" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-diseng">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" data-id="0" id="accionUsuario" >CREAR USUARIO</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="center-block" style="width: 70%">

                        <div class="form-group col-xs-12 col-md-12">
                            <label for="">Doctor</label>
                            <select name="" id="usu_doctor" class="form-control select2_max_ancho" onchange="UsuarioOdctor($(this)); invalicUsuario();">
                                <?= $option1 ?>
                            </select>
                            <small style="color: #9f191f" id="msg_doctorUsuario"></small>
                        </div>

                        <div class="form-group col-xs-12 col-md-12">
                            <label for="">Usuario</label>
                            <input type="text" class="form-control input-sm" id="usu_usuario" onkeyup="comprobar_usuario_en_uso(); invalicUsuario();">
                            <small style="color: #9f191f" id="msg_usuario_repit"></small>
                        </div>

                        <div class="form-group col-xs-12 col-md-12">
                            <label for="">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control input-sm" id="usu_password" onkeyup="keyConfirmarPassword(); invalicUsuario();">
                                <div class="input-group-addon btn" onclick="passwordMostrarOcultar('mostrar'); invalicUsuario();"><i class="fa fa-eye"></i></div>
                                <div class="input-group-addon btn" onclick="passwordMostrarOcultar('ocultar'); invalicUsuario();"><i class="fa fa-eye-slash"></i></div>
                            </div>
                            <small style="color: #9f191f" id="msg_password_d"></small>
                        </div>

                        <div class="form-group col-xs-12 col-md-12">
                            <label for="">Confirmar Password</label>
                            <input type="password" class="form-control input-sm" id="usu_confir_password" onkeyup="keyConfirmarPassword(); invalicUsuario();">
                            <small style="color: #9f191f" id="msg_password"></small>
                        </div>

                        <div class="form-group col-xs-12 col-md-12">
                            <hr>
                            <label class="bold">ASIGNAR PERMISOS</label>
                            <div class="table-responsive">
                                <table class="table" width="100%">
                                    <thead style="background-color: #e9edf2">
                                        <tr>
                                            <th width="15%" style="font-size: 1.3rem">TIPO USUARIO</th>
                                            <th width="15%" style="font-size: 1.3rem">CONSULTAR</th>
                                            <th width="15%" style="font-size: 1.3rem">AGREGAR</th>
                                            <th width="15%" style="font-size: 1.3rem">MODIFICAR</th>
                                            <th width="15%" style="font-size: 1.3rem">ELIMINAR</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width="100%">
                                                <select  id="tipoUsuario" class="form-control input-sm select2_max_ancho" onchange="invalicUsuario();">
                                                    <option value=""></option>
                                                    <option value="1">Administrador</option>
                                                    <option value="2">Usuario Normal</option>
                                                </select>
                                                <small style="color: #9f191f" id="msg_permisos"></small>
                                            </td>
                                            <td  width="100%" class="text-center" style="font-size: 4rem"> <input type="checkbox" id="chek_consultar" disabled class="disabled_link3"> </td>
                                            <td  width="100%" class="text-center" style="font-size: 4rem"> <input type="checkbox" id="chek_agregar" disabled class="disabled_link3">   </td>
                                            <td  width="100%" class="text-center" style="font-size: 4rem"> <input type="checkbox" id="chek_modificar" disabled class="disabled_link3"> </td>
                                            <td  width="100%" class="text-center" style="font-size: 4rem"> <input type="checkbox" id="chek_eliminar" disabled class="disabled_link3">  </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btnhover " style="font-weight: bolder;" data-dismiss="modal" id=""> Close </a>
                <a class="btn btnhover " style="font-weight: bolder; color: green" id="nuevoUpdateUsuario"> Aceptar </a>
            </div>
        </div>
    </div>
</div>


<!--MODAL ESPECIALIDADES ---------------------------------------------------------------------------------------------->
<div id="ModalConfEspecialidades" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-diseng">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">  <span data-id="0" id="accion_especialidad">NUEVO</span> ESPECIALIDAD</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="">Especialidad</label>
                        <input type="text" id="especialidad_nombre" class="form-control">
                        <small style="color: #9f191f" id="msg_especialidad"></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Descripción</label>
                        <textarea id="especialidad_descripcion" class="form-control" cols="30" rows="5"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="guardar_conf_especialidad">Aceptar</button>
            </div>
        </div>

    </div>
</div>


<!--JAVASCRIPT DE ESPECIALIDADES-->
<?php if(isset($_GET['view']) && GETPOST("v") == 'specialties'){?>
    <script src="<?= DOL_HTTP .'/application/system/configuraciones/js/odontespecialidades.js'; ?>"></script>
<?php }?>

<!--JAVASCRIPT DE ODONTOLOGOS-->
<?php if(isset($_GET['view']) && GETPOST("v") == 'dentist'){?>
    <script src="<?= DOL_HTTP .'/application/system/configuraciones/js/NewEditoOdontUsuario.js'; ?>"></script>
<?php }?>
