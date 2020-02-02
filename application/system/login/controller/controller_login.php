<?php

require_once '../../../controllers/controller.php';
require_once '../../../config/conneccion_entidad.php';
require_once '../../../config/lib.global.php';
require_once '../../conneccion/conneccion.php';

//controllers
if(isset($_POST['ajaxSend']) || isset($_GET['ajaxSend']))
{
    $accion = GETPOST('accion');

    switch ($accion)
    {
        case 'logearse':

            $r = "";
            if(isset($_SESSION['is_open']))
            {
                $r="SesionIniciada"; //se verifica si la sesion esta iniciada
            }
            else {

                $usuario  = GETPOST('usua'); //Usuario
                $password = GETPOST('pass'); //password

                $respuesta = concretar_validacion_usuario_coneccion_entidad($usuario, $password); //OBTENGO LA INFORMACION DE LA ENTIDAD

                if (trim($respuesta['mess']) == trim("ConeccionExitosaEmpresaEncontrada"))
                {
                    $coneccion_entity = new ObtenerConexiondb();
                    $sql = "SELECT * FROM tab_login_users lg , tab_odontologos o where lg.fk_doc = o.rowid and usuario = '$usuario' and passwords = md5('$password') and lg.estado = 'A' limit 1";
                    $rs = $coneccion_entity::conectarEmpresa($respuesta['nombreDataBase'])->query($sql);

                    if ($rs->rowCount() > 0)
                    {

                        session_start();

                        $row = $rs->fetchObject();

                        $_SESSION['is_open'] = true;
                        $_SESSION['id_user'] = $row->fk_doc; //usuario de sesion es el doctor del usuario
                        $_SESSION['db_name'] = $respuesta['nombreDataBase'];
                        $_SESSION['usuario'] = $usuario;
                        $_SESSION['entidad'] = $respuesta['entity'];


                        $_SESSION['id_Entidad']             = $respuesta['id_Entidad'];
                        $_SESSION['nombreClinica']          = $respuesta['nombreClinica'];
                        $_SESSION['direccionClinica']       = $respuesta['direccionClinica'];
                        $_SESSION['telefonoClinica']        = $respuesta['telefonoClinica'];
                        $_SESSION['celularClinica']         = $respuesta['celularClinica'];
                        $_SESSION['emailClinica']           = $respuesta['emailClinica'];
                        $_SESSION['logoClinica']            = $respuesta['logoClinica'];
                        $_SESSION['login_entidad']          = $respuesta['login_entidad'];

                        if (isset($_SESSION['db_name']) && isset($_SESSION['usuario']) && isset($_SESSION['id_user'])) {

                            $r = "SesionIniciada";

                        } else {

                            $r = "ErrorSesion";

                        }

                    }else {
                        $r = "ErrorSesion";
                    }

                }else{
                    $r = "ErrorSesion";
                }
            }

            $output = [
                'error' => $r
            ];

            echo json_encode($output);
            break;

        case 'CerraSesion':

            session_start();
            session_unset(); //borra los valores de las sessiones
            session_destroy(); //destrulle la session

            if(!isset($_SESSION['is_open']))
            {
                header('location:'.DOL_HTTP.'/application/system/login');
//                header('location:'.'http://192.168.0.108/dental'.'/application/system/login');
            }

            break;
    }
}
function concretar_validacion_usuario_coneccion_entidad($user, $pass)
{
    $ver = ""; /*mensaje*/


    /*informacion global*/
    $id_Entidad         = "";
    $nombreDataBase     = "";
    $entity             = "";
    $nombreClinica      = "";
    $direccionClinica   = "";
    $telefonoClinica    = "";
    $celularClinica     = "";
    $emailClinica       = "";
    $logoClinica        = "";

    $login_entidad        = "";

    $con1 = new CONECCION_ENTIDAD(); //ME CONECTO CON LA ENTIDAD



    $sql = "SELECT * FROM tab_login_entity WHERE nombre_user = '$user' and password_user = md5('$pass') and estado = 'A' limit 1";
    $resp = $con1::CONNECT_ENTITY()->query($sql);

    if($resp)
    {
        if($resp->rowCount() > 0)
        {
            $ver = trim("ConeccionExitosaEmpresaEncontrada");

            while ($row = $resp->fetchObject())
            {
                $sql2 = "SELECT * FROM tab_entidades_dental where rowid = $row->fk_entidad limit 1;";
                $r = $con1::CONNECT_ENTITY()->query($sql2);

                if($r->rowCount() > 0)
                {
                    $fil               = $r->fetchObject();
                    $id_Entidad        = $fil->rowid;

                    $nombreDataBase    = $fil->nombre_db_entity;
                    $entity            = $fil->numero_entity;
                    $nombreClinica     = $fil->nombre;
                    $direccionClinica  = $fil->direccion;
                    $telefonoClinica   = $fil->telefono;
                    $celularClinica    = $fil->celular;
                    $emailClinica      = $fil->email;
                    $logoClinica       = $fil->logo;

                    $login_entidad     = $row->rowid;  //ID LOGIN ENTIDAD
                }

            }
        }
    }


    $respto = [
        'mess'                  => $ver,
        'id_Entidad'            => $id_Entidad,
        'nombreDataBase'        => $nombreDataBase,
        'entity'                => $entity,
        'nombreClinica'         => $nombreClinica,
        'direccionClinica'      => $direccionClinica,
        'telefonoClinica'       => $telefonoClinica,
        'celularClinica'        => $celularClinica,
        'emailClinica'          => $emailClinica,
        'logoClinica'           => $logoClinica,

        'login_entidad'         => $login_entidad,
    ];

    return $respto;
}
?>