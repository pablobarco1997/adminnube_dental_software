
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
        var $usu_nombre_usuario   = "";
        var $usu_apellido_usuario = "";
        var $usu_usuario          = "";
        var $usu_password         = "";
        var $usu_email         = "";


        function __construct($db)
        {
            $this->Connecion_corp = $db;
        }

        public  function create_clinica()
        {

            $id_entity_Glob = 0;

            $errores['error_text'] = "";
            $errores['arror_table'] = "";

            $sql_clinica_create = "insert into tab_entidades_dental (nombre_db_entity, numero_entity, nombre, email, conf_email, conf_password, pais )";
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
            $id_entity_Glob = $this->Connecion_corp->lastInsertId('tab_entidades_dental');

            if($result && $id_entity_Glob > 0)
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

                        #CREAMOS EL USUARIO PARA EL LOGEO
                        $err = $this->create_UserClinicaEntidades($id_entity_Glob);

                        if($err > 0){
                            #err => contien el ultimo id insertado en el login
                            #CREAR USUARIO Y ODONTOLOGO
                            $this->create_UserClinica($this->nombre_schema, $err);

                        }else{
                            $errores[] = "Ocurrio un error al crear el usuario para la clinica: tab_login_entity";
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

        public function create_UserClinicaEntidades( $identity )
        {

            $sql =  " insert into tab_login_entity (nombre_user, password_user, email, fk_entidad, nombre, apellido, estado )";
            $sql .= " value( ";
            $sql .= " '".$this->usu_usuario."', ";
            $sql .= " md5('".$this->usu_password."'), ";
            $sql .= " '". $this->usu_email ."', ";
            $sql .= " $identity , ";
            $sql .= " '" .$this->usu_nombre_usuario. "' , ";
            $sql .= " '" .$this->usu_apellido_usuario. "' , ";
            $sql .= " 'A'  ";
            $sql .= " ) ;";

//            print_r($sql); die();
            $resul = $this->Connecion_corp->query($sql);
            $UltiIdLoginEntity = $this->Connecion_corp->lastInsertId('tab_login_entity');

            if(!$resul){
                return false;
            }else{
                return $UltiIdLoginEntity;
            }

        }

        public function create_UserClinica($nombre_db_entidad, $idloginEntity)
        {
            #CREAMOS UNA CONEXCION TEMPORAL HACIA LA BASE DE DATOS RECIEN CREADA
            $connecion = $this::Conneccion($nombre_db_entidad);

            #INSERTP EL ODONTOLOGO
            $sqldoct  = " insert into `tab_odontologos` (`nombre_doc`, `apellido_doc`, `estado`, `email`) ";
            $sqldoct .= "VALUE(";
            $sqldoct .= " '". $this->usu_nombre_usuario."' ,";
            $sqldoct .= " '". $this->usu_apellido_usuario."', ";
            $sqldoct .= " 'A' ,";
            $sqldoct .= " '". $this->usu_email."' ";
            $sqldoct .= ")";
            $rs = $connecion->query($sqldoct);

            $iddoct = mysqli_insert_id($connecion); #obtengo el ultimo id

            #UPDATE ENTYTI LOGIN  - se update el idusuario que contiene el id del doctor
            $sqlupdate = "UPDATE `tab_login_entity` SET `id_usuario`='$iddoct' WHERE `rowid`='$idloginEntity';";
            $this->Connecion_corp->query($sqlupdate);

            #LOGIN tab_login_users
            $sql  = " insert into tab_login_users (usuario, passwords, fk_doc, permisos, tipo_usuario, passwor_abc, estado)";
            $sql .= "value(";
            $sql .= " '" . $this->usu_usuario . "' ,";
            $sql .= " md5('" . $this->usu_password . "') ,";
            $sql .= " '" . $iddoct . "' ,";
            $sql .= " '{\"consultar\":\"true\",\"agregar\":\"true\",\"modificar\":\"true\",\"eliminar\":\"true\"}' ,";
            $sql .= " 1 ,";
            $sql .= " '" . base64_encode($this->usu_password) . "' ,";
            $sql .= " 'A' ";
            $sql .= ")";
//            print_r($sql);
            $connecion->query($sql);

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
                    $mysql_consulta = utf8_decode( $SQL_ARRAY[$i] ); #CONVIERTE LA CADENA CORRECTA - PARA EXECUTAR EL SCRIPT MYSQL

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
            $username = 'adminnub_entidad_dental'; #USUARIO
            $password = 'Pablo_1997';  #PASSWIRD #PASSWORD SERVIDOR REMOTO ==> Pablo_1997

            $db_conneccion = mysqli_connect( $host, $username, $password, $database );

            if($db_conneccion){

                return $db_conneccion;

            }else{

                return false;
            }
        }

    }

?>