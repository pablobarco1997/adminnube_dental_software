

$ULTIMO_IDCOMMENT = 0;

function  ajax_load_comment_time(text, subaccion) {

    $.ajax({
        url: $DOCUMENTO_URL_HTTP +'/application/system/pacientes/pacientes_admin/controller/controller_adm_paciente.php',
        type:'POST',
        data: {'ajaxSend':'ajaxSend', 'accion': 'comecent_doct_paciente', 'idPaciente': $id_paciente, 'text':text, 'subaccion': subaccion, 'id_ultimo' :$ULTIMO_IDCOMMENT},
        dataType:'json',
        success: function(resp) {

            var comment_html = "";

            // alert(resp.error );
            if(resp.error == '')
            {
                if(resp.numero > 0)
                {
                    var $comentario = resp.data;
                    var a = 0;

                    $ULTIMO_IDCOMMENT = resp.ultimoid;
                    // alert($ULTIMO_IDCOMMENT);

                    while (a <= $comentario.length -1)
                    {
                        var text     = ($comentario[a]['text'] == "") ? "&nbsp;" : $comentario[a]['text'];
                        var doctor   = $comentario[a]['doctor'];
                        var url_icon = $comentario[a]['icon'];
                        var fechaComment = $comentario[a]['fecha'];

                        if(a ==  $comentario.length -1) //el ultimo comentario lleva un id de localizacion
                        {

                            comment_html += '<div class="direct-chat-msg" id="loadMensage">\n' +
                                '                                    <div class="direct-chat-info clearfix">\n' +
                                '                                        <span class="direct-chat-name pull-left">'+ doctor +'</span>\n' +
                                '                                        <span class="direct-chat-timestamp pull-right">'+ fechaComment +'</span>\n' +
                                '                                    </div>\n' +
                                '\n' +
                                '                                    <img class="direct-chat-img" src="' + url_icon + '" alt="message user image">\n' +
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
                                '                                        <span class="direct-chat-timestamp pull-right">' +fechaComment+ '</span>\n' +
                                '                                    </div>\n' +
                                '\n' +
                                '                                    <img class="direct-chat-img" src="' + url_icon + '" alt="message user image">\n' +
                                '\n' +
                                '                                    <div class="direct-chat-text">\n' +
                                '                                        <a style="color: black">'+ text +'</a>\n' +
                                '                                    </div>\n' +
                                '\n' +
                                '                            </div>';


                        }

                        a++;
                    }

                    $('#chatUpdate').html(comment_html);

                    if(resp.ultimo == true)
                    {
                        document.getElementById('loadMensage').scrollIntoView();
                    }
                }

                if($('.direct-chat-msg').length == 0){

                    $('#chatUpdate').html(  '<h3 class="text-center">No hay ningún comentario para este paciente</h3>' )
                }

                if(resp.numero == 0)
                {
                    $('#chatUpdate').html(  '<h3 class="text-center">No hay ningún comentario para este paciente</h3>' )
                }

                // console.log(resp.numero);
            }
        }

    });
}

$('#comment').on("click", function() {

    var text = $("#texto_comment").val();
    ajax_load_comment_time(text, "agregar");
    $("#texto_comment").val(null);
});
// ajax_load_comment_time(null, 'consultar');
setInterval(function () {
    ajax_load_comment_time(null, 'consultar');
},1000);
