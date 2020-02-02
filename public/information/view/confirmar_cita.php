

<?php

    include_once DOL_DOCUMENT .'/public/information/controller/informacion_controller.php';


    $fecha = getdateSpanish( date('Y-m-d') );

//    echo date('D', strtotime('2019-11-10'));
//    die();
?>

<style>

    .informacion-cita{
        -webkit-box-shadow: 3px 3px 5px 0px rgba(115,110,115,1);
        -moz-box-shadow: 3px 3px 5px 0px rgba(115,110,115,1);
        box-shadow: 3px 3px 5px 0px rgba(115,110,115,1);
        width: 100%;
        padding: 20px;
    }

</style>


<div class="center-block" style="width: 450px; margin-top: 3%">
    <div class="form-group">
        <div class="informacion-cita">
            <h3 class="text-center">Datos de la cita </h3>
            <p class="alert bg-info">la confirmacion de la cita solo es valida para esta fecha</p>
            <p class="alert bg-warning"><?= $fecha; ?></p>
            <hr>

            <p class="text-center">
                <img width="80%" height="80%" class="text-center" src="https://img2.freepng.es/20190511/iug/kisspng-portable-network-graphics-calendar-date-total-acce-musicalfactory-64853-webseite-des-projekts-titan-5cd709349efb66.5865115115575964686512.jpg" alt="">
            </p>


           <div class="row">
               <div class="col-md-12">
                   <button class="btn-success btn" style="float: left"> <i class="fa fa-check"></i> Confirma cita (si, asiste)</button>
                   <button class="btn-danger btn" style="float: right">No asiste (no, pudo asistir)</button>
               </div>
           </div>

        </div>
    </div>
</div>
