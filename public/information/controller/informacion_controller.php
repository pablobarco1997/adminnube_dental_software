

<?php

#requiero la conneccion de la entidad para verificar a que clinica pertene esta confirmacion de cita
require_once DOL_DOCUMENT.'/application/config/conneccion_entidad.php';

if(isset($_POST['ajaxSend']) || isset($_GET['ajaxSend']))
{

    switch ($_POST['accion'])
    {


    }
}

function getdateSpanish($fecha)
{

    setlocale(LC_TIME, 'es_Es');

    $mes1 =  date('m', strtotime($fecha));
    $dia1 =  date('D', strtotime($fecha));
    $year1 = date('Y', strtotime($fecha));

//    print_r($dia1); die();
    $dialabel = '';

    $dateObjm = DateTime::createFromFormat('m', $mes1 );
    $nommes = strftime('%B', $dateObjm->getTimestamp());

    switch ($dia1)
    {
        case 'Mon': #lunes
            $dialabel = 'lunes';
            break;
        case 'Tue': #martes
            $dialabel = 'martes';
            break;
        case 'Wed':#miercoles
            $dialabel = 'miercoles';
            break;
        case 'Thu':#jueves
            $dialabel = 'jueves';
            break;
        case 'Fri':#viernes
            $dialabel = 'viernes';
            break;
        case 'Sat':#sabado
            $dialabel = 'sabado';
            break;
        case 'Sun':#domingo
            $dialabel = 'domingo';
            break;
    }

    return $nommes .' '.$dialabel.' ' .date('d',strtotime($fecha)).' , '.$year1;
}

?>