<?php

$array_datos_personales = (object)[
   'url'     =>  DOL_HTTP .'/application/system/pacientes/pacientes_admin/?view=dop&key='.KEY_GLOB.'&id='.tokenSecurityId($idPaciente) ,
   'active'  =>  ($VISTAS == "dop") ? "ActivaLista" : "",
   'permiso' => ''
];

$array_imagenes_archivos = (object)[
    'url'     =>  DOL_HTTP .'/application/system/pacientes/pacientes_admin/?view=arch&key='.KEY_GLOB.'&id='.tokenSecurityId($idPaciente).'' ,
    'active'  =>  ($VISTAS == "arch") ? "ActivaLista" : "",
    'permiso' => ''
];

$array_plan_tratamiento = (object)[
    'url'     =>  DOL_HTTP .'/application/system/pacientes/pacientes_admin/?view=plantram&key='.KEY_GLOB.'&id='.tokenSecurityId($idPaciente).'' ,
    'active'  =>  ($VISTAS == "plantram") ? "ActivaLista" : "",
    'permiso' => ''
];

$array_odontograma = (object)[
    'url'     =>  DOL_HTTP .'/application/system/pacientes/pacientes_admin/?view=odot&key='.KEY_GLOB.'&id='.tokenSecurityId($idPaciente).'&v=listp' ,
    'active'  =>  ($VISTAS == "odot") ? "ActivaLista" : "",
    'permiso' => ''
];

$array_citas_asociadas = (object)[
    'url'     =>   DOL_HTTP .'/application/system/pacientes/pacientes_admin/?view=citasoci&key='.KEY_GLOB .'&id='.tokenSecurityId($idPaciente),
    'active'  =>  ($VISTAS == "citasoci") ? "ActivaLista" : "",
    'permiso' => ''
];

$array_documentAsociado = (object)[
    'url'     =>  DOL_HTTP .'/application/system/pacientes/pacientes_admin/?view=docummclin&key='.KEY_GLOB .'&id='.tokenSecurityId($idPaciente).'&v=listdocumment',
    'active'  =>  ($VISTAS == "docummclin") ? "ActivaLista" : "",
    'permiso' => ''
];

$array_Pagos_pacientes = (object)[
    'url'     => DOL_HTTP.'/application/system/pacientes/pacientes_admin/?view=pagospaci&key='.KEY_GLOB.'&id='.tokenSecurityId($idPaciente).'&v=paym',
    'active'  =>  ($VISTAS == "pagospaci") ? "ActivaLista" : "",
    'permiso' => ''
];

$array_evoluciones = (object)[
    'url'     => DOL_HTTP.'/application/system/pacientes/pacientes_admin/?view=evoluc&key='.KEY_GLOB.'&id='.tokenSecurityId($idPaciente).'&v=list_evul',
    'active'  =>  ($VISTAS == "evoluc") ? "ActivaLista" : "",
    'permiso' => ''
];


?>


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

                                <li class="lipaddi <?= $array_datos_personales->active ?>">
                                    <a class="lista" href="<?= $array_datos_personales->url ?>">&nbsp;&nbsp;
                                        <i class="fa fa-user"></i>&nbsp;&nbsp; DATOS PERSONALES </a>
                                </li>

                                <li class="lipaddi <?= ($VISTAS == "form_carga_familiares") ? "ActivaLista" : "" ?>">
                                    <a class="lista" href="<?= DOL_HTTP .'/application/system/pacientes/admin_paciente/?view=form_carga_familiares&id='.$idPaciente; ?>">&nbsp;&nbsp;
                                        <i class="fa fa-link"></i>&nbsp;&nbsp; CARGA FAMILIARES </a>
                                </li>

                                <li class="lipaddi <?= $array_imagenes_archivos->active ?>">
                                    <a class="lista" href="<?= $array_imagenes_archivos->url ?>">&nbsp;&nbsp;
                                        <i class="fa fa-folder"></i>&nbsp;&nbsp; IMAGENES - ARCHIVOS</a>
                                </li>

                                <li class="lipaddi <?= $array_citas_asociadas->active ?>">
                                    <a class="lista" href="<?= $array_citas_asociadas->url ?>">&nbsp;&nbsp;
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

                                <li class="lipaddi <?= $array_plan_tratamiento->active ?>"> <!--Plande tratamiento-->
                                    <a class="lista" href="<?= $array_plan_tratamiento->url; ?>">&nbsp;&nbsp;
                                        <i class="fa fa-list-ul"></i>&nbsp;&nbsp; PLANES DE TRATAMIENTOS </a>
                                </li>

                                <li class="lipaddi <?= $array_evoluciones->active ?>"><a class="lista" href="<?= $array_evoluciones->url;  ?>">&nbsp;&nbsp;
                                        <i class="fa fa-link"></i>&nbsp;&nbsp; EVOLUCIONES </a>
                                </li>

                                <li class="lipaddi <?= $array_documentAsociado->active ?>">
                                    <a class="lista" href="<?= $array_documentAsociado->url ; ?>">&nbsp;&nbsp;
                                        <i class="fa fa-file"></i>&nbsp;&nbsp; DOCUMENTOS CLINICOS </a>
                                </li>

                                <li class="lipaddi <?= $array_odontograma->active ?>"><a class="lista" href="<?= $array_odontograma->url; ?>">&nbsp;&nbsp;
                                        <img  src=" <?= DOL_HTTP .'/logos_icon/logo_default/diente.png';?>" width="12px" height="14px" alt=""> &nbsp;&nbsp;
                                        ODONTOGRAMA </a>
                                </li>


                                <!--                                                               PAGOS ---------------------------->
                                <li>
                                    <hr style="margin: 0px; margin-bottom: 4px">
                                    <p class="text-center" style="font-weight: bold">FACTURACIÓN</p>
                                </li>

                                <li class="lipaddi <?= $array_Pagos_pacientes->active ?>">
                                    <a class="lista" href="<?= $array_Pagos_pacientes->url ; ?>">&nbsp;&nbsp;
                                        <i class="fa fa-shopping-cart"></i>&nbsp;&nbsp; RECAUDACIÓN (<small>PAGOS</small>) </a>
                                </li>

                            </ul>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
