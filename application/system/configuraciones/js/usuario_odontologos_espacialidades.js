
/** ODONTOLOGOS**/

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
                type:'POST',
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

                var datos        = resp.error;
                var nombre       = $('#nombre_doct');
                var apellido     = $('#apellido_doct');
                var telefono     = $('#TelefonoConvencional_doct');
                var direccion    = $('#direccion_doct');
                var celular      = $('#celular_doct');
                var email        = $('#email_doct');
                var ciudad       = $('#ciudad_doct');
                var especialidad = $('#especialidad_doct');

                var img = $('#icon_usuario_doct');

                nombre.val( datos.nombre_doc );
                apellido.val( datos.apellido_doc );
                celular.val( datos.celular );
                telefono.val( datos.telefono_convencional );
                direccion.val( datos.direccion );
                email.val( datos.email );
                ciudad.val( datos.ciudad );
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
        })
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
        $('#especialidad_doct').val(0).trigger('change');

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

    function ModificarUsuario(idodontologo, idusuario, $subaccion)
    {

        //modificar
        if( $subaccion.toString() == '1')
        {
            //se quita las funciones
            $('#usu_usuario').attr('onkeyup','');
            $('#accionUsuario').attr('data-id', idusuario); //id usuario
            // console.log( $('#accionUsuario') );
            // $("#usu_doctor").attr('onchange', '');
            $('#msg_doctorUsuario').text(null);
            $('#msg_password_d').text(null);
            $('#msg_password').text(null);
            $('#msg_permisos').text(null);

            fecth_modUsuarioDoct( idusuario ); //obtengo los valeres listo para modificar

            $('#accionUsuario').text('MODIFICAR USUARIO');
            $('#msg_usuario_repit').text(null);
            $('#usu_usuario').removeClass('INVALIC_ERROR');

        }

        //nuevo
        if($subaccion.toString() == "0")
        {

            $('#accionUsuario').attr('data-id', 0);
            // console.log( $('#accionUsuario') );

            $('#msg_doctorUsuario').text(null);
            $('#msg_usuario_repit').text(null);
            $('#msg_password_d').text(null);
            $('#msg_password').text(null);
            $('#msg_permisos').text(null);

            //clear
            $('#tipoUsuario').val(null).trigger('change');
            $('#usu_doctor').val(null).trigger('change');

            $('#usu_usuario').val(null);
            $('#usu_password').val(null);
            $('#usu_confir_password').val(null);

            $('#chek_consultar').prop('checked', false);
            $('#chek_agregar').prop('checked', false);
            $('#chek_modificar').prop('checked', false);
            $('#chek_eliminar').prop('checked', false);

            //onkeyup funciones  ---------------------------
            $('#usu_usuario').attr('onkeyup','comprobar_usuario_en_uso(); invalicUsuario();');
            //se aplica la funcion crear usuario
            $("#usu_doctor").attr('onchange', 'UsuarioOdctor($(this))').prop('disabled', false);

            $('#accionUsuario').text('NUEVO USUARIO');

        }

    }

    function encrytar_base64(dato) {
        return btoa(dato);
    }
    function descrytar_base64(dato) {
        return atob(dato);
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


        var subaccion = ( $('#accionUsuario').data('id') == '0') ? 'nuevo' : 'modificar';

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

        var subaccion = ( $('#accionUsuario').data('id') == '0') ? 'nuevo' : 'modificar';

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

            var subaccion = ( $('#accionUsuario').data('id') == '0') ? 'nuevo' : 'modificar';

            var parametros = {
                'ajaxSend'  : 'ajaxSend',
                'accion'    : 'nuevoUpdateUsuario',
                'subaccion' : subaccion ,
                'idUsuario' : ( $('#accionUsuario').data('id') == '0') ? 0 : $('#accionUsuario').data('id'),

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

                //de comprueba el usuario antes de crearlo
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

    function fecth_modUsuarioDoct( $idUsuario )
    {
        if( $idUsuario != ''){


            $.ajax({
                url: $DOCUMENTO_URL_HTTP + '/application/system/configuraciones/controller/conf_controller.php',
                type:'POST',
                data: {'ajaxSend':'ajaxSemd', 'accion':'fech_usuariodoct', 'id':$idUsuario},
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
    list_odontologos('A');

    /**end dentista   ------- -------------**/

}


/** ESPECIALIDADES DE ODONTOLOGOS **/

if($accion == 'specialties')
{

    //LISTA DE ESPECIALIDADES
    function list_especialidades()
    {
        $('#gention_especialidades').DataTable({

            searching: true,
            ordering:false,
            destroy:true,
            ajax:{
                url: $DOCUMENTO_URL_HTTP + '/application/system/configuraciones/controller/conf_controller.php',
                type:'POST',
                data:{'ajaxSend':'ajaxSend', 'accion':'list_especialidades'},
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

    //ESPECIALIDADES LIST
    $('#guardar_conf_especialidad').click(function() {
        var puedo = 0;

        var especialidad = $('#especialidad_nombre');

        if( especialidad.val() == ''){
            puedo++;
            especialidad.addClass('INVALIC_ERROR');
            $('#msg_especialidad').text('Campo obligatorio, (escriba una especialidad)');
        }else{
            especialidad.removeClass('INVALIC_ERROR');
            $('#msg_especialidad').text(null);
        }

        if( puedo == 0){

            $.ajax({
                url: $DOCUMENTO_URL_HTTP + '/application/system/configuraciones/controller/conf_controller.php',
                type:'POST',
                data: { 'ajaxSend': 'ajaxSend', 'accion': 'nuevo_update_especialidad', 'especialidad': especialidad.val(), 'descrip': $('#especialidad_descripcion').val() },
                dataType:'json',
                async:false,
                success: function(resp){

                    if( resp.error == ''){
                        notificacion('Información Actualizada', 'success');
                        reloadPagina();
                    }else {
                        notificacion(resp.error , 'error');
                    }
                }
            });
        }

    });



    //eliminar especialidad
    function eliminar_especialidad(id){

        if(id != ""){

            $.ajax({
                url: $DOCUMENTO_URL_HTTP + '/application/system/configuraciones/controller/conf_controller.php',
                type:'POST',
                data: { 'ajaxSend': 'ajaxSend', 'accion': 'delete_especialidad', 'id': id},
                dataType:'json',
                async:false,
                success: function(resp) {

                    if(resp.error == ''){
                        notificacion('Información Actualizada', 'success');
                        list_especialidades();
                    }else{
                        notificacion(resp.error, 'error');
                    }

                }
            });

        }
    }


    list_especialidades();



    /** END ESPECIALIDADES **/
}

