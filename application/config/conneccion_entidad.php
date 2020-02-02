<?php

class CONECCION_ENTIDAD{

    public static function CONNECT_ENTITY(){

        $conexion = null;
        $host     = 'localhost';
        $database = 'schema_dental_entity_login'; //SE ENCUENTRA TODAS LAS ENTIDADES REGISTRADAS
        $username = 'root';
        $password = '';
        $utf8mb4  = 'utf8mb4';

        try{

            $conexion = new PDO("mysql:host=$host;dbname=$database;charset=$utf8mb4",$username, $password );

        }catch (PDOException $e){

            echo $e;
        }

        return $conexion;
    }

    public static function UPDATE_ENTIDAD($nombre, $direccion, $telefono, $celular, $email, $logo, $pais, $ciudad, $id,  $conf_email, $conf_password)
    {
        $error = 0;

        $cn = new CONECCION_ENTIDAD();

        $sql = "";

        $sql  = " UPDATE schema_dental_entity_login.tab_entidades_dental SET";
        $sql .= " nombre    = '$nombre' ,";
        $sql .= " direccion = '$direccion' ,";
        $sql .= " telefono = '$telefono' ,";
        $sql .= " celular  = '$celular' ,";
        $sql .= " email    = '$email' ,";

        $sql .= " conf_email    = '$conf_email' ,";
        $sql .= " conf_password    = '$conf_password' ,";

        if($logo != "")
        {
            $sql .= " logo     = '$logo' , ";
        }

        $sql .= " pais = '$pais', ciudad = '$ciudad'";
        $sql .= " where rowid = $id ";

//        print_r($sql); die();
        $resp = $cn::CONNECT_ENTITY()->query($sql);

        if($resp) { $error = 1; }else{ $error = 0; }

        return $error;
    }

    public static function LOGIN_USUARIO_ENTITY($status, $nombre_usuario, $password_user, $email, $fk_entidad, $nombre , $apellido, $entidadLogin, $idusuario )
    {
        $error = 0;

        $cn = new CONECCION_ENTIDAD();

        $sql = "";

        if($status=="nuevo")
        {
            $sql  = " INSERT INTO `tab_login_entity` ( `nombre_user`, `password_user` , `email`, `fk_entidad`, `nombre`, `apellido`, `id_usuario` ) ";
            $sql .= "VALUES (";
            $sql .= " '$nombre_usuario',";
            $sql .= "  md5('$password_user'),";
            $sql .= " '$email',";
            $sql .= " '$fk_entidad',";
            $sql .= " '$nombre',";
            $sql .= " '$apellido', ";
            $sql .= " '$idusuario' ";
            $sql .= ")";

            $resp = $cn::CONNECT_ENTITY()->query($sql);

            if($resp) { $error = 1; }else{ $error = 0; }
        }

        if($status=="modificar")
        {
            $sql = "UPDATE `tab_login_entity` SET `nombre_user` = '$nombre_usuario' , `email` = '$email' ";

            if($password_user != "")
            {
                $sql .= " , `password_user` = md5('".$password_user."') ";
            }

            $sql .= " , `nombre` = '$nombre', `apellido` = '$apellido' ";
            $sql .= " WHERE fk_entidad = '$entidadLogin' and rowid > 0 and id_usuario = $idusuario;";

//            print_r($sql); die();
            $rs  = $cn::CONNECT_ENTITY()->query($sql);
            if($rs){$error = 1;}
            if(!$rs){ $error = 0; }
        }

        return $error;
    }

    public static function INFORMACION_EMPRESA_GLOB($idEntidad)
    {
        $datos = array();
        $cn = new CONECCION_ENTIDAD();

        $sql = "SELECT * FROM tab_entidades_dental WHERE rowid = $idEntidad";
        $result = $cn::CONNECT_ENTITY()->query($sql);

        if($result->rowCount()>0)
        {
            while ($Obj = $result->fetchObject())
            {
                $datos = $Obj;
            }
        }

        return $datos;
    }

    public function COMPROBAR_USUARIO_REPETIDO($usuario)
    {
        $error = '';
        $cn = new CONECCION_ENTIDAD();
        $sql = "select * from tab_login_entity where nombre_user = '".$usuario."'";
        $result = $cn::CONNECT_ENTITY()->query($sql);

//        print_r($sql);
        if($result->rowCount()>0) #Se Encuentra el Usuario
        {
            $error = 'Este Usuario ya se encuentra en Uso, Ingrese un Usuario que no este en Uso';
        }

        return $error;

    }

    public  function  login_status($status, $idusuario, $fk_entity)
    {
        $error = '';
        $cn = new CONECCION_ENTIDAD();
        $sql = "UPDATE `tab_login_entity` SET `estado`='$status' WHERE `rowid`>0 AND id_usuario = $idusuario AND fk_entidad = $fk_entity;";
        $rs = $cn->CONNECT_ENTITY()->query($sql);

        if(!$rs){
            $error = "Ocurrió un error al momento del Actualizar la informacion , Consulte con soporte Técnico";
        }

        return $error;
    }

}

?>
