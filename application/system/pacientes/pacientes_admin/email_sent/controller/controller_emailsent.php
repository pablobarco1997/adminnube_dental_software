
<?php

session_start();

include_once '../../../../../config/lib.global.php';
require_once DOL_DOCUMENT .'/application/config/main.php';

global  $db , $conf;

if(isset($_GET['ajaxSend']) || isset($_POST['ajaxSend']))
{

    $accion = GETPOST('accion');

    switch ( $accion )
    {

        case 'list_mail_sent':

            $idPaciente = GETPOST('idpaciente');

            $output = [
                'data' => []
            ];

            echo json_encode($output);

            break;
    }
}

?>