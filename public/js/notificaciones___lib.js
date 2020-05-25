
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
        data:{'ajaxSend': 'ajaxSend', 'accion': 'EstadoslistCitas', 'idestado':4, 'idcita':idcita },
        dataType:'json',
        async: false,
        success:function (resp) {

            if(resp.error == "")
            {
                location.reload(true);
            }

        }

    });
}


// CONSULTAR CITAS TIEMPO REAL

var interval_notification;


var timeOut  = 1000;
var timeReal = 4000;

var url    = $DOCUMENTO_URL_HTTP + "/application/controllers/controller_peticiones_globales.php";
var paramt = { 'ajaxSend':'ajaxSend', 'accion':'notification_'};

setTimeout(function() {

    $.get(url, paramt , function(data) {

        var HTML = $.parseJSON(data);
        Htmlnotificacion( HTML.data, HTML.N_noti );
    });

},timeOut);

interval_notification = setInterval(function () {

    $.get(url, paramt , function(data){

        var HTML = $.parseJSON(data);
        Htmlnotificacion( HTML.data, HTML.N_noti );

    });

},timeReal);

$( window ).on("load", function() {

    $('.notiflist , .media').mouseleave(function() {

        interval_notification = setInterval(function(){

            $.get(url, paramt , function(data){

                var HTML = $.parseJSON(data);
                Htmlnotificacion( HTML.data, HTML.N_noti );
            });

        },timeReal);

    });

    $('.notiflist , .media').mouseenter(function() {
        clearInterval( interval_notification );
    });


});


function Htmlnotificacion( $data , $N )
{
    // console.log( $data );

    $('.notiflist').html( $data );

    $('#N_Notificaciones').text( ($N==0)?0:$N );
    $('#N_noti').text( ($N==0)?0:$N );
}








// $('ul#menuNotificacion').click(function (e) {
//     // alert(4556);
//     e.stopPropagation();
//     $('.dropdown-menu').toggle();
// });

/*
/**FILTRAR X RANGO DE FECHA*/

/***$('#startDate').daterangepicker({

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
**/

