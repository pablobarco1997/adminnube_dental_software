//funciones =========================
function load_table_prestaciones() {
    $('#listprestacionestable').DataTable({

        searching: true,
        ordering:false,
        destroy:true,
        ajax:{
            url: $DOCUMENTO_URL_HTTP + '/application/system/configuraciones/controller/conf_controller.php',
            type:'POST',
            data:{'ajaxSend':'ajaxSend', 'accion':'list_prestaciones'},
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

function invalic_prestaciones(){

    var $puedoPasar = 0;

    var categoria = $('#conf_cat_prestaciones');
    var prestacion = $('#prestacion_descr');
    var valorPrestacion = $('#valorPrestacion');

    if(categoria.find(':selected').val() == ''){
        $puedoPasar++;
        categoria.addClass('INVALIC_ERROR');
        $('#msg_categoria').text('Debe Seleccioar una categoria');
    }else{
        categoria.removeClass('INVALIC_ERROR');
        $('#msg_categoria').text(null);
    }

    if(prestacion.val() == ''){
        $puedoPasar++;
        prestacion.addClass('INVALIC_ERROR');
        $('#msg_prestaciones').text('Debe ingresar el nombre de la prestación');
    }else{
        prestacion.removeClass('INVALIC_ERROR');
        $('#msg_prestaciones').text(null);
    }

    if(valorPrestacion.val() == ''){
        $puedoPasar++;
        valorPrestacion.addClass('INVALIC_ERROR');
        $('#msg_valor').text('Debe ingresar el valor del costo de esta prestación');
    }else{
        valorPrestacion.removeClass('INVALIC_ERROR');
        $('#msg_valor').text(null);
    }

    if( $puedoPasar == 0){

        var parametros = {
            'ajaxSend': 'ajaxSend',
            'accion': 'nuevoUpdatePrestacion',
            'id'     : $idprestacion_prestacion,
            'subaccion' : $accion_prestacion,
            'label_prestacion' : prestacion.val(),
            'cat_prestacion': categoria.find(':selected').val(),
            'costo_prestacion': valorPrestacion.val(), 'convenio': $('#convenioConf').find('option:selected').val()
        };

        $.ajax({
            url: $DOCUMENTO_URL_HTTP + '/application/system/configuraciones/controller/conf_controller.php',
            type:'POST',
            data: parametros ,
            dataType:'json',
            async:false,
            success: function(resp){

                if( resp.error == ''){
                    notificacion('información Actualizada', 'success');
                    reloadPagina();
                }else{
                    notificacion(resp.error, 'error');
                }

            }
        });
    }

}

function fecth_updatePrestacion( $idprestacion ){

    $.ajax({
        url: $DOCUMENTO_URL_HTTP + '/application/system/configuraciones/controller/conf_controller.php',
        type:'POST',
        data: {'accion':'fecth_update_prestacion', 'ajaxSend':'ajaxSend', 'id': $idprestacion} ,
        dataType:'json',
        async:false,
        success: function(resp){

            //para modificar
            if( resp.obj.length > 0 ){

                var vl = resp.obj[0];
                $('#conf_cat_prestaciones').val( vl.fk_categoria ).trigger('change');
                $('#prestacion_descr').val( vl.descripcion );
                $('#valorPrestacion').val( vl.valor );
                $('#convenioConf').val((vl.fk_convenio == 0)?null : vl.fk_convenio).trigger('change');

            }else{
                notificacion(resp.error, 'error');
            }

        }
    });
}

function eliminar_prestacion($id){

    $.ajax({
        url: $DOCUMENTO_URL_HTTP + '/application/system/configuraciones/controller/conf_controller.php',
        type:'POST',
        data: {'accion':'eleminar_prestacion', 'ajaxSend':'ajaxSend', 'id': $id} ,
        dataType:'json',
        async:false,
        success: function(resp){

            if(resp.error != ''){
                notificacion( resp.error , 'error');

            }else{

                notificacion('Información Actualizada', 'success');
                location.href = $DOCUMENTO_URL_HTTP + '/application/system/configuraciones/index.php?view=form_prestaciones';
            }
        }
    });

}

function eliminar_categoria_desc_prestacion(subaccion){

    var id = "";
    if(subaccion == 'categoria'){
        id = $('#conf_cat_prestaciones').find(':selected').val();
    }
    if( id != "" &&  subaccion != "")
    {
        var puedo = 0;

        $('#eliminarConfCategoriaDescuento').removeClass('disabled_link3');

    }else{

        if(id == ""){
            notificacion('No a seleccionado Ninguna categoria','error');
            $('#eliminarConfCategoriaDescuento').addClass('disabled_link3');
        }
    }

}

$('#eliminarConfCategoriaDescuento').click(function() {

    $.ajax({
        url: $DOCUMENTO_URL_HTTP + '/application/system/configuraciones/controller/conf_controller.php',
        type:'POST',
        data: {'accion':'eliminar_conf_categoria_desc', 'ajaxSend':'ajaxSend', 'id': $('#conf_cat_prestaciones').find(':selected').val(), 'subaccion': 'categoria'} ,
        dataType:'json',
        async:false,
        success: function(resp){

            if(resp.error != ''){
                notificacion( resp.error , 'error');
            }else{
                notificacion('Información Actualizada', 'success');
                reloadPagina();
            }
        }
    });

});

//convenio
function nuevoUpdateConvenio(subacion){

    var puedo = 0;

    var nombre = $('#nomb_conv');
    var valor = $('#valor_conv');

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
            'subaccion' :subacion,
            'ajaxSend': 'ajaxSend' ,
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

function nuevoUpdateConvenio(subaccion)
{

    var puedo = 0;

    var idConveinoDesc = ($('#convenioConf').find(':selected').val() == "") ? 0 :  $('#convenioConf').find(':selected').val();

    var nombre  = $('#nomb_conv');
    var valor   = $('#valor_conv');

    if(nombre.val() == ''){
        nombre.addClass('INVALIC_ERROR');
        puedo++;
    }else{
        nombre.removeClass('INVALIC_ERROR');
    }

    if(valor.val() > 100)
    {
        $('#msg_descuento').text('El descuento no puede ser mayor al 100%');
        valor.addClass('INVALIC_ERROR');
        puedo++;
    }
    if(valor.val() == '')
    {
        valor.addClass('INVALIC_ERROR');
        puedo++;
    }else{
        valor.removeClass('INVALIC_ERROR');
    }

    if( puedo == 0 || subaccion == 'eliminar'){

        var parametros = {
            'accion'  :'nuevoConvenio',
            'ajaxSend': 'ajaxSend' ,
            'subaccion' : subaccion,
            'id': idConveinoDesc,
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
                    location.reload();

                }
            }

        });
    }


}

/*Modifca la categoria de la prestacion*/
function nuevoUpdateCategoria(){

    var subaccion ='';
    var id = $('#conf_cat_prestaciones').find(':selected').val();

    if(id  == ''){
        subaccion = 'nuevo';
    }else{
        subaccion = 'modificar';
    }

    if(subaccion == 'nuevo'){
        $('#nomb_cat').val(null);
        $('#descrip_cat').val(null);
    }

    if(subaccion == 'modificar'){

        $.ajax({
            url: $DOCUMENTO_URL_HTTP + '/application/system/configuraciones/controller/conf_controller.php',
            type:'POST',
            data: { 'accion':'nuevoCategoriaPrestacion', 'ajaxSend':'ajaxSend', 'subaccion': 'consultar' ,'label': $('#nomb_cat').val(), 'descrip': $('#descrip_cat').val(), 'idCat': id } ,
            dataType:'json',
            async:false,
            success:function(resp) {

                if(resp.error == ''){
                    // alert( resp.datos.nombre_cat );
                    $('#nomb_cat').val(resp.datos.nombre_cat);
                    $('#descrip_cat').val(resp.datos.descrip);

                }else {

                    // notificacion( 'Informacion Actualizada' , 'success');
                    // reloadPagina();

                }

            }

        });

    }
}

$('#guardar_categoria_conf').click(function() {

    var puedo = 0;
    var subaccion ='';

    //subaccion nuevo Update
    var id = $('#conf_cat_prestaciones').find(':selected').val();

    if(id  == ''){
        subaccion = 'nuevo';
    }else{
        subaccion = 'modificar';
    }


    if($('#nomb_cat').val() == ''){
        puedo++;
        $('#nomb_cat').addClass('INVALIC_ERROR');
    }else{
        $('#nomb_cat').removeClass('INVALIC_ERROR');
    }

    if(puedo == 0){

        $.ajax({
            url: $DOCUMENTO_URL_HTTP + '/application/system/configuraciones/controller/conf_controller.php',
            type:'POST',
            data: { 'accion':'nuevoCategoriaPrestacion', 'ajaxSend':'ajaxSend', 'subaccion': subaccion ,'label': $('#nomb_cat').val(), 'descrip': $('#descrip_cat').val(), 'idCat': id } ,
            dataType:'json',
            async:false,
            success:function(resp) {
                if(resp.error!=''){
                    notificacion( resp.error , 'error');
                }else {
                    notificacion( 'Informacion Actualizada' , 'success');
                    reloadPagina();
                }
            }

        });
    }
});



//eventos
$('#guardar_prestacion').click(function() {
    invalic_prestaciones();
});

//EXCE ==============================================================================

//modificar prestacion

if( $accion_prestacion == 'modificar'){

    fecth_updatePrestacion( $idprestacion_prestacion );
}

$('#conf_cat_prestaciones').select2({
   placeholder: 'Selecione una categoria',
   allowClear: true,
   language:'es'
});
$('#convenioConf').select2({
    placeholder: 'Selecione una categoria',
    allowClear: true,
    language:'es'
});

