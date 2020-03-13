

function fetch_pacientes()
{
    $.ajax({
        url: $DOCUMENTO_URL_HTTP + '/application/controllers/controller_peticiones_globales.php',
        type:'POST',
        data:{'ajaxSend':'ajaxSend', 'accion':'fetch_paciente'},
        dataType:'json',
        success:function( resp ) { $('#nu_paciente').text( resp.fetchNumero ) }
    });
}

fetch_pacientes();