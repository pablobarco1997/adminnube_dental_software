

<?php

session_start();

include_once '../../../config/lib.global.php';
require_once DOL_DOCUMENT .'/application/config/main.php';
require_once DOL_DOCUMENT .'/application/system/pacientes/class/class_paciente.php';

global $db, $conf;

if(isset($_POST['ajaxSend']) && isset($_POST['accion']))
{


    if(isset($_POST['accion']))
    {

        $accion = $_POST['accion'];

        switch ($accion)
        {

            case "list_informacion_doc":

                $data = array();

                $idpaciente = GETPOST('idpaciente');

                $respobj = info_type_document_pacient( $idpaciente );


                $output = [
                    "data" => $respobj,
                ];

                echo json_encode($output);
                break;


            case 'nuevo_documentos_ficha_clinica':

                $error = "";

                $idpaciente    = GETPOST('idpaciente');
                $dataPrincipal = $_POST['principal'];

                $id_docuemnt_det = 0;
                $iddocumento_det = GETPOST('iddocumentdet'); # puede ser el id de cualquier documento por medio de un tipo

                if($iddocumento_det != 0 && !empty($idpaciente))
                {
                    $eliminar = 0;
                    #Si en caso existe lo elimino y lo vuelvo a crear - eliminar
                    $sql1 = "SELECT  * FROM tab_documentos_clinicos_admin where fk_document_det = '$iddocumento_det' and fk_document_clinico = 1";
                    $rsul1  = $db->query($sql1);
                    if($rsul1->rowCount() > 0)
                    {
                        $eliminar++;
                    }

                    #busco en la tabla ficha clinico para eliminarlo
                    $sql2 = "SELECT  * FROM tab_documentos_ficha_clinica where rowid = '$iddocumento_det' ";
                    $rsul2  = $db->query($sql2);
                    if($rsul2->rowCount() > 0)
                    {
                        $eliminar++;
                    }

                    if($eliminar > 0) #Se elimina el fichero y se vuelve a crear
                    {

                        $sqldel1 = "DELETE FROM `tab_documentos_clinicos_admin` WHERE `rowid` > 0 and fk_document_det = '$iddocumento_det' and fk_paciente = '$idpaciente'";
                        $r1 = $db->query($sqldel1);

                        if($r1){
                            $sqldel2 = "DELETE FROM `tab_documentos_ficha_clinica` WHERE `rowid` = '$iddocumento_det';";
                            $db->query($sqldel2);
                        }else{
                            $error = "Ocurrio un error con clinicos_admin , consulte con soporte tecnico";
                        }


                    }
                }

//                print_r($dataPrincipal);
//                die();
                $error = create_fichaClinica( (object)$dataPrincipal );
                $id_docuemnt_det = $db->lastInsertId("tab_documentos_ficha_clinica");

                if($error == '')
                {
                    $sql = "INSERT INTO `tab_documentos_clinicos_admin` (`label`, `fk_document_clinico`, `fk_usuario_logeado`, `fk_document_det`, `fk_paciente`) ";
                    $sql .= "   VALUES (";
                    $sql .= "   ' Ficha Clinica ', ";
                    $sql .= "   1 ,";
                    $sql .= "   '" . $conf->login_id . "' ,";
                    $sql .= "   "  . $id_docuemnt_det . "  , ";
                    $sql .= "   "  . $idpaciente. "   ";
                    $sql .= "   )";
                    $rs = $db->query($sql);

                    if (!$rs){
                        $error = 'Ocurrio un error no se pudo crear el documento';
                    }
                }


//                print_r($sql); die();

                $outuput = [
                    'error' => $error
                ];

                echo json_encode($outuput);

                break;


            case 'fetch_document': #Obtengo toda la informacion guardada del documento por tipo de documento

                $error= '';
                $typedocumennt  = GETPOST('idtypodocument');
                $iddocumen      = GETPOST('iddocument');
                $data = array();

                if( !empty($typedocumennt) )
                {

                    $data = fetch_set_document($typedocumennt,  $iddocumen);

                    if(count($data)==0)
                    {
                        $error = 'Ocurrio un error no se pudo obtener la informacion de este documento';
                    }


                }else{

                    $error = "Ocurrio un error no se identifica el tipo de documento";
                }

//                print_r($data);
//                print_r($error);
//                die();

                $outuput = [

                    'error' => $error,
                    'data'  => $data,
                ];
                echo json_encode($outuput);

                break;
        }



    }


}


