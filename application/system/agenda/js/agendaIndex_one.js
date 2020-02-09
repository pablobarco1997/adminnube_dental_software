
$formatIndex=0;

function loadtableAgenda($doctor, $estado, $fecha)
{
    $('#tableAgenda').DataTable({
        searching: false,
        ordering:false,
        destroy:true,

        scrollX: true,
        scrollY: 700,

        ajax:{
            url: $DOCUMENTO_URL_HTTP + "/application/system/agenda/controller/agenda_controller.php",
            type:'POST',
            data:{'ajaxSend':'ajaxSend', 'accion':'listCitas', 'doctor': $doctor, 'estados': $estado, 'fecha':$fecha},
            dataType:'json',
        },
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
        // ajax:{
        //
        // },
    });
}

function select2(principal) {

        if(principal == 'active')
        {
            $('[name="especialidad['+0+'].detalle"]').select2({
                placeholder:"Seleccione una especialidad",
                allowClear: true,
                language:"es"
            });

            $('[name="duraccion['+0+'].detalle"]').select2({
                placeholder:"Seleccione una especialidad",
                allowClear: true,
                language:"es"
            });

            $('[name="hora['+0+'].detalle"]').select2({
                placeholder:"Seleccione una especialidad",
                allowClear: true,
                language:"es"
            });

            $('[name="doctor['+0+'].detalle"]').select2({
                placeholder:"Seleccione una especialidad",
                allowClear: true,
                language:"es"
            });

                // $('.inputFecha').datepicker({format: "dd/mm/yyyy"});


        }
}

function Select2Run()
{
    $('.filtrar_doctor').select2({
        placeholder: 'Seleccionar un doctor',
        allowClear:true,
        language:'es',
    });

    $('#pacienteCita').select2({
        placeholder: 'Pacientes',
        allowClear: true,
        language:'es'
    });

    $('.filtrar_estados').select2({
        placeholder:'Seleccione estados cita'
    });


}

//Funcion obtengo los datos de la cita
function dataCitas()
{

    var  ArrayObtenerCab = {
        'fk_paciente' : $('#pacienteCita').find('option:selected').val(),
        'comment'     : $('#comentario_cita').val(),
        'detalle'     : [],
    };

    var ArrayObtenerDet = [];

    for (var i = 0; i <= $formatIndex; i++)
    {
            if( $('#detalle-'+i).length > 0 )
            {
                var especialidad =  $('[name="especialidad['+i+'].detalle"]').find('option:selected').val();
                var doctor       =  $('[name="doctor['+i+'].detalle"]').find('option:selected').val();
                var recursos     =  $('[name="recursos['+i+'].detalle"]').find('option:selected').val();
                var duraccion    =  $('[name="duraccion['+i+'].detalle"]').find('option:selected').val();
                var fechacita    =  $('[name="fechacita['+i+'].detalle"]').val();
                var hora         =  $('[name="hora['+i+'].detalle"]').find('option:selected').val();

                ArrayObtenerDet.push({
                    'especialidad'  : especialidad,
                    'doctor'        : doctor,
                    'recursos'      : recursos,
                    'duraccion'     : duraccion,
                    'fechacita'     : fechacita,
                    'hora'          : hora
                });

                ArrayObtenerCab['detalle'] = ArrayObtenerDet;
            }
    }

    console.log(ArrayObtenerCab);

    return ArrayObtenerCab;
}

function INVALI_CITA_DETCAT()
{
    var $error = true;
    $('.select-detalles-citas').each(function() {

        console.log($(this));
        var $padre   = $(this);

        var fk_doc   =  $padre.find(".select2_doctor");
        var fecha    =  $padre.find(".inputFecha");
        var hora     =  $padre.find(".select2_hora");
        var duracion =  $padre.find(".select2_duraccion");

        if( ON_CONSULTAR_CITAS_HORAS( fecha.val(), hora.find(":selected").val(), duracion.find(":selected").val(), fk_doc.find(":selected").val() ) == false)
        {
            $error=false;
            notificacion("Ya se encuentra agendada una cita en esta fecha y hora, VERIFIQUE la fehca y hora de las citas asignadas", "error");
        }

    });

    return $error;
}

