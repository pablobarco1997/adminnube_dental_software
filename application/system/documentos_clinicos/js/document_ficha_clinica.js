
function  fetch_ficha_clinica(idmod)
{

    var parametros = {

        "accion"     :  "nuevo_documentos_ficha_clinica",
        "ajaxSend"   :  "ajaxSend",
        "iddocumentdet" : idmod ,
        "idpaciente" :  $id_paciente,

        "principal"  : {

            "doc_nombre_apellido" : $("#doc_nombre_apellido").val() ,
            "doc_cedula"        :$("#doc_cedula").val(),
            "doc_fecha_nc"      :$("#doc_fecha_nc").val(),
            "doc_lugar_n"       :$("#doc_lugar_n").val(),
            "doc_estado_civil"  :$("#doc_estado_civil").find("option:selected").val(),
            "doc_hijos_n"       :$("#doc_hijos_n").val(),

            "sexo"    :{ "masculino": $("#radioMasculino").prop("checked") , "femenino": $("#radioFemenino").prop("checked") },

            "doc_edad"          :$("#doc_edad").val(),
            "doc_ocupacion"     :$("#doc_ocupacion").val(),
            "doc_domicilio"     :$("#doc_domicilio").val(),

            "doc_telef_convencional"    :$("#doc_telef_convencional").val(),
            "doc_operadora"             :$("#doc_operadora").find("option:selected").val(),
            "doc_celular"               :$("#doc_celular").val(),
            "doc_emergencia_call_a"     :$("#doc_emergencia_call_a").val(),
            "doc_emergencia_telef"      :$("#doc_emergencia_telef").val(),
            "doc_email"                 :$("#doc_email").val(),
            "doc_twiter"                :$("#doc_twiter").val(),
            "doc_lugar_trabajo"         :$("#doc_lugar_trabajo").val(),
            "doc_telef_trabajo"         :$("#doc_telef_trabajo").val(),
            "doc_q_seguro_posee"        :$("#doc_q_seguro_posee").val(),
            "doc_motivo_consulta"       :$("#doc_motivo_consulta").val(),

            "enfermedades":             {

                "respiratoria"   : $("#respiratoria").prop("checked") ,
                "diabetes"       : $("#diabetes").prop("checked")     ,
                "sida"           : $("#sida").prop("checked")         ,
                "renal"          : $("#renal").prop("checked")        ,
                "cardiaca"       : $("#cardiaca").prop("checked")     ,
                "sanguinia"      : $("#sanguinia").prop("checked")    ,
                "hepatitis"      : $("#hepatitis").prop("checked")    ,
                "gastritis"      : $("#gastritis").prop("checked")    ,

            },

            "doc_otras_enferm"      : $("#doc_otras_enferm").val(),

            "segui_tratamiento"     : { 'si': $("#doc_tratmient_si").prop("checked"), 'no':  $("#doc_tratmient_no").prop("checked") },
            "doc_tratmient_descrip" : $("#doc_tratmient_descrip").val(),

            "alergico_medicamento"  :  { 'si': $("#doc_alergia_si").prop("checked"), 'no':  $("#doc_alergia_no").prop("checked") },
            "doc_descrip_alergia"   :$("#doc_descrip_alergia").val(),

            "embarazada"                :{ 'si': $("#doc_embarazada_si").prop("checked"), 'no':  $("#doc_embarazada_no").prop("checked") },
            "doc_descrip_embarazada"    :$("#doc_descrip_embarazada").val(),


            "problemas_hemorragicos"        :{ 'si': $("#doc_hemorragicos_si").prop("checked"), 'no':  $("#doc_hemorragicos_no").prop("checked") },
            "doc_descrip_hemorragicos"      : $("#doc_descrip_hemorragicos").val(),

            "toma_medicamento_frecuente"    : {'si':$("#doc_medicamento_si").prop("checked"), "no": $("#doc_medicamento_no").prop("checked")},
            "doc_descrip_medicamento"       : $("#doc_descrip_medicamento").val(),

            "enferm_hederitarias"        : {'si':$("#doc_hereditaria_si").prop("checked"), "no": $("#doc_hereditaria_no").prop("checked")},
            "doc_descript_hederitaria"   : $("#doc_descript_hederitaria").val(),

            "q_medicina_tomo_24h_ultima"   : $("#doc_q_medicina_tomo_24h_ultima").val(),
            "doc_resistente_medicamento"   : $("#doc_resistente_medicamento").val(),

            "hemorragias_bocales"     :  { "si":$("#doc_hemorragias_si").prop("checked"), "no": $("#doc_hemorragias_no").prop("checked") },

            "complicaciones_masticar" :  { "si":$("#doc_problema_masticar_si").prop("checked"), "no": $("#doc_problema_masticar_no").prop("checked") },

            "abitos_consume"  : {
                "doc_fumar"     : $("#doc_fumar").prop("checked"),
                "doc_alchol"    : $("#doc_alchol").prop("checked"),
                "doc_cafe"      : $("#doc_cafe").prop("checked"),
                "doc_ninguno"   : $("#doc_ninguno").prop("checked"),
            },
        }
    }

    return parametros;
}