//Id ficha clinica document - 1
function create_fichaClinica( $dataPrincipal = array() )
{

    global $db, $conf;

    $sqlNuevoUpdate = "INSERT INTO tab_documentos_ficha_clinica(";
    $sqlNuevoUpdate .= "   nombre_apellido";
    $sqlNuevoUpdate .= " , cedula_pasaporte";
    $sqlNuevoUpdate .= " , fecha_nacimiento";
    $sqlNuevoUpdate .= " , lugar_nacimiento";
    $sqlNuevoUpdate .= " , estado_civil";
    $sqlNuevoUpdate .= " , n_hijos";
    $sqlNuevoUpdate .= " , sexo";
    $sqlNuevoUpdate .= " , edad";
    $sqlNuevoUpdate .= " , ocupacion";
    $sqlNuevoUpdate .= " , direccion_domicilio";
    $sqlNuevoUpdate .= " , emergencia_call_a";
    $sqlNuevoUpdate .= " , emergencia_telefono";
    $sqlNuevoUpdate .= " , telefono_convencional";
    $sqlNuevoUpdate .= " , operadora";
    $sqlNuevoUpdate .= " , celular";
    $sqlNuevoUpdate .= " , email";
    $sqlNuevoUpdate .= " , twiter";
    $sqlNuevoUpdate .= " , lugar_trabajo";
    $sqlNuevoUpdate .= " , telefono_trabajo";
    $sqlNuevoUpdate .= " , posee_seguro";
    $sqlNuevoUpdate .= " , motivo_consulta";
    $sqlNuevoUpdate .= " , tiene_enfermedades";
    $sqlNuevoUpdate .= " , otras_enfermedades";

    $sqlNuevoUpdate .= " , esta_algun_tratamiento_medico";
    $sqlNuevoUpdate .= " , cual_tratamiento_medico";

    $sqlNuevoUpdate .= " , tiene_problema_hemorragico";
    $sqlNuevoUpdate .= " , cual_problema_hemorragico";

    $sqlNuevoUpdate .= " , alergico_medicamento";
    $sqlNuevoUpdate .= " , cual_alergico_medicamento";

    $sqlNuevoUpdate .= " , toma_medicamento";
    $sqlNuevoUpdate .= " , cual_toma_medicamento";

    $sqlNuevoUpdate .= " , esta_embarazada";
    $sqlNuevoUpdate .= " , cual_esta_embarazada";

    $sqlNuevoUpdate .= " , enfermedades_hereditarias";
    $sqlNuevoUpdate .= " , cual_enfermedades_hereditarias";

    $sqlNuevoUpdate .= " , que_toma_ult_24horass";
    $sqlNuevoUpdate .= " , resistente_medicamento";
    $sqlNuevoUpdate .= " , hemorragia_bucales";
    $sqlNuevoUpdate .= " , complicacion_masticar";
    $sqlNuevoUpdate .= " , habitos_consume";

    $sqlNuevoUpdate .= ")";
    $sqlNuevoUpdate .= "VALUES(";

    $sqlNuevoUpdate .= "  '$dataPrincipal->doc_nombre_apellido'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_cedula'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_fecha_nc'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_lugar_n'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_estado_civil'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_hijos_n'";
    $sqlNuevoUpdate .= ", '".json_encode($dataPrincipal->sexo)."'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_edad'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_ocupacion'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_domicilio'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_emergencia_call_a'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_emergencia_telef'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_telef_convencional'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_operadora'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_celular'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_email'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_twiter'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_lugar_trabajo'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_telef_trabajo'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_q_seguro_posee'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_motivo_consulta'";

    $sqlNuevoUpdate .= ", '".json_encode($dataPrincipal->enfermedades)."'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_otras_enferm'";

    $sqlNuevoUpdate .= ", '". json_encode($dataPrincipal->segui_tratamiento) ."'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_tratmient_descrip'";

    $sqlNuevoUpdate .= ", '". json_encode($dataPrincipal->problemas_hemorragicos) ."'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_descrip_hemorragicos'";

    $sqlNuevoUpdate .= ", '". json_encode($dataPrincipal->alergico_medicamento) ."'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_descrip_alergia'";

    $sqlNuevoUpdate .= ", '". json_encode($dataPrincipal->toma_medicamento_frecuente) ."'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_descrip_medicamento'";

    $sqlNuevoUpdate .= ", '". json_encode($dataPrincipal->embarazada) ."'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_descrip_embarazada'";

    $sqlNuevoUpdate .= ", '". json_encode($dataPrincipal->enferm_hederitarias) ."'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_descript_hederitaria'";

    $sqlNuevoUpdate .= ", '$dataPrincipal->q_medicina_tomo_24h_ultima'";
    $sqlNuevoUpdate .= ", '$dataPrincipal->doc_resistente_medicamento'";

    $sqlNuevoUpdate .= ", '". json_encode($dataPrincipal->hemorragias_bocales) ."'";

    $sqlNuevoUpdate .= ", '". json_encode($dataPrincipal->complicaciones_masticar) ."'";

    $sqlNuevoUpdate .= ", '". json_encode($dataPrincipal->abitos_consume) ."'";


    $sqlNuevoUpdate .= ")";

    $rs = $db->query($sqlNuevoUpdate);

    if(!$rs){
        return 'Error no se pudo guardar el documento Ficha clinica';
    }else{
        return '';
    }

}


