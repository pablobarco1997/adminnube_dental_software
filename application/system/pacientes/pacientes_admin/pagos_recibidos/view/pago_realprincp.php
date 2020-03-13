
<?php

    $accion = "";
    if(isset($_GET['v']) && $_GET['v'] == 'pagospartic')
    {
        $accion = "pagos_particular";
    }

?>

<script>
    $accionPagospacientes = "<?= $accion ?>";
</script>

<div class="form-group col-md-12 col-xs-12">
    <label for="">LISTA DE COMPORTAMIENTOS</label>
    <ul class="list-inline" style="border-bottom: 0.6px solid #333333; padding: 3px">
        <li>
            <a href="<?= DOL_HTTP .'/application/system/pacientes/pacientes_admin/?view=pagrealipricp&key='.KEY_GLOB.'&id='. tokenSecurityId($idPaciente) .'&v=pagospartic' ?>" style="color: #333333" class="btnhover btn btn-sm " id="">
                <b>  <i class="fa fa-dollar"></i> &nbsp; Pagos Particulares </b> </a>
        </li>
        <li>
            <a href="<?= DOL_HTTP .'/application/system/pacientes/pacientes_admin/?view=pagrealipricp&key='.KEY_GLOB.'&id='. tokenSecurityId($idPaciente) .'&v=' ?>" style="color: #333333" class="btnhover btn btn-sm disabled_link3" disabled="disabled" readonly="" id="">
                <b>  <i class="fa fa-dollar"></i> &nbsp; Pagos x Financiamientos </b> </a>
        </li>
    </ul>
</div>


<!-- PAGOS PARTICULARES DEL PACIENTE -->
<?php if($accion == 'pagos_particular'){?>
    <?php  include_once 'pagos_particulares_pacit.php'; ?>
<?php }?>
