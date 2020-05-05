

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


//BUSCAR PACIENTE
$('#buscarPaciente').on('click', function() {

    var $id =  $('#idpacienteAutocp').text();
    if($id !="" && $('.seachPacienteHome').val() !="")
    {
        // var $url = $DOCUMENTO_URL_HTTP + '/application/system/pacientes/admin_paciente/?view=form_datos_personales&id='+$id;
        var $url = $DOCUMENTO_URL_HTTP + '/application/system/pacientes/pacientes_admin?view=dop&key=' + $keyGlobal + '&id=' + $id;
        // alert($url);
        location.href = $url;
    }

});