function ON_CONSULTAR_CITAS_HORAS(fecha, hora, duracion, fk_doc)
{

    var respuesta = true;

    var parametros = {
        "ajaxSend":"ajaxSend",
        "accion":"validacionFechasCitas",
        "fecha" : fecha,
        "hora"  : hora,
        "duracion" : duracion,
        "fk_doc" : fk_doc
    };

    $.ajax({
       url: $DOCUMENTO_URL_HTTP + "/application/system/agenda/controller/agenda_controller.php",
       type:'POST',
       data:parametros,
       dataType:'json',
       async:false,
       success: function(res) {
           respuesta = res;
        }

    });

    // alert(respuesta);

    return respuesta;
}

//Numero de citas
function NOTIFICACION_CITAS_NUMEROS(tipo)
{

    var parametrs = [];

    if(tipo == 0) //Nuemero de citas
    {
        parametrs = {
            "ajaxSend": "ajaxSend",
            "accion"  : "Numero_Citas",
        };
    }

    $.ajax({
        url: $DOCUMENTO_URL_HTTP + "/application/system/agenda/controller/agenda_controller.php",
        type:'POST',
        data:parametrs,
        dataType:'json',
        async:false,
        success: function(res) {
            $("#numCitas").text(res);
        }

    });
}

//EVENTOS INPUTS
$('#guardar_cita').on('click', function() {

     var datos = dataCitas();

     $(this).addClass('disabled_link3');

     var paramters = {
       'ajaxSend': 'ajaxSend',
       'accion':'create_cita_paciente',
       'datos': datos
     };

     $puede = false;
    if(INVALI_CITA_DETCAT()== true)
    {
        $puede = true;
    }

    //CREA LA CITA
    if($puede==true)
    {
        $.ajax({
           url: $DOCUMENTO_URL_HTTP + "/application/system/agenda/controller/agenda_controller.php",
           type:'POST',
           data:paramters,
           dataType:'json',
           success: function(respuesta) {

               if(respuesta == 1)
               {
                   notificacion('Información Actualizada', 'success');

                   setTimeout(function() {
                       location.reload(true);
                   },1000);

               }else{

                   notificacion('Ocurrió un problema con la Operación, contacte con soporte tecnico', 'error');
                   $(this).removeClass('disabled_link3');
               }

            }
        });
    }


});

//Funciones Cambio de estados 
function EstadosCitas(idestado, idcita, html, idpaciente) //Comprotamientos de los estados de las citas
{
    var textEstado = html.data('text');



    switch (idestado)
    {
        case 1: //notificar por email

            $('#notificar_email-modal').modal('show');
            notificacion('El sistema no se responsabiliza por correo electrónico mal ingresado', 'question');
            $('#para_email').val( $.trim( html.data('email') ) ); //email destinario

            $("#enviarEmail").attr('onclick', 'notificaionEmail('+idpaciente+','+idcita+','+idestado+','+idcita+')');

            $("#para_email").keyup();

            break;

        case 2: // No confirmado

            UpdateEstadoCita(idestado, idcita, html, textEstado );
            break;

        case 8: // Confirmar por whatsapp

            $("#number_whasap").text(html.data("telefono"));
            $("#modalWhapsapp").modal("show");

            UpdateEstadoCita(idestado, idcita, html, textEstado );
            break;

        case 5: // Atendiendose

            UpdateEstadoCita(idestado, idcita, html, textEstado );
            break;

        case 6: // Atendido

            UpdateEstadoCita(idestado, idcita, html, textEstado );
            break;

        case 7: // No asiste

            UpdateEstadoCita(idestado, idcita, html, textEstado );
            break;

        case 9: // Cancelada

            UpdateEstadoCita(idestado, idcita, html, textEstado );
            break;


    }


}

