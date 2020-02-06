<?php


require_once '../../application/config/lib.global.php';
require_once DOL_DOCUMENT.'/application/config/conneccion_entidad.php';
require_once DOL_DOCUMENT.'/admin_entidades_dentales/class/create_clinica.class.php';

global $dbEntidad;

$cnnEntidada = new CONECCION_ENTIDAD();
$dbEntidad   = $cnnEntidada::CONNECT_ENTITY();

if(isset($_GET['ajaxSend']) || isset($_POST['ajaxSend']))
{
    $accion = GETPOST('accion');

    switch( $accion )
    {
        case 'list_entidades':

            $respuesta  = list_entidades();

            $output = [
                'data' => $respuesta
            ];

            echo json_encode($output);
            break;

        case 'validar_clinica':

            $errores = [];
            $error   = 0;

            $nombre_clinica = GETPOST('nomb_clinica');
            $nomb_schema    = GETPOST('nomb_schema');
            $num_entidad    = GETPOST('num_entidad');

            $sqlResult   = " select * from tab_entidades_dental where nombre_db_entity = '$nomb_schema' or numero_entity = '$num_entidad' or nombre = '$nombre_clinica' ";
            $resul       = $dbEntidad->query($sqlResult);

            if($resul && $resul->rowCount() > 0)
            {

                while( $ob = $resul->fetchObject() )
                {

                    if($ob->nombre_db_entity == $nomb_schema) #nombre de la schema de la clinica
                    {
                        $errores['nomb_schema'] = 'El nombre de el schema de la clinica ya existe no puede registrar el mismo';
                        $error++;
                    }

                    if($ob->numero_entity == $num_entidad)
                    {
                        $error++;
                        $errores['num_entidad'] = 'El numero de la entidad ya existe no puede registrar el mismo';
                    }

                    if($ob->nombre == $nombre_clinica)
                    {
                        $error++;
                        $errores['nom_clinica'] = 'El nombre de la clinica ya existe no puede registrar el mismo';
                    }
                }

            }


            $output = [
                'error'     => $error,
                'respuesta' => $errores
            ];

            echo json_encode($output);
            break;


        case 'crear_clinica_dental':

            $errores = "";

            $nomb_clinica        = GETPOST('nomb_clinica');
            $nomb_schema         = GETPOST('nomb_schema');
            $nu_entity           = GETPOST('num_entidad');
            $clinicaEmail        = GETPOST('clinica_email');
            $passwordClinica     = GETPOST('password_clinica');


            #USUARIO - REGISTRO
            $nomb_usu                = GETPOST('nombre_usu');
            $apell_usu               = GETPOST('apellido_usu');
            $usurio_usu              = GETPOST('usuario_usu');
            $passwd_usu              = GETPOST('password_usu');
            $email_usuario           = GETPOST('email_usuario');


//            print_r($nomb_usu);
//            print_r($apell_usu);
//            print_r($usurio_usu);
//            print_r($passwd_usu);
//            die();

            $Clinica = new CREAR_CLINICA_DENTAL($dbEntidad);

            $Clinica->nombre_clinica     =  $nomb_clinica;
            $Clinica->nombre_schema      =  'schema_'.str_replace(' ', '_', $nomb_schema);
            $Clinica->numero_entidad     =  $nu_entity;
            $Clinica->email_clinica      =  $clinicaEmail;
            $Clinica->password_email     =  $passwordClinica;

            #PARAMETROS USUARIO
            $Clinica->usu_nombre_usuario        = $nomb_usu;
            $Clinica->usu_apellido_usuario      = $apell_usu;
            $Clinica->usu_usuario               = $usurio_usu;
            $Clinica->usu_password              = $passwd_usu;
            $Clinica->usu_email                 = $email_usuario;

            $errores = $Clinica->create_clinica();

            $output = [
                'error'     => $errores,
            ];

            echo json_encode($output);
            break;


        case 'inicio_sesion_admin':

            $errores = "";

            $usuario  = GETPOST('usuario');
            $password = GETPOST('password');

            if(isset($_SESSION['is_open']))
            {
                session_start();
                session_unset();
                session_destroy();
            }
            if(isset($_SESSION['is_open_admin']))
            {
                $errores = 'LA SESION YA ESTA INICIADA';

            }else{

                if(invalic_comparar_sesion_admin($usuario, $password) != false)
                {
                    $compare = invalic_comparar_sesion_admin($usuario, $password);

                    session_start();

                    $_SESSION['is_open_admin']  = "1";  #INICIO DE SESION CON 1

                    $_SESSION['USUARIO']        = $compare['USUARIO'];
                    $_SESSION['ESTADO_LOGIN']   = $compare['ESTADO_LOGIN'];
                    $_SESSION['PASSWORD']       = $compare['PASSWORD'];


                }else{

                    $errores = 'El usuario o password ingresados estan Incorrecto';
                }

            }

//            echo '<pre>';
//            print_r($errores);
//            die();
            $output = [
                'errores' => $errores
            ];

            echo json_encode($output);
            break;

        case 'cerrar_sesion':

            session_start();
            session_unset();
            session_destroy();

            $output = ["res" => "cerrar"];

            echo json_encode($output);
            break;


    }

}





