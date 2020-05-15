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


function ConfirmacionEmailHTML($token)
{
    $Url_ConfirmCita = DOL_HTTP .'/public/information/?v=confirm_cita&token='.$token;

    $buttonToken = '';
    $buttonToken .= '
            
    <div style=\'width: 100%\'>
            <a href='. $Url_ConfirmCita .' style="
                position: relative;
                padding: 10px 40px;
                margin: 0px 10px 10px 0px;
                border-radius: 3px;
                /*font-family: \'Lato\', sans-serif;*/
                font-size: 1.4rem;
                color: #FFF;
                text-decoration: none; 
                
                background-color: #3498db;
                border-bottom: 5px solid #2980B9;
                text-shadow: 0px -2px #2980B9;
                cursor: pointer;
            ">CONFIRMAR CITA &nbsp;&nbsp; <i class="fa fa-bell-o"></i> </a>
    </div>';

    return $buttonToken;
}

function Breadcrumbs_Mod( $titulo, $url, $module )
{


    $Breadcrumbs_Mod = array();
    $Breadcrumbs = "";
    $htmlBreadcrumbs = "";
    $CountBread = 0;

    #cuando sea el modulo principal
    if( $module == true){

        $_SESSION['breadcrumbsAcu'] = 0;
        $_SESSION['breadcrumbs'] = array();
        $_SESSION['breadcrumbs'][] = array( 'url' => $url , 'titulo' => $titulo );
        $Breadcrumbs_Mod = $_SESSION['breadcrumbs'];

    }else{

        #cuando sea varios modulos
        if(is_array($_SESSION['breadcrumbs']) && count($_SESSION['breadcrumbs']) > 0){

            foreach ($_SESSION['breadcrumbs'] as $key => $value)
            {
                if($value['titulo'] == $titulo){
                    unset($_SESSION['breadcrumbs'][$key]);
                }
            }

            $_SESSION['breadcrumbs'][] = array( 'url' => $url , 'titulo' => $titulo );
            $_SESSION['breadcrumbsAcu']++;

            $Breadcrumbs_Mod = $_SESSION['breadcrumbs'];
            $CountBread = $_SESSION['breadcrumbsAcu'];

        }else{

            foreach ($_SESSION['breadcrumbs'] as $key => $value)
            {
                if($value['titulo'] == $titulo){
                    unset($_SESSION['breadcrumbs'][$key]);
                }
            }

            $_SESSION['breadcrumbs'][] = array( 'url' => $url , 'titulo' => $titulo );
            $Breadcrumbs_Mod = $_SESSION['breadcrumbs'];
            $_SESSION['breadcrumbsAcu']++;
            $CountBread = $_SESSION['breadcrumbsAcu'];

        }
    }

//    echo '<pre>'; print_r($_SESSION['breadcrumbs']); die();

    if(!empty($titulo) )
    {


        $Breadcrumbs .= '<ul class="breadcrumb3 " >';
        for( $i = 0; $i <= $CountBread; $i++ )
        {
            if(isset($Breadcrumbs_Mod[$i])) //verifico si existe o hay valores
            {
                if($i==0){
                    $Breadcrumbs .= '<li><a href=" '. $Breadcrumbs_Mod[$i]['url'] .' "> '. $Breadcrumbs_Mod[$i]['titulo'] .' &nbsp;</a></li>';
                }else{
                    $Breadcrumbs .= '<li><a href=" '. $Breadcrumbs_Mod[$i]['url'] .' ">  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '. $Breadcrumbs_Mod[$i]['titulo'] .' &nbsp;</a></li>';

                }
            }
        }
        $Breadcrumbs .= '</ul>' ;



//        $htmlBreadcrumbs .= '<div class="btn-group btn-breadcrumb pull-right">';
//        $htmlBreadcrumbs .= '            <a href="#" class="btn btn-default"><i class="fa fa-dashcube"></i></a>';
//        for( $i = 0; $i <= $CountBread; $i++ )
//        {
//            if(isset($Breadcrumbs_Mod[$i])){
//                $htmlBreadcrumbs .= '<a href="'. $Breadcrumbs_Mod[$i]['url'] .'" class="btn btn-default"> '. $Breadcrumbs_Mod[$i]['titulo'] .' </a>';
//            }
//        }
//        $htmlBreadcrumbs .= '</div>';

    }

    return $Breadcrumbs;
}

?>