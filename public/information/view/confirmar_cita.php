

<?php

    include_once DOL_DOCUMENT .'/public/information/controller/informacion_controller.php';

    $fecha = GET_DATE_SPANISH( date('Y-m-d') );

    $objPacienteInfo = [];

    if(isset($_GET['token']))
    {
        $objPacienteInfo = json_decode(decomposeSecurityTokenId($_GET['token']));
    }

//    echo '<pre>';
//    print_r($objPacienteInfo); die();

?>

<style>

    .insetbox-body{
        -webkit-box-shadow: inset 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
        -moz-box-shadow: inset 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
        -ms-box-shadow: inset 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
        -o-box-shadow: inset 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
        box-shadow: inset 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
        padding: 15px;
    }

</style>

<?php if(isset($_GET['token'])) { ?>

<div class="container">
    <div class="form-group col-md-12 col-xs-12">
        <div class=" col-centered col-xs-12 col-md-8 col-sm-8  " >
            <div class="noti_content"  style="margin-top: 15%; width: 100%">
                <div class="page-header" style="padding-left: 7px; background-color: #2980B9; margin-bottom: 0px; border: none!important; ">
                    <ul class="list-inline" style="margin-bottom: 0px !important;">

                        <li style="width: 20%"><img class="img-rounded"  src="<?= DOL_HTTP .'/logos_icon/icon_logos_'.$objPacienteInfo->entity.'/'.$objPacienteInfo->logo ;?>"
                                  alt="icon_clinica" style="width: 60px; height: 60px; background-color: #ffffff">
                        </li>

                        <li style="width: 60%">  <h3 class="text-center" style="font-weight: bolder; color: #ffffff; margin-top: 25px"><?= $objPacienteInfo->name_clinica ?></h3></li>
                    </ul>
                </div>
                <div class="form-group col-md-12 col-xs-12 insetbox-body" style="background-color: #7FB3D5">

                    <div class="form-group col-md-12 col-xs-12">
                        <div class="col-centered col-md-3 col-sm-4 col-xs-6">
                            <img src="<?= DOL_HTTP .'/logos_icon/logo_default/campana.png' ?>" class=" " style="width: 100%; height: 100%;" alt="">
                        </div>
                    </div>

                    <div class="form-group col-xs-12 col-md-12">
                        <p class="text-center"> RECORDATORIO DE CITA - <b> ¿ CONFIRMAR CITA ?</b> </p>
                    </div>

                    <div class="form-group col-xs-12 col-md-12">
                        <ul style="list-style: none">
                            <li><b> <img src="<?= DOL_HTTP .'/logos_icon/logo_default/icon_def_correo.png'?>" style="width: 20px ; height: 20px ;" alt=""> &nbsp; E-mail: &nbsp;</b> <?= $objPacienteInfo->email ?>   </li>
                            <li>&nbsp;</li>
                            <li><b> <img src="<?= DOL_HTTP .'/logos_icon/logo_default/icon_def_llamar.png'?>" style="width: 20px ; height: 20px ;" alt="">  &nbsp; Cel: &nbsp;</b> <?= $objPacienteInfo->celular ?> </li>
                        </ul>
                    </div>

                    <div class="form-group col-xs-12  col-md-6 col-sm-12" style="margin-top: 25px!important;">
                        <a  class=" action-button animate-buton blue" style="font-weight: bolder; text-align: center" >CONFIRMAR CITA ( <i class="fa fa-check-circle"></i> )</a>
                    </div>

                    <div class="form-group col-xs-12  col-md-6 col-sm-12" style="margin-top: 25px!important;">
                        <a  class=" action-button animate-buton red" style="font-weight: bolder; float: right" >NO ASISTIR ? ( x )</a>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<?php } ?>


<script>




</script>
