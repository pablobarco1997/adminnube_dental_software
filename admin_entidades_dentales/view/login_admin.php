

<div class="col-xs-12 col-md-12">
    <div class="row">
        <div class="col-xs-12 col-md-5 col-sm-8  col-center-block">
            <div class="login" >
                <h3 class="text-center">INICIAR SESIÓN ADMIN</h3>
                <div class="form-group">
                    <label for="">USUARIO</label>
                    <input type="text" class="form-control input-login" id="usuario">
                </div>
                <div class="form-group">
                    <label for="">PASSWORD</label>
                    <input type="password" class="form-control input-login " id="password">
                </div>

                <div class="text-center">
                    <input type="button" id="iniciarSesionAdmin" class="btn btn-block " style="background-color: #5cb85c; color: #FFFFFF; font-weight: bolder" value="Login">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // ohSnap('Oh Snap! I cannot process your card...', {color: 'red'});  // alert will have class 'alert-color'


    $('#iniciarSesionAdmin').click(function() {

        var Usuario  = $('#usuario').val();
        var Password = $('#password').val();

        if(Usuario != "" && Password != "")
        {
            IniciarSesion({
                'ajaxSend' : 'ajaxSend' ,
                'accion'   : 'inicio_sesion_admin' ,
                'usuario' :  Usuario ,
                'password' : Password
            });

        }else{

            ohSnap('Complete los campos del formulario de Inicio Sesion', {color: 'red'});
        }
    });

    function IniciarSesion(parametros)
    {

        $.ajax({
            url: "<?= DOL_HTTP ?>" + "/admin_entidades_dentales/entidad_controller/controller.php",
            type: 'POST',
            data: parametros,
            dataType: 'json',
            async: false,
            success: function (resp)
            {
                if(resp.errores == "")
                {

                    $('#iniciarSesionAdmin').attr('value', 'cargando...');

                    ohSnap('Sesion Iniciada !Exitoso', {color: 'green'});

                    setTimeout(function() {

                        window.location = "<?= DOL_HTTP ?>" + "/admin_entidades_dentales/index.php?view=inicio";
                        $('#iniciarSesionAdmin').attr('value', 'Login');

                    }, 2000)

                }else{

                    ohSnap( resp.errores , {color: 'red'});
                }
            }
        });

    }

</script>