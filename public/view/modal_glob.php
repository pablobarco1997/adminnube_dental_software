
<!-- Modal -->
<div class="modal fade" id="ModalInfoamcionNotificaicion" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
<!--                <h4 class="modal-title">Modal Header</h4>-->
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group col-md-4">
                                <img src="<?php echo DOL_HTTP .'/dist/img/user2-160x160.jpg'; ?>" alt="" class="img-circle img-lg">
                        </div>

                        <div class="form-group col-md-8">
                            <div class="form-group col-md-12">
                                <div class="form-group col-md-6">
                                    <p id="modalnotifi_nombre" class="notifi_nombre text-bold">
<!--                                        nombre del paciente-->
                                    </p>
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-x2 fa-clock-o"></i>
                                    &nbsp; <span id="modalnotifi_horario" class="notifi_horario text-bold">
<!--                                        horario ejemplo 09:00 a 10:00-->
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <div class="form-group col-md-12">
                                    <p class="text-bold">Observación</p>
                                    <p class="text-justify text-sm notifi_observacion" id="modalnotifi_observacion">
<!--                                       observacion-->
                                    </p>
                                </div>
                            </div>

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