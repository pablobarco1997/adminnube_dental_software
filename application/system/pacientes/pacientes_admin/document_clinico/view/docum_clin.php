<?php

    #Se el busca el tipo de documento selecciado que se encuentre creado

    if (isset($_GET['dt']))
    {
        if( $_GET['dt'] == '1') #DOCUMENTO CLINICO - FICHA CLINICA
        {
            include_once DOL_DOCUMENT .'/application/system/pacientes/pacientes_admin/document_clinico/form_documentos/document_ficha_clinica.php';
        }
    }

?>