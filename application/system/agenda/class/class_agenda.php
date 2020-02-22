<?php

class admin_agenda{

    var $db;

    #AGENDA
    var $fk_paciente;
    var $comentario;
    var $fk_login_users;

    var $detalle;


    #PLAN TRATAMIENTO CAB
    var $tratam_numero = '';
    var $tratam_fk_doc = '';
    var $tratam_fk_convenio = '';
    var $tratam_fk_paciente = '';
    var $tratam_estado_tratamiento = '';
    var $tratam_evoluciones = '';
    var $tratam_ultimacita = '';
    var $tratam_fk_cita = '';
    var $tratam_detencion = '';
    var $tratam_situaccion = '';

    #PLAN TRATAMIENTO DET
    var $tramdet_fk_tramcab = '';
    var $tramdet_fk_prestacion = '';
    var $tramdet_fk_diente = '';
    var $tramdet_jsoncaras = '';
    var $tramdet_subtotal = '';
    var $tramdet_desconvenio = '';
    var $tramdet_descadicional = '';
    var $tramdet_total = '';
    var $tramdet_cantidad = '';
    var $tramdet_detencion = '';
    var $tramdet_fk_usuario = '';

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function fetchData()
    {



    }

    public function GenerarCitas()
    {

        $error = "";

        $sql = "INSERT INTO tab_pacientes_citas_cab (`fecha_create`, `fk_paciente`, `comentario`, `fk_login_user`) ";
        $sql .= "value(";
        $sql .= "now(),";
        $sql .= " $this->fk_paciente,";
        $sql .= "'$this->comentario',";
        $sql .= " $this->fk_login_users";
        $sql .= ")";

        $rs = $this->db->query($sql);
//        $rs = true;
        if($rs)
        {

            $id = $this->db->lastInsertId('tab_pacientes_citas_cab');

            foreach ($this->detalle as $item)
            {

    //                print_r($item['especialidad']);
                    $fk_doc    = $item['doctor'];
                    $recursos  = "0";
                    $duracion  = $item['duraccion'];
                    $especialidad  = $item['especialidad'];
                    $fechacita = str_replace('/','-', $item['fechacita']);
                    $hora = $item['hora'];
                    $dateformat = date('Y-m-d', strtotime($fechacita));

                    $Hora_inicio  = "$hora:00";
                    $aux_horadate =  strtotime(" +$duracion minute", strtotime("$dateformat $Hora_inicio") );
                    $Hora_Fin     = date('H:i:s',$aux_horadate);

                    $sql1  = "INSERT INTO tab_pacientes_citas_det (`fk_pacient_cita_cab`,  `fk_estado_paciente_cita`, `fk_especialidad`,  `fk_doc`, `recurso`, `duracion`,
                        `fecha_cita`, 
                        `hora_cita`, 
                        `type`,
                        `hora_inicio`,
                        `hora_fin`
                    )";
                    $sql1 .= "VALUES(";
                    $sql1 .= "$id,";
                    $sql1 .= "2,"; //el estado se guarda en dos "NO CONFIRMADO"
                    $sql1 .= "$especialidad,";
                    $sql1 .= "$fk_doc,";
                    $sql1 .= "$recursos,";
                    $sql1 .= "$duracion,";
                    $sql1 .= "'$dateformat',";
                    $sql1 .= "'$hora:00',";
                    $sql1 .= "0,";
                    $sql1 .= "'$Hora_inicio',";
                    $sql1 .= "'$Hora_Fin' ";
                    $sql1 .= ")";

                    $this->db->query($sql1);

            }

        }else{
            $error = 'Ocurrio un error al  generar la cita , consulte con soporte tecnico';
        }

