<?php

$VISTAS      = $_GET['view'];

#VISTAS FORMULARIOS
switch($VISTAS)
{

    case "dop": #DATOS PEROSNALES
        $VIEW_GLOB_ADMIN_PACIENTES   = "dop_formulario";    #view formulario
        $DIRECTORIO_ADMIN            = "datos_personales";  #directorio
        $_JS_DOCMENT                 = "pacientesdatos";    #doc javascript
        $NAME_MODULO                 = "DATOS PERSONALES";
        break;

    case "arch": #ARCHIVOS
        $VIEW_GLOB_ADMIN_PACIENTES   = "form_ficheros_pacientes";    #view formulario
        $DIRECTORIO_ADMIN            = "archivos_ficheros";          #directorio
        $_JS_DOCMENT                 = "ficherosp";                  #doc javascript
        $NAME_MODULO                 = "ARCHIVOS PACIENTE";
        break;

    case "commp": #COMMENTARIO
        $VIEW_GLOB_ADMIN_PACIENTES   = "commentp";                    #view formulario
        $DIRECTORIO_ADMIN            = "comment_pacientes";           #directorio
        $_JS_DOCMENT                 = "commentp";                    #doc javascript
        $NAME_MODULO                 = "COMENTARIOS ADMINISTRATIVOS";
        break;

    case "plantram": #PLAN DE TRATAMIENTO
        $VIEW_GLOB_ADMIN_PACIENTES   = "plantram";                    #view formulario
        $DIRECTORIO_ADMIN            = "plan_tratamiento";            #directorio
        $_JS_DOCMENT                 = "plant";                       #doc javascript
        $NAME_MODULO                 = "PLAN DE TRATAMIENTO";
        break;

    case "odot": #ODONTOGRAMA ACTUAL
        $VIEW_GLOB_ADMIN_PACIENTES   = "principal_odontograma";        #view formulario
        $DIRECTORIO_ADMIN            = "odontograma_paciente";         #directorio
        $_JS_DOCMENT                 = "odont";                        #doc javascript
        $NAME_MODULO                 = "ODONTOGRAMA";
        break;

    case "citasoci": #CITAS ASOCIADAS
        $VIEW_GLOB_ADMIN_PACIENTES   = "citasoci";                #view citas asociadas
        $DIRECTORIO_ADMIN            = "citas_asociadas";         #directorio
        $_JS_DOCMENT                 = "citasoci";                #doc javascript
        $NAME_MODULO                 = "CITAS ASOCIADAS";
        break;


    case "docummclin": #DOCUMENTOS CLINICOS
        $VIEW_GLOB_ADMIN_PACIENTES   = "documprinp";                    #view documentos clinicos asociados
        $DIRECTORIO_ADMIN            = "document_clinico";              #directorio
        $_JS_DOCMENT                 = "indx_documclin";                #doc javascript
        $NAME_MODULO                 = "DOCUMENTOS CLINICOS ASOCIADOS";
        break;


    case "pagospaci": #PAGOS DE PACIENTES
        $VIEW_GLOB_ADMIN_PACIENTES   = "pagos_principl";                    #view Pagos Principal
        $DIRECTORIO_ADMIN            = "pagos_pacientes";                   #directorio
        $_JS_DOCMENT                 = "indexpagos";                        #doc javascript
        $NAME_MODULO                 = "RECAUDACIONES";
        break;

    case "evoluc":                                                         #EVOLUCIONES DE PACIENTE
        $VIEW_GLOB_ADMIN_PACIENTES   = "evulocprinp";                       #view Pagos Principal
        $DIRECTORIO_ADMIN            = "evoluciones";                       #directorio
        $_JS_DOCMENT                 = "evulprincp";                        #doc javascript
        $NAME_MODULO                 = "EVOLUCIONES DEL PACIENTE";
        break;

case "pagrealipricp":                                                        #PAGOS REALIZADOS DEL PACIENTE
        $VIEW_GLOB_ADMIN_PACIENTES   = "pago_realprincp";                    #view Pagos realizados Principal
        $DIRECTORIO_ADMIN            = "pagos_recibidos";                    #directorio
        $_JS_DOCMENT                 = "pagrealizadprincp";                  #doc javascript
        $NAME_MODULO                 = "PAGOS REALIZADOS";
        break;

    case "mail":
        $VIEW_GLOB_ADMIN_PACIENTES   = "principl_email";                    #view E-mail
        $DIRECTORIO_ADMIN            = "email_sent";                        #directorio
        $_JS_DOCMENT                 = "email_prinpsent";                   #E-mail javascript
        $NAME_MODULO                 = "E-MAIL ENVIADOS";
        break;

}

?>