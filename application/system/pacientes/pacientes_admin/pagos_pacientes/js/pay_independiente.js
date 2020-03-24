
function listaprestacionesApagar()
{
    $('#ApagarlistPlantratmm').DataTable({


        searching: false,
        ordering:false,
        destroy:true,
        paging:false,

        ajax:{
            url: $DOCUMENTO_URL_HTTP + '/application/system/pacientes/pacientes_admin/pagos_pacientes/controller_pagos/controller_pag.php',
            type:'POST',
            data:
                {
                    'ajaxSend'   : 'ajaxSend',
                    'accion'     : 'listaprestaciones_apagar',
                    'idpaciente' : $id_paciente,
                    'idplantram' : Get_jquery_URL('idplantram'),

                },

            dataType:'json',
        },
        language:{
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },

            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }

        },


    });
}


listaprestacionesApagar();

//mask money
function moneyPagosInput(Input)
{
    Input.maskMoney({precision:2,thousands:'', decimal:'.',allowZero:true,allowNegative:true, defaultZero:true,allowEmpty: true});
    acumuladorTotal();
    IngresarValorApagar(Input, 'Input');
}


//CHECKEAR TODODS LOS CHECKBOX -- EJECUTAR UMA TOTAL
$('#checkeAllCitas').change(function(){

    if($(this).is(':checked') == true){

        $('.check_prestacion').prop('checked', true);
        IngresarValorApagar($(this), 'checkeboxAll');

    }else{

        IngresarValorApagar($(this), 'checkeboxAll');
        $('.check_prestacion').prop('checked', false);
    }


});


function IngresarValorApagar(html , xComportamiento)
{
    var erro_invalic = 0;

    console.log(html.parents('tr'));

    if( xComportamiento == 'checkebox')
    {
        var padre      =  html.parents('tr');
        var TotalPrest =  padre.find('.total_apagar').text();
        var Abonado    =  padre.find('.Abonado').text();
        var Abonar     =  padre.find('.Abonar');
        var error_apagar = padre.find('.error_pag');
        var Pendiente  =  padre.find('.Pendiente').text();
        var AbonarAux  = 0;


        //Si pendiente es 0
        if(parseFloat(Pendiente) == parseFloat(0)){
            AbonarAux = parseFloat(TotalPrest);
            Abonar.val(redondear(AbonarAux,2,false));
        }

        // Si pendiente es mayor a 0
        if(parseFloat(Pendiente) > parseFloat(0)){
            AbonarAux = parseFloat(Pendiente);
            Abonar.val(redondear(AbonarAux,2,false));
        }
        setTimeout(function() {
            error_apagar.text(null);
        }, 1500);

    }

    if( xComportamiento == 'checkeboxAll')
    {
        if( html.is(':checked') == true){

            $('#ApagarlistPlantratmm tbody tr').each(function(){

                var padre      =  $(this);
                var TotalPrest =  padre.find('.total_apagar').text();
                var Abonado    =  padre.find('.Abonado').text();
                var Abonar     =  padre.find('.Abonar');
                var Pendiente  =  padre.find('.Pendiente').text();
                var AbonarAux  = 0;

                var errorpago = padre.find('.error_pag');

                //Si pendiente es 0
                if(parseFloat(Pendiente) == parseFloat(0)){
                    AbonarAux = parseFloat(TotalPrest);
                    Abonar.val(redondear(AbonarAux,2,false));
                }

                // Si pendiente es mayor a 0
                if(parseFloat(Pendiente) > parseFloat(0)){
                    AbonarAux = parseFloat(Pendiente);
                    Abonar.val(redondear(AbonarAux,2,false));
                }

                setTimeout(function() {
                    errorpago.text(null);
                }, 1500);

            });


        }

        if( html.is(':checked') == false){
            $('.Abonar').val(0.00).trigger('onkeyup');
        }

    }

    if(xComportamiento == 'Input')
    {

        var padre      =  html.parents('tr');
        var TotalPrest =  padre.find('.total_apagar').text();
        var Abonado    =  padre.find('.Abonado').text();
        var Abonar     =  padre.find('.Abonar');
        var error_apagar = padre.find('.error_pag');
        var Pendiente  =  padre.find('.Pendiente').text();
        var AbonarAux  = 0;


        //Si pendiente es 0
        if(parseFloat(Pendiente) == parseFloat(0))
        {
            AbonarAux = parseFloat(TotalPrest);

            // console.log(parseFloat(Abonar.val()) + '>' + AbonarAux);
            if(parseFloat(Abonar.val()) > AbonarAux)
            {
                Abonar.addClass('INVALIC_ERROR');
                error_apagar.text('El pago no puede ser mayor al Total');
                erro_invalic++;

            }else{
                Abonar.removeClass('INVALIC_ERROR');
                error_apagar.text(null);
            }
        }

        // alert(Pendiente);
        // Si pendiente es mayor a 0
        if( parseFloat(Pendiente) > parseFloat(0) ){
            AbonarAux = parseFloat(Pendiente);

            if(parseFloat(Abonar.val()) > AbonarAux)
            {
                Abonar.addClass('INVALIC_ERROR');
                error_apagar.text('El pago no puede ser mayor al Pendiente');
                erro_invalic++;

            }else{
                Abonar.removeClass('INVALIC_ERROR');
                error_apagar.text(null);
            }
        }

        setTimeout(function() {
            $('#error_pag').text(null);
        }, 1500);
    }

    acumuladorTotal();

    if(erro_invalic > 0){
        $('#btnApagar').attr('disabled', true).addClass('disabled_link3');
    }else{
        $('#btnApagar').attr('disabled', false).removeClass('disabled_link3');
    }
}

