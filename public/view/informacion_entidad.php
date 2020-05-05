

<!--INFOMACION DE CLINICA -->

<div id="Informacion_clinica_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-diseng">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="info_clinica">CLINICA</h4>
            </div>
            <div class="modal-body">

                <form action="">

                    <div class="row">
                        <div class="form-group col-md-4">

                            <div class="row">
                                <div class="col-md-12"></div>
                                <div class="col-md-12">
                                    <div class="center-block" style="width: 60%;display: block; overflow: hidden">
                                        <img src=" <?= !empty($conf->EMPRESA->INFORMACION->logo) ? DOL_HTTP.'/logos_icon/'.$conf->NAME_DIRECTORIO.'/'.$conf->EMPRESA->INFORMACION->logo :  DOL_HTTP .'/logos_icon/logo_default/icon_software_dental.png'?>" style="width: 100%" alt="" id="imgLogo">
                                    </div>
                                        <br>
                                    <label for="subirLogo" class="btn btn-xs btn-block" style="background-color: #00a157; border-radius: 0px;color: #FFFFFF">Subir Logo</label>
                                    <input type="file" id="subirLogo" style="display: none" accept="image/png" >
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-8">

                                <div class="form-group">
                                    <label for="">Clinica</label>
                                    <input type="text" class="form-control input-sm" id="entidad_clinica" value="<?= $conf->EMPRESA->INFORMACION->nombre ?>">
                                </div>
                                <div class="form-group col-md-6" style="padding: 1px">
                                    <label for="">Pais</label>
                                    <input type="text" class="form-control input-sm" id="entidad_pais" value="<?= $conf->EMPRESA->INFORMACION->pais ?>">
                                </div>
                                <div class="form-group col-md-6" style="padding: 1px">
                                    <label for="">Ciudad</label>
                                    <input type="text" class="form-control input-sm" id="entidad_ciudad" value="<?= $conf->EMPRESA->INFORMACION->ciudad ?>" >
                                </div>


                                <div class="form-group col-md-4" style="padding: 1px">
                                    <label for="">Dirección</label>
                                    <input type="text" class="form-control input-sm" id="entidad_direccion" value="<?= $conf->EMPRESA->INFORMACION->direccion ?>">
                                </div>
                                <div class="form-group col-md-4" style="padding: 1px">
                                    <label for="">Telefono</label>
                                    <input type="text" class="form-control input-sm" id="entidad_telefono" value="<?= $conf->EMPRESA->INFORMACION->telefono ?>">
                                </div>
                                <div class="form-group col-md-4" style="padding: 1px">
                                    <label for="">Celular</label>
                                    <input type="text" class="form-control input-sm" id="entidad_celular" value="<?= $conf->EMPRESA->INFORMACION->celular ?>" >
                                </div>


                                <div class="form-group">
                                    <label for="">E-mail</label>
                                    <input type="text" class="form-control input-sm" id="entidad_email" value="<?= $conf->EMPRESA->INFORMACION->email ?>" >
                                </div>

                                <hr>
                                <h2>Configurar e-mail</h2>
                                <div class="form-group">
                                    <label for="">E-mail</label>
                                    <input type="text" class="form-control input-sm" id="conf_email_entidad" value="<?= $conf->EMPRESA->INFORMACION->conf_email ?>" >
                                </div>
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input type="password" class="form-control input-sm" id="conf_password_entidad" value="<?= $conf->EMPRESA->INFORMACION->conf_password ?>" >
                                </div>

                        </div>

                    </div>

                </form>

                <div class="row">

                    <div class="form-group col-md-4"></div>

                    <div class="form-group col-md-8">
                        <div class="row">
                            <div class="col-md-6 pull-right">
                                <a href="#" class="btn btnhover pull-right" data-dismiss="modal" style="font-weight: bolder">Close</a>
                                <a href="#" class="btn btnhover pull-right" style="font-weight: bolder; color: green" id="Update_entidad">Aceptar</a>
                            </div>
                            <div class="col-md-6">
<!--                                <button type="button" class="btn btn-success btn-block" id="Update_entidad">Aceptar</button>-->
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>