function fetch_set_document($tyoedocmm = "", $iddocumdet = "")
{
    global  $db , $conf;

    $dataPrincipal= array();

    //FICHA CLINICA
    if($tyoedocmm == 1)
    {
        $sql = "SELECT * FROM tab_documentos_ficha_clinica where rowid = " . $iddocumdet;
        $rs  = $db->query($sql);

        if($rs->rowCount() > 0)
        {
            while ($Obj = $rs->fetchObject())
            {
                $dataPrincipal = $Obj;
            }
        }
    }

    return $dataPrincipal;

}


#LISTA DE DOCUMENTOS FILTRADOS
function info_type_document_pacient($idpaciente="")
{

    global  $db;

    $data = array();

    $sql = "
            SELECT 
                cl.rowid AS rowid,
                cl.tms AS fecha,
                cl.label AS label,
               
                -- loging del creador del documento
                (SELECT 
                        (SELECT 
                                    CONCAT(o.nombre_doc, ' ', apellido_doc)
                                FROM
                                    tab_odontologos o
                                WHERE
                                    o.rowid = s.fk_doc) AS labl
                    FROM
                        tab_login_users s
                    WHERE
                        s.rowid = cl.fk_usuario_logeado) AS login_creador_document,
                        
                        
                -- id tipo de documento
                cl.fk_document_clinico AS fk_documento,
                -- id del documento
                cl.fk_document_det
                
        FROM
            tab_documentos_clinicos_admin cl
        WHERE
            cl.rowid > 0 ";

    if($idpaciente!=""){
        $sql .= " and cl.fk_paciente =". (($idpaciente == "") ? 0 : $idpaciente);
    }
    $resul = $db->query($sql);
    if($resul->rowCount()>0)
    {
        while ($Fila = $resul->fetchObject())
        {
            $row = array();


            $row[] = date("Y/m/d", strtotime($Fila->fecha));
            $row[] = $Fila->label;
            $row[] = "Creado x Doc(a) " . (($Fila->login_creador_document=="") ? "No asignado": $Fila->login_creador_document);
            $row[] = "<div class='form-group col-md-12 col-xs-12'>
                        <ul class='list-inline pull-right'>
                           
                            <li class='btn lipdf'    data-idtipo='$Fila->fk_documento'  data-iddocument='$Fila->fk_document_det' id='impr_pdf'>
                                 <a href='#' class='impripdf' >  <img src='". DOL_HTTP ."/logos_icon/logo_default/pdf.png' alt='Export - pdf' class='img-rounded img-md'> </a> 
                            </li>
                            
                            <li class='btn liexcel '  data-idtipo='$Fila->fk_documento'  data-iddocument='$Fila->fk_document_det'> 
                                <a href='#' class='disabled_link3'> <img src='". DOL_HTTP ."/logos_icon/logo_default/xls.png' alt='Export - pdf' class='img-rounded img-md'> </a> 
                            </li>
                             
                            <li class='btn limodificar'  data-idtipo='$Fila->fk_documento'  data-iddocument='$Fila->fk_document_det'> 
                                <a href='" . DOL_HTTP . "/application/system/pacientes/pacientes_admin/?view=docummclin&key=". KEY_GLOB ."&id=". tokenSecurityId( $idpaciente ) ."&v=docum_clin&dt=". $Fila->fk_documento ."&iddocmnt=". $Fila->fk_document_det ."'> 
                                    <img src='". DOL_HTTP ."/logos_icon/logo_default/modificar-icon.png' alt='Export - pdf' class='img-rounded img-md'> 
                                </a> 
                            </li>
                            
                        </ul>
                      </div>";


            $row[] = $Fila->fk_documento; //id del documento
            $row[] = $Fila->fk_document_det; #id del documento detallado "tab_documentos_clinicos_admin"
            $row[] = $Fila->rowid; #Id de la cabezera principal tabla del documento tab_documentos_ficha_clinica o puede ser diferentes tablas

            $data[] = $row;
        }

    }

    return $data;

}

?>