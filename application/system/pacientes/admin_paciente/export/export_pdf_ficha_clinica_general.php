<?php

require_once '../../../../config/lib.global.php';

session_start();

//print_r(DOL_HTTP); die();
if(!isset($_SESSION['is_open']))
{
    header("location:".DOL_HTTP."/application/system/login");
}


require_once DOL_DOCUMENT .'/application/config/main.php';
require_once DOL_DOCUMENT .'/public/lib/mpdf60/mpdf.php';
require_once DOL_DOCUMENT .'/application/system/pacientes/admin_paciente/controller/controller_adm_paciente.php';

global $conf, $db, $user;

$id = GETPOST("iddocument");

$objeto = array();
$sql = "SELECT * FROM tab_documentos_ficha_clinica where rowid = $id";
$result = $db->query($sql);

if($result->rowCount()>0)
{
    while ($ob = $result->fetchObject())
    {
        $objeto = $ob;
    }

}
//echo '<pre>';
//print_r($objeto);
//die();

$pdf .= '<style>
            .tables {
                border-collapse: collapse;
                 width="100%"; 
               
            }
            
            .tables {
                border: 1px solid black;
            }
            
            .borderButom{
                 border-bottom: 1px solid black;
                 text-align: left;
            }
            .fonttml{
                font-size: 1.1rem;
            }
            </style>';

$pdf .= "
    <table  width='100%' class='tables'>
        <tr  style='width: 100%'>
            <td style='text-align: center'> <h2> FICHA CLINICA</h2> </td>
        </tr>
    </table>    
        ";

$pdf .= "<br>";
$pdf .= "
    <table width='100%'  class='borderButom'>
        <tr style='width: 100%' >
            <td width='20%' class='fonttml'>
               <b> NOMBRE Y APELLIDO:</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                 $objeto->nombre_apellido 
            </td>
        </tr>
    </table>";

$pdf .= "
<table width='100%'  class='borderButom' >
        <tr style='width: 100%' >
        
            <td width='25%' class='fonttml' >
                <b>CEDULA/PASAPORTE:</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                $objeto->cedula_pasaporte
            </td>
             
            <td width='20%' class='fonttml'>
               <b>FECHA NACIMIENTO:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               $objeto->fecha_nacimiento
            </td>
          
        </tr>
       
    </table>";

$pdf .= "
<table width='100%'  class='borderButom' >
        <tr style='width: 100%'>
            <td width='33.33%' class='fonttml'>
                <b>LUGAR DE NACIMIENTO </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                 $objeto->lugar_nacimiento Guayaquil
            </td>
            
            <td width='33.33%' class='fonttml'>
              <b>ESTADO CIVIL</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                $objeto->estado_civil
            </td>
            
            <td width='33.33%' class='fonttml'>
                <b>NUMEROS DE HIJOS</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                $objeto->n_hijos
            </td>
        </tr>
       
    </table>";


$sexo = "";
if(json_decode($objeto->sexo)->masculino == "true")
{
    $sexo= "masculino";
}
if(json_decode($objeto->sexo)->femenino == "true"){
    $sexo= "femenino";
}

$pdf .= "
<table  style='width: 100%'  class='borderButom'>
     <tr style='width: 100%'>
        <td width='16.66%' class='fonttml'><b>SEXO:</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $sexo </td>
        <td width='16.66%' class='fonttml'><b>EDAD:</b>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $objeto->edad</td>
        <td width='16.66%' class='fonttml'><b>OCUPACIÓN:</b>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $objeto->ocupacion </td> 
    </tr>
</table>";


$pdf .= "
<table  class='borderButom' width='100%'>
     <tr style='width: 100%'>
        <td width='16.66%' class='fonttml'><b>DIRECCIÓN DE DOMICILIO:</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ".$objeto->direccion_domicilio."</td>
    </tr>
</table>";

