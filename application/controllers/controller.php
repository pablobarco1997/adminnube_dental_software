<?php


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


function UploadFicherosLogosEntidadGlob($name, $type, $tmp_name) //Mueve los archivos a una carpeta creada
{
    global $db, $conf;

    $error = false;

    //compruebo si la carpeta exite , si no existe la creo
    if(!is_dir($conf->DIRECTORIO)){

        mkdir($conf->DIRECTORIO,0777, true);

    }

    if(!empty($type))
    {
        if(file_exists($conf->DIRECTORIO))//Si la carpeta Si exite de los logos Default
        {
            $link = $conf->DIRECTORIO.'/'.$name; //la url a donde se va a dirigir el archivo carpeta padre  /logos_icon/

            if( move_uploaded_file($tmp_name, $link) )
            {
                $error= $link;
            }else{
                $error= false;
            }
        }
    }else{
        $error= false;
    }

    return $error;
}

function getnombreUsuario($id=''){

    global $db, $conf;

    $objet = array();

    $sql  = 'select * from tab_login_users where rowid = ' .$id .' limit 1';
    $resl = $db->query($sql);
    if($resl->rowCount()>0){

        while ($ko = $resl->fetchObject()){

            $objet = $ko;
        }
    }

    return $objet;
}

function getnombreDentiste($id=''){

    global $db, $conf;

    $objeto = array();

    $sql = "SELECT * FROM tab_odontologos WHERE rowid = $id";
    $rs = $db->query($sql);

    if($rs->rowCount()>0)
    {
        while ($ob = $rs->fetchObject()){
            $objeto = $ob;
        }
    }

    return $objeto;
}


function getnombrePaciente($id=''){

    global $db, $conf;

    $objeto = array();

    $sql = "SELECT * FROM tab_admin_pacientes WHERE rowid = $id";
    $rs = $db->query($sql);

    if($rs->rowCount()>0)
    {
        while ($ob = $rs->fetchObject()){
            $objeto = $ob;
        }
    }

    return $objeto;
}

#OBTENER LA FECHA EN ESPAÑOL
function GET_DATE_SPANISH($fecha)
{

    setlocale(LC_TIME, 'es_Es');

    $mes1 =  date('m', strtotime($fecha));
    $dia1 =  date('D', strtotime($fecha));
    $year1 = date('Y', strtotime($fecha));

//    print_r($dia1); die();
    $dialabel = '';

    $dateObjm = DateTime::createFromFormat('m', $mes1 );
    $nommes = strftime('%B', $dateObjm->getTimestamp());

    switch ($dia1)
    {
        case 'Mon': #lunes
            $dialabel = 'lunes';
            break;
        case 'Tue': #martes
            $dialabel = 'martes';
            break;
        case 'Wed':#miercoles
            $dialabel = 'miercoles';
            break;
        case 'Thu':#jueves
            $dialabel = 'jueves';
            break;
        case 'Fri':#viernes
            $dialabel = 'viernes';
            break;
        case 'Sat':#sabado
            $dialabel = 'sabado';
            break;
        case 'Sun':#domingo
            $dialabel = 'domingo';
            break;
    }

    return $nommes .' '.$dialabel.' ' .date('d',strtotime($fecha)).' , '.$year1;
}

#ESTE PERMISO SIRVE PARA PERMITIR ACCEDER A CMS DE PACIENTES
function PERMISO_ACCESO_ADMIN_PACIENTES($keyGlob)
{

    if($keyGlob == md5('PASSWORD_2020_123')){

    }else{

        echo '<h1> ACCESO DENEGADO </h1>';
        die();
    }

}

#token permisos acceso
function tokenSecurityId($token){
    return bin2hex($token);
}
function decomposeSecurityTokenId($token){
    return hex2bin($token);
}

?>