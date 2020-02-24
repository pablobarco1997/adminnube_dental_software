<style>
    .list_option li{
        padding: 10px;
    }
</style>

<div class="row">
    <div class="col-md-12">

        <div class="box box-solid">

            <div class="box-header with-border">
                <h3>Directorio de Pacientes</h3>
            </div>

            <div class="box-body">

                <div class="row">
                    <div class="form-group col-xs-12 col-md-12">
                        <div class="col-lg-8 col-xs-12 col-md-6 col-sm-6 margenTopDiv pull-right">
                            <ul class="list-inline pull-right list_option">
                                <li>
                                    <div class="checkbox btnhover" style="margin: 0px; padding: 5px">
                                        <label>
                                            <input type="checkbox" id="checkPacienteDesact">
                                            <i class="fa fa-user-times"></i> Ver lista de pacientes desabilitados
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <label>
                                        <a id="imprimir_listPacientes" class="btnhover" style="padding: 5px; color: #333333" target="_blank" href="<?= DOL_HTTP .'/application/system/pacientes/directorio_paciente/export/export_pdf_directorio.php' ?>"><i class="fa fa-print"></i>   &nbsp;Imprimir Lista</a>
                                    </label>
                                </li>
                                <li>
                                    <label for="">
                                        <a class="btnhover" style="padding: 5px; color: #333333" href="<?= DOL_HTTP .'/application/system/pacientes/nuevo_paciente/index.php?view=nuev_paciente'?>"> <i class="fa fa-users"></i> Nuevo Paciente</a>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>



                <div class="row">

                    <div class="form-group col-md-12 col-xs-12">
                        <div class="col-md-12  col-sm-12 margenTopDiv">
                            <div style=" border-radius: 3px; padding: 3px; width: 100%">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table_direc" width="100%">
                                        <thead>
                                            <tr>
                                                <th>NOMBRE</th>
                                                <th>APELLIDO</th>
                                                <th>RUD - CEDULA</th>
                                                <th>E-MAIL</th>
                                                <th>TELEFONO CEL.</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>



            </div>

        </div>

    </div>
</div>
<br>