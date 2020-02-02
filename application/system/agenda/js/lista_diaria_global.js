
//Funciones
function list_global_diaria_citas(){


    $('#table_ficheros_paciente').DataTable({

        searching: true,
        ordering:false,
        destroy:true,
        // scrollX: true,

        ajax:{
            url: $DOCUMENTO_URL_HTTP + "/application/system/agenda/controller/agenda_controller.php",
            type:'POST',
            data:{
                'ajaxSend':'ajaxSend',
                'accion': 'consul_hora_fecha_listglobal',
                'doctor': $('#filtro_doctor').find(':selected').val(),
                'fecha' : $('.filtroFecha').val(),
                'estados' : ($('#filtroEstados').val() == "") ? "" : $('#filtroEstados').val()
            } ,
            dataType:'json',
        },

        column:[
            { "width" : "20%" , "target": 6 }
        ],
        // columnDefs:[
        //     {
        //         'targets': 1,
        //         'searchable':false,
        //         'orderable':false,
        //         'className': 'dt-body-center',
        //         'render': function (data, type, full, meta){
        //
        //             var html = "";
        //
        //             console.log(full[4]);
        //
        //
        //             return '';
        //         },
        //
        //     }
        // ],

        language: {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },

    });


}


list_global_diaria_citas();