//funciones
function GuardarDatosPacientes()
{
    var puedoPasar = invalic_paciente();

    var nombre       = $('#nombre').val();
    var apellido     = $('#apellido').val();
    var rud_dni      = $('#rud_dni').val();
    var email        = $('#email').val();
    var convenio        = $('#convenio').find('option:selected').val();
    var n_interno       = $('#n_interno').val();
    var sexo            = $('#sexo').find('option:selected').val();
    var fech_nacimit    = $('#fech_nacimit').val();
    var ciudad       = $('#ciudad').val();
    var comuna       = $('#comuna').val();
    var direcc       = $('#direcc').val();
    var t_fijo       = $('#t_fijo').val();
    var t_movil       = $('#t_movil').val();
    var act_profec   = $('#act_profec').val();
    var empleado     = $('#empleado').val();
    var obsrv        = $('#obsrv').val();
    var apoderado        = $('#apoderado').val();
    var refer        = $('#refer').val();

    var datos_paciente = {
        'nombre'    : nombre,
        'apellido'    : apellido,
        'rud_dni'   : rud_dni,
        'email'     : email,
        'convenio'  : convenio,
        'n_interno' : n_interno,
        'sexo'      : sexo,
        'fech_nacimit': fech_nacimit,
        'ciudad'      : ciudad,
        'comuna'      : comuna,
        'direcc'      : direcc,
        't_fijo'      : t_fijo,
        't_movil'      : t_movil,
        'act_profec'  : act_profec,
        'empleado'    : empleado,
        'obsrv'       : obsrv,
        'apoderado'   : apoderado,
        'refer'       : refer,
    };

    var parametros = {
        'accion': 'nuew_paciente',
        'ajaxSend':'ajaxSend',
        'datos': datos_paciente,
    };

    console.log(parametros);

    if(puedoPasar == true){
        $.ajax({
            url: $DOCUMENTO_URL_HTTP +'/application/system/pacientes/nuevo_paciente/controller/nuevo_pacit_controller.php',
            type:"POST",
            data: parametros,
            dataType: 'json',
            async: false,
            success: function(resp)
            {
                if(resp.error == "exito")
                {
                    notificacion("Información Actualizada", "success");
                    reloadPagina(); //recarga la pagina

                }else{
                    notificacion("Error, Ocurrió un error con la Operción", "error");
                }
            }

        });
    }


}

function invalic_paciente()
{

    var cont = 0;

    if($('#nombre').val() == ''){
        cont++;
        $('#nombre').focus();
        $('#noti_nombre').text("ingrese el nombre del paciente");
    }else{
        $('#noti_nombre').text(null);
    }


    if($('#apellido').val() == ''){
        cont++;
        $('#apellido').focus();
        $('#noti_apellido').text("ingrese el apellido del paciente");
    }else{
        $('#noti_apellido').text(null);
    }

    if($('#rud_dni').val() == ''){
        cont++;
        $('#rud_dni').focus();
        $('#noti_ruddni').text("ingrese un rud o dni del paciente");
    }else{
        $('#noti_ruddni').text(null);
    }

    if($('#sexo').find(':selected').val() == ''){
        cont++;
        $('#sexo').focus();
        $('#noti_sexo').text("ingrese el genero del paciente");
    }else{
        $('#noti_sexo').text(null);
    }

    if($('#fech_nacimit').find(':selected').val() == ''){
        cont++;
        $('#fech_nacimit').focus();
        $('#noti_date_nacimiento').text("ingrese fecha de nacimiento del paciente");
    }else{
        $('#noti_date_nacimiento').text(null);
    }

    if($('#direcc').val() == ''){
        cont++;
        $('#direcc').focus();
        $('#noti_direccion').text("ingrese la dirección del paciente");
    }else{
        $('#noti_direccion').text(null);
    }

    if( cont > 0){

        return false
    }else {

        return true
    }

}
//eventos

    $('#guardar').on('click', function(){
        GuardarDatosPacientes();
    });

$(document).ready(function() {


    $('#fech_nacimit').daterangepicker({
        locale: {
            format: 'YYYY/MM/DD' ,
            daysOfWeek: [
                "Dom",
                "Lun",
                "Mar",
                "Mie",
                "Jue",
                "Vie",
                "Sáb"
            ],
            monthNames: [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre"
            ],
        },
        singleDatePicker: true,
        showDropdowns: true,
    });


});