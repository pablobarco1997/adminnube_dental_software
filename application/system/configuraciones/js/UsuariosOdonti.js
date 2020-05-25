

//Para obetenr el paramatro de una url x medio de GET
let paramsGet = new URLSearchParams(location.search);


function CargarUsuarioInfo()
{

    if( $('#usuariolistinfo').length > 0 ){
        $('#usuariolistinfo').DataTable({
        searching: true,
        ordering:false,
        destroy:true,
        ajax:{
            url: $DOCUMENTO_URL_HTTP + '/application/system/configuraciones/controller/conf_controller.php',
            type:'GET',
            data:{'ajaxSend':'ajaxSend', 'accion':'infoUsuarioOdontic', 'cual': 'list'},
            dataType:'json',
        },
        columnDefs:[
            {
                targets:0 ,
                render: function (data , type , full , meta) {

                    var menu = "";
                    menu += "<div class='dropdown'>";
                        menu += "<button class='btn btnhover btn-xs dropdown-toggle' type='button' data-toggle='dropdown' > <i style='padding-top: 3px; padding-bottom: 3px' class=\"fa fa-ellipsis-v\"></i> </button> ";

                        menu += "<ul class=\"dropdown-menu\"> ";
                            menu += "<li> <a style='cursor: pointer; font-size: 1.1rem;' href='"+$DOCUMENTO_URL_HTTP+"/application/system/configuraciones/index.php?view=form_gestion_odontologos_especialidades&v=users&mod=true&id="+full[6] +"'> Modificar  </a> </li>";

                            // INACTIVAR
                            if(full[5] == 'A'){
                                menu += "<li> <a style='cursor: pointer; font-size: 1.1rem;'> Inactivar  </a> </li>";
                            }
                            // ACTIVAR
                            if(full[5] == 'I'){
                                menu += "<li> <a style='cursor: pointer; font-size: 1.1rem;'> Activar  </a> </li>";
                            }

                            menu += "<li> <a style='cursor: pointer; font-size: 1.1rem;'> Eliminar </a> </li>";

                    menu += "</ul>";

                    menu += "</div>";

                    console.log(full);
                    return menu;
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
}



function keyConfirmarPassword()
{
    if( $('#usu_password').val() != $('#usu_confir_password').val())
    {
        $('#msg_password').text('Password Incorrecto');
        $('#usu_confir_password').addClass('INVALIC_ERROR');
        $('#nuevoUpdateUsuario').addClass('disabled_link3').attr('disabled', true);
    }else{
        $('#msg_password').text(null);
        $('#usu_confir_password').removeClass('INVALIC_ERROR');
        $('#nuevoUpdateUsuario').removeClass('disabled_link3').attr('disabled', false);
    }

    if( $('#usu_password').val() != '' ){
        $('#usu_password').removeClass('INVALIC_ERROR');
        $('#msg_password_d').text(null);
    }
}
function passwordMostrarOcultar( por )
{
    if(por == 'mostrar'){
        $('#usu_password').attr('type','text');
        $('#usu_confir_password').attr('type','text');
    }
    if(por == 'ocultar'){
        $('#usu_password').attr('type','password');
        $('#usu_confir_password').attr('type','password');
    }
}

function fetchUsuarioRepetido($paramet_usuario)
{
    var url = $DOCUMENTO_URL_HTTP + '/application/system/configuraciones/controller/conf_controller.php';
    // var pamarts = { 'ajaxSend':'ajaxSend' , 'accion':'infoUsuarioOdontic' , 'idmodusu' : id, 'cual':'objecto' };
    var pamarts = { 'ajaxSend':'ajaxSend' , 'accion':'consultar_usuario' , 'paramUsuario':$paramet_usuario };

    var objUsuario = null;
    $.get(url  , pamarts, function(data){
        objUsuario = $.parseJSON(data);

    });
}


$('#tipoUsuario').change(function() {


    var modificarcheck  = $('#chek_modificar');
    var eliminarcheck   = $('#chek_eliminar');
    var consultar       = $('#chek_consultar');
    var agregarcheck    = $('#chek_agregar');

    if( $(this).find(':selected').val() == '' || $(this).find(':selected').val() == 1 )
    {

        modificarcheck.addClass('disabled_link3').attr('disabled', true);
        eliminarcheck.addClass('disabled_link3').attr('disabled', true);
        consultar.addClass('disabled_link3').attr('disabled', true);
        agregarcheck.addClass('disabled_link3').attr('disabled', true);

    }else{

        modificarcheck.removeClass('disabled_link3').attr('disabled', false);
        eliminarcheck.removeClass('disabled_link3').attr('disabled', false);
        consultar.removeClass('disabled_link3').attr('disabled', false);
        agregarcheck.removeClass('disabled_link3').attr('disabled', false);
    }

    //si es igual a 0 y no se a seleccionado nada
    if( $(this).find(':selected').val() == '')
    {
        $(this).addClass('INVALIC_ERROR');
        $('#msg_permisos').text('Debe seleccionar un tipo de usuario');
        $('#nuevoUpdateUsuario').addClass('disabled_link3');
    }else{
        $(this).removeClass('INVALIC_ERROR');
        $('#msg_permisos').text(null);
        $('#nuevoUpdateUsuario').removeClass('disabled_link3');
    }

    //administrador
    if(  $(this).find(':selected').val() == 1 ){

        modificarcheck.prop('checked', true);
        eliminarcheck.prop('checked', true);
        consultar.prop('checked', true);
        agregarcheck.prop('checked', true);

    }else{

        modificarcheck.prop('checked', false);
        eliminarcheck.prop('checked', false);
        consultar.prop('checked', false);
        agregarcheck.prop('checked', false);
    }
});


$('#nuevoUpdateUsuario').on('click', function() {

    var $puedoPasar = 0;

    var doctor     = $("#usu_doctor");
    var usuario    = $("#usu_usuario");
    var passeord   = $("#usu_password");
    var Confir_passeord = $("#usu_confir_password");
    var tipoUsuario = $("#tipoUsuario");

    if(doctor.find(':selected').val() == "" ){

        doctor.addClass('INVALIC_ERROR');
        $('#msg_doctorUsuario').text('Tiene que asociar un doctor');
        $puedoPasar++;
    }else{
        doctor.removeClass('INVALIC_ERROR');
        $('#msg_doctorUsuario').text(null);
    }

    if(usuario.val() == ""){
        usuario.addClass('INVALIC_ERROR');
        $('#msg_usuario_repit').text('Debe Ingresar un Usuario');
        $puedoPasar++;
    }else{
        usuario.removeClass('INVALIC_ERROR');
        $('#msg_usuario_repit').text(null);
    }

    if(passeord.val() == ""){
        passeord.addClass('INVALIC_ERROR');
        $('#msg_password_d').text('Debe Ingresar un password');
        $puedoPasar++;
    }else{
        passeord.removeClass('INVALIC_ERROR');
        $('#msg_password_d').text(null);
    }

    if(Confir_passeord.val() == ""){
        Confir_passeord.addClass('INVALIC_ERROR');
        $('#msg_password').text('Debe confirmar el password');
        $puedoPasar++;
    }else{
        Confir_passeord.removeClass('INVALIC_ERROR');
        $('#msg_password').text(null);
    }

    if(tipoUsuario.find(':selected').val() == ""){
        tipoUsuario.addClass('INVALIC_ERROR');
        $('#msg_permisos').text('Debe seleccionar un tipo de usuario');
        $puedoPasar++;
    }else{
        tipoUsuario.removeClass('INVALIC_ERROR');
        $('#msg_permisos').text(null);
    }

    if( $puedoPasar == 0){

        var parametros = {
            'ajaxSend'  : 'ajaxSend',
            'accion'    : 'nuevoUpdateUsuario',
            'subaccion' : 'nuevo',

            'doctor'      : $('#usu_doctor').find(':selected').val(),
            'usuario'     : $('#usu_usuario').val(),
            'passwords'   : encrytar_base64( $('#usu_password').val() ) ,
            'tipoUsuario' : $('#tipoUsuario').find(':selected').val(),

            'permisos': {
                'consultar' : $('#chek_consultar').prop('checked'),
                'agregar'   : $('#chek_agregar').prop('checked'),
                'modificar' : $('#chek_modificar').prop('checked'),
                'eliminar'  : $('#chek_eliminar').prop('checked'),
            }

        };

        $.ajax({
            url: $DOCUMENTO_URL_HTTP + '/application/system/configuraciones/controller/conf_controller.php',
            type:'POST',
            data: parametros,
            dataType:'json',
            async:false,
            success:function(r) {
                if(r.error == ''){

                }else{
                    notificacion(r.error, 'error');
                }
            }

        });
    }

    console.log(parametros);

});



function fetchUsuarioUpdate( id_usu )
{
    if( id_usu != '')
    {

        $.ajax({
            url: $DOCUMENTO_URL_HTTP + '/application/system/configuraciones/controller/conf_controller.php',
            type:'POST',
            data: {'ajaxSend':'ajaxSemd', 'accion':'fech_usuariodoct', 'id':id_usu},
            dataType:'json',
            async:false,
            success: function(resp){
                console.log(resp);

                var obj = resp;
                var doctor               = obj.fk_doc;
                var usuario              = obj.usuario;
                var password             = obj.passwor_abc;
                var confir_password      = obj.passwor_abc;
                var tipousuario          = obj.tipo_usuario;
                var permisos             = JSON.parse(obj.permisos);


                $('#tipoUsuario').val(tipousuario).trigger('change');

                $("#chek_consultar").prop('checked', ( permisos.consultar == "true" ) ? true : false);
                $("#chek_agregar").prop('checked'  , ( permisos.agregar == "true" ) ? true : false);
                $("#chek_modificar").prop('checked', ( permisos.modificar == "true" ) ? true : false);
                $("#chek_eliminar").prop('checked' , ( permisos.eliminar == "true" ) ? true : false);


                $("#usu_doctor").val( doctor ).trigger('change').prop('disabled', true);
                $('#usu_usuario').val( usuario );
                $('#usu_password').val( descrytar_base64(password) );
                $('#usu_confir_password').val( descrytar_base64(confir_password) );
            }

        });
    }
}

$(document).ready(function() {

    CargarUsuarioInfo();

    $('#tipoUsuario').val(2).trigger('change');
    $('#tipoUsuario').select2();
    $('#usu_doctor').select2({
        placeholder:'Odontolog@',
        allowClear: true,

    });

    if(paramsGet.get('mod')){
        if((paramsGet.get('id'))){
            alert(paramsGet.get('id'));
            fetchUsuarioUpdate( paramsGet.get('id') )
        }
    }
    //si en caso esta con create y tiene el id
    if(paramsGet.get('creat')){
        if((paramsGet.get('id'))){
            $('.row').eq(1).attr('disabled', true).addClass('disabled_link3');
        }
    }

});



function encrytar_base64(dato) {
    return btoa(dato);
}
function descrytar_base64(dato) {
    return atob(dato);
}
