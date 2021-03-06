/** ODONTOLOGOS Y CREACION DE USUARIOS**/

if($accion == 'dentist')
{

    //LIST ODONTOLOGOS
    //FUNCION
    function list_odontologos(estado)
    {
        $('#gention_odontologos_list').DataTable({

            searching: true,
            ordering:false,
            destroy:true,
            ajax:{
                url: $DOCUMENTO_URL_HTTP + '/application/system/configuraciones/controller/conf_controller.php',
                type:'GET',
                data:{'ajaxSend':'ajaxSend', 'accion':'list_odontologos', 'estado':estado},
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

        });
    }

    //GUARDAR NUEVO ODONTOLOGO
    //GUARDAR REGISTRO DE ODONTOLOGOS
    $('#guardar_informacion_odontologos').click(function() {

        var archivo = document.getElementById('icon_doct');
        var fichero = archivo.files[0];

        var $puedo = 0;

        var nombre       = $('#nombre_doct');
        var apellido     = $('#apellido_doct');
        var telefono     = $('#TelefonoConvencional_doct');
        var direccion    = $('#direccion_doct');
        var celular      = $('#celular_doct');
        var email        = $('#email_doct');
        var ciudad       = $('#ciudad_doct');
        var ruc_cedula   = $('#rucedula_doct');
        var especialidad = $('#especialidad_doct').find(':selected').val();


        if( nombre.val() == ''){
            $puedo++;
            nombre.addClass('INVALIC_ERROR');
        }else{
            nombre.removeClass('INVALIC_ERROR');
        }

        if( apellido.val() == ''){
            $puedo++;
            apellido.addClass('INVALIC_ERROR');
        }else{
            apellido.removeClass('INVALIC_ERROR');
        }

        // if( direccion.val() == ''){
        //     $puedo++;
        //     direccion.addClass('INVALIC_ERROR');
        // }else{
        //     direccion.removeClass('INVALIC_ERROR');
        // }

        if( email.val() == ''){
            $puedo++;
            email.addClass('INVALIC_ERROR');
        }else{
            email.removeClass('INVALIC_ERROR');
        }

        if( celular.val() == ''){
            $puedo++;
            celular.addClass('INVALIC_ERROR');
        }else{
            celular.removeClass('INVALIC_ERROR');
        }

        if( ruc_cedula.val() == ''){
            $puedo++;
            ruc_cedula.addClass('INVALIC_ERROR');
        }else{
            ruc_cedula.removeClass('INVALIC_ERROR');
        }

        //subaaccion modal

        var subaccion = '';
        var id = '';
        if($('#accion').data('id') == '0'){
            subaccion = 'nuevo';
        }
        if(parseInt( $('#accion').data('id') ) > 0){
            subaccion = 'modificar';
            id = $('#accion').data('id');
        }
        var datos = {
            'nombre'    :nombre.val(),
            'apellido'  :apellido.val(),
            'telefono'  :telefono.val(),
            'direccion' :direccion.val(),
            'celular'   :celular.val(),
            'email'     :email.val(),
            'ciudad'    :ciudad.val(),
            'especialidad': especialidad,
            // 'icon'        : fichero,
            'cedula_ruc': ruc_cedula.val(),
        };

        if($puedo == 0){
            nuevoGuardarOdontologo(datos, subaccion, id, fichero);
            $('#icon_doct').val(null);
        }else{
            notificacion('No puede guardar la informacion, Faltan campos obligatorios', 'error');

        }

    });
    function nuevoGuardarOdontologo(datos, subaccion, id, fichero)
    {

        console.log(datos);

        var form = new FormData();

        form.append('ajaxSend', 'ajaxSend');
        form.append('accion', 'crear_odontologo');
        form.append('subaccion', subaccion);
        form.append('id', id);
        form.append('datos', JSON.stringify(datos));
        form.append('icon', fichero);
        // datos = { 'ajaxSend':'ajaxSend', 'accion':'crear_odontologo','datos':datos, 'subaccion': subaccion, 'id': id };

        $.ajax({
            url: $DOCUMENTO_URL_HTTP + '/application/system/configuraciones/controller/conf_controller.php',
            type:'POST',
            data: form,
            dataType:'json',
            contentType:false,
            processData:false,
            async:false,
            success: function(resp){

                if(resp.error == ''){
                    notificacion('Información Actualizada', 'success');
                    location.reload(true);

                }else{
                    notificacion(resp.error, 'error');
                }
            }

        });
    }

    //MODIFICAR ODONTOLOGO
    function modificarOdontologo(id)
    {
        //Modificar
        $('#accion').attr('data-id', id);
        $('#accion').text( 'Modificar' );
        $.ajax({
            url: $DOCUMENTO_URL_HTTP + '/application/system/configuraciones/controller/conf_controller.php',
            type:'POST',
            data:{ 'ajaxSend':'ajaxSend', 'accion':'fetch_odontologos', 'id': id },
            dataType:'json',
            async:false,
            success: function(resp){

                console.log(resp);

                var datos         = resp.error;
                var nombre        = $('#nombre_doct');
                var apellido      = $('#apellido_doct');
                var telefono      = $('#TelefonoConvencional_doct');
                var direccion     = $('#direccion_doct');
                var celular       = $('#celular_doct');
                var email         = $('#email_doct');
                var ciudad        = $('#ciudad_doct');
                var especialidad  = $('#especialidad_doct');
                var rucedula_doct = $('#rucedula_doct');

                var img = $('#icon_usuario_doct');

                nombre.val( datos.nombre_doc );
                apellido.val( datos.apellido_doc );
                celular.val( datos.celular );
                telefono.val( datos.telefono_convencional );
                direccion.val( datos.direccion );
                email.val( datos.email );
                ciudad.val( datos.ciudad );
                rucedula_doct.val( datos.cedula );
                especialidad.val( datos.fk_especialidad ).trigger('change');

                if(datos.icon != ''){
                    img.attr('src',  $DOCUMENTO_URL_HTTP + '/logos_icon/' + $DIRECTORIO + '/' + datos.icon );
                }
                if( datos.icon == null){
                    img.attr('src',  $DOCUMENTO_URL_HTTP + '/logos_icon/logo_default/doct-icon.png' );
                }
            }

        });
    }

    //ACTUALIZAR ESTADO DEL ODONTOLOGO
    function UpdateEstadoOdontologos(id, estado)
    {
        $.ajax({
            url: $DOCUMENTO_URL_HTTP + '/application/system/configuraciones/controller/conf_controller.php',
            type:'POST',
            data:{ 'ajaxSend':'ajaxSend', 'accion':'actualizar_estados', 'id': id, 'estado': estado },
            dataType:'json',
            async:false,
            success: function(resp) {

                if(resp.error != ''){
                    notificacion(resp.error, 'error');
                }else{
                    if(estado == 'A'){
                        list_odontologos('E');
                    }
                    if(estado == 'E'){
                        list_odontologos('A');
                    }

                }
            }
        });
    }

    //cambiar attr accion nuevo && modificar
    function cambiarattr(){

        //Odontologos
        $('#accion').attr('data-id', 0);     $('#accion').text( 'Nuevo' );

        $('#nombre_doct').val(null);
        $('#apellido_doct').val(null);
        $('#TelefonoConvencional_doct').val(null);
        $('#direccion_doct').val(null);
        $('#celular_doct').val(null);
        $('#email_doct').val(null);
        $('#ciudad_doct').val(null);
        $('#rucedula_doct').val(null);
        $('#especialidad_doct').val(0).trigger('change');
        $('#icon_usuario_doct').attr('src',  $DOCUMENTO_URL_HTTP + '/logos_icon/logo_default/doct-icon.png' );
    }


    //EVENTOS
    //Cambiar Icono paciente
    $('#icon_doct').change(function(e){

        SubirImagenes( this , $('#icon_usuario_doct') , $DOCUMENTO_URL_HTTP + '/logos_icon/logo_default/doct-icon.png');

    });


    $('#desabilitado_doctores').change(function() {

        if( $(this).prop('checked')){

            list_odontologos('E');
        }else{
            list_odontologos('A');

        }

    });


    /**CREACION MODIFICAR USUARIO DEL PACIENTE**/

    function encrytar_base64(dato) {
        return btoa(dato);
    }
    function descrytar_base64(dato) {
        return atob(dato);
    }

    //Compruba q usuario esta en uso
    function comprobar_usuario_en_uso()
    {

        var puedoPasar  = 0;

        var usuario = $('#usu_usuario').val();

        if( usuario != ''){

            $.ajax({
                url: $DOCUMENTO_URL_HTTP + '/application/system/configuraciones/controller/conf_controller.php',
                type:'POST',
                data:
                    {
                        'ajaxSend':'ajaxSend',
                        'accion':'consultar_usuario',
                        'usuario': usuario,
                        'subaccion':'usuario_rep'
                    },
                dataType:'json',
                async:false,
                success: function(resp)
                {

                    console.log(resp);

                    if(resp.error != ''){

                        puedoPasar++;

                        $('#msg_usuario_repit').text(resp.error);
                        $('#nuevoUpdateUsuario').addClass('disabled_link3');
                        $("#usu_usuario").addClass('INVALIC_ERROR');

                    }else {

                        $('#msg_usuario_repit').text(null);
                        $('#nuevoUpdateUsuario').removeClass('disabled_link3');
                        $("#usu_usuario").removeClass('INVALIC_ERROR');

                    }
                }

            });

        }else{

            puedoPasar++;
            $('#msg_usuario_repit').text( 'Debe ingresar un Usuario' );
        }


        var subaccion = ( $('#accionUsuario').prop('dataset').id == '0') ? 'nuevo' : 'modificar';

        if( subaccion == 'nuevo'){
            var iddoct = $('#usu_doctor'); //se comprueba el doctor si tienen usuario de nuevo
            UsuarioOdctor( iddoct );
        }

        return puedoPasar;
    }


    $('#tipoUsuario').change(function() {


        var modificarcheck  = $('#chek_modificar');
        var eliminarcheck   = $('#chek_eliminar');
        var consultar       = $('#chek_consultar');
        var agregarcheck    = $('#chek_agregar');

        if( $(this).find(':selected').val() == '' || $(this).find(':selected').val() == 1 ){

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

    //compruebo si el odontologo ya tiene creado un usuario
    function UsuarioOdctor(docto)
    {

        var puede = 0;

        var iddoctor = docto.find(':selected').val();
        $.ajax({
            url: $DOCUMENTO_URL_HTTP + '/application/system/configuraciones/controller/conf_controller.php',
            type:'POST',
            data: {'ajaxSend':'ajaxSend','accion':'consultar_usuario', 'iddoctor': iddoctor , 'subaccion':'doct_usuario'},
            dataType:'json',
            async:false,
            success: function(resp){
                if(resp.error != ''){
                    $('#msg_doctorUsuario').text(resp.error);
                    $('#nuevoUpdateUsuario').addClass('disabled_link3');
                    puede++;
                }else {
                    $('#msg_doctorUsuario').text(null);
                    $('#nuevoUpdateUsuario').removeClass('disabled_link3');
                    $('#usu_doctor').removeClass('INVALIC_ERROR');
                }
            }
        });

        if( iddoctor == ""){
            $('#msg_doctorUsuario').text('Debe Selecionar un doctor');
            $('#nuevoUpdateUsuario').addClass('disabled_link3');
        }

        return puede;

    }

    //validacion de usuarios
    function invalicUsuario()
    {

        var subaccion = ( $('#accionUsuario').prop('dataset').id == '0') ? 'nuevo' : 'modificar';

        if( subaccion == 'nuevo') {

            var puedoPasar = 0;
            puedoPasar +=  UsuarioOdctor( $('#usu_doctor') );
            puedoPasar +=  comprobar_usuario_en_uso();

            if( puedoPasar > 0)
            {
                $('#nuevoUpdateUsuario').addClass('disabled_link3');
            }
            if( puedoPasar == 0)
            {
                $('#nuevoUpdateUsuario').removeClass('disabled_link3');
            }

        }


    }

    $('#nuevoUpdateUsuario').click(function(){

        var $puedoPasar = 0;

        var doctor  = $("#usu_doctor");
        var usuario  = $("#usu_usuario");
        var passeord = $("#usu_password");
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

            var subaccion = ( $('#accionUsuario').prop('dataset').id == '0') ? 'nuevo' : 'modificar';

            var parametros = {
                'ajaxSend'  : 'ajaxSend',
                'accion'    : 'nuevoUpdateUsuario',
                'subaccion' : subaccion ,
                'idUsuario' : ( $('#accionUsuario').prop('dataset').id == '0') ? 0 : $('#accionUsuario').prop('dataset').id,

                'doctor'      : $('#usu_doctor').find(':selected').val(),
                'usuario'     : $('#usu_usuario').val(),
                'passwords'   : encrytar_base64( $('#usu_password').val() ) +'-'+ $('#usu_password').val(),
                'tipoUsuario' : $('#tipoUsuario').find(':selected').val(),

                'permisos': {
                    'consultar' : $('#chek_consultar').prop('checked'),
                    'agregar'   : $('#chek_agregar').prop('checked'),
                    'modificar' : $('#chek_modificar').prop('checked'),
                    'eliminar'  : $('#chek_eliminar').prop('checked'),
                }

            };

            if( subaccion == 'nuevo' ){

                //de comprueba de NUEVO  el usuario ANTES de crearlo
                if( UsuarioOdctor( $('#usu_doctor') ) == 0 ){

                    $.ajax({
                        url: $DOCUMENTO_URL_HTTP + '/application/system/configuraciones/controller/conf_controller.php',
                        type:'POST',
                        data: parametros,
                        dataType:'json',
                        async:false,
                        success: function(resp){

                            if(resp.error == ''){
                                notificacion('Información Actualizada', 'success');
                                reloadPagina();
                            }else{
                                notificacion( resp.error , 'error');
                            }
                        }
                    });

                }else{
                    notificacion('Ya tiene Usuario Asignado', 'error');
                }
            }

            if( subaccion == 'modificar'){

                $.ajax({
                    url: $DOCUMENTO_URL_HTTP + '/application/system/configuraciones/controller/conf_controller.php',
                    type:'POST',
                    data: parametros,
                    dataType:'json',
                    async:false,
                    success: function(resp){

                        if(resp.error == ''){
                            notificacion('Información Actualizada', 'success');
                            reloadPagina();
                        }else{
                            notificacion( resp.error , 'error');
                        }
                    }
                });

            }

        }

    });




    $('#usu_doctor').select2({
        placeholder: 'seleccione un doctor',
        allowClear:true,
        language:'es'
    });
    $('#tipoUsuario').select2({
        placeholder: 'seleccione un tipo de Usuario',
        allowClear:true,
        language:'es'
    });
    $('#especialidad_doct').select2();


}

list_odontologos('A');