<div class="box box-solid">
    <div class="box-header with-border">
        <h3>Configuración</h3>
    </div>

    <div class="box-body">
        <br>

        <div class="form-group col-xs-12 col-md-10 col-lg-10 col-sm-12 col-centered">

            <div class="form-group col-sm-12 col-md-12 col-xs-12">
                <ul class="list-inline pull-right">
                    <li> <b> <a  href="#modal_conf_convenio" data-toggle="modal" class="btn btnhover " onclick="InputsClean()"> <i class="fa fa-plus"></i> Agregar Convenio </a> </b> </li>
                </ul>
            </div>

            <div class="form-group col-xs-12 col-md-12 col-lg-12">
                <div class="table-responsive">
                    <table class="table table-striped" id="conf_table_convenio" width="100%">
                        <thead >
                            <tr>
                                <th WIDTH="25%">NOMBRE</th>
                                <th WIDTH="25%">DESCRIPCIÓN</th>
                                <th WIDTH="6%">DESCUENTO %</th>
                                <th WIDTH="10%"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>


        </div>

    </div>

</div>

<!--//Modal de agregar convenio ------------------------------------------- -->
<div id="modal_conf_convenio" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-diseng">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="comportamiento" >AGREGAR CONVENIO</h4>
            </div>
            <div class="modal-body">

                <div style="padding: 10px">

                    <div class="form-group">
                        <label for="">Nombre</label>
                        <input type="text" id="nomb_conv" class="form-control input-sm">
                    </div>
                    <div class="form-group">
                        <label for="">Descripción</label>
                        <textarea name="" class="form-control input-sm" id="descrip_conv" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Descuento %</label>
                        <input type="text" id="valor_conv" class="form-control input-sm mask">
                        <small style="color: red; " id="msg_descuento"></small>
                    </div>

                </div>

            </div>
            <div class="modal-footer">

                <a href="#" class="btn btnhover " style="font-weight: bolder; color: green" id="guardar_convenio_conf">Aceptar</a>
                <a href="#" class="btn btnhover" style="font-weight: bolder;" data-dismiss="modal">Close</a>

            </div>
        </div>

    </div>
</div>