$pdf .= "
<table style='width: 100%; ' class='borderButom'>

    <tr style='width: 100%'>
   
        <td width='16.66%' class='fonttml'><b>TELEFONO CONVENCIONAL:</b>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $objeto->telefono_convencional </td>
        <td width='16.66%' class='fonttml'><b>OPERADORA:</b>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $objeto->operadora </td>
        <td width='16.66%' class='fonttml'><b>CELULAR:</b>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $objeto->celular </td>
   
   
    </tr>
    
</table>";

$pdf .= "
<table width='100%' class='borderButom'>
<tr style='width: 100%'>
    <td width='50%' class='fonttml'>
        <b>EN CASO DE EMERGENCIAS LLAMAR A:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        $objeto->emergencia_call_a
    </td>
    <td width='50%' class='fonttml'>
        <b>TELEFONO:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        $objeto->emergencia_telefono
    </td>
</tr>
</table>
";

$pdf .= "
<table width='100%' class='borderButom'>
<tr style='width: 100%'>
    <td width='50%' class='fonttml'>
        <b>E-MAIL:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        $objeto->email
    </td>
    <td width='50%' class='fonttml'>
        <b>TWITER:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        $objeto->twiter
    </td>
</tr>
</table>
";

$pdf .= "
<table width='100%' class='borderButom'>
<tr style='width: 100%'>
    <td width='50%' class='fonttml'>
        <b>LUGAR DE TRABAJO:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        $objeto->lugar_trabajo
    </td>
    <td width='50%' class='fonttml'>
        <b>TELEFONO:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        $objeto->telefono_trabajo
    </td>
</tr>
</table>
";

$pdf .= "
<table width='100%' class='borderButom'>
<tr style='width: 100%'>
    <td width='50%' class='fonttml'>
        <b>¿QUÉ SEGURO POSEE?:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        $objeto->posee_seguro
    </td>
    <td width='50%' class='fonttml'>
        <b>MOTIVO DE LA CONSULTA:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        $objeto->motivo_consulta
    </td>
</tr>
</table>
";

#ANTECEDENTES EMDICOS --------------------------------------------------------------------------------------------------

$pdf .= "<br>
    <table  width='100%' class='tables'>
        <tr  style='width: 100%'>
            <td style='text-align: center'> <h2> ANTECEDENTES MEDICOS </h2> </td>
        </tr>
    </table>   ";

$pdf .= "<br>
    <table  width='100%' style='border-bottom: 1px solid black'>
        
        <tr  style='width: 100%'>
            <td class='fonttml' width='100%'><b>¿TIENE CONFIRMADA ALGUNA(5) DE LAS SIGUIENTES ENFERMEDADES?</b></td>
        </tr>
    </table>
    
    <table>
    
        <tr style='width: 100%'>
       ";

//print_r(json_decode($objeto->tiene_enfermedades)->diabetes); die();
        $pdf .= "<td class='fonttml' width='50%'> 
                       ".iconcheckedboxtruefalse(json_decode($objeto->tiene_enfermedades)->respiratoria)."  &nbsp; RESPIRATORIA 
                 <td>
                 
                 <td class='fonttml' width='50%'> 
                       ".iconcheckedboxtruefalse(json_decode($objeto->tiene_enfermedades)->diabetes)."  &nbsp; DIABETES 
                 <td>
                 
                 <td class='fonttml' width='50%'> 
                       ".iconcheckedboxtruefalse(json_decode($objeto->tiene_enfermedades)->sida)."  &nbsp; SIDA (VIH) 
                 <td>
                 
                 <td class='fonttml' width='50%'> 
                       ".iconcheckedboxtruefalse(json_decode($objeto->tiene_enfermedades)->renal)."  &nbsp; RENAL 
                 <td>
                 ";
$pdf .=   "
        </tr> 
        
        <tr  style='width: 100%' >";

