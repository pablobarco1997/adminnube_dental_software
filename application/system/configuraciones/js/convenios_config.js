
function list_convenios_configurados()
{
    $('#conf_table_convenio').DataTable({

        searching: true,
        ordering:false,
        destroy:true,
        ajax:{
            url: $DOCUMENTO_URL_HTTP + '/application/system/configuraciones/controller/conf_controller.php',
            type:'POST',
            data:{'ajaxSend':'ajaxSend', 'accion':'list_convenios' },
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


function nuevoUpdateConvenio($subaccion, id){

    var puedo = 0;

    var nombre  = $('#nomb_conv');
    var valor   = $('#valor_conv');

    if(nombre.val() == ''){
        nombre.addClass('INVALIC_ERROR');
        puedo++;
    }else{
        nombre.removeClass('INVALIC_ERROR');
    }

    if(valor.val() == ''){
        valor.addClass('INVALIC_ERROR');
        puedo++;
    }else{
        valor.removeClass('INVALIC_ERROR');
    }

    if( puedo == 0){

        var parametros = {
            'accion'  :'nuevoConvenio',
            'ajaxSend': 'ajaxSend' ,
            'subaccion' : $subaccion,
            'id' : id  ,
            'nombre'  : nombre.val() ,
            'valor'   : valor.val() ,
            'descrip' : $('#descrip_conv').val(),
        };

        $.ajax({
            url: $DOCUMENTO_URL_HTTP + '/application/system/configuraciones/controller/conf_controller.php',
            type:'POST',
            data: parametros ,
            dataType:'json',
            async:false,
            success:function(resp){

                if(resp.error != ''){
                    notificacion( resp.error , 'error');
                }else{
                    notificacion( 'Informacion Actualizada' , 'success');
                    reloadPagina();
                }
            }

        });

    }
}

function  fetch_modificar_convenio(id) {

    if( id != ""){

        //cambio el comportamient a modificar
        $('#comportamiento').attr('data-subaccion','modificar').text('MODIFICAR CONVENIO').attr('data-id', id);

        $.ajax({
            url: $DOCUMENTO_URL_HTTP + '/application/system/configuraciones/controller/conf_controller.php',
            type:'POST',
            data: {'accion':'fetch_modificar_convenio', 'ajaxSend':'ajaxSend', 'id': id} ,
            dataType:'json',
            async:false,
            success:function(resp) {

                console.log(resp['error']);

                if(resp.error == ""){

                    var datos = resp.respuesta;

                    var nombre  = datos[0];
                    var descrip = datos[1];
                    var valor   = datos[2];

                    $('#nomb_conv').val( nombre );
                    $('#descrip_conv').val( descrip );
                    $('#valor_conv').val( valor );

                }else{

                    notificacion(resp.error, 'error');
                }
            }
        });
    }
}

function modalCleanInputs(){

    //nuevo
    $('#comportamiento').attr('data-subaccion','nuevo').text('AGREGAR CONVENIO').attr('data-id',0);
    $('#nomb_conv').val(null);
    $('#valor_conv').val(null);
    $('#descrip_conv').val(null);
}

//nuevo Update convenios
$('#guardar_convenio_conf').click(function() {

    var accion = $('#comportamiento').data('subaccion');
    var id = $('#comportamiento').data('id');

    nuevoUpdateConvenio(accion, id);
});

//EXEC

list_convenios_configurados();