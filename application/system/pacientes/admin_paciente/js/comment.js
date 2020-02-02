//COMENTARIOS ADMINISTRATIVOS

function OBJ_COMENTARIOS_DOCTOR_PACIENTE(text, subaccion)
{
    $.ajax({
        url: $DOCUMENTO_URL_HTTP +'/application/system/pacientes/admin_paciente/controller/controller_adm_paciente.php',
        type:'POST',
        data: {'ajaxSend':'ajaxSend', 'accion': 'comecent_doct_paciente', 'idPaciente': $id_paciente, 'text':text, 'subaccion': subaccion},
        dataType:'json',
        success: function(resp) {

            var comment_html = "";

            if(resp.error == "exito")
            {
                if(resp.numero > 0)
                {
                    var $comentario = resp.data;
                    var a = 0;
                    while (a <= $comentario.length -1)
                    {
                        var text   = $comentario[a]['text'];
                        var doctor = $comentario[a]['doctor'];

                        if(a ==  $comentario.length -1) //el ultimo comentario lleva un id de localizacion
                        {

                            comment_html += '<div class="direct-chat-msg" id="loadMensage">\n' +
                                '                                    <div class="direct-chat-info clearfix">\n' +
                                '                                        <span class="direct-chat-name pull-left">'+ doctor +'</span>\n' +
                                '                                        <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>\n' +
                                '                                    </div>\n' +
                                '\n' +
                                '                                    <img class="direct-chat-img" src="https://icon-library.net/images/avatar-icon-images/avatar-icon-images-4.jpg" alt="message user image">\n' +
                                '\n' +
                                '                                    <div class="direct-chat-text">\n' +
                                '                                        <a style="color: black" >'+ text +'</a>\n' +
                                '                                    </div>\n' +
                                '\n' +
                                '                            </div>';


                        }else{

                            comment_html += '<div class="direct-chat-msg" >\n' +
                                '                                    <div class="direct-chat-info clearfix">\n' +
                                '                                        <span class="direct-chat-name pull-left">'+ doctor +'</span>\n' +
                                '                                        <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>\n' +
                                '                                    </div>\n' +
                                '\n' +
                                '                                    <img class="direct-chat-img" src="https://icon-library.net/images/avatar-icon-images/avatar-icon-images-4.jpg" alt="message user image">\n' +
                                '\n' +
                                '                                    <div class="direct-chat-text">\n' +
                                '                                        <a style="color: black">'+ text +'</a>\n' +
                                '                                    </div>\n' +
                                '\n' +
                                '                            </div>';


                        }

                        a++;
                    }

                    $('#mensajesInsert').html(comment_html);

                    // window.location.hash = "#loadMensage"; //localiso el ultimo mensage
                }

                console.log(resp.numero);
            }
        }

    });

    if(subaccion == "consultar")
    {
        setTimeout(function() {
            document.getElementById('loadMensage').scrollIntoView(); //el escrool busca ese id y se desplaza
        },1000/6);
    }

}

$('#comment').on("click", function() {

    var text = $("#texto_comment").val();
    OBJ_COMENTARIOS_DOCTOR_PACIENTE(text, "agregar");

    // window.location.hash = "#loadMensage"; //localiso el ultimo mensage
    setTimeout(function() {
        document.getElementById('loadMensage').scrollIntoView();
    },1000/6);

    $("#texto_comment").val(null);

});

// EXEC
OBJ_COMENTARIOS_DOCTOR_PACIENTE('', 'consultar');