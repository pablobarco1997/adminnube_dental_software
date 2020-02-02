

function ficha_clinica_nuevoUpdate(label_doc_clinico)
{

    var parameters = {
      "accion"     :  "nuevoUpdate_documento_clinico",
      "subaccion"  :  label_doc_clinico,
      "create_document" : $create_documento ,
      "idpaciente" : $id_paciente ,

      "hay_id"  : idClinicoDocumento,  //id del docuemtno
      "hay_id_cab" : idCaberzaDocumento, //id cabezera para Actualizar el nuevo documento

      "ajaxSend"   : "ajaxSend",

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
    };

    console.log(parameters);

    return parameters;

}


function  list_documentos_clinicos()
{
    $('#table-documentos-clinicos1').DataTable({

        searching: false,
        ordering:false,
        destroy: true,

        ajax:{
            url: $DOCUMENTO_URL_HTTP + '/application/system/pacientes/admin_paciente/controller/controller_adm_paciente.php',
            type:'POST',
            data:{'ajaxSend':'ajaxSend', 'accion':'list_informacion_doc', 'idpaciente': $id_paciente},
            dataType:'json',
        },

        columnDefs: [
            {

                "targets": 2,
                "render": function ( data, type, row, meta ) {
                    console.log(row);
                    return '<a href="'+$DOCUMENTO_URL_HTTP+'/application/system/pacientes/admin_paciente/?view=documentos_clinicos&id='+$id_paciente+'&create_document='+row[4]+'&id_ficha='+row[5]+'-'+row[6]+'" > ' + data + ' </a>';
                }

            }
        ],

        language:{
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },

            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }

        },
    });
}

function ObtenerDatosDocumentosFichaClinica(typo, idDocumento)
{
    if(typo == 1) //FICHA CLINICA GENERAL DEL PACIENTE
    {
        $.ajax({
            url: $DOCUMENTO_URL_HTTP + '/application/system/pacientes/admin_paciente/controller/controller_adm_paciente.php',
            type:"POST",
            data: {"ajaxSend":"ajaxSend", "accion":"obj_document_clinico", "idClinico": idDocumento, "hay_id": idClinicoDocumento},
            dataType: "json",
            success: function(resp){

                console.log(JSON.parse(resp.data.tiene_enfermedades));

                console.log(resp);

                if(resp.error == true)
                {


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

                }

            }

        })
    }
}
function  Obj_default_doctClinico(obj)
{
    var date = new Date();

    $("#doc_nombre_apellido").val((obj.nombre + " " + obj.apellido));
    $("#doc_cedula").val(obj.rut_dni);
    $("#doc_fecha_nc").val(obj.fecha_nacimiento);

    $("#radioFemenino").attr("checked", (obj.sexo == "femenino") ? true : false);
    $("#radioMasculino").attr("checked", (obj.sexo == "masculino") ? true : false);

    $("#doc_ocupacion").val( obj.actividad_profecion );
    $("#doc_edad").val( (date.getFullYear() - obj.fecha_nacimiento.substr(0,4)) );
    $("#doc_celular").val( obj.telefono_movil );
}

function CargarSelect2ClinicoDocument()
{
    $('#SeletedTipoDocumentClinico').select2({
        placeholder: 'Selecione un documento',
        allowClear: true,
        language:'es'
    });
}

//CREATE DOCUMENTO CLINICO
function _createdocuemto_clinico(label){

    if(label = 'fichaClinicaGeneral'){

        var ficha_clinica_obj = ficha_clinica_nuevoUpdate('ficha_clinica_general');

        $('#guardar_informacion_fichaclinica').addClass('disabled_link3');
    }

    $.ajax({
        url: $DOCUMENTO_URL_HTTP + "/application/system/pacientes/admin_paciente/controller/controller_adm_paciente.php",
        type: "POST",
        data: ficha_clinica_obj,
        dataType: "json",
        success: function (resp) {
            if (resp.error == true)
            {
                notificacion("Información Actualizada", "success");

                setTimeout(function() {

                    window.location = $DOCUMENTO_URL_HTTP + "/application/system/pacientes/admin_paciente/?view=documentos_clinicos&id=" + $id_paciente;

                },1300);

            }else{

                notificacion("Ocurrió un problema con la Operación, Contacte a con soporte Técnico", "error");

                $('#guardar_informacion_fichaclinica').addClass('disabled_link3');

            }

        }
    });
}

// EVENTOS ------------------------------------------------------------------------------------------------------------

$("#guardar_informacion_fichaclinica").on("click", function() {

    var labelClinico = 'fichaClinicaGeneral';
    _createdocuemto_clinico(labelClinico);

});

$('#SelectedTipoDocumentClinico').on('change', function(){

    //si se encutra seleccionada un tipo de documento entonces se jecuta un ajax
    if($(this).find('option:selected').val() != "" || $(this).find('option:selected').val() != 0)
    {
        $('#crearDocumentClinico').removeClass('disabled_link3');

    }else{

        $('#crearDocumentClinico').addClass('disabled_link3');
    }

});

$('#crearDocumentClinico').click(function() {

    if($('#SelectedTipoDocumentClinico').find('option:selected').val() != 0 || $('#SelectedTipoDocumentClinico').find('option:selected').val() != "")
    {
        window.location = $DOCUMENTO_URL_HTTP + '/application/system/pacientes/admin_paciente/?view=documentos_clinicos&id='+$id_paciente+'&create_document=1';
    }

});

//Imprimir documentos Clinicos

function selectCheckedeachdocument(){

    var dataChedckeddocument = [];

    $('.selectChecked').each(function() {

        if($(this).is(":checked")){

            dataChedckeddocument.push({
                'idtipodocumento' : $(this).data('idtipo'),
                'iddocument'      : $(this).data('iddocument'),
            });

        }

    });

    return dataChedckeddocument;

}

//Esta funcione mme a permitir imprimi varios tipos de documento s
function ImprimirDocumentosClinicos($idTipoDocument, $iddocumento)
{
    var url = "";

    switch ($idTipoDocument)
    {
        case 1: //Ficha Clinica General

            url = $DOCUMENTO_URL_HTTP + "/application/system/pacientes/admin_paciente/export/export_pdf_ficha_clinica_general.php?iddocument=" + $iddocumento;
            window.open(url, '_blank');

            break;
    }


}

$('#printDocumentos').click(function() {

    var resultCheckeddocument = selectCheckedeachdocument();

    console.log(resultCheckeddocument);

    if(resultCheckeddocument.length == 1){
        $.each(resultCheckeddocument, function(i, item) {

            console.log(item.idtipodocumento + ' ::: '  +item.iddocument);
            ImprimirDocumentosClinicos(item.idtipodocumento, item.iddocument);

        });
    }else{

        notificacion('Solo puede imprimir un documento', 'question');

    }


});


// EXECUTE LOAD PAGING
