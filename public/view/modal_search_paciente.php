<!-- Modal -->
<div class="modal fade" id="buscarPacienteModal" role="dialog">
    <div class="modal-dialog" style="width: 50%">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Buscar Paciente</h4>
            </div>
            <div class="modal-body">

                <div class="row">

                    <div class="col-md-12 col-xs-12">
                        <div class="center-block" style="width: 70%">
                            <div class="autocomplete">
                                <div class="input-group">
                                    <input type="search" autocomplete="off" onfocus="InputSearcheIndex_1(this)" class="form-control" name="myCountry" id="myInput" placeholder="Buscar pacientes..." aria-describedby="basic-addon2">
                                    <span class="input-group-addon" id="basic-addon2"><i class="fa fa-search"></i></span>
                                    <span style="display: none" id="pacien"></span>
                                </div>
                                <br>
                                <button class="btn btn-block" id="buscarPaciente">Buscar</button>
                            </div>
                        </div>
                    </div>

                    <?php


                    ?>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