function invalic_comparar_sesion_admin($usuario, $password)
{

    global $dbEntidad;

    $objetUsuario = array();

    $sqlComp = "SELECT s.nombre usuario, estado_login, password, password2 FROM tab_sesion_admin s where s.password = md5('$password') and s.nombre = '$usuario' limit 1";
    $rsComp  = $dbEntidad->query($sqlComp);

    if($rsComp && $rsComp->rowCount() > 0)
    {
        $ob1 = $rsComp->fetchObject();

        $objetUsuario = array(
            'USUARIO'               =>  $ob1->usuario ,
            'ESTADO_LOGIN'          =>  $ob1->estado_login ,
            'PASSWORD'              =>  $ob1->password2 ,
        );

    }else{

        return false;
    }

    return $objetUsuario;
}



function list_entidades()
{
    global $dbEntidad;

    $data = array();

    $sql = "
   SELECT
   
    e.rowid , 
	e.nombre_db_entity as db_dental  ,
    e.numero_entity as num_entidad ,
    e.nombre as nom_clinica , 
    e.direccion , 
    e.email ,
    e.pais , 
    e.ciudad , 
    e.conf_email , 
    e.conf_password 
    
    FROM tab_entidades_dental e;";

    $rs = $dbEntidad->query($sql);

    if($rs->rowCount() > 0)
    {
        while ($ob1 = $rs->fetchObject())
        {
            $row = array();

            $row[] = $ob1->num_entidad;
            $row[] = $ob1->db_dental;
            $row[] = $ob1->nom_clinica;
            $row[] = $ob1->direccion;
            $row[] = $ob1->email;
            $row[] = $ob1->pais;
            $row[] = $ob1->ciudad;

            $data[] = $row;
        }
    }

    return $data;
}












//---------------------------------------------------- o ----------------------------------------------------------------

function GETPOST($paramname, $check = '', $method = 0)
{
    if (empty($method)) $out = isset($_GET[$paramname]) ? $_GET[$paramname] : (isset($_POST[$paramname]) ? $_POST[$paramname] : '');
    elseif ($method == 1) $out = isset($_GET[$paramname]) ? $_GET[$paramname] : '';
    elseif ($method == 2) $out = isset($_POST[$paramname]) ? $_POST[$paramname] : '';
    elseif ($method == 3) $out = isset($_POST[$paramname]) ? $_POST[$paramname] : (isset($_GET[$paramname]) ? $_GET[$paramname] : '');
    else return 'BadParameter';

    if (!empty($check)) {
        // Check if numeric
        if ($check == 'int' && !preg_match('/^[-\.,0-9]+$/i', $out)) {
            $out = trim($out);
            $out = '';
        } // Check if alpha
        elseif ($check == 'alpha') {
            $out = trim($out);
            // '"' is dangerous because param in url can close the href= or src= and add javascript functions.
            // '../' is dangerous because it allows dir transversals
            if (preg_match('/"/', $out)) $out = '';
            else if (preg_match('/\.\.\//', $out)) $out = '';
        } elseif ($check == 'array') {
            if (!is_array($out) || empty($out)) $out = array();
        }
    }

    return $out;
}
?>