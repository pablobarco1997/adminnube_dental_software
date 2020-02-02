<?php

class  ObtenerConexiondb{

    public static function conectarEmpresa($name_db){

        $Conexion_entidad = null;
        $host     ='adminnub_entidad_dental';
        $database = "$name_db";
        $username = 'Pablo_1997';
        $password = '';
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