
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

<!--    LISTA DE ODONTOGRAMA PRINCIPAL -->
    <?php if($v == "listp"){  ?>

<!--        OPCIONES ODONTOGRAMA-->
        <div class="form-group col-md-12 col-xs-12">
            <label for="">LISTA DE COMPORTAMIENTOS</label>

            <ul class="list-inline" style="border-bottom: 0.6px solid #333333; padding: 3px">

                <li>
                    <a href="#add_odontograma" data-toggle="modal" class="btnhover btn btn-sm " style="color: #333333" id="createOdontograma"> <b> &nbsp;&nbsp; <img  src=" <?= DOL_HTTP .'/logos_icon/logo_default/diente.png';?>" width="12px" height="14px" alt="">
                            Crear Odontograma  </b> </a>
                </li>

            </ul>

            <br>
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

        <?php include_once 'add_odontograma_modal.php'; ?>

    <?php } ?>


<!--    FORMULARIO ODONTOGRAMA-->

    <?php if($v == 'fordont'){?>

        <div class="form-group col-md-12 col-xs-12">

            <?php include_once DOL_DOCUMENT .'/application/system/pacientes/pacientes_admin/odontograma_paciente/view/picture_piezas_odontograma.php'; ?>

            <br>

            <?php include_once DOL_DOCUMENT .'/application/system/pacientes/pacientes_admin/odontograma_paciente/view/odontogram_tram_form.php'; ?>

        </div>

    <?php } ?>
</div>
