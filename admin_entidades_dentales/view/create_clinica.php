<div class="row">

    <div class="col-xs-12 col-ms-12 col-md-12 col-lg-12">
        <h3>CREAR - CLINICA DENTAL </h3>
        <h3>BASE DE DATOS - USUARIO LOGIN </h3>

        <br>

        <div class="form-group col-lg-12 col-md-12 col-xs-12">

            <div class="form-horizontal">

                <div class="form-group">
                    <label class="control-label col-sm-4 " style="text-align: center" for="nom_clinica">Nombre de la Clinica</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control presionar" id="nom_clinica" >
                        <small style="color: red" id="mensaje_nom_clinica"></small>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-4 " style="text-align: center" for="nom_schema">Nombre del schema</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">adminnub_schema_</span>
                            <input id="nom_schema" type="text" class="form-control presionar"   style="z-index:1">
                            <small style="color: red" id="mensaje_nom_schema"></small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-4 " style="text-align: center" for="nom_clinica">Numero de Entidad</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control presionar" id="num_entidad" >
                        <small style="color: red" id="mensaje_num_entidad"></small>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-4 " style="text-align: center" for="clinica_email">Clinica E-mail</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control presionar" id="clinica_email" >
                        <small style="color: red" id="mensaje_clinica_email"></small>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-4 " style="text-align: center" for="password_clinica_email">Clinica - Password E-mail</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control presionar" id="password_clinica_email" >
                        <small style="color: red" id="mensaje_clinica_email"></small>
                    </div>
                </div>

                <hr>

                <h3>REGISTRO DE USUARIO</h3>

                <div class="form-group">
                    <label class="control-label col-sm-4 " style="text-align: center" for="nombre_doc">Nombre</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control presionar" id="nombre_doc" >
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-4 " style="text-align: center" for="apellido_doc">Apellido</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control presionar" id="apellido_doc" >
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-4 " style="text-align: center" for="nom_usuario">Usuario</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control presionar" id="nom_usuario" >
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-4 " style="text-align: center" for="usu_password">Password</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="password" class="form-control input-sm" id="usu_password" >
                            <div class="input-group-addon btn" onclick="passwordMostrarOcultar('mostrar')"><i class="fa fa-eye"></i></div>
                            <div class="input-group-addon btn" onclick="passwordMostrarOcultar('ocultar')"><i class="fa fa-eye-slash"></i></div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <br>
                    <button id="crear_clinica" class="btn btn-block" style="font-weight: bolder; color: green; background-color: #f8f8f8; border: 1px solid green;">Guardar</button>
                </div>

                <br>
                <br>
            </div>
        </div>
    </div>

</div>

<!--modales -->
<!--modal de errores-->

<?php include_once 'errores_registro_clinica_modal.php'?>

<script>

    // $('#errores_modal_create_clinica').modal('show');

    $('#crear_clinica').click(function(){

        var nombreClinica                = $('#nom_clinica').val();
        var nombre_schema                = 'adminnub_schema_' + $('#nom_schema').val();
        var numeroEntidad                = $('#num_entidad').val();
        var clinicaEmail                 = $('#clinica_email').val();
        var PasswordClinicaEmil          = $('#password_clinica_email').val();

        /** CREARCION DE USUARIO **/

        var nombre          = $('#nombre_doc').val();
        var apellido        = $('#apellido_doc').val();
        var usuario         = $('#nom_usuario').val();
        var password        = $('#usu_password').val();

        /*  array de usuario */
        var createUsuario = {nombre, apellido, usuario, password};

        var datos = {
            'ajaxSend'            : 'ajaxSend' ,
            'accion'              : 'crear_clinica_dental' ,
            'nomb_clinica'        : nombreClinica,
            'nomb_schema'         : nombre_schema,
            'num_entidad'         : numeroEntidad,
            'clinica_email'       : clinicaEmail,
            'password_clinica'    : PasswordClinicaEmil,

            'createUsuario'       : createUsuario,

        };

        console.log( datos );

        if( INVALIC_REPETIR_CLINICA_CREDENCIALES(nombreClinica, nombre_schema, numeroEntidad) == 0)
        {
            $.ajax({
                url:  "<?= DOL_HTTP ?>" + "/admin_entidades_dentales/entidad_controller/controller.php",
                type: 'POST',
                data: datos,
                dataType:'json',
                async:false,
                success:function(resp){

                    if( resp.error.error_text == '' && resp.error.arror_table.length == 0)
                    {
                        ohSnap('Información Actualizada', { color: 'green'});
                    }

                    //mensajes de errores
                    if(resp.error.error_text != '')
                    {
                        notificacion(resp.error.error_text , {color: 'red'});
                    }

                    //Lista de Errores con al creacion de tablas
                    if(resp.error.arror_table.length > 0)
                    {
                        var list_err = resp.error.arror_table;
                        var table = "" +
                            "<tbody>";

                        var i = 0;
                        while(i <= list_err.length -1)
                        {
                            table += "<tr>";
                                table +=  "<td> "+ list_err[i][0] +" </td>";
                            table += "</tr>";
                            i++;
                        }

                        table += "</tbody>";

                        $('#list_errores').html( table );

                        $('#errores_modal_create_clinica').modal('show');
                    }

                    console.log(resp);
                }

            });
        }
    });


    //SE VALIDA SI LOS DATOS A INGRESAR YA ESTAN INGRESADO O ES DIFERENSTES
    function  INVALIC_REPETIR_CLINICA_CREDENCIALES(nom_clinica , nomb_schema, num_entidad )
    {

        var puedo = 0;

        $.ajax({
           url: "<?= DOL_HTTP ?>" + "/admin_entidades_dentales/entidad_controller/controller.php",
           type:"POST" ,
           data: {
               'ajaxSend': 'ajaxSend'        ,
               'accion': 'validar_clinica'   ,
               'nomb_clinica' :  nom_clinica ,
               'nomb_schema'  :  nomb_schema ,
               'num_entidad'  :  num_entidad ,
           } ,
           dataType: 'json',
           async:false,
           success:function(resp)
           {

               console.log(resp);

               if( resp.error > 0 )
               {
                   // alert( resp.respuesta.nom_clinica );
                   $('#mensaje_nom_clinica').text( resp.respuesta.nom_clinica );
                   $('#mensaje_nom_schema').text( resp.respuesta.nomb_schema );
                   $('#mensaje_num_entidad').text( resp.respuesta.num_entidad );

                   puedo++;
               }
           }

        });

        return puedo;
    }

    //MOSTRAR Y OCULTAR CONTRASENA
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

    function encrytar_base64(dato) {
        return btoa(dato);
    }
    function descrytar_base64(dato) {
        return atob(dato);
    }

</script>