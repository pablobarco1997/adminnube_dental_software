<?php

session_start();

require_once '../../../../config/lib.global.php';
require_once DOL_DOCUMENT .'/application/config/main.php';
require_once DOL_DOCUMENT .'/application/system/pacientes/class/class_paciente.php';

if(isset($_GET['ajaxSend']) || isset($_POST['ajaxSend']))
{
    $accion = GETPOST('accion');

    switch($accion)
    {
        case 'nuew_paciente':

            $paciente = new Pacientes($db);

            $datos = GETPOST('datos');

            $paciente->nombre       = $datos['nombre'];
            $paciente->apellido     = $datos['apellido'];
            $paciente->rud_dni      = $datos['rud_dni'];
            $paciente->email        = $datos['email'];
            $paciente->convenio     = $datos['convenio'];
            $paciente->n_interno    = $datos['n_interno'];
            $paciente->sexo         = $datos['sexo'];
            $paciente->fech_nacimit = $datos['fech_nacimit'];
            $paciente->ciudad       = $datos['ciudad'];
            $paciente->comuna       = $datos['comuna'];
            $paciente->direcc       = $datos['direcc'];
            $paciente->t_fijo       = $datos['t_fijo'];
            $paciente->t_movil      = $datos['t_movil'];
            $paciente->act_profec    = $datos['act_profec'];
            $paciente->empleado      = $datos['empleado'];
            $paciente->obsrv         = $datos['obsrv'];
            $paciente->refer         = $datos['refer'];

            $res = $paciente->create_paciente();

            $output = [
                "error" => $res
            ];

            echo json_encode($output);
            break;
    }

}
?>