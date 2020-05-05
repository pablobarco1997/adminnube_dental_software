
<?php

    $Permissions_inicio = array(
        'url'     => DOL_HTTP .'?view=inicio',
        'Active'  => ( isset($Active) && $Active == 'inicio') ? 'Active_link' : '',
        'permiso' => '',
    );

    $Permissions_agenda = array(
        'url'     => DOL_HTTP.'/application/system/agenda/index.php?view=principal&list=diaria',
        'Active'  => ( isset($Active) && $Active == 'agenda') ? 'Active_link' : '',
        'permiso' => '',
    );

    $Permissions_pacientes = array(
        'url'     => array(
                'directorioPaciente' => DOL_HTTP.'/application/system/pacientes/directorio_paciente/index.php?view=directorio' ,
                'nuevoPaciente'      => DOL_HTTP.'/application/system/pacientes/nuevo_paciente/index.php?view=nuev_paciente'   ,
        ),
        'Active'  => ( isset($Active) && $Active == 'pacientes') ? 'Active_link' : '',
        'permiso' => '',
    );

    $Permissions_configuration = array(
        'url'     => DOL_HTTP .'/application/system/configuraciones/index.php',
        'Active'  => (isset($Active)  && $Active == 'configuraciones') ? 'Active_link' : '' ,
        'permiso' => '',
    );

    $Permissions_documentosClinicos = array(
        'url'     => DOL_HTTP .'/application/system/documentos_clinicos/index.php?view=listdocumment',
        'Active'  => (isset($Active)  && $Active == 'documento_clinicos') ? 'Active_link' : '' ,
        'permiso' => '',
    );

?>










<li class=" <?php if(isset($Active) && $Active =='inicio'){ echo 'disabled_link3'; } ?>">
    <a href="#buscarPacienteModal" data-toggle="modal"><i class="fa fa-search"></i> <span>Buscar</span></a>
</li>

<li class="<?= $Permissions_inicio['Active'] ?>">
    <a href="<?= $Permissions_inicio['url'] ?>"><i class="fa fa-dashcube"></i>
        <span>inicio</span>
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
<li class="<?= $Permissions_agenda['Active'] ?>">
    <a href="<?= $Permissions_agenda['url'] ?>">
        <i class="fa fa-list-alt"></i> <span>agenda</span>
    </a>
</li>

<!--MODULO PACIENTES-->
<li class="treeview <?= $Permissions_pacientes['Active'] ?> " style="cursor: pointer">
    <a><i class="fa fa-users"></i> <span>pacientes</span>
        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="<?= $Permissions_pacientes['url']['directorioPaciente'] ?>" >Directorio de pacientes</a></li>
        <li><a href="<?= $Permissions_pacientes['url']['nuevoPaciente'] ?>"      >Nuevo Paciente</a></li>
    </ul>
</li>

<!--MODULO DE DOCUMENTOS CLINICOS DE UN PACIENTE-->
<li class="<?= $Permissions_documentosClinicos['Active'] ?>"><a href="<?= $Permissions_documentosClinicos['url'] ?>"><i class="fa fa-file-text-o"></i><span>documentos clinicos</span></a></li>

<!--MODULO CONFIGURACIONES-->
<li class="<?= $Permissions_configuration['Active'] ?>"><a href="<?= $Permissions_configuration['url'] ?>"><i class="fa fa-wrench"></i> <span>configuraciones</span></a></li>
