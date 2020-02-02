<?php

    include_once '../../../config/lib.global.php';
    include_once  DOL_DOCUMENT .'/application/system/agenda/controller/agenda_controller.php';
    include_once  DOL_DOCUMENT .'/public/lib/mpdf60/mpdf.php';


    global $db, $conf, $user;


    $logo = !empty($conf->EMPRESA->INFORMACION->logo) ? DOL_HTTP.'/logos_icon/'.$conf->NAME_DIRECTORIO.'/'.$conf->EMPRESA->INFORMACION->logo :  DOL_HTTP .'/logos_icon/logo_default/icon_software_dental.png';
    $icon = "<img src='https://i.ytimg.com/vi/_pO85H6I5Ck/hqdefault.jpg'>";

    $fecha = GETPOST("fecha");
    $obj = fecth_diariaHorasGlobal($fecha, '' , $doctor, true, $estados);

//    echo '<pre>';
//    print_r($logo); die();

    $pdf .= '<style>
            .tables {
                border-collapse: collapse;
                 width="100%"; 
               
            }
            
            .tables {
                border: 1px solid black;
            }
            
            </style>';

    $htmlheader = '<table width="100%">
                        <tr>
                            <td style="width: 30%">
                               <img src="'.$logo.'" width="25%" height="25%">  
                            </td>
                            
                            <td rowspan="2" style="width: 50%;" >
                                <table class="tables">
                                    <tr class="tables"> <td></td> <td style="text-align: center;"> <h2 style="text-align: center;"> '.$conf->EMPRESA->INFORMACION->nombre.' </h2> </td> </tr>
                                    <tr class="tables"> <td> <h3> '.$conf->EMPRESA->INFORMACION->direccion.' </h3> </td> </tr>
                                    <tr class="tables"> <td> <h3> '.$conf->EMPRESA->INFORMACION->celular.' </h3> </td> </tr>
                                </table>
                            </td>
                               
                        </tr>
                    </table>';

    $htmltable = '<table width="100%" class="tables">';
        $htmltable .= '<thead>';
            $htmltable .= '<tr>';
                $htmltable .= '<th width="5%" class="tables">HORA</th>';
                $htmltable .= '<th width="15%" class="tables">DOCTOR</th>';
                $htmltable .= '<th width="15%" class="tables">PACIENTE</th>';
                $htmltable .= '<th width="10%" class="tables">RUC/CÉDULA</th>';
                $htmltable .= '<th width="10%" class="tables">TELÉFONO</th>';
                $htmltable .= '<th width="10%" class="tables">ESPECIALIDAD</th>';
                $htmltable .= '<th width="20%"class="tables">OBSERVACIÓN</th>';
            $htmltable .= '</tr>';
        $htmltable .= '</thead>';
        $htmltable .= '<tbody>';


        foreach ($obj as $key => $v)
        {
            $htmltable .= '<tr>';
            $htmltable .= '<td class="tables" >'.$v->hora_cita.'</td>';
            $htmltable .= '<td class="tables" >'.$v->doctor.'</td>';
            $htmltable .= '<td class="tables" >'.$v->paciente.'</td>';
            $htmltable .= '<td class="tables" >'.$v->rudcedula.'</td>';
            $htmltable .= '<td class="tables" >'.$v->telefonoMobil.'</td>';
            $htmltable .= '<td class="tables" >'.$v->especialidad.'</td>';
            $htmltable .= '<td class="tables" >'.$v->observacion.'</td>';
            $htmltable .= '</tr>';
        }



        $htmltable .= '</tbody>';
    $htmltable .= '</table>';

    $pdf .= '<br>'. $htmltable;

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

    $footer = '<!--<hr style="margin-bottom: 2px"><table width="100%" style="font-size: 10pt;">-->
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


    $pdfFooter='<hr>
    <table>
        <tr>
            <td>
                www.dentalSotware.com
            </td>
        </tr>
    </table>
    ';

    $mpdf=new mPDF('c','LETTER','10px','Calibri',
        12, //left
        12, // right
        23, //top
        18, //bottom
        3, //header top
        3 //footer botoom
    );

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
    $mpdf->SetTitle('Horas diarias global ' );

    $mpdf->WriteHTML($body.$pdf);

    $mpdf->Output();


//    print_r($pdf);
//    die();

?>