$('#guardar_informacion_fichaclinica').click(function() {

    var idmod        =  Get_jquery_URL('iddocmnt');
    var obtenerdatos =  fetch_ficha_clinica(idmod);

    $.ajax({
        url: $DOCUMENTO_URL_HTTP + "/application/system/pacientes/pacientes_admin/document_clinico/controller_document/controller_document.php",
        type: "POST",
        data: obtenerdatos,
        dataType: "json",
        success: function (resp){

            if(resp.error == '')
            {
                notificacion('Información Actualizada', 'success');

                setTimeout(function() {

                    window.location = $DOCUMENTO_URL_HTTP + '/application/system/pacientes/pacientes_admin/?view=docummclin&key='+$keyGlobal+'&id='+ Get_jquery_URL('id') +'&v=listdocumment';

                },2500);


            }else{

                notificacion(resp.error, 'error');
            }
        }
    });

});


//Se asigna el documento para modificar
function  setDocumentMod_fichaClinica(type_documn, iddocument)
{
    $.ajax({

        url: $DOCUMENTO_URL_HTTP + "/application/system/pacientes/pacientes_admin/document_clinico/controller_document/controller_document.php" ,
        type:"POST",
        data: {"ajaxSend":"ajaxSend", "accion":"fetch_document", "idtypodocument": type_documn, "iddocument": iddocument},
        dataType: "json",
        success: function(resp) {

            if(resp.error == '')
            {

                //Se asigna los datos guardados

                $("#doc_nombre_apellido").val(resp.data.nombre_apellido);
                $("#doc_cedula").val(resp.data.cedula_pasaporte);
                $("#doc_fecha_nc").val(resp.data.fecha_nacimiento);
                $("#doc_lugar_n").val(resp.data.lugar_nacimiento);
                $("#doc_estado_civil").val(resp.data.estado_civil).trigger('change');
                $("#doc_hijos_n").val(resp.data.n_hijos);
                $("#doc_edad").val(resp.data.edad);
                $("#doc_ocupacion").val(resp.data.ocupacion);
                $("#doc_domicilio").val(resp.data.direccion_domicilio);

                $("#doc_telef_convencional").val(resp.data.telefono_convencional);
                $("#doc_operadora").val(resp.data.operadora).trigger('change');
                $("#doc_celular").val(resp.data.celular);
                $("#doc_emergencia_call_a").val(resp.data.emergencia_call_a);
                $("#doc_emergencia_telef").val(resp.data.emergencia_telefono);
                $("#doc_email").val(resp.data.email);
                $("#doc_twiter").val(resp.data.twiter);
                $("#doc_lugar_trabajo").val(resp.data.lugar_trabajo);
                $("#doc_telef_trabajo").val(resp.data.telefono_trabajo);
                $("#doc_q_seguro_posee").val(resp.data.posee_seguro);
                $("#doc_motivo_consulta").val(resp.data.motivo_consulta);
                $("#doc_otras_enferm").val(resp.data.otras_enfermedades);

                $("#doc_q_medicina_tomo_24h_ultima").val(resp.data.que_toma_ult_24horass);
                $("#doc_resistente_medicamento").val(resp.data.resistente_medicamento);

                //JSON SEXO
                var sexo = JSON.parse(resp.data.sexo);
                $("#radioMasculino").attr("checked", (sexo.masculino == "true") ? true : false);
                $("#radioFemenino").attr("checked", (sexo.femenino == "true") ? true : false);

                // JSON ENFERMEDADES
                var enfermedades = JSON.parse(resp.data.tiene_enfermedades);

                // console.log( enfermedades );

                $("#respiratoria").attr('checked',  (enfermedades.respiratoria == "true") ? true:false);
                $("#diabetes").attr('checked',   (enfermedades.diabetes == "true")  ? true:false );
                $("#sida").attr('checked',       (enfermedades.sida == "true") ? true : false );
                $("#renal").attr('checked' ,     (enfermedades.renal == "true") ? true : false );
                $("#cardiaca").attr('checked',   (enfermedades.cardiaca == "true") ? true : false);
                $("#sanguinia").attr('checked',  (enfermedades.sanguinia == "true") ? true : false );
                $("#hepatitis").attr('checked',  (enfermedades.hepatitis == "true") ? true : false);
                $("#gastritis").attr('checked',  (enfermedades.gastritis == "true") ? true : false);

                // JSON  SI NO
                var tratamiento = JSON.parse(resp.data.esta_algun_tratamiento_medico);
                $("#doc_tratmient_si").attr("checked", (tratamiento.si=="true") ? true : false ); $("#doc_tratmient_no").attr("checked", (tratamiento.no=="true") ? true : false );
                $("#doc_tratmient_descrip").val(resp.data.cual_tratamiento_medico);

                var alergia = JSON.parse(resp.data.alergico_medicamento);
                $("#doc_alergia_si").attr("checked", (alergia.si=="true") ? true : false ); $("#doc_alergia_no").attr("checked", (alergia.no=="true") ? true : false );
                $("#doc_descrip_alergia").val(resp.data.cual_alergico_medicamento);

                var embarazada = JSON.parse(resp.data.esta_embarazada);
                $("#doc_embarazada_si").attr("checked", (embarazada.si=="true") ? true : false ); $("#doc_embarazada_no").attr("checked", (embarazada.no=="true") ? true : false );
                $("#doc_descrip_embarazada").val(resp.data.cual_esta_embarazada);

                var hemorragico = JSON.parse(resp.data.tiene_problema_hemorragico);
                $("#doc_hemorragicos_si").attr("checked", (hemorragico.si=="true") ? true : false ); $("#doc_hemorragicos_no").attr("checked", (hemorragico.no=="true") ? true : false );
                $("#doc_descrip_hemorragicos").val(resp.data.cual_problema_hemorragico);

                var medicamento_frecuente = JSON.parse(resp.data.toma_medicamento);
                $("#doc_medicamento_si").attr("checked", (medicamento_frecuente.si=="true") ? true : false ); $("#doc_medicamento_no").attr("checked", (medicamento_frecuente.no=="true") ? true : false );
                $("#doc_descrip_medicamento").val(resp.data.cual_problema_hemorragico);

                var enferme_hereditarias = JSON.parse(resp.data.enfermedades_hereditarias);
                $("#doc_hereditaria_si").attr("checked", (enferme_hereditarias.si=="true") ? true : false ); $("#doc_hereditaria_no").attr("checked", (enferme_hereditarias.no=="true") ? true : false );
                $("#doc_descript_hederitaria").val(resp.data.cual_enfermedades_hereditarias);

                //Hemorragias vocales
                var hemorragiasBocales = JSON.parse(resp.data.hemorragia_bucales);
                $("#doc_hemorragias_si").attr('checked',(hemorragiasBocales.si=="true") ? true : false ) ;
                $("#doc_hemorragias_no").attr('checked',(hemorragiasBocales.no=="true") ? true : false ) ;

                //Complicacion masticar
                var complicacion_masticar = JSON.parse(resp.data.complicacion_masticar);
                $("#doc_problema_masticar_si").attr('checked',(complicacion_masticar.si=="true") ? true : false ) ;
                $("#doc_problema_masticar_no").attr('checked',(complicacion_masticar.no=="true") ? true : false ) ;

                //CONSUMOS
                var Consumos = JSON.parse(resp.data.habitos_consume);
                // console.log(Consumos);
                $("#doc_alchol").attr('checked' ,     (Consumos.doc_alchol == "true") ? true : false );
                $("#doc_cafe").attr('checked',   (Consumos.doc_cafe == "true") ? true : false);
                $("#doc_fumar").attr('checked',  (Consumos.doc_fumar == "true") ? true : false );
                $("#doc_ninguno").attr('checked',  (Consumos.doc_ninguno == "true") ? true : false);


            }else
                {

                    notificacion( resp.error , 'error');

                }
        }
    });
}