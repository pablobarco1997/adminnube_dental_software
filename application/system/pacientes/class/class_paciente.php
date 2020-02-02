<?php

//require_once '../../../config/variables_globales.php';
//require_once $DOL_DOCUMENT .'/application/system/conneccion/conneccion';

    class Pacientes{

        var $db;

        #PACIENTE
        var $tipo           = "";
        var $nombre         = "";
        var $apellido       = "";
        var $rud_dni        = "";
        var $email          = "";
        var $convenio       = "";
        var $n_interno      = "";
        var $sexo           = "";
        var $fech_nacimit   = "";
        var $ciudad         = "";
        var $comuna         = "";
        var $direcc         = "";
        var $t_fijo         = "";
        var $t_movil        = "";
        var $act_profec     = "";
        var $empleado       = "";
        var $apoderado      = "";
        var $obsrv          = "";
        var $refer          = "";
        var $icon           = "";

        #ODONTOGRAMA
        # CAB DET
        var $numero                = "";
        var $fk_usuario            = "";
        var $odontodescripcion     = "";
        var $fk_plantratamiento    = "";
        var $fk_paciente           = "";

        #DETALLE
        var $fk_diente          = "";
        var $json_caras         = "";
        var $fk_estadosdientes  = "";
        var $observacionOdont   = "";
        var $listCaras          = "";
        var $fechaDet           = "";

        public  function __construct($db)
        {
            $this->db = $db;
        }

        #OBTENER PACIENTE
        public function fectch_pacientes($id)
        {
            $array_paciente = array();

            $sql = "SELECT * FROM tab_admin_pacientes where rowid = $id";
            $rs  = $this->db->query($sql);

            if($rs->rowCount() > 0)
            {
                while ($row = $rs->fetchObject())
                {
                    $array_paciente[] = $row;
                }
            }

            return $array_paciente;
        }

        #CREACION DE UN PACIENTE
        public function create_paciente()
        {

                $sql = "INSERT INTO `tab_admin_pacientes` (`nombre`, `apellido`, `rut_dni`,`email`,`fk_convenio`,`numero_interno`,`sexo`, `fecha_nacimiento`,`fk_ciudad`,`comuna`,`direccion`,`telefono_fijo`, `telefono_movil`, `actividad_profecion`, `empleador`, `observacion`,`apoderado`,`referencia`, `fk_tipo`) ";
                $sql .= "VALUES(";
                $sql .= "'$this->nombre',";
                $sql .= "'$this->apellido',";
                $sql .= "'$this->rud_dni', ";
                $sql .= "'$this->email',  ";
                $sql .= "'$this->convenio', ";
                $sql .= "'$this->n_interno', ";
                $sql .= "'$this->sexo', ";
                $sql .= "'$this->fech_nacimit', ";
                $sql .= "'$this->ciudad', ";
                $sql .= "'$this->comuna', ";
                $sql .= "'$this->direcc', ";
                $sql .= "'$this->t_fijo', ";
                $sql .= "'$this->t_movil',";
                $sql .= "'$this->act_profec',";
                $sql .= "'$this->empleado',";
                $sql .= "'$this->obsrv',";
                $sql .= "'$this->apoderado', ";
                $sql .= "'$this->refer',";
                $sql .= "'0'";
                $sql .= ");";

                $rs = $this->db->query($sql);
                if ($rs)
                {
                    return 'exito';
                }else{
                    return 'error';
                }

        }

        #ACTUALIZACION DE INFORMACION DE PACIENTES
        public function UpdatePaciente($id)
        {

            $fk_tipo     = empty($this->tipo) ? '0' : $this->tipo;
            $fk_convenio = empty($this->convenio) ? '0' : $this->convenio;
            $icon_img    = !empty($this->icon) ? $this->icon : "";

            $error = '';

            $sql  = " UPDATE tab_admin_pacientes SET ";

            $sql .= " nombre                    = '$this->nombre'  , ";
            $sql .= " apellido                  = '$this->apellido'  , ";
            $sql .= " rut_dni                   = '$this->rud_dni' , ";
            $sql .= " email                     = '$this->email' ,";
            $sql .= " fk_convenio               = '$fk_convenio'  ,";
            $sql .= " numero_interno            = '$this->n_interno'  ,";
            $sql .= " sexo                      = '$this->sexo' ,";
            $sql .= " fecha_nacimiento          = '$this->fech_nacimit'  ,";
            $sql .= " fk_ciudad                 = '$this->ciudad'  ,";
            $sql .= " comuna                    = '$this->comuna'  ,";
            $sql .= " direccion                 = '$this->direcc'  ,";
            $sql .= " telefono_fijo             = '$this->t_fijo' , ";
            $sql .= " telefono_movil            = '$this->t_movil' ,";
            $sql .= " actividad_profecion       = '$this->act_profec' , ";
            $sql .= " empleador                 = '$this->empleado' , ";
            $sql .= " observacion               = '$this->obsrv' , ";
            $sql .= " apoderado                 = '$this->apoderado' , ";
            $sql .= " referencia                = '$this->refer' , ";
            $sql .= " fk_tipo                   = '$fk_tipo ' ";

            if($icon_img != ""){
                $sql .= " , icon                      = '$icon_img ' ";
            }


            $sql .= " WHERE (rowid = '$id')";

//            echo '<pre><br>';
//            print_r($sql);

            $rs = $this->db->query($sql);

            if(!$rs)
            {
                $error = "Ocurrió un problema con la Operación, consulte con soporte tecnico";
            }

            return $error;

        }

        #CREACION DE ODONTOGRAMA CABEZERA
        public function createOdontogramaCab()
        {
            $error = '';

            $tratamiento = !empty($this->fk_plantratamiento) ? $this->fk_plantratamiento : '0';

            $numero = str_pad($this->numero, 4, "0", STR_PAD_LEFT);

            $sql  = "INSERT INTO `tab_odontograma_paciente_cab` (`numero`, `fk_user`, `descripcion`, `fk_tratamiento`, `fecha`, `fk_paciente`) ";
            $sql .= " VALUES(";
            $sql .= " '$numero',";
            $sql .= " '$this->fk_usuario',";
            $sql .= " '$this->odontodescripcion',";
            $sql .= " '$tratamiento' ,";
            $sql .= " now() ,";
            $sql .= " $this->fk_paciente ";
            $sql .= ");";
//            print_r($sql); die();
            $rs = $this->db->query($sql);

            if( !$rs ){
                $error = 'Ocurrió un problema con la Operción, consulte con soporte Técnico';
            }

            return $error;

        }

        #CREACION DE ODONTOGRAMA DETALLES
        public function createOdontogramaDet()
        {
//            print_r($this->json_caras);
            $error = '';
            $tratamiento = !empty($this->fk_plantratamiento) ? $this->fk_plantratamiento : '0';

            $sql = "INSERT INTO `tab_odontograma_paciente_det` (`fk_diente`, `json_caras`, `fk_estado_diente`, `fk_tratamiento`, `obsrvacion`, `list_caras`, `fecha`, `estado_anulado`)";
            $sql .= "VALUES(";
            $sql .= "'".$this->fk_diente."', ";
            $sql .= "'".json_encode($this->json_caras)."', ";
            $sql .= "'".$this->fk_estadosdientes."', ";
            $sql .= "'".$tratamiento."', ";
            $sql .= "'".$this->observacionOdont."', ";
            $sql .= "'".$this->listCaras."', ";
            $sql .= " ".$this->fechaDet." ,";
            $sql .= " 'A' ";
            $sql .= ")";
//            print_r($sql);
            $rs = $this->db->query($sql);

            if(!$rs){
                $error = "Ocurrió un problema con la Operción, consulte con soporte Técnico";
            }

            return $error;
        }



    }
?>