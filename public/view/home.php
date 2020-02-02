
<div class="row">
        <div class="col-md-12 col-xs-12">

           <div class="box box-solid">

               <div class="box-header with-border">
                   <h3>Inicio</h3>
               </div>

               <div class="box-body">

                   <div class="center-block" style="width: 50%">
                       <div class="autocomplete">
                           <div class="input-group">
                               <input type="search" autocomplete="off" onfocus="InputSearcheIndex_1(this)" class="form-control" name="myCountry" id="myInput" placeholder="Buscar pacientes..." aria-describedby="basic-addon2">
                               <span class="input-group-addon" id="basic-addon2"><i class="fa fa-search"></i></span>
                               <span style="display: none" id="pacien"></span>
                           </div>
                           <br>
                           <button class="btn btn-block" id="buscarPaciente">Buscar</button>
                       </div>
                   </div>

               </div>

               <?php
               /*
               global $conf, $user;
               echo '<pre>';
                    print_r($conf);
                    echo '<pre>';
                    print_r($user);*/

               ?>
           </div>

        </div>
 </div>
