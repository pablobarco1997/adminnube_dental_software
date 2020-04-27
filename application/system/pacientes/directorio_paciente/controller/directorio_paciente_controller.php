<?php

session_start();

require_once '../../../../config/lib.global.php';
require_once DOL_DOCUMENT.'/application/config/main.php';

if(isset($_GET['ajaxSend']) || isset($_POST['ajaxSend']))
{

    $accion = GETPOST('accion');

    switch($accion)
    {
        case 'direct_pacient_list':

            $estado = GETPOST('estado');
            $data = array();
            $sql = "SELECT * FROM tab_admin_pacientes WHERE rowid > 0 ";

            if(!empty($estado))
            {
                if($estado == 'E'){ $sql .= " and estado = 'E' "; }
                if($estado == 'A'){ $sql .= " and estado = 'A' "; }
            }

            $rs = $db->query($sql);

            if($rs->rowCount() > 0)
            {
                while($fila =  $rs->fetchObject())
                {
                    $row = array();

                    /*
                     * {
                     *      key: PASSWORD ,
                     *      id: 18
                     * }
                     * */
                    #ID IMPORTANTE YA QUE ES UN TOKEN CREADO COMO UN ID DE LA CITAS GENERADO EN UN BINARIO HEXADECIMAL
                    $token = tokenSecurityId($fila->rowid); #ME RETORNA UN TOKEN
                    $view  = "dop"; #view vista de datos personales admin pacientes

                    $row[] = $fila->nombre;
                    $row[] = $fila->apellido;
                    #$row[] = "<a id='ruddni_link' class='link_pacientes_id' data-id='$fila->rowid' href='".DOL_HTTP."/application/system/pacientes/admin_paciente?view=form_datos_personales&id=$fila->rowid'>$fila->rut_dni</a>";
                    $row[] = "<a id='ruddni_link' class='link_pacientes_id' data-id='$fila->rowid' 
                                    href='".DOL_HTTP."/application/system/pacientes/pacientes_admin?view=$view&key=".KEY_GLOB."&id=$token'> $fila->ruc_ced </a> ";
                    $row[] = $fila->email;
                    $row[] = (($fila->telefono_movil == "") ? "No asignado" : $fila->telefono_movil);

                    if($estado=='A')
                    {
                        $row[] = "<a class='btn btn-block btn-danger btn-xs' onclick='ActivarEliminarPaciente($fila->rowid,0)'>Eliminar</a>";
                    }

                    if($estado=='E')
                    {
                        $row[] = "<a class='btn btn-block btn-success btn-xs' onclick='ActivarEliminarPaciente($fila->rowid,1)'>Activar</a>";
                    }

                    $data[] = $row;
                }
            }

            $output = [
             'data' => $data,
            ];

            echo json_encode($output);

            break;

        case 'ObtenerPacienteslistaSearch':

            $data = [];

            #nombre ingresado del paciente nombre apellido or
            $nom = GETPOST('label');

            if( !empty($nom) )
            {

                $sql = "SELECT * FROM tab_admin_pacientes ps WHERE ps.nombre  like '%$nom%'  or ps.apellido like '$nom%' ";
                $rs = $db->query($sql);
                if($rs->rowCount() > 0)
                {
                    while( $obPaciente =  $rs->fetchObject() )
                    {
                        $data[] = array(
                            'nomb'  =>  $obPaciente->nombre .' '.$obPaciente->apellido,
                            'id'    => tokenSecurityId( $obPaciente->rowid )
                        );
                    }
                }

            }else{

                $data[] = array(
                    'nomb'  =>  'NO SE ENCONTRO RESULTADOS ...',
                    'id'    =>  ''
                );
            }

            echo json_encode($data);

            break;

        case 'updateEstado':

            $id = GETPOST('id');
            $estado = GETPOST("estado");
            $error = false;

            if(!empty($id)) {
                $sql = "UPDATE `tab_admin_pacientes` SET `estado` = '$estado' WHERE (`rowid` = '$id');";
                $rs = $db->query($sql);
                if($rs){$error='OK';}
            }

            echo json_encode($error);

            break;
    }
}

?>