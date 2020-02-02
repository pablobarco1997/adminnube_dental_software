
<?php

include_once '../../config/lib.global.php';

session_start();

if(isset($_SESSION['is_open']))
{
    header("location:".DOL_HTTP."");
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="../../../public/bower_components/bootstrap/dist/css/bootstrap.css">
    <!--    sweetarlert2 -->
    <link rel="stylesheet" href=" <?php echo DOL_HTTP .'/public/lib/sweetalert2/sweetalert2.css'?> ">

    <title>Login</title>
    <link href="https://fonts.googleapis.com/css?family=Hind&display=swap" rel="stylesheet">
</head>
<style>

    *{
        font-family: 'Hind', sans-serif;
    }
    body{
        background-image: url("<?php echo DOL_HTTP .'/application/system/login/img/photo_main.jpg'?>");
        background-size: 670px 669px;
        background-repeat: no-repeat;
    }

    input {
        width: 100%;
        /*background-color: #EBEDEF;*/
        padding: 5px;
        border: none;
        font-family: 'Karla', sans-serif;
    }
    .form-uic{
        width: 100%;
        -webkit-box-shadow: 10px 10px 5px -9px rgba(0,0,0,0.75);
        -moz-box-shadow: 10px 10px 5px -9px rgba(0,0,0,0.75);
        box-shadow: 10px 10px 5px -9px rgba(0,0,0,0.75);
    }

    .effect-2 ~ .focus-border{position: absolute; bottom: 0; left: 50%; width: 0; height: 2px; background-color: #4caf50; transition: 0.4s;}
    .effect-2:focus ~ .focus-border{width: 100%; transition: 0.4s; left: 0;}

    .effect-2:{border: 0; padding: 7px 0; border-bottom: 1px solid #ccc;}

    input[type="text"]{ color: #333; width: 100%; box-sizing: border-box; }
    input[type="password"]{ color: #333; width: 100%; box-sizing: border-box;}
    :focus{outline: none;}

    input{
        font-family: 'Hind', sans-serif;
    }
    .col-3{margin: 40px 3%; position: relative;}

</style>

<body>

<div class="container">
    <div class="row">

        <div class="center-block" style="width: 700px;">
            <br>
            <br>
            <div  class="form-uic" style="background-color: #EBF5FB">

                <div class="form-group" style="padding: 10px">

                    <h3 class="text-center">LOGIN</h3>
                    <br>
                    <p class="text-center">
                        <img  width="20%" src="<?php echo DOL_HTTP .'/application/system/login/img/avatar_login.png'?>" alt="">
                    </p>

                    <div class="form-group">
                        <div class="col-3">
                            <label for="">Usuario</label>
                            <input class="effect-2" type="text" placeholder="Ingrese su Usuario" id="usu">
                            <span class="focus-border"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-3">
                            <label for="">Password</label>
                            <input class="effect-2" type="password" placeholder="Ingrese su Password" id="pass">
                            <span class="focus-border"></span>
                        </div>
                    </div>

                </div>

                <div style="width: 100%">
                    <input type="button" id="btn_logearse" value="Acceder" class="btn" style="width: 100%;height: 50px; border-radius: 0px !important; font-size: 1.5rem; font-weight: bolder; background-color: #00a157; color: #dddddd" >
                </div>

            </div>

        </div>

    </div>
</div>


</body>
</html>

<script src="../../../public/bower_components/jquery/dist/jquery.js"></script>
<script src="../../../public/bower_components/bootstrap/dist/js/bootstrap.js"></script>
<script src="<?php echo DOL_HTTP .'/public/lib/sweetalert2/sweetalert2.js'?>" ></script>
<script>

    function logearse()
    {
        var usu  =  $('#usu').val();
        var pass = $('#pass').val();

        var param = {
          'accion': 'logearse',
          'ajaxSend':'ajaxSend',
          'usua': usu,
          'pass': pass,
        };
        $.ajax({
            url: "<?php echo DOL_HTTP .'/application/system/login/controller/controller_login.php'?>",
            type:'POST',
            data: param,
            dataType:'json',
            async:false,
            success:function(resp)
            {
                if(resp.error == "SesionIniciada")
                {
                    location.href = "<?php echo DOL_HTTP.'?view=inicio' ?>";

                }else{

                    Swal.fire({
                        type:  'error',
                        title: 'Oops...',
                        text:  ' Ocurrió un error, No se encontro el USUARIO: ' + $('#usu').val() + ' , Porfavor compruebe la información antes de Iniciar Session ' + '',
                        // footer: '<a href>Why do I have this issue?</a>'
                    })
                }
            }

        });
    }

    $('#btn_logearse').on('click', function() {
        logearse();
    });

    $(document).ready(function() {

    });

</script>