//ACUMULA EL TOTAL
function acumuladorTotal()
{
    var totalPrestacion = 0;
    $('#ApagarlistPlantratmm tbody tr').each(function(){

        var padre      =  $(this);
        var TotalPrest =  padre.find('.total_apagar').text();
        var Abonado    =  padre.find('.Abonado').text();
        var Abonar     =  padre.find('.Abonar');

        totalPrestacion += parseFloat(Abonar.val());

    });

    $('#totalPrestacion').text( redondear(totalPrestacion, 2, false));
    $('#monto_pag').text( redondear(totalPrestacion, 2, false));

}

//Obtengo los valores a pagar
function fetch_apagar()
{
    var data_pagos = [];

    $('#ApagarlistPlantratmm tbody tr').each(function(){

        var padre      =  $(this);
        var TotalPrest =  padre.find('.total_apagar').text();
        var Abonado    =  padre.find('.Abonado').text();
        var Abonar     =  padre.find('.Abonar'); //input abonar

        var fk_prestacion = padre.find('.prestaciones_det').data('idprest');
        var iddetplantram = padre.find('.prestaciones_det').data('iddetplantram');
        var idcabplantram = padre.find('.prestaciones_det').data('idcabplantram');

        var valorAbonar = Abonar.val();

        if(Abonar.val() != 0)
        {
            data_pagos.push({
                fk_prestacion, iddetplantram,  idcabplantram, valorAbonar ,
                'totalprestacion':TotalPrest
            });
        }

    });

    console.log(data_pagos);
    return data_pagos;
}

/**PAGAR PLAN DE TRATAMIENTO ------------------*/
$('#btnApagar').click(function() {

    $(this).addClass('disabled_link3');
    var puedo = 0;

    if($('#t_pagos').find(':selected').val() == 0){

        $('#err_t_pago').text('Debe seleccionar un tipo de pago');
        puedo++;

    }else{

        $('#err_t_pago').text(null);
    }

    if( $('#monto_pag').text() == 0 )
    {
        $('#err_monto').text('El monto no puede ser $ 0.00');
        puedo++;
    }

    if( $('#n_factboleta').val() != 0 ){

    }else{ }

    if(puedo == 0)
    {
        var datos = fetch_apagar();

        $.ajax({

            url: $DOCUMENTO_URL_HTTP + '/application/system/pacientes/pacientes_admin/pagos_pacientes/controller_pagos/controller_pag.php',
            type:'POST',
            data: {
                'ajaxSend': 'ajaxSend',
                'accion':'realizar_pago_independiente',
                'datos': datos,
                'tipo_pago' : $('#t_pagos').find(':selected').val(),
                'n_fact_bolet' : $('#n_factboleta').val(),
                'amount_total' : $('#monto_pag').text(),
                'observ' : $('#descripObserv').val(),
                'idpaciente': $id_paciente , 'idplancab': Get_jquery_URL('idplantram'),
            },
            dataType: 'json',
            async: false,
            success: function( respuesta ){

                if(respuesta.error == 1){

                    listaprestacionesApagar();
                    notificacion('Pago realizado con Exito !', 'success');
                    location.reload();

                }else{
                    notificacion(respuesta.error, 'error');
                }
            }

        });

    }

    setTimeout(function() {

        $('#err_t_pago').text(null);
        $('#err_monto').text(null);

    },3000);

});


$('#t_pagos').select2({
    placeholder:'Seleccione un tipo de pago',
    allowClear: true,
    language:'es'
});

$('#n_factboleta').mask('000-000-000000000',{placeholder:'___-___-_________'});