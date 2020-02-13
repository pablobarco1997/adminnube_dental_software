<?php

include_once DOL_DOCUMENT .'/public/information/conneccion/connection_info.php';

if(isset($_POST['dbname']))
{


    if(isset($_POST['ajaxSend']) || isset($_GET['ajaxSend']))
    {
        $accion = GETPOST('accion');

        switch (  $accion  )
        {

        }
    }


}




?>