
<?php

    class configuration{

        var $PERFIL     = "";
        var $EMPRESA    = "";
        var $PACIENTES  = "";
        var $NOTIFICACIONES_CITAS = "";
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
            $this->NOTIFICACIONES_CITAS      = array();
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

        function ObtenerInformacionCitasPacientes($db, $independiente, $id_detalle_cita)
        {

                $OBJ_CITAS = array();
                $Fecha_Hoy = "now()";

                $sql2 = "SELECT 
                        d.rowid as id_detalle_cita,
                        c.fecha_create , 
                        d.hora_inicio , 
                        d.hora_fin ,
                        concat(d.hora_inicio , ' A ' , d.hora_fin) as cita_desde,
                        concat(p.nombre , ' ' , p.apellido) as nombre , 
                        c.comentario,
                        (select concat(o.nombre_doc , ' ', o.apellido_doc ) from tab_odontologos o where o.rowid = d.fk_doc) as doctor_cargo,
                        s.text,
                        
                        
                        p.rowid       as idpaciente   , 
                        d.fk_doc      as iddoctorcargo,
                        p.fk_convenio as convenio     ,
                        
                        ifnull((select cv.nombre_conv from tab_conf_convenio_desc cv where  cv.rowid = p.fk_convenio), 'sin convenio') as nomconvenio
                        
                        
                        FROM tab_pacientes_citas_cab c, tab_pacientes_citas_det d , tab_admin_pacientes p , tab_pacientes_estado_citas s
                        WHERE c.fk_paciente = p.rowid and c.rowid = d.fk_pacient_cita_cab and d.fk_estado_paciente_cita = s.rowid 
                        ";

                if($independiente == 1)  //Q me muestre solo un registro de esta informacion
                {

                    $sql2 .= " and d.rowid = " . $id_detalle_cita;

                }else{

                    $sql2 .= " and date_format(d.fecha_cita , '%Y-%m-%d') = date_format($Fecha_Hoy , '%Y-%m-%d') ";

                }


//            echo '<pre><br>';
//            print_r($sql2);

                $rs = $db->query($sql2);

                if($rs->rowCount() > 0)
                {
                    while ($Obj = $rs->fetchObject())
                    {
                        if($independiente == true)
                        {
                            $OBJ_CITAS = $Obj;

                        }else{
                            $this->NOTIFICACIONES_CITAS[] = $Obj;  // le ENVIO EL OBJ COMPLETO
                        }
                    }
                }

                return $OBJ_CITAS;


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