<?php
#FUNCIONES ESPECIALES JAVASCRIP

switch ($VISTAS)
{
    case 'arch': #Modulo Ficheros
        echo "<script src='".DOL_HTTP."/application/system/pacientes/pacientes_admin/archivos_ficheros/js/input_file.js'></script>";
        break;

    case 'plantram': #mod Plan tratamiento

        echo '<script src="'.DOL_HTTP.'/application/system/pacientes/pacientes_admin/plan_tratamiento/js/plant2.js"></script>';

        if(isset($_GET['v']) && $_GET['v'] == 'planform')
        {
            echo '<script src="'.DOL_HTTP.'/application/system/pacientes/pacientes_admin/plan_tratamiento/js/plant3.js"></script>';
        }

        break;

    case 'odot': #Odontograma

        if(isset($_GET['v']) && $_GET['v'] == 'fordont') #FORMULARIO DE ODONTOGRAMA
        {
            echo '<script src="'.DOL_HTTP.'/application/system/pacientes/pacientes_admin/odontograma_paciente/js/fetch_odontograma_paint.js"></script>';
            echo '<script src="'.DOL_HTTP.'/application/system/pacientes/pacientes_admin/odontograma_paciente/js/odont2.js"></script>';
        }

        break;

    case 'docummclin':#documentos clinicos del paciente

        if(isset($_GET['v']) && isset($_GET['dt'])) #documentos Clinicos
        {
            if($_GET['v'] == "docum_clin")
            {
                if($_GET['dt']=="1") #FICHA CLINICA
                {
                    echo '<script src="'.DOL_HTTP.'/application/system/pacientes/pacientes_admin/document_clinico/js/document_ficha_clinica.js"></script>';
                }
            }

        }

        break;

    case 'pagospaci':

        //COBRAR PAGOS INDEPENDIENTES
        if(isset($_GET['v']) && $_GET['v'] == 'paym_pay')
        {
            echo '<script src="'.DOL_HTTP.'/application/system/pacientes/pacientes_admin/pagos_pacientes/js/pay_independiente.js" ></script> ';
        }

        break;
}
?>


<script src="<?= DOL_HTTP.'/application/system/pacientes/pacientes_admin/'.$DIRECTORIO_ADMIN.'/js/'.$_JS_DOCMENT.'.js' ?>"></script>
