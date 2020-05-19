
function  cargarlistdocummclini()
{
    $('#list_docum_clini').DataTable({

        searching: true,
        ordering:false,
        destroy:true,

        ajax:{
            url: $DOCUMENTO_URL_HTTP + '/application/system/documentos_clinicos/controller_documentos/controller_document.php',
            type:'POST',
            data:{'ajaxSend':'ajaxSend', 'accion':'list_informacion_doc', 'idpaciente': $('#pacientes').find(':selected').val() },
            dataType:'json',
        },

        createdRow:function(row, data, dataIndex){

            // console.log(row);

            $(row).on('click', '.impripdf', function() {

                var DOMpdf = $(this).parents('.lipdf');
                var idtypeDocument = DOMpdf.data('idtipo'); /*tipo del documento ya sea ficha clinica o otros*/
                var iddocument     = DOMpdf.data('iddocument'); /*id del documento */

                // console.log(iddocument);
                ImprimirDocumentosClinicos(idtypeDocument, iddocument, 'pdf'); //se imprimi el documento

            });

        },
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


    //IMPRIMIR PDF DEL DOCUMENTO - SE COMPUEBA EL TIPO DE DOCUMENTO  ---------------------------
    $('#list_docum_clini tbody td ').on('click', '.impripdf', function() {



    });

}



//Esta funcione mme a permitir imprimi varios tipos de documento s
function ImprimirDocumentosClinicos($idTipoDocument, $iddocumento, $formato)
{

    var url = "";

    switch ($idTipoDocument)
    {
        case 1: //Ficha Clinica General

            if($formato == 'pdf')
            {
                url = $DOCUMENTO_URL_HTTP + "/application/system/pacientes/pacientes_admin/document_clinico/export/export_ficha_clinica.php?iddocument=" + $iddocumento;
                window.open(url, '_blank');
            }
            if($formato == 'excel')
            {

            }

            if($formato=="")
            {
                notificacion('Ocurrio un error con el formato', 'error');
            }

            break;
    }


}

$(document).ready(function() {

    //cargas los documentos clinicos
    cargarlistdocummclini();  //esta funcion es ta la lista de los documentos - debe ejecutarse primero


});


/*
if( $acciondocummAsociado == "listdocumment")
{

    //creas un documento para el paciente - admin - en este caso este es un script para Fichas clinicas
    //En esta opcion uno puede seleccionar cualquier documento que este creado listo para guardar ya sea una ficha clinica o ficha odontogrma etc
    $('#crearDocumentClinico').click(function() {

        if($('#documento_').find('option:selected').val() != 0 || $('#documento_').find('option:selected').val() != "")
        {

            var idtypedoc = $('#documento_').find('option:selected').val(); //#id tipo del documento
            var urlDocument = $DOCUMENTO_URL_HTTP + '/application/system/pacientes/pacientes_admin/?view=docummclin&key=' + $keyGlobal + '&id='+ Get_jquery_URL('id') +'&v=docum_clin&dt='+idtypedoc;
            // alert(urlDocument);
            window.location = urlDocument;

        }else{

            notificacion('Debe selecionar un documento', 'error');
        }

    });



} */


/*

if($acciondocummAsociado == "docum_clin") //Docoumentos clinicos
{

    var iddocumentfk     = 0; //El id del documento  creado
    var idtipodocumentfk = 0; //El id del tipo de documento  creado

    idtipodocumentfk = Get_jquery_URL('dt');  //tipo
    iddocumentfk     = Get_jquery_URL('iddocmnt'); // id documento


    if(idtipodocumentfk == 1) //FICHA  CLINICA
    {
        if(iddocumentfk > 0)
        {
            setDocumentMod_fichaClinica( idtipodocumentfk , iddocumentfk );
        }
    }

}  */


//OBTENER EL ID DE UNA URL CON JQUERY         ----------------------------------------
function Get_jquery_URL(Getparam)
{
    let paramsGet = new URLSearchParams(location.search);
    var idGetUrl = paramsGet.get(Getparam);

    return idGetUrl;
}