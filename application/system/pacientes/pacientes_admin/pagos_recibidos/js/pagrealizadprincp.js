
if($accionPagospacientes = "pagos_particular")
{

    function list_pagos_particulares()
    {
        
        $('#pag_particular').DataTable({
            searching: true,
            ordering:false,
            destroy:true,
            paging: false,
            ajax:{
                url: $DOCUMENTO_URL_HTTP + '/application/system/pacientes/pacientes_admin/pagos_pacientes/controller_pagos/controller_pag.php',
                type:'POST',
                data:{
                    'ajaxSend'   :'ajaxSend',
                    'accion'     : 'list_pagos_particular',
                    'idpaciente' : $id_paciente
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

    list_pagos_particulares();
    
    function detalle_prestaciones_pagosParticulares($idpago)
    {
        $('#detalle_prestaciones_pagos_part').DataTable({
            searching: true,
            ordering:false,
            destroy:true,
            paging: false,
            searching:false,
            ajax:{
                url: $DOCUMENTO_URL_HTTP + '/application/system/pacientes/pacientes_admin/pagos_pacientes/controller_pagos/controller_pag.php',
                type:'POST',
                data:{
                    'ajaxSend'   : 'ajaxSend',
                    'accion'     : 'detalle_pagos_particular',
                    'idpaciente' : $id_paciente ,
                    'idpago'     : $idpago
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

}