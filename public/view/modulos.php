
<li class=" <?php if(isset($Active) && $Active =='inicio'){ echo 'disabled_link3'; } ?>"><a href="#buscarPacienteModal" data-toggle="modal"><i class="fa fa-search"></i> <span>Buscar</span></a></li>

<li class=" <?php if(isset($Active) && $Active =='inicio'){ echo 'Active_link '; } ?>">
    <a href="<?php echo DOL_HTTP .'?view=inicio'; ?>"><i class="fa fa-home"></i>
        <span>INICIO</span>
    </a>
</li>




<!--<li  class="" ><a href="#"><i class="fa fa-link"></i> <span>Another Link</span></a></li>-->
<!--<li class="treeview">-->
<!--    <a href="#"><i class="fa fa-link"></i> <span>Multilevel</span>-->
<!--        <span class="pull-right-container">-->
<!--                <i class="fa fa-angle-left pull-right"></i>-->
<!--              </span>-->
<!--    </a>-->
<!--    <ul class="treeview-menu">-->
<!--        <li><a href="#">Link in level 2</a></li>-->
<!--        <li><a href="#">Link in level 2</a></li>-->
<!--    </ul>-->
<!---->
<!--</li>-->


<!--MODULO AGENDA-->
<li class=" <?php if(isset($Active) && $Active =='agenda'){ echo 'Active_link'; } ?>">
    <a href="<?php echo DOL_HTTP.'/application/system/agenda/index.php?view=principal&list=diaria'?>">
        <i class="fa fa-list-alt"></i> <span>AGENDA</span>
    </a>
</li>

<!--MODULO PACIENTES-->
<li class="treeview <?php if(isset($Active)  && $Active == 'pacientes'){ echo 'Active_link'; }?> " style="cursor: pointer">

    <a ><i class="fa fa-users"></i> <span>PACIENTES</span>
        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>

    <ul class="treeview-menu">

        <li><a href="<?php echo DOL_HTTP.'/application/system/pacientes/directorio_paciente/index.php?view=directorio'?>" >Directorio de pacientes</a></li>
        <li><a href="<?php echo DOL_HTTP.'/application/system/pacientes/nuevo_paciente/index.php?view=nuev_paciente'?>">Nuevo Paciente</a></li>

    </ul>

</li>

<!--MODULO CONFIGURACIONES-->

<li class=" <?php if(isset($Active)  && $Active == 'configuraciones'){ echo 'Active_link'; }?>"><a href="<?php echo DOL_HTTP.'/application/system/configuraciones/index.php'?>"><i class="fa fa-wrench"></i> <span>CONFIGURACIONES</span></a></li>
