
<?php if(isset($_GET['ope']) && isset($_GET['idtratam']))
{

    $s = "";
    $c = "";
    if(isset($_GET['ope'])){

        $s = $_GET['ope']; # tipo de operacion nuevo o modificar
    }
    if(isset( $_GET['idtratam'])){

        $c = $_GET['idtratam']; #id del tratamiento

    }

    ?>

<script>

    $tratamientoOperacion     = "<?=  $s ?>";  //tipo  de Tratamiento   modificar o nuevo
    $idCitaGlob               = "<?=  0  ?>";  //id de citas
    $idplantratamiento        = "<?=  $c ?>";  //id plan de tratamiento cabezera

</script>

<?php } ?>


<form id="formTratamiento" style="background-color: #ffffff; padding: 15px">

    <label for="" id="numtratamiento">Plan de Tratamiento # 001</label>

    <br>

    <div class="row">

        <div class="col-md-8 col-xs-12 col-sm-8">
            <table style="font-size: 1.2rem">
                <tr>
                    <td><i class="fa fa-user"></i> Profecional: </td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td id="tratamiento_doctor">Dr(a): </td>
                </tr>
                <tr>
                    <td><i class="fa fa-folder-open"></i> convenio: </td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td id="tratamiento_convenio">Sin convenio</td>
                </tr>
            </table>
        </div>

        <div class="col-md-4 col-xs-12 col-ms-4">
            <div class="disabled_link3" id="contentBono">
                <div style="border-radius: 50px; background-color: " class="center-block">
                    <p class="text-center labeltextBono " style="font-size: 1.5em; font-weight: bold" >No hay bonos disponibles</p>
                    <p class="text-center labelBonoSaldo" style="font-size: 1.5em; font-weight: bold" id="tartamiento_saldo">$ 0.00</p>
                </div>
            </div>
        </div>


    </div>

    <br>

    <div class="row">

        <div class="table-responsive">
            <table class="table" id="tablePlanTratamiento1" width="100%">
                <thead>
                        <tr>
                            <th WIDTH="40%">
                                <label  style="float: left">Prestación</label>
                                <label data-toggle="modal" data-target="#ModalTratamiento_1" style="color: #00a157; font-size: 1.4rem; cursor: pointer; float: right; padding-top: 2.5px" onclick="clearModalDetalle()"> <i class="fa fa-plus-circle"></i> Cargar Prestaciones</label>
                            </th>
                            <th WIDTH="10%">
                                Realización
                            </th>
                            <th WIDTH="15%">Dcto Adicional</th>
                            <th WIDTH="15%">Total &nbsp; <i class="fa fa-edit"></i></th>
                            <th WIDTH="20%">Estado Pago</th>
                        </tr>

                        <tr>
                            <th colspan="5" style="font-size: 1.4rem; cursor: pointer">Acciones Clinicas</th>
                        </tr>
                </thead>

                <tbody id="listdetalleplantramiento">

                </tbody>
            </table>

        </div>
        <div class="form-group col-md-6" style="position: relative; float: right">
            <table width="100%" class="table">
                <tr>
                    <td class="text-right" style="border: 1px solid #dddddd;">
                        <b>estado:</b>
                    </td>
                    <td  style="border: 1px solid #dddddd;">
                        <select name="estadotratamiento" id="estadotratamiento" class="form-control input-sm">
                            <option value="P">pendiente</option>
                            <option value="F">Finalizado</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="text-right" style="border: 1px solid #dddddd;">
                        <b>Subtotal:</b>
                    </td>
                    <td  style="border: 1px solid #dddddd;"> <p class="subtotal_det"></p> </td>
                </tr>
                <tr>
                    <td class="text-right" style="border: 1px solid #dddddd;">
                        <b>Descuento Adicional:</b>
                    </td>
                    <td  style="border: 1px solid #dddddd;"> <p class="descAdi_det"></p> </td>
                </tr>
                <tr>
                    <td class="text-right"  style="border: 1px solid #dddddd;">
                        <b>Total:</b>
                    </td>
                    <td  style="border: 1px solid #dddddd;"> <p class="total_det"></p> </td>
                </tr>
                <tr>
                    <td class="text-right" style="border: 1px solid #dddddd;">
                        <b>Abonado:</b>
                    </td>
                    <td  style="border: 1px solid #dddddd;">
                        <input type="text" class="form-control input-sm mask" id="abonado" onkeyup="recalcular_detalle()" value="0.00">
                    </td>
                </tr>
                <tr>
                    <td class="text-right" style="border: 1px solid #dddddd;">
                        <b>Saldo pendiente:</b>
                    </td>
                    <td  style="border: 1px solid #dddddd;"> <p class="sald_pendiente"></p> </td>
                </tr>
            </table>
        </div>
        
        <div class="form-group col-md-12 col-xs-12 col-lg-12">
            <label for="">Comentarios para el Paciente</label>
            <textarea name="" id="" cols="30" rows="5" class="form-control"></textarea>
        </div>

    </div>

</form>