
<?php

session_start();

require_once '../config/lib.global.php';
require_once DOL_DOCUMENT.'/application/config/main.php';

global $db, $conf;

if(isset($_GET['ajaxSend']) || isset($_POST['ajaxSend']))
{
    $accion = GETPOST("accion");

    switch($accion)
    {
        case "UpdateEntidad":


            $logo            = "";
            $type            = "";
            $name_fichero    = "";
            $link            = false;

            if(isset($_FILES["logo"]))
            {
                $logo = $_FILES["logo"];

                switch ($logo["type"])
                {
                    case "image/jpeg":
                        $type = ".jpeg";
                        break;

                    case "image/png":
                        $type = ".png";
                        break;
                }

                $tmp_name          =  $logo["tmp_name"];
                $name_fichero = "entidad_logo_".$conf->EMPRESA->ID_ENTIDAD."_".$conf->EMPRESA->ENTIDAD."".$type;
                $link = UploadFicherosLogosEntidadGlob($name_fichero,$type,$tmp_name);

            }

            $clinica      = GETPOST("nombre");
            $pais         = GETPOST("pais");
            $ciudad       = GETPOST("ciudad");
            $direccion    = GETPOST("direccion");
            $telefono     = GETPOST("telefono");
            $celular      = GETPOST("celular");
            $email        = GETPOST("email");

            #configuracion de acceso de email
            $conf_email    = GETPOST('conf_emil');
            $conf_password = GETPOST('conf_password');


            $UpdateEntidad = new CONECCION_ENTIDAD();

            #SE ACTUALIZA LA ENTIDAD DE LA EMPRESA
            $rs = $UpdateEntidad
                ::UPDATE_ENTIDAD(
                        $clinica,
                        $direccion,
                        $telefono,
                        $celular,
                        $email,
                        $name_fichero,
                        $pais,
                        $ciudad,
                        $conf->EMPRESA->ID_ENTIDAD,
                        $conf_email,
                        $conf_password
                );

            if($rs == 0) //No se Update
            {
                if($link != false) //Si el link me retorna un false entonces se envia
                {
                    unlink($link);
                }
            }

            $output = [
                'error' => $rs,
                'link'  => $link
            ];

            echo json_encode($output);

            break;


            case 'fetch_paciente':

                $sql    = "SELECT count(*) as fetchpaciente FROM tab_admin_pacientes WHERE estado = 'A'";
                $resul  = $db->query($sql)->fetchObject();

                $output = [
                    'fetchNumero' => $resul->fetchpaciente,
                ];

                echo json_encode($output);
                break;


        case 'accept_noti_confirm_pacient':

            $error = "";

            $id = GETPOST('id');

            $query = "UPDATE `tab_noti_confirmacion_cita_email` SET `noti_aceptar`='1' WHERE `rowid`= $id;";
            $rs = $db->query($query);
            if(!$rs){
                $error = 'Ocurrio un error';
            }

            $output = [
                'error' => $error,
            ];

            echo json_encode($output);
            break;

    }

}

?>