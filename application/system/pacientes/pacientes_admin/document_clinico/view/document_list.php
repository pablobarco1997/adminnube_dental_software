
<?php

$opcionDocmmClinicos = "";
$sql = "select nombre_documento , rowid from tab_documentos_clinicos";
$rsDoctClini = $db->query($sql);
if($rsDoctClini->rowCount()>0)
{
    while ($Doc = $rsDoctClini->fetchObject())
    {
        $opcionDocmmClinicos .= "<option value='$Doc->rowid'> $Doc->nombre_documento </option>";
    }
}

?>


<style>

    tbody td{
        text-align: center;
    }
</style>

<div class="form-group col-xs-12 col-md-12">
    <!--        OPCIONES -->
    <div  class="form-group col-md-12 col-xs-12">
        <label for="">LISTA DE COMPORTAMIENTOS</label>

        <ul class="list-inline" style="border-bottom: 0.6px solid #333333; padding: 3px">
            <li>
                <a href="#" style="color: #333333" class="btnhover btn btn-sm " id="fitrar_document"> <b>  ▼ &nbsp;Filtrar <i ></i> </b> </a>
            </li>
            <li>
                <a href="#addnewdocument" data-toggle="modal" style="color: #333333" class="btnhover btn btn-sm " id="create_document" > <b> <i class="fa fa-file-text"></i> &nbsp; nuevo documento clinico <i ></i> </b> </a>
            </li>
        </ul>
    </div>

</div>

<div class="form-group col-xs-12 col-md-12">
    <div class="table-responsive">
        <table class="table-striped table" WIDTH="100%" id="list_docum_clini">
            <thead>
                <tr>
                    <th width="20%" class="text-center">FECHA</th>
                    <th width="30%" class="text-center">OBSERVACIÓN</th>
                    <th width="20%" class="text-center">CREADO X</th>
                    <th width="30%" class="text-center">EXPORT</th>
                </tr>
            </thead>
        </table>
    </div>
</div>


<!-- Modal docmuento clinico -->

<div class="modal fade" id="addnewdocument" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-diseng">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">CREAR NUEVO DOCUMENTO CLINICO</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12 col-xs-12">
                        <select class="form-control select2_max_ancho" id="documento_">
                            <option value=""></option>
                            <?= $opcionDocmmClinicos; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btnhover" style="font-weight: bolder; color: green" id="crearDocumentClinico">Guardar</a>
                <a href="#" class="btn btnhover" data-dismiss="modal" style="font-weight: bolder">Close</a>
            </div>
        </div>

    </div>
</div>