$pdf .= "
                 <td class='fonttml' width='50%'> 
                       ".iconcheckedboxtruefalse(json_decode($objeto->tiene_enfermedades)->cardiaca)."  &nbsp; CARDIACA 
                 <td>
                 
                 <td class='fonttml' width='50%'> 
                       ".iconcheckedboxtruefalse(json_decode($objeto->tiene_enfermedades)->sanguinia)."  &nbsp; SANGUINIA 
                 <td>
                 
                 <td class='fonttml' width='50%'> 
                       ".iconcheckedboxtruefalse(json_decode($objeto->tiene_enfermedades)->hepatitis)."  &nbsp; HEPATITIS
                 <td>
                 
                 <td class='fonttml' width='50%'> 
                       ".iconcheckedboxtruefalse(json_decode($objeto->tiene_enfermedades)->gastritis)."  &nbsp; GASTRICAS 
                 <td>
                 ";
$pdf .= "</tr>";

$pdf .= "</table>   ";

$pdf .= "
<table width='100%' style='border-bottom: 1px solid black'> 
        <tr style='width: 100%'>
                <td class='fonttml'> <b>OTRAS ENFERMEDADES:</b>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  $objeto->otras_enfermedades  </td>
        </tr>
</table>";

$pdf .= "
<table width='100%'>
    <tr style='width: 100%'>
        
        <td style='width: 33.33%'>
            <table>
                <tr style='width: 100%'>
                    <td class='fonttml'>¿ESTAS BAJO ALGUN TRATAMIENTO MEDICO?</td>                        
                </tr>
                <tr style='width: 100%'>
                    <td class='fonttml' >".iconcheckedboxtruefalse(json_decode($objeto->esta_algun_tratamiento_medico)->si)." SI  &nbsp;&nbsp;&nbsp; ".iconcheckedboxtruefalse(json_decode($objeto->esta_algun_tratamiento_medico)->no)." NO</td>
                </tr>
                <tr style='width: 100%'>
                    <td class='fonttml'>Cual? &nbsp;&nbsp; $objeto->cual_tratamiento_medico </td>
                </tr>
            </table>        
        </td>
        
        <td style='width: 33.33%'>
            <table style='border-left: 1px solid black'>
                <tr style='width: 100%'>
                    <td class='fonttml'>¿ES ALERGICO A ALGÚN MEDICAMENTO?</td>                        
                </tr>
                <tr style='width: 100%'>
                    <td class='fonttml' >".iconcheckedboxtruefalse(json_decode($objeto->tiene_problema_hemorragico)->si)." SI  &nbsp;&nbsp;&nbsp; ".iconcheckedboxtruefalse(json_decode($objeto->tiene_problema_hemorragico)->no)." NO</td>
                </tr>
                <tr style='width: 100%'>
                    <td class='fonttml'>Cual? &nbsp;&nbsp; $objeto->cual_problema_hemorragico </td>
                </tr>
            </table> 
        </td>
        
        <td style='width: 33.33%'>
            <table style='border-left: 1px solid black'>
                <tr style='width: 100%'>
                    <td class='fonttml'>¿ESTA EMBARAZADA?</td>                        
                </tr>
                <tr style='width: 100%'>
                    <td class='fonttml' >".iconcheckedboxtruefalse(json_decode($objeto->alergico_medicamento)->si)." SI  &nbsp;&nbsp;&nbsp; ".iconcheckedboxtruefalse(json_decode($objeto->alergico_medicamento)->no)." NO</td>
                </tr>
                <tr style='width: 100%'>
                    <td class='fonttml'>Cual? &nbsp;&nbsp; $objeto->cual_alergico_medicamento </td>
                </tr>
            </table> 
        </td>
    
    </tr>
</table>";



