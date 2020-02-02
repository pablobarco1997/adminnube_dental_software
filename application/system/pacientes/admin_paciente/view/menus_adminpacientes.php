

<!-- Modal -->
<div class="modal fade" id="menu_admin" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Menu (Opcional)</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div style="background-color: #E5E8E8; border-radius: 3px;" id="menus_admin">

                            <ul style="width: 100%; list-style: none; padding-left: 0px; padding: 5px">

                                <li>
                                    <div style="width: 100%">
                                        <p class="text-center">
                                            <i class="fa fa-4x fa-user"></i>
                                        </p>
                                        <p class="text-center" >
                                            <?= getnombrePaciente($id)->nombre.' '. getnombrePaciente($id)->apellido ?>
                                        </p>
                                        <hr style="margin: 2px" >
                                    </div>
                                </li>

                                <li class="lipaddi <?= ($view == "form_datos_personales") ? "ActivaLista" : "" ?>"><a class="lista" href="<?= DOL_HTTP .'/application/system/pacientes/admin_paciente/?view=form_datos_personales&id='.$id; ?>">&nbsp;&nbsp; <i class="fa fa-user"></i>&nbsp;&nbsp; Datos personales </a></li>
                                <li class="lipaddi <?= ($view == "form_carga_familiares") ? "ActivaLista" : "" ?>"><a class="lista" href="<?= DOL_HTTP .'/application/system/pacientes/admin_paciente/?view=form_carga_familiares&id='.$id; ?>">&nbsp;&nbsp; <i class="fa fa-link"></i>&nbsp;&nbsp; Carga Familiares </a></li>
                                <li class="lipaddi <?= ($view == "form_archivos") ? "ActivaLista" : "" ?>"><a class="lista" href="<?= DOL_HTTP .'/application/system/pacientes/admin_paciente/?view=form_archivos&id='.$id; ?>">&nbsp;&nbsp; <i class="fa fa-folder"></i>&nbsp;&nbsp; Imagenes y Archivos </a></li>
                                <li class="lipaddi <?= ($view == "form_citas") ? "ActivaLista" : "" ?>"><a class="lista" href="<?= DOL_HTTP .'/application/system/pacientes/admin_paciente/?view=form_citas&id='.$id; ?>">&nbsp;&nbsp; <i class="fa fa-calendar"></i>&nbsp;&nbsp; Citas </a></li>
                                <li class="lipaddi <?= ($view == " ") ? "ActivaLista" : "" ?>"><a class="lista" href="">&nbsp;&nbsp; <i class="fa fa-envelope"></i>&nbsp;&nbsp; Mails </a></li>
                                <li class="lipaddi <?= ($view == "comentarios_pacientes") ? "ActivaLista" : "" ?>"><a class="lista" href="<?= DOL_HTTP .'/application/system/pacientes/admin_paciente/?view=comentarios_pacientes&id='.$id; ?>">&nbsp;&nbsp; <i class="fa fa-comment-o"></i>&nbsp;&nbsp; Comentarios Administrativos </a></li>

                                <!--                                                               CLINICO ---------------------------->
                                <li>
                                    <hr style="margin: 0px;">
                                    <p class="text-center">CLINICO</p>
                                </li>

                                <li class="lipaddi <?= ($view == "form_plan_tratamiento") ? "ActivaLista" : "" ?>"><a class="lista" href="<?= DOL_HTTP .'/application/system/pacientes/admin_paciente/?view=form_plan_tratamiento&id='.$id; ?>">&nbsp;&nbsp; <i class="fa fa-list-ul"></i>&nbsp;&nbsp; Planes de Tratamiento </a></li>

                                <li class="lipaddi <?= ($view == "") ? "ActivaLista" : "" ?>"><a class="lista" href="<?= DOL_HTTP .'/application/system/pacientes/admin_paciente/?view=form_carga_familiares&id='.$id; ?>">&nbsp;&nbsp; <i class="fa fa-link"></i>&nbsp;&nbsp; Evoluciones </a></li>

                                <li class="lipaddi <?= ($view == "documentos_clinicos") ? "ActivaLista" : "" ?>"><a class="lista" href="<?= DOL_HTTP .'/application/system/pacientes/admin_paciente/?view=documentos_clinicos&id='.$id; ?>">&nbsp;&nbsp; <i class="fa fa-file"></i>&nbsp;&nbsp; Documentos Clinicos </a></li>

                                <li class="lipaddi <?= ($view == "form_odontograma") ? "ActivaLista" : "" ?>"><a class="lista" href="<?= DOL_HTTP .'/application/system/pacientes/admin_paciente/?view=form_odontograma&id='.$id; ?>">&nbsp;&nbsp;
                                        <img  src=" <?= DOL_HTTP .'/logos_icon/logo_default/diente.png';?>" width="12px" height="14px" alt=""> &nbsp;&nbsp; Odontograma Actual Clinicos </a>
                                </li>

                            </ul>

                        </div>
                    </div>
                </div>
            </div>
<!--            <div class="modal-footer">-->
<!--                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
<!--            </div>-->
        </div>

    </div>
</div>
