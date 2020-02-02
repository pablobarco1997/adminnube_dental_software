<div class="box box-solid">
    <div class="box-header with-border">
        <h3>Configuración</h3>
    </div>

    <div class="box-body">
        <br>

        <div class="center-block" style="width: 70%;">

            <div class="row">
                <div class="col-md-12">
                    <div class="" style="background-color: #E5E8E8; padding: 3px; height: 30px; border-radius: 4px">
                        <label for="" style="cursor: pointer; " data-toggle="modal" data-target="#modal_conf_convenio" onclick="modalCleanInputs(); "> &nbsp;&nbsp;<i class="fa fa-file-text-o"></i> &nbsp;&nbsp; Agregar Convenio</label>
                    </div>
                </div>
            </div>

            <br>
            <br>

            <div class="row">
               <div class="col-md-12">
                   <div class="table-responsive">
                       <table class="table" id="conf_table_convenio" width="100%">
                           <thead style="background-color: #E5E8E8">
                               <tr>
                                   <th WIDTH="30%">NOMBRE</th>
                                   <th WIDTH="25%">DESCRIPCIÓN</th>
                                   <th WIDTH="20%">VALOR</th>
                                   <th WIDTH="5%"></th>
                               </tr>
                           </thead>
                       </table>
                   </div>
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
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="comportamiento">AGREGAR CONVENIO</h4>
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
                        <label for="">valor</label>
                        <input type="number" id="valor_conv" class="form-control input-sm ">
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="guardar_convenio_conf" >Aceptar</button>
            </div>
        </div>

    </div>
</div>