$pdf .= "
<table width='100%'>
    <tr style='width: 100%'>
        
        <td style='width: 33.33%'>
            <table>
                <tr style='width: 100%'>
                    <td class='fonttml'>¿TIENE PROBLEMAS HEMORRÁGICOS?</td>                        
                </tr>
                <tr style='width: 100%'>
                    <td class='fonttml' >".iconcheckedboxtruefalse(json_decode($objeto->tiene_problema_hemorragico)->si)." SI  &nbsp;&nbsp;&nbsp; ".iconcheckedboxtruefalse(json_decode($objeto->tiene_problema_hemorragico)->no)." NO</td>
                </tr>
                <tr style='width: 100%'>
                    <td class='fonttml'>Cual? &nbsp;&nbsp; $objeto->cual_problema_hemorragico </td>
                </tr>
            </table>        
        </td>
        
        <td style='width: 33.33%'>
            <table style='border-left: 1px solid black'>
                <tr style='width: 100%'>
                    <td class='fonttml'>¿TOMA ALGÚN MEDICAMENTO FRECUENTE?</td>                        
                </tr>
                <tr style='width: 100%'>
                    <td class='fonttml' >".iconcheckedboxtruefalse(json_decode($objeto->alergico_medicamento)->si)." SI  &nbsp;&nbsp;&nbsp; ".iconcheckedboxtruefalse(json_decode($objeto->alergico_medicamento)->no)." NO</td>
                </tr>
                <tr style='width: 100%'>
                    <td class='fonttml'>Cual? &nbsp;&nbsp; $objeto->cual_alergico_medicamento </td>
                </tr>
            </table> 
        </td>
        
        <td style='width: 33.33%'>
            <table style='border-left: 1px solid black'>
                <tr>
                    <td class='fonttml'>¿TIENE ENFERMEDAD(ES) HEREDITARIAS?</td>                        
                </tr>
                <tr style='width: 100%'>
                    <td class='fonttml' >".iconcheckedboxtruefalse(json_decode($objeto->enfermedades_hereditarias)->si)." SI  &nbsp;&nbsp;&nbsp; ".iconcheckedboxtruefalse(json_decode($objeto->enfermedades_hereditarias)->no)." NO</td>
                </tr>
                <tr style='width: 100%'>
                    <td class='fonttml'>Cual? &nbsp;&nbsp; $objeto->cual_enfermedades_hereditarias </td>
                </tr>
            </table> 
        </td>
    
    </tr>
</table>";

$pdf .= "<br>
    <table  width='100%' class='tables'>
        <tr  style='width: 100%'>
            <td style='text-align: center'> <h2> ANTECEDENTES ODONTOLOGICOS</h2> </td>
        </tr>
    </table>   ";

$pdf .= "<br>
<table width='100%'>
    <tr style='width: 100%'>
        <td width='50%'  class='fonttml'><b>¿QUÉ MEDICINA TOMÓ EN LAS ÚLTIMAS 24 HORAS?</b> &nbsp;&nbsp; <p  class='fonttml'>$objeto->que_toma_ult_24horass</p></td>
        <td width='50%' class='fonttml'><b>¿ES RESISTENTE A ALGÚN MEDICAMENTO?</b>&nbsp;&nbsp; <p  class='fonttml'>$objeto->resistente_medicamento</p></td>
    </tr>
</table>";

$pdf .= "<br>
<table width='100%'>
    
    <tr  style='width: 100%'>
        <td  class='fonttml'>
            <b>¿HA TENIDO HEMORRAGIAS BUCALES?</b> &nbsp;&nbsp;
        </td>
         <td  class='fonttml'>
            <b>¿COMPLICACIONES POR MASTICAR?</b> &nbsp;&nbsp;
        </td>
    </tr>
    
    <tr style='100%'>
         <td  class='fonttml'>
             ".iconcheckedboxtruefalse(json_decode($objeto->complicacion_masticar)->si)." SI  &nbsp;&nbsp;&nbsp; ".iconcheckedboxtruefalse(json_decode($objeto->complicacion_masticar)->no)." NO
          </td>
          <td  class='fonttml'>
             ".iconcheckedboxtruefalse(json_decode($objeto->hemorragia_bucales)->si)." SI  &nbsp;&nbsp;&nbsp; ".iconcheckedboxtruefalse(json_decode($objeto->hemorragia_bucales)->no)." NO
          </td>
    </tr>
    
