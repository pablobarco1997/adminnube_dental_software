

<?php

    if( isset($_GET['view']))
    {

        if( $_GET['view'] == 'inicio')
        {


?>

<style>

    .searchHome{
        width: 100% !important;
        border: 0;
    }

    .searchHome:focus{
        outline: 0;
        outline: none;
    }

</style>


<div class="row">
        <div class="col-md-12 col-xs-12">

           <div class="box box-solid">

               <div class="box-header with-border">
                   <h3>Inicio</h3>
               </div>

               <div class="box-body">

                   <div class="form-group col-xs-12 col-md-12 col-lg-12">

                       <div class="form-group col-md-8 col-lg-8 col-sm-8 ol-xs-12 col-centered" >

                           <div class="autocomplete form-group">
                               <br>
                               <label for="busquedaPaciente">BUQUEDA DE PACIENTES &nbsp; <i class="fa fa-search"></i> </label>
                               <small style="display: block; color: #212f3d" > Puede seleccionar por tipos filtro de busqueda cedula - nombre - apellido</small>
                               <div class="radio">
                                   <label>
                                       <input type="radio" name="rdbusqPaciente" id="rd_nombre" value="nombre" >
                                       <small> nombre </small>
                                   </label>
                                   <label>
                                       &nbsp;&nbsp;&nbsp;&nbsp;
                                       <input type="radio" name="rdbusqPaciente" id="rd_apellido" value="apellido">
                                       <small> apellido </small>
                                   </label>
                                   <label>
                                       &nbsp;&nbsp;&nbsp;&nbsp;
                                       <input type="radio" name="rdbusqPaciente" id="rd_cedula" value="cedula" >
                                       <small> cedula </small>
                                   </label>
                               </div>
                               <input type="text"   onkeyup="aplicasearchpaciente($(this))"  class=" searchHome seachPacienteHome" name="" id="busquedaPaciente" placeholder="Ingrese 5 carateres para iniciar la busqueda" aria-describedby="basic-addon2">
<!--                               <div class="input-group">-->
<!--                                   <span class="input-group-addon" id="basic-addon2"><i class="fa fa-search"></i></span>-->
                               <span style="display: none" id="idpacienteAutocp"></span>
<!--                               </div>-->
                           </div>

                           <div class="form-group">
                               <button class="btn btnhover btn-block" style="color:  green; font-weight: bolder" id="buscarPaciente">Buscar</button>
                           </div>

                       </div>


                       <br>
                       <!--                           FILTRO DE FECHA -->
                       <div class="form-group col-md-8 col-lg-8 col-sm-12 col-xs-12 col-centered">
                           <label for="">Fecha - Rango</label>
                           <div class="input-group form-group rango" style="margin: 0">
                               <input type="text" class="form-control filtroFecha  " id="startDate" value="" readonly>
                               <span class="input-group-addon" style="border-radius: 0"><i class="fa fa-calendar"></i></span>
                           </div>
                       </div>

                   </div>


<!--                   DESBOARH-->


                   <div class="form-group col-xs-12 col-md-12 col-lg-12">

                       <br><br>
                       <div class="col-md-3 col-sm-6 col-xs-12">
                           <div class="info-box">
                               <span class="info-box-icon bg-green">
                                   <i class="fa fa-user"></i>
                               </span>
                               <div class="info-box-content">
                                   <span class="info-box-text">PACIENTES REGISTRADOS</span>
                                   <span class="info-box-number" id="nu_paciente"></span>
                               </div><!-- /.info-box-content -->
                           </div><!-- /.info-box -->
                       </div>

                   </div>

               </div>

               <?php

//               global $conf, $user;
//               echo '<pre>';
//                    print_r($conf);

               ?>
           </div>

        </div>
 </div>

<?php

        }else{

            echo "
            <div class='row'>
                <div class='col-md-8 col-xs-8 col-centered'>
                    <h3 style='font-weight: bolder'>Ocurrio un error no se encontro la vista de inicio</h3>
                </div>                
            </div>";

        }

    }else{


        echo "
            <div class='row'>
                <div class='col-md-8 col-xs-8 col-centered'>
                    <h3 style='font-weight: bolder'>Ocurrio un error no se encontro la vista de inicio</h3>
                </div>                
            </div>";

    }

?>