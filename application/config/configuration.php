
<?php

    class configuration{

        var $PERFIL     = "";
        var $EMPRESA    = "";
        var $PACIENTES  = "";
        var $NOTIFICACIONES = "";
        var $DIRECTORIO = "";
        var $NAME_DIRECTORIO = "";

        var $Entidad    = "";
        var $db_schema  = "";
        var $login_user = "";
        var $login_id   = "";

        public  function __construct()
        {
            $this->PACIENTES                 = array();
            $this->EMPRESA                   = new stdClass();
            $this->DIRECTORIO                = new stdClass();
            $this->NAME_DIRECTORIO           = new stdClass();
            $this->PERFIL                    = new stdClass();
            $this->NOTIFICACIONES            = (object)array( 'Glob_Notificaciones' => [] , 'Numero' => 0 );
        }

        public function ObtenerPaciente($db, $id, $tipo)
        {
            $obj = array();
            $sql1  = "SELECT * FROM tab_admin_pacientes WHERE rowid > 0 ";

            if($tipo==true)
            {
                if(!empty($id))
                {
                    $sql1 .= " and rowid = $id";
                }
            }

            $resp = $db->query($sql1);
            if($resp->rowCount())
            {
                while ($row = $resp->fetchObject())
                {
//                   $this->pacientesObj[] = array("id" => $row->rowid, "nombre" => $row->nombre .' '.$row->apellido);

                     if($tipo==true)
                     {
                         $obj = $row;
                     }
                     if($tipo==false)
                     {
                         $this->PACIENTES[]= $row;
                     }

                }
            }

            return $obj;
        }

        function ObtnerNoficaciones($db, $puedoAxu)
        {
                #ESTA VARIABLE CAPTURAR EL NUMERO DE NOTIFICACIONES QUE EXTIS
                $numeroNotificaciones = 0;

                $ConsultarCitas = "
                        SELECT 
                            d.rowid AS id_detalle_cita,
                            c.fecha_create,
                            d.hora_inicio,
                            d.hora_fin,
                            CONCAT(d.hora_inicio, ' A ', d.hora_fin) AS cita_desde,
                            CONCAT(p.nombre, ' ', p.apellido) AS nombre,
                            c.comentario,
                            (SELECT 
                                    CONCAT(o.nombre_doc, ' ', o.apellido_doc)
                                FROM
                                    tab_odontologos o
                                WHERE
                                    o.rowid = d.fk_doc) AS doctor_cargo,
                            s.text,
                            p.rowid AS idpaciente,
                            d.fk_doc AS iddoctorcargo,
                            p.fk_convenio AS convenio,
                            IFNULL((SELECT 
                                            cv.nombre_conv
                                        FROM
                                            tab_conf_convenio_desc cv
                                        WHERE
                                            cv.rowid = p.fk_convenio),
                                    'sin convenio') AS nomconvenio ,
                            p.icon
                        FROM
                            tab_pacientes_citas_cab c,
                            tab_pacientes_citas_det d,
                            tab_admin_pacientes p,
                            tab_pacientes_estado_citas s
                        WHERE
                            c.fk_paciente = p.rowid
                                AND c.rowid = d.fk_pacient_cita_cab
                                AND d.fk_estado_paciente_cita = s.rowid 
                                
                        AND date_format(d.fecha_cita , '%Y-%m-%d') = date_format( now() , '%Y-%m-%d') ";

                #NOTIFICACIONES DE CITAS
                $rsConsultCitas = $db->query($ConsultarCitas);
                if($rsConsultCitas->rowCount() > 0)
                {
                    while ( $CitasConsult = $rsConsultCitas->fetchObject() )
                    {

                        $this->NOTIFICACIONES->Glob_Notificaciones[] = (object)array(

                            'tipo_notificacion'     => 'notificacion_citas_paciente' ,

                            'fecha'                 => date('Y-m-d', strtotime( str_replace('-', '/', $CitasConsult->fecha_create))),
                            'horaIni'               =>  $CitasConsult->hora_inicio,
                            'horafin'               =>  $CitasConsult->hora_fin ,

                            'nombe_paciente'        =>  $CitasConsult->nombre,
                            'comment'               =>  $CitasConsult->comentario,
                            'doctor_cargo'          =>  $CitasConsult->doctor_cargo,
                            'icon'                  =>  $CitasConsult->icon,

                            'id_detalle_cita'       =>  $CitasConsult->id_detalle_cita,
                            'idpaciente'            =>  $CitasConsult->idpaciente,
                            'iddoctorcargo'         =>  $CitasConsult->iddoctorcargo,
                        );

                        $numeroNotificaciones++;
                    }
                }

                #NUMERO DE NOTIFICACIONES
                $this->NOTIFICACIONES->Numero = (object)array(

                    'NumeroNotificaciones'      => $numeroNotificaciones

                );


                return "";


        }

        function perfil($db, $idUsuario, $url, $directorio_url)
        {
            $sql = "SELECT * FROM tab_odontologos WHERE rowid = $idUsuario limit 1";
            $rs = $db->query($sql);

            if($rs->rowCount()>0)
            {
                $Obj = $rs->fetchObject();

                $img = $url."/logos_icon/logo_default/doct-icon2.png"; //Icon por default
                if(!empty($Obj->icon))
                {
                    $img = $url."/logos_icon/".$directorio_url."/".$Obj->icon;
                }

                $data = (object)array("id" => $Obj->rowid, "nombre" => $Obj->nombre_doc, "apellido" => $Obj->apellido_doc, "icon" => $img);
                $this->PERFIL = $data;
            }
        }

    }


?>