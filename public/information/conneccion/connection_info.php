
<?php

    function connection($db_name)
    {
        $host     = "localhost";
        $username = "root";
        $password = "";
        $database = $db_name;

        $cn = mysqli_connect($host, $username, $password, $database);

        if($cn)
        {
            return $cn;
        }else{

            echo '<h1 style="color: red">Error no se pudo conectar a la red - consulte con soporte tecnico</h1>';
        }

    }

?>