<?php

require_once '../../../application/config/lib.global.php';
include_once DOL_DOCUMENT .'/public/information/conneccion/connection_info.php';
require_once DOL_DOCUMENT .'/application/controllers/controller.php';

if(isset($_POST['dbname']))
{
    global  $db;

    $db = connection( trim(decomposeSecurityTokenId($_POST['dbname'])) );

    if(isset($_POST['ajaxSend']) || isset($_GET['ajaxSend']))
    {

        $Datequery    = "SELECT NOW() dateCurrent";
        $DateNow = $db->query($Datequery)->fetch_object()->dateCurrent;

        $accion = GETPOST('accion');

        switch (  $accion  )
        {

            case 'asistir_confim':

                $error = '';
                $iddetcita  = GETPOST('idcita'); #id de la cita detalle


                if($iddetcita != '' && $iddetcita > 0)
                {
                    $data_citas = [];
                    $errores = [];

                    $obtenerCita = "SELECT d.rowid , d.fecha_cita, d.fk_estado_paciente_cita , c.fk_paciente FROM tab_pacientes_citas_det d , tab_pacientes_citas_cab c where d.fk_pacient_cita_cab = c.rowid and d.rowid = $iddetcita limit 1";
                    $rsCita      = $db->query($obtenerCita);
                    if($rsCita && $rsCita->num_rows>0)
                    {

                        $obcita = $rsCita->fetch_object();

//                        print_r($obcita->rowid); echo '<br>'; print_r($obcita->fk_paciente); die();
//                        print_r($obcita); die();
                        /** FECHAS ASIGNADAS FECHA DE LA CITA ACTUAL **/
                        $FechaCitas  = $obcita->fecha_cita;
                        $FechaActual = $DateNow;


                        #en esta validacion de fecha toma encuenta FECHA Y HORA
                        if( $FechaActual <= $FechaCitas  )
                        {
                            #echo '<pre>';  print_r( $FechaCitas .' >= '. $DateNow ); die();
                            if( $obcita->fk_estado_paciente_cita == 1 )
                            {
                                #SE ACTUALIZA A ESTADO CONFIRMADO X PACIENTE EMAIL
                                $sqlUpdatConfirmPacient = "UPDATE `tab_pacientes_citas_det` SET `fk_estado_paciente_cita` = 10 WHERE `rowid`= $iddetcita ;";
                                $rs = $db->query($sqlUpdatConfirmPacient);
                                if(!$rs)
                                {
                                    $error = 'Ocurrio un error intentelo de nuevo';
                                }

                                if($rs){

                                    if($iddetcita!="")
                                    {

                                        $consult = " SELECT rowid FROM tab_noti_confirmacion_cita_email where fk_cita = $iddetcita";
                                        $rsulConsult = $db->query($consult);
//                                        print_r($rsulConsult); die();
                                        if( $rsulConsult )
                                        {

                                            if($rsulConsult->num_rows > 0)
                                            {
                                                #SI EN CASO CONFIRMA QUE SI ASISTIRA
                                                $sqlUpdatConfirmPacient = " UPDATE `tab_noti_confirmacion_cita_email` SET `date_confirm`= now(), `estado`='10', `fecha_cita`= '$FechaCitas', `comment`='', `action`='ASISTIR' WHERE `rowid` > 0 and fk_cita = $iddetcita ";
                                                $rsConfirm = $db->query($sqlUpdatConfirmPacient);

                                                if( $rsConfirm ){
                                                    #
                                                }

                                                if(!$rsConfirm){
                                                    $error = 'Ocurrio un error con la Operacion - <b> No puede confirmar esta cita por favor intentarlo mas tarde </b> ';
                                                }

                                            }else{
                                                $error = 'No puede confirmar esta Cita';
                                            }

                                        }else{

                                            $error = 'Ocurrio un error con la Operacion';

                                        }
                                    }
                                }

                            }elseif ( $obcita->fk_estado_paciente_cita == 10 ){

                                $error = 'Ya se encuentra confirmada esta cita';

                            } else{

                                $error = 'Ya no puede confirmar esta cita, La cita se encuentra con un estado diferente';
                            }

                        }else{

                            $error = 'Ya no puede confirmar esta cita la fecha ya se encuentra <b>Atrazada</b>';
                        }

                    }else{
                        $error = 'Ocurrio un error no puede confirmar esta cita';
                    }
                }

                $output = [
                    'error' => $error,
                ];

                echo json_encode($output);
                break;
        }
    }


}else{
    echo json_encode(['error' => 'Ocurrio un error']);
}




?>