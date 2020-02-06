<?php

require_once '../../../../config/lib.global.php';
session_start();

if(!isset($_SESSION['is_open']))
{
    header("location:".DOL_HTTP."/application/system/login");
}
require_once DOL_DOCUMENT .'/application/config/main.php';
require_once DOL_DOCUMENT .'/public/lib/mpdf60/mpdf.php';




$id = GETPOST('id');

$datos = [];
$sql = "SELECT * FROM tab_admin_pacientes  WHERE rowid in($id)";
$rs  = $db->query($sql);
if($rs->rowCount()>0){
    while ($obj = $rs->fetchObject())
    {
        $datos[] = (object)array(
            'nombre'          => $obj->nombre . ' '.  $obj->apellido,
            'rud_dni'         => $obj->rut_dni,
            'email'           => $obj->email,
            'numeroCelular'   => $obj->telefono_movil,
        );
    }
}


$pdf .= '<style>
            .tables {
                border-collapse: collapse;
                 width="100%"; 
               
            }
            
            .tables {
                border: 1px solid black;
                font-size: 1.1rem;
                padding: 3px;
            }
            
            </style>';

$pdf .= "
    <table  width='100%' class='tables'>
        <tr  style='width: 100%'>
            <td style='text-align: center'> <h2> DIRECTORIO DE PACIENTES</h2> </td>
        </tr>
    </table>    
        ";


//echo '<pre>';
//print_r($datos);
//die();
//LISTA DE PACIENTES

$pdf .= "<table width='100%' class=\"tables\">";
    $pdf .= "<thead>
                <tr class='tables'>
                    <th>PACIENTE</th>
                    <th>Rud/Dni</th>
                    <th>E-mail</th>
                    <th>TELEFONO</th>
                </tr>
            </thead>
            <tbody>";

    foreach ($datos as $key => $val){

        $pdf .= "<tr>";
            $pdf .= "<td width='25%' class=\"tables\">".$val->nombre."</td>";
            $pdf .= "<td width='25%' class=\"tables\">".$val->rud_dni."</td>";
            $pdf .= "<td width='25%' class=\"tables\">".$val->email."</td>";
            $pdf .= "<td width='25%' class=\"tables\">".$val->numeroCelular."</td>";
        $pdf .= "</tr>";

    }

    $pdf .= "</tbody>";
$pdf .= "</table>";


$footer = '<!--<hr style="margin-bottom: 2px"><table width="100%" style="font-size: 10pt;">-->
<br>
          <table>
                <tr>
                    <td width="50%">
                        <div align="left">'. $conf->EMPRESA->INFORMACION->email .'</div>
                    </td>
                    <td width="50%" align="right">
                        <!--<div  style="float: right">Pagina:{PAGENO}</div>-->
                    </td>
                </tr>
            </table>';



$mpdf=new mPDF('c','LETTER','10px','arial',
    12, //left
    12, // right
    23, //top
    18, //bottom
    3, //header top
    3 //footer botoom
);

$header = ' 
    <table width="100%" style="vertical-align: bottom; font-family: Arial; font-size: 9pt; color: black;">
        <tr>
          <td width="100%" align="left"><span style="font-size:28pt;">'.$conf->EMPRESA->INFORMACION->nombre.'</span></td>
        </tr>
        <tr>
            <td width="33%">'.$conf->EMPRESA->INFORMACION->direccion.' <span style="font-size:10pt;"></span></td>
            <td width="33%" style="text-align: right;">Usuario:<span style="font-weight: bold;"> '.$user->name.'</span></td>
        </tr>
        <tr>
            <td width="33%">'.$conf->EMPRESA->INFORMACION->email.'<span style="font-size:10pt;"></span></td>
            <td width="33%" style="text-align: right;">Fecha: <span style="font-weight: bold;">{DATE j/m/Y}</span></td>
        </tr>
    </table>
    ';

$mpdf->mirrorMargins = 1;	// Use different Odd/Even headers and footers and mirror margins

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
$mpdf->SetTitle('Directorio' );

$mpdf->WriteHTML($body.$pdf);


//para evitar errores por los mensajes de avertencias que salen por pantalles bloqueando la salida del pdf

ob_start();
error_reporting(E_ALL & ~E_NOTICE);

ini_set('display_errors', 0);
ini_set('log_errors', 1);

//limpieza del búfer antes de la salida () antes de generar elarchivo pdf
ob_end_clean(); // cleaning the buffer before Output()

error_reporting(E_ALL);

#Muestro la Informacion

//$mpdf->Output('DirectorioPacientes.pdf', 'I'); #IMPRIMIR EL PDF POR browser google
//$mpdf->Output('DirectorioPacientes.pdf', 'D'); #DESCARGA EL PDF DIRECTAMENTE
$mpdf->Output(); 

exit;

?>