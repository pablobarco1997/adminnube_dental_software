
//Table
function LoadPacientesFicheros()
{
    $('#table_ficheros_paciente').DataTable({

        searching: true,
        ordering:false,
        destroy:true,
        // scrollX: true,

        ajax:{
            url: $DOCUMENTO_URL_HTTP + '/application/system/pacientes/pacientes_admin/controller/controller_adm_paciente.php',
            type:'POST',
            data:{'ajaxSend':'ajaxSend', 'accion':'Ficheros_pacientes', 'idpaciente': $id_paciente} ,
            dataType:'json',
        },

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


//VALIDACION
function InvalicFicheros(){

    var puedo = 0;

    if( $('#ficheroTitulo').val() == "" ){
        puedo++;
        $('#ficheroTitulo').addClass('INVALIC_ERROR');
    }else{
        $('#ficheroTitulo').removeClass('INVALIC_ERROR');
    }

    if( $('#doctor').find('option:selected').val() == ""){
        puedo++;
        $('#doctor').addClass('INVALIC_ERROR');
    }else{
        $('#doctor').removeClass('INVALIC_ERROR');
    }

    if( $('#ficheroobservacion').val() == ""){
        puedo++;
        $('#ficheroobservacion').addClass('INVALIC_ERROR');
    }else {
        $('#ficheroobservacion').removeClass('INVALIC_ERROR');
    }

    if( $('#file-5').val() == ''){
        notificacion('No está seleccionado ningún archivo', 'error');
    }

    return puedo;
}

function ficherosInputsClear()
{
    $('#ficheroTitulo').val(null);
    $('#doctor').val(null).trigger('change');
    $('#ficheroobservacion').val(null);
    $('#file-5').val(null);
    $('#iconviewblock').attr('src', $DOCUMENTO_URL_HTTP + '/logos_icon/logo_default/file.png');
}

$('#formFicheros').on('submit', function(e) {

    var $puedo = false;

    if(InvalicFicheros() == 0){
        $puedo = true;
    }

    e.preventDefault();

    var formdata = new FormData($(this)[0]);

    formdata.append('idpaciente', $id_paciente );
    formdata.append('accion', 'FicheroPacienteInsert');
    formdata.append('ajaxSend', 'ajaxSend');

    // console.log(formdata);

    if($puedo == true){

        $.ajax({
            url:  $DOCUMENTO_URL_HTTP + '/application/system/pacientes/admin_paciente/controller/controller_adm_paciente.php',
            type: 'POST',
            data: formdata,
            dataType:'json',
            contentType: false,
            processData: false,
            success: function(resp){

                if(resp.error == '')
                {
                    notificacion('Información Actualizada', 'success');

                    var table = $('#table_ficheros_paciente').DataTable();
                    table.ajax.reload();

                    ficherosInputsClear();

                    reloadPagina();

                }else{

                    // notificacion('Ocurrió, un problema con la Operación, Contacte a con soporte Técnico', 'error');
                    notificacion( resp.error , 'error');

                }

            }

        });
    }


});

function del_ficheropaciente(id)
{
    $.ajax({
        url:  $DOCUMENTO_URL_HTTP + '/application/system/pacientes/admin_paciente/controller/controller_adm_paciente.php',
        type: 'POST',
        data: { 'accion':'delete_fichero_paciente', 'ajaxSend':'ajaxSend', 'id': id },
        dataType:'json',
        success:function(resp) {
            if( resp.error == ''){

                notificacion('Información Actualizada', 'success');
                var table = $('#table_ficheros_paciente').DataTable();
                table.ajax.reload();
            }else{
                notificacion(resp.error , 'error');

            }
        }
    });
}


//EXCET DOCUMENT RELOAD ------------------------------------------------------------------------------------------------

$('#doctor').select2({
    allowClear: true,
    placeholder: 'Seleccionar doctor',
});

LoadPacientesFicheros();