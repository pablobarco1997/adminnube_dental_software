<?php

require_once '../../../../../config/lib.global.php';
session_start();

if(!isset($_SESSION['is_open']))
{
    header("location:".DOL_HTTP."/application/system/login");
}

require_once  DOL_DOCUMENT .'/application/system/conneccion/conneccion.php';    //Coneccion de Empresa
require_once  DOL_DOCUMENT .'/public/lib/mpdf60/mpdf.php';
require_once  DOL_DOCUMENT .'/application/controllers/controller.php';

/**SE CREA LAS VARIABLES DE INICIO**/
$cn = new ObtenerConexiondb();                    //Conexion global Empresa Fija
$db = $cn::conectarEmpresa($_SESSION['db_name']); //coneccion de la empresa variable global


$InformacionEntity = (object)array(
    'nombre'            => $_SESSION['nombreClinica'],
    'email'             => $_SESSION['emailClinica'],
    'direccion'         => $_SESSION['direccionClinica'],
    'telefonoClinica'   => $_SESSION['telefonoClinica'],
    'logoClinica'       => DOL_HTTP.'/logos_icon/icon_logos_'.$_SESSION['entidad'].'/'.$_SESSION['logoClinica'],
    'entidad'           => $_SESSION['entidad'],
);


$loginUsuario = $_SESSION['usuario']; #Login Inicio de Sesion
$pdf = null;

/**------------------------------------------------------------------------------------------------------------------**/


$dataPagosCab = [];
$dataPagosDet = [];

$idpaciente   = GETPOST('idpac');
$idpago       = GETPOST('npag');

$queryCabPag = "SELECT cast(fecha as  date) as fecha , n_fact_boleta  FROM tab_pagos_independ_pacientes_cab where  rowid = $idpago; ";
$dataPagosCab   = $db->query($queryCabPag)->fetchObject();


$queryDetPag = "SELECT 
   concat('PAG-',d.rowid) AS codpag ,
    (SELECT 
            c.descripcion
        FROM
            tab_conf_prestaciones c
        WHERE
            c.rowid = d.fk_prestacion) AS prestacion,
    (SELECT 
            IFNULL(dt.fk_diente, ' ')
        FROM
            tab_plan_tratamiento_det dt
        WHERE
            dt.rowid = d.fk_plantram_det) AS diente,
    d.amount
FROM
    tab_pagos_independ_pacientes_det d
WHERE
    d.fk_paciente = $idpaciente
        AND d.fk_pago_cab = $idpago";

$rsDet = $db->query($queryDetPag);
if($rsDet && $rsDet->rowCount()>0){

    while ($dp = $rsDet->fetchObject()){

        $prestacion = null;

        if($dp->diente==0){
            $prestacion = "&nbsp;&nbsp;&nbsp;&nbsp;".$dp->prestacion;
        }else{
            $prestacion = "&nbsp;&nbsp;&nbsp;&nbsp;".$dp->prestacion ." ". "<img src='".DOL_HTTP."/logos_icon/logo_default/diente.png' width='15px' height='15px' > ".$dp->diente;
        }
        $dataPagosDet[] = (object)array(
              'codpag'   => $dp->codpag,
              'prestacion' => $prestacion,
              'amount'     => $dp->amount,
        );
    }
}

//echo '<pre>'; print_r($dataPagosCab); die();



$pdf .= '<style>

            .tables { font-size: 1.2rem; }
            .theader{background-color: #688fc2;                border: 1px solid black;}
            .detalle{ border: 1px solid black; font-size: 1.2rem; padding: 5px !important;}
            .listdetalle tr:nth-child(even){background-color: #f2f2f2;}
            
            </style>';


$pdf .= '<table width="100%" class="tables">
            <tr>
                <td><b><h3>COMPROBANTE DE PAGO</h3></b></td>
                <td align="right" > <span> <img  src="'.$InformacionEntity->logoClinica.'"   style="border-radius: 50%" width="80px" height="80px" alt=""> </span> </td>
            </tr>
        </table>';

$pdf .= '<br>';
$pdf .= '<table width="100%" class="tables">
            <tr>
                <td>
                    <table width="100%" class="tables">
                        <tr>
                            <td><b>Clinica:</b>&nbsp;&nbsp; '.$InformacionEntity->nombre.'</td> 
                        </tr>
                        <tr>
                            <td><b>Direcciòn:</b> &nbsp;&nbsp; '.$InformacionEntity->direccion.'</td>
                        </tr>
                        <tr>
                            <td><b>Telefono:</b> &nbsp;&nbsp; '.$InformacionEntity->telefonoClinica.'</td>
                        </tr>
                        <tr>
                            <td><b>E-mail:</b> &nbsp;&nbsp; '.$InformacionEntity->email.'</td>
                        </tr>
                    </table> 
                </td>
                
                <td>
                    <table width="100%" class="tables">
                        <tr>
                            <td align="center">
                                <span><b>Fecha </b></span>
                                <hr>
                                <span>'.$dataPagosCab->fecha.'</span>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <span><b>Nº de Comprobante</b></span>
                                <hr>
                                <span>'.$dataPagosCab->n_fact_boleta.'</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
           
        </table>';

$pdf .= ' <br><br>
    <table width="100%" class="tables listdetalle" style="border-collapse: initial" >
        <thead>
            <tr class="theader">
                <th class="theader">Nº PAGO</th>
                <th class="theader">PRESTACIONES</th>
                <th class="theader">ABONO</th>
            </tr>
        </thead>
        <tbody>';

        $amountTotal = 0;
        foreach ($dataPagosDet as $key => $item) {

            $pdf.= '<tr>
                          <td  class="detalle">'.$item->codpag.'</td>
                          <td  class="detalle">'.$item->prestacion.'</td>
                          <td  class="detalle">'.$item->amount.'</td>  
                    </tr>';

            $amountTotal += (double)$item->amount;
        }

        $pdf .= '<tr> 
                    <td  class="detalle" colspan="2"> <b>TOTAL PAGOS</b> </td> 
                    <td  class="detalle"><b> '.$amountTotal.' </b></td> 
                </tr>';

$pdf .='</tbody>
    </table>';

ob_end_clean();


$mpdf=new mPDF('c','LETTER','10px','Calibri',
    12, //left
    12, // right
    23, //top
    18, //bottom
    3, //header top
    3 //footer botoom
);


$mpdf->SetHTMLHeader($header,"E",true);
$mpdf->SetHTMLHeader($header,"O",true);
$mpdf->SetHTMLFooter($footer,"E",true);
$mpdf->SetHTMLFooter($footer,"O",true);

// Make it DOUBLE SIDED document with 4mm bleed
$mpdf->mirrorMargins = 1;
$mpdf->bleedMargin = 4;
// Set left to right text
$mpdf->SetDirectionality('ltr');
$mpdf->showImageErrors = 'true';
$mpdf->SetDisplayMode('fullpage');
$mpdf->SetTitle('Comprobante de Pago' );

$mpdf->WriteHTML($body.$pdf);


$mpdf->Output('ejemplo.pdf', 'I');

print_r($pdf);
die();
?>