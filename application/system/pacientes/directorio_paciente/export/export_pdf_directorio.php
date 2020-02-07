<?php

//header('Content-type: application/pdf');

require_once '../../../../config/lib.global.php';
session_start();

if(!isset($_SESSION['is_open']))
{
    header("location:".DOL_HTTP."/application/system/login");
}

//require_once  DOL_DOCUMENT  .'/application/config/lib_glob_export.php';

require_once  DOL_DOCUMENT .'/application/system/conneccion/conneccion.php';    //Coneccion de Empresa
require_once  DOL_DOCUMENT .'/public/lib/mpdf60/mpdf.php';
require_once  DOL_DOCUMENT .'/application/controllers/controller.php';
/**SE CREA LAS VARIABLES DE INICIO**/
$cn = new ObtenerConexiondb();                    //Conexion global Empresa Fija
$db = $cn::conectarEmpresa($_SESSION['db_name']); //coneccion de la empresa variable global


$loginUsuario = $_SESSION['usuario'];
$pdf = null;
$id = GETPOST('id');

//echo '<pre>';
//print_r($loginUsuario);
//die();

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

//print_r($datos);
//die();


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
        <tr  style='width: 100%; background-color: #688fc2'>
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
                        <div align="left">'. $InformacionEntity->email .'</div>
                    </td>
                    <td width="50%" align="right">
                        <!--<div  style="float: right">Pagina:{PAGENO}</div>-->
                    </td>
                </tr>
            </table>';




$header = ' 
    <table width="100%" style="vertical-align: bottom; font-family: Arial; font-size: 9pt; color: black;">
        <tr>
          <td width="100%" align="left"><span style="font-size:28pt;">'.$InformacionEntity->nombre.'</span></td>
        </tr>
        <tr>
            <td width="33%">'.$InformacionEntity->direccion.' <span style="font-size:10pt;"></span></td>
            <td width="33%" style="text-align: right;">Usuario:<span style="font-weight: bold;"> '.$loginUsuario.'</span></td>
        </tr>
        <tr>
            <td width="33%">'.$InformacionEntity->email.'<span style="font-size:10pt;"></span></td>
            <td width="33%" style="text-align: right;">Fecha: <span style="font-weight: bold;">{DATE j/m/Y}</span></td>
        </tr>
    </table>
    ';

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
$mpdf->SetTitle('directorio de pacientes' );

$mpdf->WriteHTML($body.$pdf);


$mpdf->Output('ejemplo.pdf', 'I');
//print_r($mpdf); die();
//exit;

?>