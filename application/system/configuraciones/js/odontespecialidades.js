

/** ESPECIALIDADES DE ODONTOLOGOS **/

if($accion == 'specialties')
{

    //LISTA DE ESPECIALIDADES
    function list_especialidades()
    {
        $('#gention_especialidades').DataTable({

            searching: true,
            ordering:false,
            destroy:true,
            ajax:{
                url: $DOCUMENTO_URL_HTTP + '/application/system/configuraciones/controller/conf_controller.php',
                type:'POST',
                data:{'ajaxSend':'ajaxSend', 'accion':'list_especialidades'},
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

    //ESPECIALIDADES LIST
    $('#guardar_conf_especialidad').click(function() {
        var puedo = 0;

        var especialidad = $('#especialidad_nombre');

        if( especialidad.val() == ''){
            puedo++;
            especialidad.addClass('INVALIC_ERROR');
            $('#msg_especialidad').text('Campo obligatorio, (escriba una especialidad)');
        }else{
            especialidad.removeClass('INVALIC_ERROR');
            $('#msg_especialidad').text(null);
        }

        if( puedo == 0){

            $.ajax({
                url: $DOCUMENTO_URL_HTTP + '/application/system/configuraciones/controller/conf_controller.php',
                type:'POST',
                data: { 'ajaxSend': 'ajaxSend', 'accion': 'nuevo_update_especialidad', 'especialidad': especialidad.val(), 'descrip': $('#especialidad_descripcion').val() },
                dataType:'json',
                async:false,
                success: function(resp){

                    if( resp.error == ''){
                        notificacion('Información Actualizada', 'success');
                        reloadPagina();
                    }else {
                        notificacion(resp.error , 'error');
                    }
                }
            });
        }

    });



    //eliminar especialidad
    function eliminar_especialidad(id){

        if(id != ""){

            $.ajax({
                url: $DOCUMENTO_URL_HTTP + '/application/system/configuraciones/controller/conf_controller.php',
                type:'POST',
                data: { 'ajaxSend': 'ajaxSend', 'accion': 'delete_especialidad', 'id': id},
                dataType:'json',
                async:false,
                success: function(resp) {

                    if(resp.error == ''){
                        notificacion('Información Actualizada', 'success');
                        list_especialidades();
                    }else{
                        notificacion(resp.error, 'error');
                    }

                }
            });

        }
    }


    list_especialidades();



    /** END ESPECIALIDADES **/
}