        return $error;
    }


    #crear plan de tratamiento del lado de la agenda => PLAN DE TRATAMIENTO CABEZERA
    public function create_plantratamientocab()
    {

        $error = '';

        $sql = "INSERT INTO `tab_plan_tratamiento_cab` (`numero`, `fk_doc`, `fk_sucursal`, `fk_convenio`, `fk_paciente`, `abonos`, `estados_tratamiento`, `evoluciones_porct`, `ultima_cita`, `fk_cita`, `detencion`, situacion, fecha_create)";
        $sql .= "VALUES(";

        $sql .= "'$this->tratam_numero' ,";
        $sql .= "'$this->tratam_fk_doc' ,";
        $sql .= "'0' ,";
        $sql .= "'$this->tratam_fk_convenio' ,";
        $sql .= "'$this->tratam_fk_paciente' ,";
        $sql .= "'0' ,";
        $sql .= "'$this->tratam_estado_tratamiento' ,";
        $sql .= "'0' ,";
        $sql .= " $this->tratam_ultimacita ,";
        $sql .= "'$this->tratam_fk_cita' ,";
        $sql .= "'$this->tratam_detencion' ,";
        $sql .= "'$this->tratam_situaccion' ,  ";
        $sql .= " now() ";

        $sql .= ");";

//        print_r($sql); die();

        $rs = $this->db->query($sql);
        if($rs){
            $error = '';
        }else{
            $error = 'Ocurrio un error al crear el Plan de tratamiento , Consulte con soporte Tecnico';
        }

        return $error;

    }

    #crear plan de tratamiento detalle
    public function create_plantratamientodet()
    {

        $error = '';

        $descAdicional = !empty($this->tramdet_descadicional) ? $this->tramdet_descadicional : 0.00;

        $sql  = "INSERT INTO tab_plan_tratamiento_det  (`fk_plantratam_cab`, `fk_prestacion`, `fk_diente`, `json_caras`, `sub_total`, `desc_convenio`, `desc_adicional`, `total`, `cantidad`, detencion, fk_usuario) ";
        $sql .= "VALUES(";
        $sql .= " ".$this->tramdet_fk_tramcab." , ";
        $sql .= " ".$this->tramdet_fk_prestacion." , ";
        $sql .= " ".$this->tramdet_fk_diente." , ";
        $sql .= " '".json_encode($this->tramdet_jsoncaras)."' , ";
        $sql .= " ".$this->tramdet_subtotal." , ";
        $sql .= " ".$this->tramdet_desconvenio." , ";
        $sql .= " ".$descAdicional." , ";
        $sql .= " ".$this->tramdet_total." , ";
        $sql .= " ".$this->tramdet_cantidad." , ";
        $sql .= " '".$this->tramdet_detencion."' ,  "; #detencion permanente - permanente
        $sql .= " ".$this->tramdet_fk_usuario."  ";
        $sql .= ");";

//        print_r($sql);
//        die();
        $rs = $this->db->query($sql);
        if(!$rs){
            $error = 'Ocurrió un error con la Operacion guardar detalle, Consulte con soporte Técnico';
        }

        #SE ACTUALIZA LA FECHA DE LA CITA CADA VEZ QUE HAY UN CAMBIO EN EL SISTEMA DEL MODULO PLAN DE TRATAMIENTO
        if($rs){
            $sqlUpDatePlantram = "UPDATE `tab_plan_tratamiento_cab` SET `ultima_cita`= now() WHERE `rowid`= ".$this->tramdet_fk_tramcab."  ";
            $rs = $this->db->query($sqlUpDatePlantram);
        }

        return $error;
    }

    #Update detalle del plan de tratamiento
    public function Updateplantratmdetalle($id)
    {
        #Estados detalle
        #E eliminar
        #R realizado
        #A Activo

        $error = '';

        $sql  = "UPDATE `tab_plan_tratamiento_det` SET ";
        $sql .= " `json_caras` = '". json_encode( $this->tramdet_jsoncaras ) ."' ,";
        $sql .= " `desc_adicional` = ". $this->tramdet_descadicional ." ,";
        $sql .= " `total` = ". $this->tramdet_total ." ";
        $sql .= " WHERE `rowid`= ".$id." ";

//        print_r($sql); die();
        $rs = $this->db->query($sql);

        if(!$rs){
            $error = 'Ocurrió un error con la Operacion Modificar este detalle';
        }


        return $error;

    }


}

?>