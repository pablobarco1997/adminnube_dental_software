
<div class="box box-solid">

    <div class="box-header with-border">
        <h3>  DOCUMENTOS ASOCIADOS</h3>
    </div>

    <div class="box-body">

        <br>

        <div class="center-block" style="width: 80%;">

            <div class="row">

                <div class="col-lg-12 col-md-12 col-xs-12">
                    <ul class="list-inline">
                        <li> <a href="#ModalSub_file" data-toggle="modal" class=" btn btnhover" style="background-color: #F2F3F4; color: #333333"><i class="fa fa-file" aria-hidden="true"></i>&nbsp; AGREGAR CITAS</a> </li>
                    </ul>
                </div>
                <div class="col-lg-12 col-md-12 col-xs-12">
                    <div class="table-responsive">
                        <table class="table" WIDTH="100%" id="plantillaclinicas">
                            <thead>
                                <tr>
                                    <th width="30%">DOCUMENTOS</th>
                                    <th width="70%">DESCRIPCION</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="ModalSub_file" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-diseng">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="tomar" data-id="0" data-subaccion="">SUBIR ARCHIVO CLINICO</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label for="" class="control-label col-sm-2">Descripcion</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="descripcion" placeholder="descripcion">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label col-sm-4 " style="text-align: left">Seleccione un archivo</label>
                                <div class="col-sm-6">
                                    <input type="file" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" data-dismiss="modal" id="eliminarConfCategoriaDescuento">Aceptar</button>
            </div>
        </div>

    </div>
</div>