function UpdateEstadoCita(idestado, idcita, html, textEstado) //Actualizar Estados de las citas
{
    $.ajax({
        url: $DOCUMENTO_URL_HTTP + "/application/system/agenda/controller/agenda_controller.php",
        type:'POST',
        data:{'ajaxSend': 'ajaxSend', 'accion': 'EstadoslistCitas', 'idestado':idestado, 'idcita':idcita, 'estadoText':textEstado },
        dataType:'json',
        async: false,
        success: function(resp)
        {
            if(resp.error != "")
            {

                var table =  $('#tableAgenda').DataTable();
                notificacion( 'Información Actualizada', 'success');
                table.ajax.reload();// recargo el ajax del table
            }
        }
    });
}


function notificaionEmail($idPaciente, $idcita, idestado, idcita )
{

    $('#emailEspere').fadeIn();

    var error = '';
    $.ajax({
        url: $DOCUMENTO_URL_HTTP + "/application/system/agenda/controller/agenda_controller.php",
        type:'POST',
        data:{
            'ajaxSend': 'ajaxSend',
            'accion': 'envio_email_notificacion',
            'idpaciente':$idPaciente,
            'idcita' : $idcita,

            'asunto': $('#asunto_email').val(),
            'from': $('#de_email').val(),
            'to': $('#para_email').val(),
            'subject': $('#titulo_email').val(),
            'message': $('#messge_email').val(),
        },
        dataType:'json',
        async: false,
        success: function(resp){

            error = resp.error;

            if(error == ''){
                $('#asunto_email').val();
                $('#de_email').val();
                $('#para_email').val();
                $('#titulo_email').val();
                $('#messge_email').val();

                $('#notificar_email-modal').modal('hide');
                UpdateEstadoCita(idestado, idcita, '', '' );
                $('#emailEspere').fadeOut();

            }else{

                notificacion(error, 'error');
                $('#emailEspere').fadeOut();
            }

        }
    });

    return error;

}


//CREATE PLAN DE TRATAMIENTO DESDE CITAS
function create_plandetratamiento($idpaciente, $idcitadet, $iddoct, $html)
{

    var $puedo = false;

    var consultarPlanTratamiento = [];

    $.ajax({
        url: $DOCUMENTO_URL_HTTP + "/application/system/agenda/controller/agenda_controller.php",
        type:'POST',
        data:{'ajaxSend': 'ajaxSend', 'accion': 'nuevoUpdatePlantratamiento', 'idpaciente': $idpaciente, 'idcitadet': $idcitadet, 'iddoct': $iddoct},
        dataType:'json',
        async:false,
        success:function(resp) {

            if(resp.error == true){

                $puedo = true;
                consultarPlanTratamiento = resp.idtratamiento;
                notificacion('Plan de Tratamiento Creado', 'success');

            }else {
                notificacion(resp.error , 'error');
            }
        }

    });

    if($puedo == true){

        //consulto si el plan de tratamiento ya esta creado con el id
        if(consultarPlanTratamiento > 0){

            // alert(consultarPlanTratamiento);
            window.location = $DOCUMENTO_URL_HTTP + '/application/system/pacientes/admin_paciente/?view=form_plan_tratamiento&id=' + $idpaciente + '&ope=new&idtratam=' + consultarPlanTratamiento;
        }else{

            notificacion("Ocurrió un error con la Operación, consulte con soporte técnico ", "error");

        }

    }else{

        notificacion('Ocurrió un error con la Operación, pero el plan de tratamiento ya esta creado !', 'question');
    }

    loadtableAgenda(); //reload table agenda
}

function keyemail_invalic()
{
    var expresionRegularEmail = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    var email = $('#para_email');

    if(!expresionRegularEmail.test(email.val()))
    {
        $('#invali_emil_mssg').text('email incorrecto');
    }else{
        $('#invali_emil_mssg').text('');
    }

}


//Enviar Mensaje por whatsap
$("#sendwhap").click(function() {

    var telf = $("#number_whasap").text();
    var url = "https://wa.me/"+telf+"?text="+$("#mensajetext").val();
    // alert(url);
    $("#sendwhap").attr("href", url);

});

