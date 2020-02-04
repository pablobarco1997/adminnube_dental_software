
<?php

    class CREAR_CLINICA_DENTAL{

        var $Connecion_corp; #VARIABLE DE CONEXCION DE LA ENTIDAD PRINCIPAL - TABLA ENTIDADES PADRES

        /** BASE DE DATOS  **/
        var $nombre_clinica = "";
        var $nombre_schema  = ""; #SCHEMA DE LA CLINICA
        var $numero_entidad = "";
        var $email_clinica  = "";
        var $password_email = "";


        /** REGISTRO DE USUARIO **/
        var $nombre_usuario   = "";
        var $apellido_usuario = "";
        var $usuario          = "";
        var $password         = "";


        function __construct($db)
        {
            $this->Connecion_corp = $db;
        }

        public  function create_clinica()
        {

            $errores['error_text'] = "";
            $errores['arror_table'] = "";

            $sql_clinica_create = "insert into schema_dental_entity_login.tab_entidades_dental (nombre_db_entity, numero_entity, nombre, email, conf_email, conf_password, pais )";
            $sql_clinica_create .= "value(";
            $sql_clinica_create .= " '". str_replace(' ', '_', $this->nombre_schema) ."'  , ";
            $sql_clinica_create .= " '".$this->numero_entidad."' ,";
            $sql_clinica_create .= " '".$this->nombre_clinica."' ,";
            $sql_clinica_create .= " '".$this->email_clinica."'  ,";
            $sql_clinica_create .= " '".$this->email_clinica."'  ,";
            $sql_clinica_create .= " '".$this->password_email."'  ,";
            $sql_clinica_create .= " 'ECUADOR' ";
            $sql_clinica_create .= ")";

//            echo '<pre>';  print_r($sql_clinica_create); die() ;

            $result = $this->Connecion_corp->query($sql_clinica_create);

            if($result)
            {
                #CREAMOS LA BASDE DE DATOS DE LA ENTIDAD DE LA CLINICA
                $respuesta = $this->create_clinica_db(true, false, $this->nombre_schema);

                if(!$respuesta){
                    $errores['error_text'] = "Ocurrio un error, no se pudo crear la base de datos de esta clinica a Registrar";
                }

                if($errores['error_text'] == "")
                {
                    if($respuesta){

                        #CREAMOS LAS TABLAS
                        $respuesta_table = $this->create_clinica_db(false, true, $this->nombre_schema);

                        foreach ($respuesta_table as $stringMysqlError)
                        {
                            $errores['arror_table'][] = $stringMysqlError;
                        }
                    }
                }

            }else{

                $errores['error_text'] = "Ocurrio un error no se pudo crear la Clinica";
            }

//            print_r($errores);
//            die();

            return $errores;
        }

        /*CREAR LA BASE DE DATOS*/
        public function create_clinica_db($schema , $tables, $nombre_db_entidad)
        {
            $respuesta = [];

            #CREO EL SCHEMA DE LA CLINICA
            if($schema == true)
            {
                $Schema = "CREATE SCHEMA `$nombre_db_entidad` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;";
                $result = $this->Connecion_corp->query($Schema);

                if($result){
                    return true;
                }else{
                    return false;
                }
            }

            #CREO LAS TABLAS DE LA CLINICA
            if($tables == true)
            {

                /** SE EXCUTA EL SCRIPT EN LA BASE DE DATOS **/

                $SQL_REQUEST_SCRIPT = file('../database/tab_admin_pacientes.sql');
                $respuesta[] = $this->scrip_mysql($SQL_REQUEST_SCRIPT, $nombre_db_entidad);

                $SQL_REQUEST_SCRIPT = file('../database/tab_comentarios_odontologos.sql');
                $respuesta[] = $this->scrip_mysql($SQL_REQUEST_SCRIPT, $nombre_db_entidad);

                $SQL_REQUEST_SCRIPT = file('../database/tab_conf_categoria_prestacion.sql');
                $respuesta[] = $this->scrip_mysql($SQL_REQUEST_SCRIPT, $nombre_db_entidad);

                $SQL_REQUEST_SCRIPT = file('../database/tab_conf_convenio_desc.sql');
                $respuesta[] = $this->scrip_mysql($SQL_REQUEST_SCRIPT, $nombre_db_entidad);

                $SQL_REQUEST_SCRIPT = file('../database/tab_conf_prestaciones.sql');
                $respuesta[] = $this->scrip_mysql($SQL_REQUEST_SCRIPT, $nombre_db_entidad);

                $SQL_REQUEST_SCRIPT = file('../database/tab_dientes_caras.sql');
                $respuesta[] = $this->scrip_mysql($SQL_REQUEST_SCRIPT, $nombre_db_entidad);

                $SQL_REQUEST_SCRIPT = file('../database/tab_dientes_piezas.sql');
                $respuesta[] = $this->scrip_mysql($SQL_REQUEST_SCRIPT, $nombre_db_entidad);

                $SQL_REQUEST_SCRIPT = file('../database/tab_especialidades_doc.sql');
                $respuesta[] = $this->scrip_mysql($SQL_REQUEST_SCRIPT, $nombre_db_entidad);

                $SQL_REQUEST_SCRIPT = file('../database/tab_fichero_pacientes_cab.sql');
                $respuesta[] = $this->scrip_mysql($SQL_REQUEST_SCRIPT, $nombre_db_entidad);

                $SQL_REQUEST_SCRIPT = file('../database/tab_fichero_pacientes_det.sql');
                $respuesta[] = $this->scrip_mysql($SQL_REQUEST_SCRIPT, $nombre_db_entidad);

                $SQL_REQUEST_SCRIPT = file('../database/tab_login_users.sql');
                $respuesta[] = $this->scrip_mysql($SQL_REQUEST_SCRIPT, $nombre_db_entidad);

                $SQL_REQUEST_SCRIPT = file('../database/tab_noti_confirmacion_cita_email.sql');
                $respuesta[] = $this->scrip_mysql($SQL_REQUEST_SCRIPT, $nombre_db_entidad);

                $SQL_REQUEST_SCRIPT = file('../database/tab_notificacion_email.sql');
                $respuesta[] = $this->scrip_mysql($SQL_REQUEST_SCRIPT, $nombre_db_entidad);

                $SQL_REQUEST_SCRIPT = file('../database/tab_odontograma_estados_piezas.sql');
                $respuesta[] = $this->scrip_mysql($SQL_REQUEST_SCRIPT, $nombre_db_entidad);

                $SQL_REQUEST_SCRIPT = file('../database/tab_odontograma_paciente_cab.sql');
                $respuesta[] = $this->scrip_mysql($SQL_REQUEST_SCRIPT, $nombre_db_entidad);

                $SQL_REQUEST_SCRIPT = file('../database/tab_odontograma_paciente_det.sql');
                $respuesta[] = $this->scrip_mysql($SQL_REQUEST_SCRIPT, $nombre_db_entidad);

                $SQL_REQUEST_SCRIPT = file('../database/tab_odontograma_update.sql');
                $respuesta[] = $this->scrip_mysql($SQL_REQUEST_SCRIPT, $nombre_db_entidad);

                $SQL_REQUEST_SCRIPT = file('../database/tab_odontologos.sql');
                $respuesta[] = $this->scrip_mysql($SQL_REQUEST_SCRIPT, $nombre_db_entidad);

                $SQL_REQUEST_SCRIPT = file('../database/tab_pacientes_citas_cab.sql');
                $respuesta[] = $this->scrip_mysql($SQL_REQUEST_SCRIPT, $nombre_db_entidad);

                $SQL_REQUEST_SCRIPT = file('../database/tab_pacientes_citas_det.sql');
                $respuesta[] = $this->scrip_mysql($SQL_REQUEST_SCRIPT, $nombre_db_entidad);

                $SQL_REQUEST_SCRIPT = file('../database/tab_pacientes_estado_citas.sql');
                $respuesta[] = $this->scrip_mysql($SQL_REQUEST_SCRIPT, $nombre_db_entidad);

                $SQL_REQUEST_SCRIPT = file('../database/tab_plan_tratamiento_cab.sql');
                $respuesta[] = $this->scrip_mysql($SQL_REQUEST_SCRIPT, $nombre_db_entidad);

                $SQL_REQUEST_SCRIPT = file('../database/tab_plan_tratamiento_det.sql');
                $respuesta[] = $this->scrip_mysql($SQL_REQUEST_SCRIPT, $nombre_db_entidad);

                $SQL_REQUEST_SCRIPT = file('../database/tab_plantillas_documentos.sql');
                $respuesta[] = $this->scrip_mysql($SQL_REQUEST_SCRIPT, $nombre_db_entidad);

//                echo '<pre>';
//                print_r($respuesta);
//                die();
                return $respuesta;
            }

        }

        public function scrip_mysql($script, $nombre_db_entidad)
        {

            $errores2 = [];

            $SQL_ARRAY = [];

            #CREAMOS UNA CONEXCION TEMPORAL HACIA LA BASE DE DATOS RECIEN CREADA
            $connecion = $this::Conneccion($nombre_db_entidad);

//            echo '<pre>';
//            print_r($script);

            $query = "";
            foreach ($script as $line)
            {
                $query .=  $line;

                if( trim($line) == trim(";") )
                {
                    $SQL_ARRAY[] = $query;
                    $query = "";
                }
            }

//            echo '<pre>';
//            print_r($SQL_ARRAY);

            if(count($SQL_ARRAY) > 0)
            {
                for ($i = 0; $i <= count($SQL_ARRAY) -1; $i++)
                {
                    $mysql_consulta = $SQL_ARRAY[$i];
                    if($mysql_consulta != ";")
                    {
                        $rs = $connecion->query($mysql_consulta);
                        if(!$rs)
                        {
                            $errores2[] = "Ocurrio un error con la tabla :: =>  \n ".$mysql_consulta;
                        }

                    }
                }
            }

            return $errores2;
        }

        /*CONNECION STATIC A LA ENTIDAD CREADA*/
        public static function Conneccion($schema)
        {

            $host     = 'localhost';
            $database = $schema; //SE ENCUENTRA TODAS LAS ENTIDADES REGISTRADAS
            $username = 'root'; #USUARIO
            $password = ''; #PASSWIRD

            $db_conneccion = mysqli_connect( $host, $username, $password, $database );

            if($db_conneccion){

                return $db_conneccion;

            }else{

                return false;
            }
        }

    }

?>