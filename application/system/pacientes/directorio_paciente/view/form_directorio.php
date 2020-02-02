<div class="row">
    <div class="col-md-12">

        <div class="box box-solid">

            <div class="box-header with-border">
                <h3>Directorio de Pacientes</h3>
            </div>

            <div class="box-body">

                <div class="row">

                        <div class="col-lg-8 margenTopDiv">

                            <div style="background-color: #E5E8E8; border-radius: 3px; padding: 3px; width: 100%" >
                                <div class="checkbox" style="margin: 0px">
                                    &nbsp;&nbsp;
                                    <label>
                                        <input type="checkbox" id="checkPacienteDesact">
                                        <i class="fa fa-user-times"></i> Ver lista de pacientes desabilitados
                                    </label>
                                    &nbsp;
                                    <label>
                                        <a id="imprimir_listPacientes" target="_blank" href="<?= DOL_HTTP .'/application/system/pacientes/directorio_paciente/export/export_pdf_directorio.php' ?>"><i class="fa fa-print"></i>   &nbsp;Imprimir Lista</a>
                                    </label>

                                    <label for="">
                                        <a href="<?= DOL_HTTP .'/application/system/pacientes/nuevo_paciente/index.php?view=nuev_paciente'?>"> <i class="fa fa-users"></i> Nuevo Paciente</a>
                                    </label>

                                </div>
                            </div>

                        </div>

<!--                        <div class="col-lg-6 margenTopDiv">-->
<!---->
<!---->
<!--                            <label for="">-->
<!--                                <a href="--><?//= DOL_HTTP .'/application/system/pacientes/nuevo_paciente/index.php?view=nuev_paciente'?><!--"> <i class="fa fa-users"></i> Nuevo Paciente</a>-->
<!--                            </label>-->
<!--                            &nbsp;&nbsp;&nbsp;                            &nbsp;&nbsp;&nbsp;-->
<!---->
<!---->
<!--                        </div>-->

                </div>


                <div class="row">
                    <div class="col-md-12  col-sm-12 margenTopDiv">

                        <div style=" border-radius: 3px; padding: 3px; width: 100%">

                            <div class="table-responsive">
                                <table class="table" id="table_direc" width="100%">
                                    <thead style="background-color: #E5E8E8">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>rud / dni</th>
                                        <th>email</th>
                                        <th>numero celular</th>
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
<br>