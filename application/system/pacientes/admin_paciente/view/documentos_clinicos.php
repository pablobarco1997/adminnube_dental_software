
<?php

    $idClinicoDocumento = '';
    $idCaberzaDocumento = '';
    $create_documento   = '';

    if(isset($_GET['id_ficha']))
    {
        $aux = explode('-', $_GET['id_ficha']); //Id paciente
        $idClinicoDocumento = $aux[0]; //id del documento clinico "FICHA CLINICA"
        $idCaberzaDocumento = $aux[1];//id de la cabezera clinica "CABEZERA DE DOCUMENTOS"
    }

    if(isset($_GET["create_document"])){
        $create_documento = $_GET["create_document"];
    }

?>

<script>

    //    #Se declara una varible global para la modificaion de Documentos Clinicos
    idClinicoDocumento = "<?= $idClinicoDocumento ?>";
    idCaberzaDocumento = "<?= $idCaberzaDocumento ?>";
    $create_documento  = "<?= $create_documento   ?>";

</script>

<div class="row" style="padding: 10px">


    <?php
        if(!isset($_GET['create_document']))
        {

    ?>

    <div class="col-md-12">
        <div class="row">
            <div class="col-xs-12 col-md-3">
                <div class="checkbox">
                    <label>
                        <input type="checkbox">
                        Doct. Habilitados
                    </label>
                </div>
            </div>
            <div class="col-xs-12 col-md-3">
                <div class="checkbox">
                    <label>
                        <input type="checkbox">
                        Doct. Desabilitados
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <ul class="list-inline" style="float: right">
            <li><a href="#SelectedTipoDocumentClinico" data-toggle="modal" class="btn btn-block" style="color: #333333; border-left: 1.3px solid #333333" ><i class="fa fa-file"></i> &nbsp; documento clinico</a></li>
            <li><a href="#" id="printDocumentos" class="btn btn-block " style="color: #333333; border-left: 1.3px solid #333333"><i class="fa fa-print"></i> &nbsp; Imprimir documentos</a></li>
        </ul>
<!--            <label for="">-->
<!--                <a style="margin-top: 3px " data-target="#"  data-toggle="modal" class="btn btn-success"><i class="fa fa-file"></i> &nbsp; Crear nuevo documento Clinico</a>-->
<!--            </label>-->
    </div>

    <?php } ?>

<!--    documentos-->
    <?php if(isset($_GET['create_document'])) { ?>

<!--        No muestra nada-->

    <?php } ?>

</div>

<div class="row" style="padding: 9px">
<br>

    <?php

    if(!isset($_GET['create_document']))
    {

    ?>

        <div class="col-md-12">
            <div class="table-responsive">
                <table id="table-documentos-clinicos1" class="table" width="100%">
                    <thead style="background-color: #f4f4f4">
                        <tr>
                            <th WIDTH="1%"><input type="checkbox" style="margin-bottom: 3px"></th>
                            <th WIDTH="15%">Fecha</th>
                            <th WIDTH="30%">Documento</th>
                            <th WIDTH="20%">Responsable</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    <?php } ?>

    <?php
        if( isset($_GET['create_document']) ) //Muestra el docmeuneto Clinico o ficha
        {
    ?>
            <div class="col-md-12">

                <?php

                    switch ($_GET['create_document']) //Tipo de Documento
                    {
                        case '1': //Ficha clinica

                            include_once  DOL_DOCUMENT .'/application/system/pacientes/admin_paciente/view/sub_view/form_clinico_ficha_clinica.php';

                            break;
                    }

                ?>

            </div>

    <?php } ?>

</div>

<!--MODAL QUE SELECCION TIPO DE DOCUMENTO -->


<div class="modal fade" id="SelectedTipoDocumentClinico" role="dialog">
    <div class="modal-dialog small">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Crear nuevo documento clínico</h4>
            </div>

            <div class="modal-body">

                <div class="form-group col-md-12">
                    <label for="">Seleccione el tipo de ficha que desa crear</label>
                    <select id="SeletedTipoDocumentClinico" class="select2_max_ancho">
                        <option value=""></option>
                        <?php
                            $sql = "SELECT * FROM tab_documentos_clinicos";
                            $rs = $db->query($sql);
                            if($rs->rowCount())
                            {
                                while ($acc = $rs->fetchObject())
                                {
                                    echo "<option value='$acc->rowid'>$acc->nombre_documento</option>";
                                }
                            }
                        ?>

                    </select>

                </div>


               <div style="width: 30%; " class="center-block">
                   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                   <button type="button" class="btn btn-success  disabled_link3" id="crearDocumentClinico" style="float: right;">Crear</button>
               </div>
            </div>

        </div>

    </div>
</div>