
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

        case 'notification_':


            $notification = $conf->ObtnerNoficaciones($db, false);

            $info = info_noti( $notification );

//            echo '<pre>';
//            print_r($notification);
//            die();

            $output = [
              'data'   => $info ,
              'N_noti' => $notification['numero']
            ];

            echo json_encode($output);
            break;

    }

}


function info_noti( $data = array() )
{

    global $conf;

    $HTML = "";

    foreach ($data['data'] as $key => $v)
    {

        #notificaciones de citas
        if( $v->tipo_notificacion == 'NOTIFICAIONES_CITAS_PACIENTES' )
        {


            $hora_desde_A = substr($v->horaIni, 0, 5 ) ." A " . substr($v->horafin, 0, 5 ); //Corto

            $HTML_CITAS_PACIENTES = "
                                                <li style='margin-bottom: 2px; padding: 5px' class='listNotificacion' >
                                                
                                                    <div class='form-group col-md-12 col-xs-12 no-margin no-padding'>
                                                        
                                                        <div class='media' style='border-top: 1px solid #f4f4f4; padding:10px 10px'>
                                                            <a class='pull-left'> <img src='".DOL_HTTP."/logos_icon/logo_default/cita-medica.ico' class='img-rounded img-md' alt=''> </a>
                                                            <div class='media-body'>
                                                            
                                                                <div class='text-justify' style='font-size: 1.2rem;'>
                                                                    <b>Doctor -   &nbsp;</b>".(strtoupper($v->doctor_cargo))."<br>
                                                                    <b>Paciente - &nbsp;</b>".(strtoupper($v->nombe_paciente))."<br>
                                                                    <b>Fecha -    &nbsp;</b>$v->fecha<br>
                                                                    <b>Hora -     &nbsp;</b>$hora_desde_A<br>
                                                                    
                                                                    ";

            $HTML_CITAS_PACIENTES               .= ($v->comment!='')?"<b>Comentario -</b>&nbsp;&nbsp; $v->comment":"";

            $HTML_CITAS_PACIENTES .=    "
                                                                    <button class='btn-sm btn btn-block btnhover' onclick='Actulizar_notificacion_citas($v->id_detalle_cita)' style='font-weight: bolder; color: green'>EN SALA DE ESPERA</button>
                                                                </div>
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </li>
                                                
                                        ";

            $HTML .= $HTML_CITAS_PACIENTES;

        }


        #notificaiones x pacientes - confirmaciones de pacientes via email
        if( $v->tipo_notificacion == 'NOTIFICACION_CONFIRMAR_PACIENTE' )
        {
            $HTML_NOTIFICACION_X_PACIENTES_EMAIL = "
                                                <li style='margin-bottom: 2px; padding: 5px' class='listNotificacion' >
                                                    <div class='form-group col-md-12 col-xs-12 no-margin no-padding'>
                                                        <div class='media'>
                                                            <a class='pull-left'> <img src='".DOL_HTTP."/logos_icon/".$conf->NAME_DIRECTORIO."/".$v->icon_paciente."' class='img-rounded img-md' alt=''> </a>    
                                                            <div class='media-body'>
                                                                <h5 class='media-heading'>
                                                                    <b>Paciente -</b> &nbsp;&nbsp;   $v->paciente <br>
                                                                    <b>información adicional -</b> &nbsp;&nbsp;   $v->accion <br>
                                                                    <button class='btn-xs btn btn-block btnhover'  onclick='to_accept_noti_confirmpacient($v->id)' style='font-weight: bolder; color: green'>ACEPTAR</button> 
                                                                </h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            ";

            $HTML .= $HTML_NOTIFICACION_X_PACIENTES_EMAIL;
        }


    }

    return $HTML;

}


?>