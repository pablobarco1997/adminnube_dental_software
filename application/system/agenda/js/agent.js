
function loadtableAgenda()
{
    $('#tableAgenda').DataTable({
        searching: false,
        ordering:false,
        destroy:true,

        scrollX: true,
        scrollY: 700,

        ajax:{
            url: $DOCUMENTO_URL_HTTP + "/application/system/agenda/controller/agenda_controller.php",
            type:'GET',
            data:
                {
                    'ajaxSend'  : 'ajaxSend',
                    'accion'    : 'listCitas',

                    'doctor'    : ($("#filtro_doctor").val()!="")?$("#filtro_doctor").val().toString():"",
                    'estados'   : ($("#filtroEstados").val()!="")?$("#filtroEstados").val().toString():"",
                    'fecha'     : $('.filtroFecha').val(),
                    'eliminada_canceladas' : ( ( $('#listcitasCanceladasEliminadas').is(':checked')==true) ? "checked" : "") ,
                    'buscar_xpaciente': ($('#buscarxPaciente').val()!="")?$('#buscarxPaciente').val().toString():""
                },
            dataType:'json',
        },
        'createdRow':function(row, data, index){

            // console.log(data[7]);

            if( data[7] == 6){
                $(row).css('backgroundColor','#58D68D');
            }

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


//Numero de citas
function NOTIFICACION_CITAS_NUMEROS()
{

    var parameters = {
        "ajaxSend": "ajaxSend",
        "accion"  : "numero_citas_pacientes_hoy",
    };

    var url = $DOCUMENTO_URL_HTTP + "/application/system/agenda/controller/agenda_controller.php";

    $.get(url , parameters , function(data) {

        var datos = $.parseJSON(data);

        $("#numCitas").text( datos.result );

    });


    setInterval(function(){

        $.get(url , parameters , function(data) {

            var datos = $.parseJSON(data);

            $("#numCitas").text( datos.result );

        });

    },3500)
}


//Funciones Cambio de estados 
function EstadosCitas(idestado, idcita, html, idpaciente) //Comprotamientos de los estados de las citas
{

    var textEstado = html.data('text');

    // alert(idestado);

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

        case 3: // Confirmar por Telefono

            UpdateEstadoCita(idestado, idcita, html, textEstado );
            break;

        case 4: // En sala de espera

            UpdateEstadoCita(idestado, idcita, html, textEstado );
            break;

        case 5: // Atendiendose

            UpdateEstadoCita(idestado, idcita, html, textEstado );
            break;

        case 6: // Atendido

            $.get($DOCUMENTO_URL_HTTP + "/application/system/agenda/controller/agenda_controller.php" , {'ajaxSend':'ajaxSend', 'accion':'consultar_estado_cita_atrazada', 'idcita':idcita } , function(data) {

                var dato = $.parseJSON(data);

                if(dato.result == 'atrazada'){
                    notificacion('Esta cita se encuentra atrazada no puede cambiar a estado <b>Atendido</b>', 'question');
                }else{
                    UpdateEstadoCita(idestado, idcita, html, textEstado );
                }

            });

            break;

        case 7: // No asiste

            UpdateEstadoCita(idestado, idcita, html, textEstado );
            break;

        case 9: // Cancelada

            UpdateEstadoCita(idestado, idcita, html, textEstado );
            break;

        case 8:

            $("#number_whasap").text(html.data("telefono"));
            $("#modalWhapsapp").modal("show");
            $("#sendwhap").addClass('disabled_link3');

            UpdateEstadoCita(idestado, idcita, html, textEstado );
            break;

        default:

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


    $('#emailEspere').text('Enviando mensaje espere ...');

    // $(document).
    // bind("ajaxStart", function(){
    //     $('#emailEspere').text('Enviando mensaje espere ...');
    // }) .bind("ajaxSend", function(){
    //     $('#emailEspere').text('Enviando mensaje espere ...');
    // }).bind("ajaxComplete", function(){
    //     $('#emailEspere').text(null);
    // });


    var error = '';
    var error_registrar_email_ = '';

    setTimeout(function() {


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
            complete: function(){
                $('#emailEspere').text(null);
            },
            success: function(resp){

                error                   = resp.error_email;
                error_registrar_email_  = resp.registrar;

                if(error == "" && error_registrar_email_ == "") {

                    $('#asunto_email').val();
                    $('#de_email').val();
                    $('#para_email').val();
                    $('#titulo_email').val();
                    $('#messge_email').val();

                    $('#notificar_email-modal').modal('hide');
                    UpdateEstadoCita(idestado, idcita, '', '' );
                    $('#emailEspere').text(null);

                }else{

                    if(error!="" ){
                        notificacion(error, 'error');
                    }
                    if(error_registrar_email_ != ""){
                        notificacion(error_registrar_email_, 'error');
                    }
                    $('#emailEspere').text(null);
                }

            }
        });

    },1500);

    return error;

}


//CREATE PLAN DE TRATAMIENTO DESDE CITAS
function create_plandetratamiento($idpaciente, $idcitadet, $iddoct, $html)
{

    var $puedo = false;

    var consultarPlanTratamiento = [];

    // alert($idcitadet+': idpaciente:' +$idpaciente);
    $.ajax({
        url: $DOCUMENTO_URL_HTTP + "/application/system/agenda/controller/agenda_controller.php",
        type:'POST',
        data:{'ajaxSend': 'ajaxSend', 'accion': 'nuevoUpdatePlantratamiento', 'idpaciente': $idpaciente, 'idcitadet': $idcitadet, 'iddoct': $iddoct, 'subaccion':'CREATE'},
        dataType:'json',
        async:false,
        success:function(resp) {

            var idpacienteToken = resp.idpacientetoken;

            if(resp.error == ''){

                notificacion('Plan de Tratamiento Creado - cargando...', 'success');

            }else {

                notificacion('Ocurrio un error con la Operación' , 'error');
            }

            if(resp.error == ''){

                var $tener = 0;
                var $idtratamiento = 0;

                if( resp.idtratamiento > 0){
                    $idtratamiento = resp.idtratamiento;
                    $tener++;
                }

                if($tener > 0){

                    if($idtratamiento > 0){

                        setTimeout(function() {
                            window.location = $DOCUMENTO_URL_HTTP + '/application/system/pacientes/pacientes_admin/?view=plantram&key=' + $keyGlobal + '&id=' + idpacienteToken + '&v=planform&idplan=' + $idtratamiento;
                        }, 1500);

                    }
                }
            }
        }

    });

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
$("#mensajetext").keyup(function() {

    var telf  = $("#number_whasap").text();
    var texto = $(this).val();
    var url = "https://wa.me/"+telf+"?text=" + texto;

    if(texto != ""){
        $("#sendwhap").removeClass('disabled_link3');
        $("#sendwhap").attr("href", url);
    }

    if(texto == ""){
        $("#sendwhap").addClass('disabled_link3');
    }
    // alert(url);

});


// $(".select2_especialidad .select2_doctor .select2_duraccion .inputFecha .select2_hora").on("change",function(){
//     var $padre = $(this).parents(".row_detalleCitas");
//     INVALIC_CITAS_DETALLE($padre);
// });


//Commentari adicional muestra el modal y guarda el comentario
function clearModalCommentAdicional(iddetcita, html)
{
    if(iddetcita != "")
    {
        $('#iddet-comment').attr('data-iddet', iddetcita);
        $('#invali_commentadciol_mssg').text(null);

        $('#guardarCommentAdicional').attr('onclick', 'UpdateCitasCommentAdicional('+iddetcita+')')
    }
}


function UpdateCitasCommentAdicional(iddetcita)
{
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
            data:{'ajaxSend': 'ajaxSend', 'accion': 'UpdateComentarioAdicional', 'iddetcita': iddetcita ,'commentAdicional': $('#comment_adicional').val() },
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
}

$('#pacientes_habilitados , #pacientes_desabilitados').change(function() {

    var dataPacientes = [];

    var url = $DOCUMENTO_URL_HTTP + "/application/system/agenda/controller/agenda_controller.php";

    var pamarts = { 'accion':'pacientes_activodesact', 'ajaxSend':'ajaxSend', 'habilitado': $('#pacientes_habilitados').prop('checked') , 'desabilitado':$('#pacientes_desabilitados').prop('checked') };

    var puede = 0;

    if( $('#pacientes_habilitados').prop('checked') ){
        puede++;
    }
    if( $('#pacientes_desabilitados').prop('checked') ){
        puede++;
    }


    if( puede > 0){

        var option = "";
        $.get(url , pamarts ,  function (data) {

            dataPacientes = $.parseJSON(data);

            // $('#buscarxPaciente').empty();

            $.each(dataPacientes, function(i, item) {
                console.log(item);
                option += '<option value="'+item.id+'">'+item.text+'</option>';
            });

            $('.buscarxPaciente').html( option );

            $('#buscarxPaciente').select2({
                placeholder:'buscar pacientes' ,
                // language:'es'
            });

        });

    }

});


//APLICAR FILTRO DE BUSQUEDA O LIMPIAR
$(".aplicar").click(function() {

    loadtableAgenda();
});

//MOSTRAR CITAS ELIMINADAS O CANCELADAS
$('#listcitasCanceladasEliminadas').change(function(){

    loadtableAgenda();

});

$(".limpiar").click(function() {


    $("#buscarxPaciente").val(null).trigger('change');
    $("#filtro_doctor").val(null).trigger('change');
    $('#filtroEstados').val(null).trigger('change');
    loadtableAgenda();

});


//SELECCIONAR TODOS LOS CHECKEDS DIARIA
$('#checkeAllCitas').change(function() {


    if($(this).is(':checked') == true)
    {
        $('.checked_detalleCitas').prop('checked', true);
    }else{
        $('.checked_detalleCitas').prop('checked', false);
    }

});



$(document).ready(function() {

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


    /**PETICIONES EN TIEMPO REAL*/
    var time_agenda;

    function TimeRealAgenda() {

        time_agenda = setInterval(function() {
            loadtableAgenda();
        },3000);
    }

    loadtableAgenda();

    //Cuando no me  coloque sobre la table realizara peticione en tiempo real
    $('#tableAgenda thead , tbody').mouseleave(function(){
        TimeRealAgenda();
    });

    //cuenado me coloque sobre la table STOP a peticiones en tiempo real
    $('#tableAgenda thead , tbody').mouseleave(function(){
        clearInterval(time_agenda);
    });



    NOTIFICACION_CITAS_NUMEROS();

    $('.filtrar_doctor').select2({
        placeholder: 'Seleccionar un doctor',
        // allowClear:true,
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

    $('#buscarxPaciente').select2({
        placeholder:'buscar pacientes',
        // language:'es',
    });



});