//AGREGAR DETALLE MULTIPLE
$(".add_detalle_cita").on("click", function() {

    var $puedo = false; //No va permitir clonar si no es true

    var count = 0;
    $(".row_detalleCitas").each(function() {

         if( INVALIC_CITAS_DETALLE($(this)) == 0) {
             $puedo = true;
         }else{
             count++;
         }

    });

    if(count > 0)
    {
        notificacion("Error, Debe seleccionar todos los Campos antes de agregar otro", "error");

    }else{

        $formatIndex++;

        var $template = $("#template-detalle-cita");

        var $clone = $template
            .clone()
            .attr("id", "detalle-"+$formatIndex)
            .attr("data-index", $formatIndex)
            .addClass("row_detalleCitas")
            .removeClass("hide")
            .insertAfter($template);


        $clone
            .find("#template-especialidad").attr("name", "especialidad["+$formatIndex+"].detalle").end()
            .find("#template-duracion").attr("name", "duraccion["+$formatIndex+"].detalle").end()
            .find("#template-fechaCita").attr("name", "fechacita["+$formatIndex+"].detalle").end()
            .find("#template-hora").attr("name", "hora["+$formatIndex+"].detalle").end()
            .find("#template-doctor").attr("name", "doctor["+$formatIndex+"].detalle").end();


        $('[name="especialidad['+$formatIndex+'].detalle"]').select2({
            placeholder:"Seleccione una especialidad",
            allowClear: true,
            language:"es"
        });

        $('[name="duraccion['+$formatIndex+'].detalle"]').select2({
            placeholder:"Seleccione una especialidad",
            allowClear: true,
            language:"es"
        });

        $('[name="hora['+$formatIndex+'].detalle"]').select2({
            placeholder:"Seleccione una especialidad",
            allowClear: true,
            language:"es"
        });

        $('[name="doctor['+$formatIndex+'].detalle"]').select2({
            placeholder:"Seleccione una especialidad",
            allowClear: true,
            language:"es"
        });

    }

    $(".delete-detalle-cita").on("click", function (){

        var $padre = $(this).parents(".row_detalleCitas");
        $padre.remove();
        console.log($padre);

    });

});

// $(".select2_especialidad .select2_doctor .select2_duraccion .inputFecha .select2_hora").on("change",function(){
//     var $padre = $(this).parents(".row_detalleCitas");
//     INVALIC_CITAS_DETALLE($padre);
// });

function INVALIC_CITAS_DETALLE($html)
{

    var $puedo = 0;

    var $padre                 = $html;
    var $selectEspecialidad    = $padre.find(".select2_especialidad");
    var $doctor                = $padre.find(".select2_doctor");
    var $duracion              = $padre.find(".select2_duraccion");
    var $inputFecha            = $padre.find(".inputFecha");
    var $horaCita              = $padre.find(".select2_hora");

    console.log($padre);

    if($selectEspecialidad.find(':selected').val() == 0)
    {
        $selectEspecialidad.addClass("INVALIC_ERROR");
        $puedo++;
    }else { $selectEspecialidad.removeClass("INVALIC_ERROR");}

    if($doctor.find(':selected').val() == 0)
    {
        $doctor.addClass("INVALIC_ERROR");
        $puedo++;
    }else { $doctor.removeClass("INVALIC_ERROR");}

    if($duracion.find(':selected').val() == 0)
    {
        $duracion.addClass("INVALIC_ERROR");
        $puedo++;
    }else { $duracion.removeClass("INVALIC_ERROR");}

    if($inputFecha.val() == "dd/mm/aaaa" || $inputFecha.val() == "")
    {
        $inputFecha.addClass("INVALIC_ERROR");
        $puedo++;
    }else { $inputFecha.removeClass("INVALIC_ERROR");}

    if($horaCita.find(':selected').val() == 0)
    {
        $horaCita.addClass("INVALIC_ERROR");
        $puedo++;
    }else { $horaCita.removeClass("INVALIC_ERROR");}

    return $puedo;

}

//Commentari adicional muestra el modal
//y guarda el comentario
function clearModalCommentAdicional(iddetcita, html)
{
    if(iddetcita != "")
    {
        $('#iddet-comment').attr('data-iddet', iddetcita);
    }
}

