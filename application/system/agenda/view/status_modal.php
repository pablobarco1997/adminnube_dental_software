
<!--CONFIRMACION DE CITA EMAIL-->
<div id="notificar_email-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header modal-diseng">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Notificar  e-mail  &nbsp;<i class="fa fa-envelope"></i> </h4>
                </div>
                <div class="modal-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label for="" class="control-label col-sm-2">Asunto</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="asunto_email" placeholder="asunto" value="Notificación de Cita">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="control-label col-sm-2">From</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" disabled id="de_email" placeholder="" value="<?= $conf->EMPRESA->INFORMACION->email ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="control-label col-sm-2">To</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="para_email" placeholder="destinario" value="" onkeyup="keyemail_invalic()">
                                <small style="color: red;" id="invali_emil_mssg"></small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="control-label col-sm-2">Titulo</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="titulo_email" placeholder="titulo" value="Notificación de Citas - Clinica <?= $conf->EMPRESA->INFORMACION->nombre;  ?> ">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="control-label col-sm-2">Message</label>
                            <div class="col-sm-9">
                                <textarea id="messge_email" class="form-control" cols="30" rows="4"></textarea>
                            </div>
                        </div>

                        <div class="form-group" id="emailEspere" style="display: none">
                            <label for="" class="control-label col-sm-2">&nbsp;&nbsp;</label>
                            <div class="col-sm-9">
                                <small> Enviando mensaje espere ... </small>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="enviarEmail" onclick="">Enviar</button>
                </div>
            </div>

    </div>
</div>




<!--COMENTARIO ADICIONAL-->

    <!-- Modal -->
    <div id="modal_coment_adicional"  class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header modal-diseng">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="iddet-comment">Comentario Adicional</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group col-md-12">
                        <label for="#">Agrege un comentario</label>
                        <textarea cols="" class="form-control" id="comment_adicional"></textarea>
                        <small style="color: red;" id="invali_commentadciol_mssg"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"> Close </button>
                    <button type="button" class="btn btn-success" id="guardarCommentAdicional" > Guardar </button>
                </div>
            </div>

        </div>
    </div>