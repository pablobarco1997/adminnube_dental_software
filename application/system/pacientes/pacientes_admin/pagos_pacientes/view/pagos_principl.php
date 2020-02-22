
<?php

$accionPag = "";

if(isset($_GET['v'])){

    if($_GET['v'] == 'paym'){

        $accionPag = "pagos_independientes";

    }

    if($_GET['v'] == 'paym_pay'){

        $accionPag = "cobros_independientes";

    }

}
?>

<script>

    $accionPagos = "<?= $accionPag ?>";

</script>



<div class="form-group col-xs-12 col-md-12">

    <div class="form-group col-md-12 col-xs-12">
        <label for="">LISTA DE COMPORTAMIENTOS</label>
        <ul class="list-inline" style="border-bottom: 0.6px solid #333333; padding: 3px">
            <li>
                <a href="<?= DOL_HTTP .'/application/system/pacientes/pacientes_admin/?view=pagospaci&key='.KEY_GLOB.'&id='. tokenSecurityId($idPaciente) .'&v=paym' ?>" style="color: #333333" class="btnhover btn btn-sm " id=""> <b>  <i class="fa fa-dollar"></i> &nbsp; Pagos </b> </a>
            </li>
            <li>
                <a href="<?= DOL_HTTP .'/application/system/pacientes/pacientes_admin/?view=pagospaci&key='.KEY_GLOB.'&id='. tokenSecurityId($idPaciente) .'&v=paym_financier' ?>" style="color: #333333" class="btnhover btn btn-sm " id=""> <b>  <i class="fa fa-dollar"></i> &nbsp; Pagos Financieros </b> </a>
            </li>
        </ul>
    </div>


    <?php

    if(isset($_GET['v']))
    {
        #Manega dos vista lista de pagos donde muestra los planes de tratamientos => paym
        #Manega dos vista lista de las prestaciones realizadas de ese planes de tratamientos => paym_pay
        if($_GET['v'] == 'paym' || $_GET['v'] == 'paym_pay')
        {

            include_once 'pagos_independientes.php';
        }

//        ----------   o  -------------

        if($_GET['v'] == 'paym_financier'  )
        {
            include_once 'pagos_financieros.php';
        }

        if( $_GET['v'] != 'paym' && $_GET['v'] != 'paym_financier' && $_GET['v'] != 'paym_pay')
        {
            echo '<h1 style="color: red">Ocurrio un error no se encontro la vista a consultar - <b>NO TIENE ACCESO A ESTA VISTA</b></h1>';
            die();
        }

    }


    ?>

</div>

<script>
    //OBTENER EL ID DE UNA URL CON JQUERY         ---------------------------------------- --------------------------------
    function Get_jquery_URL(Getparam)
    {
        let paramsGet = new URLSearchParams(location.search);
        var idGetUrl = paramsGet.get(Getparam);

        return idGetUrl;
    }
</script>