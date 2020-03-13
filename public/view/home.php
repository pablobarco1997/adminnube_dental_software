
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
                               <div class="input-group">
                                   <input type="search" autocomplete="off" onfocus="InputSearcheIndex_1(this)" class="form-control" name="myCountry" id="myInput" placeholder="Buscar pacientes" aria-describedby="basic-addon2">
                                   <span class="input-group-addon" id="basic-addon2"><i class="fa fa-search"></i></span>
                                   <span style="display: none" id="pacien"></span>
                               </div>
                           </div>

                           <div class="form-group">
                               <button class="btn btnhover btn-block" style="color:  green; font-weight: bolder" id="buscarPaciente">Aplicar</button>
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
                                   <span class="info-box-number" id="nu_paciente">410</span>
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
