<?php



    $fecha = GET_DATE_SPANISH( date('Y-m-d') );

    $objPacienteInfo = [];

    if(isset($_GET['token']))
    {
        $objPacienteInfo = json_decode(decomposeSecurityTokenId($_GET['token']));
    }

    $name_db_entity = $objPacienteInfo[1];  #nombre de la entidad a conectar
    $id_citadet     = $objPacienteInfo[0];  #id de la cita detalle

    $db_encrytp = tokenSecurityId($name_db_entity); #NAME DATA BASE ENCRIPTADO

    #echo '<pre>'; print_r($objPacienteInfo); die();
?>

<style>

    .insetbox-body{
        -webkit-box-shadow: inset 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
        -moz-box-shadow: inset 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
        -ms-box-shadow: inset 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
        -o-box-shadow: inset 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
        box-shadow: inset 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
        padding-top: 15px;
    }

    #swal2-content{
        font-size: 1.6rem !important;
    }

</style>

<?php if(isset($_GET['token'])) { ?>

<div class="container">
    <div class="form-group col-md-12 col-xs-12">
        <div class=" col-centered col-xs-12 col-md-8 col-sm-8  " >
            <div class="noti_content"  style="margin-top: 7%; width: 100%">
                <div class="page-header" style="padding-left: 7px; background-color: #2980B9; margin-bottom: 0px; border: none!important; ">
                    <ul class="list-inline" style="margin-bottom: 0px !important;">

                        <li style="width: 20%"><img class="img-rounded"  src="<?= DOL_HTTP .'/logos_icon/icon_logos_'.$objPacienteInfo[2] .'/'.$objPacienteInfo[4] ;?>"
                                  alt="icon_clinica" style="width: 60px; height: 60px; background-color: #ffffff">
                        </li>

                        <li style="width: 60%">  <h3 class="text-center" style="font-weight: bolder; color: #ffffff; margin-top: 25px"><?= $objPacienteInfo[3] ?></h3></li>
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

                    <div class="form-group col-xs-12 col-md-12 col-sm-12" style="text-align: justify; overflow-y: auto">
                        <hr>
                    </div>

                    <div class="row">
                        <div class="form-group col-xs-12  col-md-6 col-sm-12" style="margin-top: 25px!important;">
                            <a  class=" action-button animate-buton blue" id="asistir" style="font-weight: bolder; float: left" onclick="ConfirmarCitasAsistir()">ASISTIR </a>
                        </div>

                        <div class="form-group col-xs-12  col-md-6 col-sm-12" style="margin-top: 25px!important;">
                            <a  class=" action-button animate-buton red" id="no_asistir" style="font-weight: bolder; float: right" >NO ASISTIR</a>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

<?php } ?>


<script>

    $dbname = "<?= $db_encrytp ?>";

    function ConfirmarCitasAsistir()
    {

        $.ajax({

            url: "<?= DOL_HTTP ?>" + '/public/information/controller/informacion_controller',
            type:"POST",
            data:{
                'ajaxSend': 'ajaxSend',
                'accion'  : 'asistir_confim',
                'dbname'  : $dbname,
                'idcita'  : "<?= $id_citadet ?>",
            },
            dataType:'json',
            success: function(resp){


                if(resp.error.toString() == "")
                {
                    Swal.fire(
                        'Exito!',
                        'Información Actualizada',
                        'success'
                    );

                }else{

                    Swal.fire(
                        'Oops!',
                         resp.error,
                        'error'
                    );
                }
            }

        });
    }

</script>
