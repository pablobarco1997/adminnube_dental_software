<?php

class  ObtenerConexiondb{

    public static function conectarEmpresa($name_db){

        $Conexion_entidad = null;
        $host     = 'localhost';
        $database = "$name_db";
        $username = 'adminnub_entidad_dental'; #USUARIO
        $password = 'Pablo_1997'; #PASSWORD
        $utf8mb4  = 'utf8mb4'; //mysql utf8

        try{

            $Conexion_entidad = new PDO("mysql:host=$host;dbname=$database;charset=$utf8mb4",$username, $password );

        }catch (PDOException $e){
            echo $e;
        }

        return $Conexion_entidad;
    }
}

?>