</table> ";

$pdf .= "

<table width='100%'>
    
    <tr style='width: 100%'>
         <td style='width: 50%'>
             <table>
                 <tr>
                     <td  class='fonttml'> <b>¿TIENE LOS SIGUIENTES HÁBITOS DE CONSUMO? </b></td> 
                 </tr>
                 <tr> <td  class='fonttml'>  ".iconcheckedboxtruefalse(json_decode($objeto->habitos_consume)->doc_fumar)." FUMAR</td></tr>
                 <tr> <td  class='fonttml'>".iconcheckedboxtruefalse(json_decode($objeto->habitos_consume)->doc_alchol)." TOMAR ALCOHOL</td> </tr>
                 <tr> <td  class='fonttml'>".iconcheckedboxtruefalse(json_decode($objeto->habitos_consume)->doc_cafe)." TOMAR CAFÉ </td> </tr>
                 <tr> <td  class='fonttml'>".iconcheckedboxtruefalse(json_decode($objeto->habitos_consume)->doc_ninguno)." NINGUNO </td> </tr>
            </table>
        </td>
        
        <td style='width: 50%'>
            <table>
                 <tr>
                    <td style='text-align: center' class='fonttml'>DECLAROQUE HE RESPONDIDO TODAS LAS PREGUNTAS CON SINCERIDAD Y QUE NO RESPONSABILIZO A LA CLINICA POR LA INFORMACIÓN NO VERAZ</td>
                 </tr>
                <tr> <td>&nbsp;</td></tr>
                <tr> <td>&nbsp;</td></tr>
                <tr> <td>&nbsp;</td></tr>
                 <tr>
                     <td style='border-bottom: 1px solid black'></td>  
                </tr>
            </table>
        </td>
        
    </tr>
    
</table>";

#funciones checked true false
function iconcheckedboxtruefalse($booleano)
{
    $puedo = null;
    $puedo = $booleano;

//    echo '<pre>';
//    print_r($puedo);

    if($puedo == "true"){

        $checkedTrue  = "<img style='margin-top:1%' width=\"1.7%\" height=\"1.7%\" src='".DOL_HTTP."/logos_icon/logo_default/checkboxtrue.png' alt=''>";
        return $checkedTrue;
    }

    if($puedo == "false"){

        $checkedFalse = "<img style='margin-top:1%' width=\"1.7%\" height=\"1.7%\" src='".DOL_HTTP."/logos_icon/logo_default/checkboxfalse.png' alt=''>";
        return $checkedFalse;
    }

}
//die();

#CONF PDF --------------------------------------------------------------------------------------------------------------

$footer = '<!--<hr style="margin-bottom: 2px"><table width="100%" style="font-size: 10pt;">-->
<br>
              <table>
                    <tr>
                        <td width="50%">
                            <div align="left">www.dentalSoftware.com</div>
                        </td>
                        <td width="50%" align="right">
                            <!--<div  style="float: right">Pagina:{PAGENO}</div>-->
                        </td>
                    </tr>
                </table>';



$mpdf=new mPDF('c','LETTER','10px','Calibri',
    12, //left
    12, // right
    23, //top
    18, //bottom
    3, //header top
    3 //footer botoom
);

$header = ' 
    <table width="100%" style="vertical-align: bottom; font-family: monospace, monospace; font-size: 9pt; color: black;">
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
$mpdf->SetTitle('Ficha Clinica ' );

$mpdf->WriteHTML($body.$pdf);

#Muestro la Informacion
$mpdf->Output('FichaClinica.pdf', 'I');


#Descargar El Fichero Directamente
//$mpdf->Output('FichaClinica.pdf', 'D');


?>