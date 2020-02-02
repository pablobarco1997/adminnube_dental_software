

<style>
    .listItem li{
        margin-bottom: 5px;
    }

    .lista{
        display: block;
        padding: 3px;
        color: black;
    }
    .listItem li:hover{
        background-color: #202d3b;
        color: #ffffff;
        display: block;
    }
    .listItem li:hover a{
        color: #ffffff;
    }
    .ActivaLista a{
        background-color: #202d3b;
        color: #ffffff;
        display: block;
    }

</style>

<!-- Modal -->
<div class="modal fade" id="menu_admin" role="dialog">
    <div class="modal-dialog modal-sm">

        <!-- Modal content-->
    <div class="modal-content">

            <div class="modal-header modal-diseng">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Menu (Opcional)</h4>
            </div>

            <div class="modal-body" style="padding-bottom: 0px; padding-top: 0px; background-color: #e5e8e8;">

                <div class="row">

                    <div class="col-md-12 col-xs-12" style="padding: 0px">

                        <div style="background-color: #E5E8E8; border-radius: 0px;" id="menus_admin">

                            <ul style="width: 100%;list-style: none;padding-left: 0px;padding: 0px;margin-bottom: 0px;" class="listItem">

                                <li>
                                    <div style="width: 100%">

                                        <p class="text-center">

                                            <i class="fa fa-4x fa-user"></i>
                                        </p>

                                        <p class="text-center" style="font-weight: bold">
                                            <?= getnombrePaciente($idPaciente)->nombre.' '. getnombrePaciente($idPaciente)->apellido ?>
                                        </p>

                                        <hr style="margin: 2px" >

                                    </div>

                                </li>

                                <li class="lipaddi <?= ($VISTAS == "dop") ? "ActivaLista" : "" ?>">
                                    <a class="lista" href="<?= DOL_HTTP .'/application/system/pacientes/pacientes_admin/?view=dop&key='.KEY_GLOB.'&id='.tokenSecurityId($idPaciente) ?>">&nbsp;&nbsp;
                                        <i class="fa fa-user"></i>&nbsp;&nbsp; DATOS PERSONALES </a>
                                </li>

                                <li class="lipaddi <?= ($VISTAS == "form_carga_familiares") ? "ActivaLista" : "" ?>">
                                    <a class="lista" href="<?= DOL_HTTP .'/application/system/pacientes/admin_paciente/?view=form_carga_familiares&id='.$idPaciente; ?>">&nbsp;&nbsp;
                                        <i class="fa fa-link"></i>&nbsp;&nbsp; CARGA FAMILIARES </a>
                                </li>

                                <li class="lipaddi <?= ($VISTAS == "arch") ? "ActivaLista" : "" ?>">
                                    <a class="lista" href="<?= DOL_HTTP .'/application/system/pacientes/pacientes_admin/?view=arch&key='.KEY_GLOB.'&id='.tokenSecurityId($idPaciente).''; ?>">&nbsp;&nbsp;
                                        <i class="fa fa-folder"></i>&nbsp;&nbsp; IMAGENES - ARCHIVOS</a>
                                </li>

                                <li class="lipaddi <?= ($VISTAS == "form_citas") ? "ActivaLista" : "" ?>">
                                    <a class="lista" href="<?= DOL_HTTP .'/application/system/pacientes/admin_paciente/?view=form_citas&id='.$idPaciente; ?>">&nbsp;&nbsp;
                                        <i class="fa fa-calendar"></i>&nbsp;&nbsp; CITAS </a>
                                </li>

                                <li class="lipaddi <?= ($VISTAS == " ") ? "ActivaLista" : "" ?>">
                                    <a class="lista" href="">&nbsp;&nbsp;
                                        <i class="fa fa-envelope"></i>&nbsp;&nbsp; MAILS </a>
                                </li>

                                <li class="lipaddi <?= ($VISTAS == "comentarios_pacientes") ? "ActivaLista" : "" ?>">
                                    <a class="lista" href="<?= DOL_HTTP .'/application/system/pacientes/pacientes_admin/?view=commp&key='.KEY_GLOB.'&id='.tokenSecurityId($idPaciente); ?>">&nbsp;&nbsp;
                                        <i class="fa fa-comment-o"></i>&nbsp;&nbsp; COMENTARIOS ADMINISTRATIVOS </a>
                                </li>

                                <!--                                                               CLINICO ---------------------------->
                                <li>
                                    <hr style="margin: 0px; margin-bottom: 4px">
                                    <p class="text-center" style="font-weight: bold">CLINICO</p>
                                </li>

                                <li class="lipaddi <?= ($VISTAS == "form_plan_tratamiento") ? "ActivaLista" : "" ?>"> <!--Plande tratamiento-->
                                    <a class="lista" href="<?= DOL_HTTP .'/application/system/pacientes/pacientes_admin/?view=plantram&key='.KEY_GLOB.'&id='.tokenSecurityId($idPaciente).''; ?>">&nbsp;&nbsp;
                                        <i class="fa fa-list-ul"></i>&nbsp;&nbsp; PLANES DE TRATAMIENTOS </a>
                                </li>

                                <li class="lipaddi <?= ($VISTAS == "") ? "ActivaLista" : "" ?>"><a class="lista" href="<?= DOL_HTTP .'/application/system/pacientes/admin_paciente/?view=form_carga_familiares&id='.$idPaciente; ?>">&nbsp;&nbsp;
                                        <i class="fa fa-link"></i>&nbsp;&nbsp; EVOLUCIONES </a>
                                </li>

                                <li class="lipaddi <?= ($VISTAS == "documentos_clinicos") ? "ActivaLista" : "" ?>">
                                    <a class="lista" href="<?= DOL_HTTP .'/application/system/pacientes/admin_paciente/?view=documentos_clinicos&id='.$idPaciente; ?>">&nbsp;&nbsp;
                                        <i class="fa fa-file"></i>&nbsp;&nbsp; DOCUMENTOS CLINICOS </a>
                                </li>

                                <li class="lipaddi <?= ($VISTAS == "form_odontograma") ? "ActivaLista" : "" ?>"><a class="lista" href="<?= DOL_HTTP .'/application/system/pacientes/pacientes_admin/?view=odot&key='.KEY_GLOB.'&id='.tokenSecurityId($idPaciente).'&v=listp'; ?>">&nbsp;&nbsp;
                                        <img  src=" <?= DOL_HTTP .'/logos_icon/logo_default/diente.png';?>" width="12px" height="14px" alt=""> &nbsp;&nbsp;
                                        ODONTOGRAMA </a>
                                </li>

                            </ul>

                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
