
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

    <link rel="stylesheet" href=" <?php echo DOL_HTTP .'/public/css/css_global/lib_glob_style.css'?> ">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo DOL_HTTP .'/public/bower_components/font-awesome/css/font-awesome.min.css'?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo DOL_HTTP .'/public/bower_components/Ionicons/css/ionicons.min.css'?>">

    <!--    font google-->
<!--    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">-->
<!--    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">-->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">

    <link rel="shortcut icon" href=" <?= DOL_HTTP .'/application/system/login/img/dental_icon.png' ?>" type="image/x-icon" >
    <title>Login</title>

</head>
<style>

    *{

        font-family: 'Roboto', sans-serif;
    }
    body{
        /*background-image: url("*/<?php //echo DOL_HTTP .'/application/system/login/img/photo_main.jpg'?>/*");*/
        background-size: 670px 669px;
        background-repeat: no-repeat;
    }

    input {
        width: 100%;
        /*background-color: #EBEDEF;*/
        padding: 5px;
        border: none;
        /*font-weight: bolder;*/
    }
    .form-uic{
        width: 100%;
        -webkit-box-shadow: 10px 10px 5px -9px rgba(0,0,0,0.75);
        -moz-box-shadow: 10px 10px 5px -9px rgba(0,0,0,0.75);
        box-shadow: 10px 10px 5px -9px rgba(0,0,0,0.75);
        border-bottom-left-radius: 30px;
        border-top-right-radius: 30px ;


    }

    .effect-2 ~ .focus-border{position: absolute; bottom: 0; left: 50%; width: 0; height: 2px; background-color: #4caf50; transition: 0.4s;}
    .effect-2:focus ~ .focus-border{width: 100%; transition: 0.4s; left: 0;}

    .effect-2:{border: 0; padding: 7px 0; border-bottom: 1px solid #ccc;}

    input[type="text"]{ color: #333; width: 100%; box-sizing: border-box; }
    input[type="password"]{ color: #333; width: 100%; box-sizing: border-box;}
    :focus{outline: none;}


    .col-3{margin: 40px 3%; position: relative;}

    body{
        background-color: #f3f4f7;
    }

    .btnlogin{
        border-bottom-left-radius: 30px;
        border-top-left-radius: 0px;
        border-top-right-radius: 0px;
        border-bottom-right-radius: 0px;
    }
    .btnlogin:focus{
        outline: 0;
        outline: none; !important;
    }

    .outlogintext{
        /*border-radius: 15px;*/
        border: solid 1px #cccccc;
        padding: 10px;
    }

</style>

<body>

<div class="container">
    <div class="row">

        <div class="col-xs-12 col-md-6 col-sm-8 col-centered" >
            <br>
            <br>

            <div  class="form-uic" style="background-color: #ffffff; width: 100%">

                <div class="form-group col-sm-12 col-xs-12" style="padding: 10px">

                    <br>

                    <img  width="35%" class="img-rounded center-block" src="<?php echo DOL_HTTP .'/application/system/login/img/dental_icon.png'?>" alt="">

                    <div class="form-group">
                        <div class="col-3">
                            <label for=""> <i class="fa fa-2x fa-fw fa-user"></i> </label>
                            <input class="effect-2 outlogintext" type="text" placeholder="Ingrese su Usuario" id="usu">
                            <span class="focus-border"></span>
                            <small style="color: red;" id="msg_usuario"></small>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-3">
                            <label for=""> <i class="fa fa-2x fa-fw fa-unlock-alt"></i> </label>
                            <input class="effect-2 outlogintext" type="password" placeholder="Ingrese su Password" id="pass">
                            <span class="focus-border"></span>
                            <small style="color: red;" id="msg_password"></small>
                        </div>
                    </div>

                </div>

                <div style="width: 100%;  " >
                    <input type="button" id="btn_logearse" value="LOGIN" class="btn btnlogin"  style="width: 100%;height: 50px;   !important; font-size: 1.5rem; background-color: #00a157; color: #ffffff; outline: none" >
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

                    var text = " <i class='fa fa-fw fa-user'></i> Usuario: " + $('#usu').val() + " <br> " +
                        "<b>" +
                        "<small> usuario no encontrado <br> <span class=''> compruebe la información antes de iniciar <i class='fa fa-fw fa-times-circle'></i> </span> </small>" +
                        "</b>";

                    Swal.fire('Error' , text, 'error');
                }
            }

        });
    }

    $('#btn_logearse').on('click', function() {

        var $puedo = 0;

        var usu  =  $('#usu').val();
        var pass = $('#pass').val();

        if( usu == '' ) {
            $puedo++;
            $('#msg_usuario').text('Ingrese el usuario');
        }
        if( pass == '' ) {
            $puedo++;
            $('#msg_password').text('Ingrese la contraseña');
        }

        if( $puedo == 0 ){
            logearse();
        }

        setTimeout(function() {
            $('#msg_usuario').text(null);
            $('#msg_password').text(null);
        }, 2500);

    });

    $(document).ready(function() {

    });

</script>