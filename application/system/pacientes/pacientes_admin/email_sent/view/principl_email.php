
<?php

    $accion  = "";
    $modv    = "";


    # listpmail ==> LISTA DE MAIL VISTA PRINCIPAL
    if(isset($_GET['v']) && $_GET['v'] == "listpmail")
    {
        $accion = 'list_email';
    }


?>

<script>

    $subaccion = "<?= $accion ?>";

</script>


<!--        OPCIONES EMIL-->
<div class="form-group col-md-12 col-xs-12">

    <label for="">LISTA DE COMPORTAMIENTOS</label>
    <ul class="list-inline" style="border-bottom: 0.6px solid #333333; padding: 3px">
        <li>
            <a data-toggle="collapse" data-target="#contentFilter" class="btnhover btn btn-sm collapsed" style="color: #333333" aria-expanded="false"> <b>   ▼  Filtrar  </b>  </a>
        </li>
    </ul>

    <br>
</div>

<div class="form-group col-xs-12 col-md-12 col-lg-12 collapse" id="contentFilter" aria-expanded="false" style="height: 0px;" >
    <div class="form-group col-xs-12 col-md-4 col-sm-6">
        <label for="">Fecha - range</label>
        <div class="input-group form-group rango" style="margin: 0">
            <input type="text" class="form-control filtroFecha  " readonly="" id="startDate" value="">
            <span class="input-group-addon" style="border-radius: 0"><i class="fa fa-calendar"></i></span>
        </div>
    </div>
</div>


<?php

    # VISTAS PRINCIPALES
    if(isset($_GET['v']) && $_GET['v'] == "listpmail")
    {

        include_once 'list_emailsent.php';

    }

?>

