
<div class="row">
    <div class="form-group col-md-12 col-xs-12 col-sm-12">
        <ul style="float: right" class="list-inline ">
            <li><a href="<?= DOL_HTTP ?>/application/system/agenda/export/export_pdf_agenda_diariaglobal.php" target="_blank" id="export_diariaGlobal" class="btn btn-xs <?= $permisos->consultar ?>" title="imprimir PDF"> <img width="25px" src="<?= DOL_HTTP ?> /logos_icon/logo_default/pdf.png" alt=""> </a> </li>
            <li>&nbsp;</li>
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <div class="table-responsive">
            <table class="table" style="width: 100%" id="table_ficheros_paciente">
                <thead style="background-color: #FDFEFE">
                <tr>
                    <th WIDTH="14%">HORA</th>
                    <th WIDTH="14%">DOCTOR</th>
                    <th WIDTH="14%">PACIENTE</th>
                    <th WIDTH="14%">RUC/CÉDULA</th>
                    <th WIDTH="14%">TELÉFONO</th>
                    <th WIDTH="14%">ESPECIALIDAD</th>
                    <th WIDTH="14%">OBSERVACIÓN</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>