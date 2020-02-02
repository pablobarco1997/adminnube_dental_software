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