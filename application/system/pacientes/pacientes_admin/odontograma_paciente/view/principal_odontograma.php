
<?php

    $idOdontograma = "";
    $view          = "";
    $v             = "";

    #LISTA DE PRINCIPAL
    if(isset($_GET['v']) && $_GET['v'] == 'listp')
    {
        $view  = "principal";
        $v     = $_GET['v'];
    }

    #ACTUALIZAR ODONTOGRAMA
    if(isset($_GET['v']) && $_GET['v'] == 'fordont')
    {
        $v        = $_GET['v'];
        $view     = "form_odont";
    }

?>


<script>

    $accionOdontograma = "<?= $view ?>";

</script>

<div class="form-group col-md-12 col-xs-12">

<!--    LISTA DE ODONTOGRAMA-->
    <?php if($v == "listp"){  ?>

<!--        OPCIONES ODONTOGRAMA-->
        <div class="form-group col-md-12 col-xs-12">
            <ul class="list-inline">
                <li><a href="#" class="btnhover btn btn-sm " id="createOdontograma"> <b>  <img  src=" <?= DOL_HTTP .'/logos_icon/logo_default/diente.png';?>" width="12px" height="14px" alt="">
                            Crear Odontograma  </b> </a>
                </li>
            </ul>
        </div>


<!--        LISTA DE ODONTOGRAMA-->
        <div class="form-group col-md-12 col-xs-12">
            <div class="table-responsive">
                <table class="table dataTable" id="odontPLant" width="100%">
                    <thead>
                        <tr>
                            <th WIDTH="10%">FECHA</th>
                            <th WIDTH="20%">NÚMERO</th>
                            <th WIDTH="30%">DESCRIPCIÓN</th>
                            <th WIDTH="20%">PLAN DE TRATAMIENTO</th>
                            <th WIDTH="20%"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    <?php } ?>


<!--    FORMULARIO ODONTOGRAMA-->

    <?php if($v == 'fordont'){?>

        <div class="form-group col-md-12 col-xs-12">

            <?php include_once DOL_DOCUMENT .'/application/system/pacientes/pacientes_admin/odontograma_paciente/view/picture_piezas_odontograma.php'; ?>

        </div>

    <?php } ?>
</div>