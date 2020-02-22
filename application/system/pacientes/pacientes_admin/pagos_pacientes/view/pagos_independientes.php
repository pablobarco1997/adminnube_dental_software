

<style>

    /* Custom checkbox */
    .custom-checkbox-myStyle {
        position: relative;
    }
    .custom-checkbox-myStyle input[type="checkbox"] {
        opacity: 0;
        position: absolute;
        margin: 5px 0 0 3px;
        z-index: 9;
    }
    .custom-checkbox-myStyle label:before{
        width: 18px;
        height: 18px;
    }
    .custom-checkbox-myStyle label:before {
        content: '';
        margin-right: 10px;
        display: inline-block;
        vertical-align: text-top;
        background: white;
        border: 1px solid #bbb;
        border-radius: 2px;
        box-sizing: border-box;
        z-index: 2;
    }
    .custom-checkbox-myStyle input[type="checkbox"]:checked + label:after {
        content: '';
        position: absolute;
        left: 6px;
        top: 3px;
        width: 6px;
        height: 11px;
        border: solid #000;
        border-width: 0 3px 3px 0;
        transform: inherit;
        z-index: 3;
        transform: rotateZ(45deg);
    }
    .custom-checkbox-myStyle input[type="checkbox"]:checked + label:before {
        border-color: #212f3d;
        background: #15528A;
    }
    .custom-checkbox-myStyle input[type="checkbox"]:checked + label:after {
        border-color: #fff;
    }
    .custom-checkbox-myStyle input[type="checkbox"]:disabled + label:before {
        color: #b8b8b8;
        cursor: auto;
        box-shadow: none;
        background: #ddd;
    }

    .custom-checkbox-myStyle input[type="checkbox"]{
        cursor: pointer;
    }

</style>


<?php

if(isset($_GET['v']) && $_GET['v'] == 'paym')
{

?>

<div class="form-group col-xs-12 col-md-12">

    <div class="table-responsive">

        <table class="table table-striped" id="pagos_planestratamiento_list" width="100%">
            <thead>
                <tr>
                    <th colspan="3">PAGOS POR PLANES DE TRATAMIENTO DE PACIENTES</th>
                </tr>
                <tr>
                    <th width="10%">COBRAR</th>
                    <th width="15%">FECHA</th>
                    <th width="30%">PLAN DE TRATAMIENTO</th>
                    <th width="20%">CITA ASOCIADA</th>
                    <th width="15%">TOTAL</th>
                    <th width="15%">REALIZADO</th>
                </tr>
            </thead>
        </table>

    </div>

</div>

<?php

}
?>


<?php

// lista de prestaciones de este plan de tratamiento cobros a realizar

 if(isset($_GET['v']) && $_GET['v'] == 'paym_pay')
 {

 ?>

     <div class="form-group col-xs-12 col-md-12 col-sm-12">
         <div class="table-responsive">
             <table class="table-striped table" id="ApagarlistPlantratmm" width="100%">

                 <thead>
                     <tr>
                         <th colspan="3">LISTA DE PRESTACIONES N. </th>
                     </tr>
                     <tr>
                         <th width="5%">
                             <span class="custom-checkbox-myStyle">
								<input type="checkbox" id="checkeAllCitas">
								<label for="checkeAllCitas"></label>
							</span>
                         </th>
                         <th width="35%">PRESTACIÓN</th>
                         <th width="10%">TOTAL</th>
                         <th width="10%">ABONADO</th>
                         <th width="10%">PENDIENTE</th>
                         <th width="10%">ESTADO</th>
                         <th width="10%">ABONAR</th>
                     </tr>
                 </thead>

                 <tfoot>
                    <tr>
                        <td colspan="5" class="text-right">&nbsp;</td>
                        <td colspan="1" class="" style="font-weight: bolder">TOTAL:</td>
                        <td colspan="1" class="text-center" style="font-weight: bolder">
                            <span id="totalPrestacion" style="padding: 5px; border-radius: 5px; padding: 5px; font-weight: bolder; background-color: #f0f0f0">0.00</span>
                        </td>
                    </tr>
                 </tfoot>

             </table>
         </div>
     </div>

     <div class="form-group col-xs-12 col-md-12">
         <div class="col-sm-6 col-xs-12 col-md-8 col-centered" >
             <h3>DATOS DE PAGOS</h3>
             <br>
             <div class="form-horizontal">

                 <div class="form-group">
                     <label for=""  class="control-label col-sm-4 col-md-4 col-xs-12">Medio de Pago:</label>
                     <div class="col-sm-5 col-md-5 col-xs-12">
                         <select id="t_pagos" class="form-control select2_max_ancho">
                             <option value=""></option>
                             <?php

                                $querypagos = "SELECT * FROM tab_tipos_pagos";
                                $rspagos = $db->query($querypagos);

                                if($rspagos && $rspagos->rowCount() > 0)
                                {
                                    while ( $pag =  $rspagos->fetchObject() )
                                    {
                                        echo "<option value='$pag->rowid'> $pag->descripcion </option>";
                                    }
                                }

                             ?>
                         </select>
                         <small style="color: red" id="err_t_pago"></small>
                     </div>
                 </div>

                 <div class="form-group">
                     <label for=""  class="control-label col-sm-4 col-md-4 col-xs-12"> № Factura / Boleta </label>
                     <div class="col-sm-5 col-md-5 col-xs-12">
                         <input type="text" id="n_factboleta" class="form-control" maxlength="11">
                     </div>
                 </div>

                 <div class="form-group">
                     <label for=""  class="control-label col-sm-4 col-md-4 col-xs-12"> Descripción ( <small>opcional</small> ) </label>
                     <div class="col-sm-5 col-md-5 col-xs-12">
                         <textarea id="descripObserv" class="form-control"></textarea>
                     </div>
                 </div>

                 <div class="form-group">
                     <label for=""  class="control-label col-sm-4 col-md-4 col-xs-12"> Monto </label>
                     <div class="col-sm-5 col-md-5 col-xs-12">
                         <label for=""  class="control-label col-sm-8 col-md-8 col-xs-12">
                             <i class="fa fa-dollar"></i> <span id="monto_pag">0.00</span>
                             <small style="color: red; display: block" id="err_monto" ></small>
                         </label>
                     </div>
                 </div>


                 <div class="form-group col-sm-12 col-md-12 col-xs-12 pull-right">
                     <a  class="btn btnhover" style="font-weight: bolder; color: green; width: 100%" id="btnApagar">Aceptar</a>
                 </div>

             </div>
         </div>
     </div>


<?php

 }

?>