$('#guardarCommentAdicional').click(function(){

    var puedo = 0;

    if( $('#comment_adicional').val() == "" ){
        puedo++;
        $('#invali_commentadciol_mssg').text("Debe Ingresar un comentario");
    }else{
        puedo = 0;
        $('#invali_commentadciol_mssg').text(null);
    }

    if(puedo == 0){

        $.ajax({
            url: $DOCUMENTO_URL_HTTP + "/application/system/agenda/controller/agenda_controller.php",
            type:'POST',
            data:{'ajaxSend': 'ajaxSend', 'accion': 'UpdateComentarioAdicional', 'iddetcita':$('#iddet-comment').data('iddet') ,'commentAdicional':$('#comment_adicional').val() },
            dataType:'json',
            async:false,
            success:function(resp) {

                if(resp.error == ''){
                    var table = $('#tableAgenda').DataTable();
                    table.ajax.reload();
                    $('#modal_coment_adicional').modal('hide');
                }else {
                    notificacion(resp.error , 'error');
                }
            }

        });

    }


});


$("#ActivarMultipleCitas").click(function() {

    var count = 0;
    $(".row_detalleCitas").each(function() {

        if( INVALIC_CITAS_DETALLE($(this)) == 0) {

        }else{
            count++;
        }

    });

    if(count==0) //Conpruebo si esta seleccionado los checkvos
    {
        if($("#ActivarMasCitasChecked").is(":checked"))
        {
            //compruebe si leyo los teriminos
            notificacion("Tener en cuenta que si usted selecciona la opcion multiple citas, EL SISTEMA no validara las citas mal ingresadas, Verificar, la FECHA, HORA, Y DURACIÓN DE LA CITA antes de guardar la información", "question");

            if( $(".swal2-confirm").length > 0 )
            {
                var $click = 0;
                $(".swal2-confirm").click(function() {
                    $click++;

                    if($click > 0)
                    {
                        $("#ActivarMasCitasChecked").prop("checked", true);
                        $(".add_detalle_cita").removeClass("disabled_link3");
                        $(".add_detalle_cita").trigger("click"); //Simulo un click

                    }
                });

                if($click == 0){
                    $("#ActivarMasCitasChecked").prop("checked", false);
                }
            }

        }

    }else{
        notificacion("Para esta Opcion Debe Seleccionar antes", "error");
        $("#ActivarMasCitasChecked").prop("checked", false);
    }


});

//APLICAR FILTRO DE BUSQUEDA O LIMPIAR
$(".aplicar").click(function() {

    var doctor  = $("#filtro_doctor").find(":selected").val();
    var estados = $("#filtroEstados").val();
    var fecha   = $(".filtroFecha").val();

    loadtableAgenda(doctor, estados, fecha);
    console.log(estados);

    //Aplicar Cambios citas diarias global
    list_global_diaria_citas();

    var urlpdf = $DOCUMENTO_URL_HTTP + "/application/system/agenda/export/export_pdf_agenda_diariaglobal.php?fecha="+fecha;
    $("#export_diariaGlobal").attr('target','_blank').attr('href', urlpdf );

});

$(".limpiar").click(function() {


    $("#filtro_doctor").val(null).trigger('change');
    document.getElementById('filtroEstados').innerHTML = "";

    loadtableAgenda();
    list_global_diaria_citas();
});


$('.filtroFecha').daterangepicker({

    locale: {
        format: 'YYYY/MM/DD' ,
        daysOfWeek: [
            "Dom",
            "Lun",
            "Mar",
            "Mie",
            "Jue",
            "Vie",
            "Sáb"
        ],
        monthNames: [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        ],
    },

    startDate: moment().startOf('month'),
    endDate: moment(),
    ranges: {
        'Hoy': [moment(), moment()],
        'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Últimos 7 Dias': [moment().subtract(6, 'days'), moment()],
        'Últimos 30 Dias': [moment().subtract(29, 'days'), moment()],
        'Mes Actual': [moment().startOf('month'), moment().endOf('month')],
        'Mes Pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
        'Año Actual': [moment().startOf('year'), moment().endOf('year')],
        'Año Pasado': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
    }
});

$('.rango span').click(function() {
    $(this).parent().find('input').click();
});

