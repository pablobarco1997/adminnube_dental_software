
function to_accept_noti_confirmpacient( id )
{
    $.ajax({
        url: $DOCUMENTO_URL_HTTP + '/application/controllers/controller_peticiones_globales.php',
        data:{'ajaxSend':'ajaSend', 'accion' : 'accept_noti_confirm_pacient', 'id': id},
        dataType:'json',
        async:false,
        success:function(resp){
            if(resp.error == ""){
                location.reload(true);
            }
        }

    });
}


function Actulizar_notificacion_citas(idcita)
{
    $.ajax({
        url: $DOCUMENTO_URL_HTTP + "/application/system/agenda/controller/agenda_controller.php",
        type:'POST',
        data:{'ajaxSend': 'ajaxSend', 'accion': 'EstadoslistCitas', 'idestado':4, 'idcita':idcita,  },
        dataType:'json',
        async: false,
        success:function (resp) {
            if(resp.error == ""){
                location.reload(true);
            }
        }
    });
}


/**FILTRAR X RANGO DE FECHA*/
$('#startDate').daterangepicker({

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

    startDate: moment().startOf('month'),
    endDate: moment(),
    ranges: {
        'Hoy': [moment(), moment()],
        'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Últimos 7 Dias': [moment().subtract(6, 'days'), moment()],
        'Últimos 30 Dias': [moment().subtract(29, 'days'), moment()],
        'Mes Actual': [moment().startOf('month'), moment().endOf('month')],
        'Mes Pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
        'Año Actual': [moment().startOf('year'), moment().endOf('year')],
        'Año Pasado': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
    }
});

$('.rango span').click(function() {
    $(this).parent().find('input').click();
});

