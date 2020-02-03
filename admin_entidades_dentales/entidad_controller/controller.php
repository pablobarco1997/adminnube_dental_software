<?php


require_once '../../application/config/lib.global.php';
require_once DOL_DOCUMENT.'/application/config/conneccion_entidad.php';


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
    }

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