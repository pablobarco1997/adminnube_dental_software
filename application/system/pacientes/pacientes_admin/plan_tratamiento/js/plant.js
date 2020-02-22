
//VARIABLES GLOBALES DETALLES ------------------------------------------------------------------------------------------
$formatoIndexPrestacion = 0;
$convenioValor = 0;   //Porcentage del conveio asociado
$AbonadoGlob = 0;
$detalle_plantratm = [];
$ID_PLAN_TRATAMIENTO


//LISTA DE PLAN DE TRATAMIENTO
function  listplaneTratamiento(){

    $('#listtratamientotable').DataTable({

        searching: true,
        ordering:false,
        destroy:true,
        paging: false,
        // scrollX: true,

        ajax:{
            url: $DOCUMENTO_URL_HTTP + '/application/system/pacientes/pacientes_admin/controller/controller_adm_paciente.php',
            type:'POST',
            data:{

                'ajaxSend':'ajaxSend',
                'accion':'list_tratamiento',
                'idpaciente': $id_paciente,
                'mostrar_anulados': ($('#mostrarAnuladosPlantram').prop('checked') == true) ? 'si': 'no'

            } ,
            dataType:'json',
        },

        columnDefs:[
            {
                'targets': 0,
                'searchable':false,
                'orderable':false,
                'className': 'dt-body-center',
                'render': function (data, type, full, meta){

                    console.log(full);

                    var idplantratamiento     = null;
                    var numeroPlantratamiento = null;
                    var profecionalCargo      = null;
                    var ultimaCitaFecha       = null;
                    var ultimaCitaHora        = null;
                    var estadoPlanTram        = null;

                    idplantratamiento     = full[6];
                    profecionalCargo      = full[1];
                    numeroPlantratamiento = full[0];
                    ultimaCitaFecha       = full[3];
                    ultimaCitaHora        = full[4];
                    estadoPlanTram        = full[8];

                    //Se bloqueara si ya tiene asociada una cita
                    var disablelinkCitasAsocid = "";
                    var disableEstadoPlantrem  = "";

                    if(full[7] != 0){
                        disablelinkCitasAsocid = 'disabled_link3'
                    }

                    if(estadoPlanTram == 'E'){
                        disableEstadoPlantrem = 'disabled_link3';
                    }

                    //DROPDOWN MENU
                    var listaOpciones = "" +
                        "<ul class='dropdown-menu pull-right'>\n" +
                                "\n" +
                                "   <li><a href=\"#\" onclick='optionTratamiento("+idplantratamiento+", \"editname\")'>Cambiar Nombre de Plan Tratamiento</a></li>\n" +
                                "   <li><a href=\"#\">Financiamiento</a></li>\n" +
                                "   <li><a href=\"#\">Recaudar este Tratamiento</a></li>\n" +
                                "   <li><a href=\"#\" class='"+disableEstadoPlantrem+"' onclick='eliminarPlan_tratamiento($(this), "+ idplantratamiento +")' >Anular</a></li>\n" +
                                "   <li><a href=\"#\">Finalizar</a></li>\n" +
                                "   <li><a href=\"#\">Duplicar este plan de tratamiento</a></li>\n" +
                                "\n" +
                        "   </ul>";

                    //------------------------html ------------------------------------
                var html = "";

                html += "<div id='boxtratamiento' class='box-ptratamiento row_list_plantram' style=' padding: 7px' >";
                html += "<div class='row'> " +


                        " <div class='col-md-11 col-sm-9 col-xs-8'>" +
                        "       <ul class='list-inline'>" +
                        "           <li>" +numeroPlantratamiento+ "</li>" +
                        "           <li></li>" +
                        "       </ul>   " +
                        " </div>" +


                        // DROPDOWN MENU ACCIONES PLAN TRATAMIENTO
                        " <div class='col-md-1 col-sm-1 col-xs-1' style='padding: 6px 3px'>" +
                        "   <div class='dropdown col-md-1 col-xs-1'>" +
                        "      <button class='btn dropdown-toggle' type='button' data-toggle='dropdown' >" +
                        "      <i class='fa fa-ellipsis-v'></i> "   +
                        "      </button>      " +
                        "       "  + listaOpciones +
                        "    </div>" +
                        "</div>" +

                        "</div>" +

                        "<br>";

                    html += "   <div class='row'>" +
                        "<div class='col-sm-3'>" +
                                "<small style='color: #85929E; font-weight: bold'>PROFESIONAL</small>" +
                                "<br>" +
                                "<br>" +
                                  "<small style='font-weight: bold; width: 100%; display: block' class='trunc'> <i class='fa fa-user-md'></i> &nbsp; " + profecionalCargo + " </small>" +
                                "<br>" +
                        "</div>" +

                        "<div class='col-sm-3'>" +
                            "<small style='color: #85929E; font-weight: bold'>ÚLTIMA CITA</small>" +
                            "<br>" +
                            "<br>" +
                                "<small style='font-weight: bold; width: 100%; display: block' class='trunc'> " +
                                "<i class='fa fa-calendar'></i> &nbsp; " + ultimaCitaFecha + "  " +
                                "<i class='fa fa-clock-o'></i>  &nbsp; " + ultimaCitaHora + " " +
                                "</small>" +
                            "<br>" +
                        "</div>" +

                        "<div class='col-sm-3'>" +
                            "<small style='color: #85929E; font-weight: bold; '>ESTADO FINANCIERO</small>" +
                            "<br>" +
                            "<br>" +
                                "<small style='font-weight: bold; width: 100%; display: block' class='trunc fontsize'> " +
                                "<i class='fa fa-user-md'></i> &nbsp; DIAGNOSTICO </small>" +
                            "<br>" +
                        "</div>" +

                        "<div class='col-sm-2'>" +
                            "<small style='color: #85929E; font-weight: bold; '>ASOCIAR A CITA</small>" +
                            "<br>" +
                            "<br>" +
                                "<a href='#modal_plantrem_citas' onclick='attrChangAsociarCitas("+idplantratamiento+")' data-toggle='modal' style='font-weight: bold; width:80px; font-size: 1.1rem; color: #000;' class='trunc fontsize btn btn-xs btnhover "+disablelinkCitasAsocid+" '> " +
                                "<i class='fa fa-list-ul'></i> &nbsp; C I T A S </a>" +
                            "<br>" +
                        "</div>" +


                        "   </div>";
                    html += "</div>";


                    // return full[4];
                    return html;
                },

            }
        ],

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


//PANTALLA PRINCIPAL TRATAMIENTO  --------------------------------------------------------------------------------------
if($accion == "principal")
{
    // READY DOCUMENT
    listplaneTratamiento();

    //CREA EL PLEN DE TRATAMIENTO DESDE EL MODULO PLAN DE TRATAMIENTO
    $('#createPlanTratamientoCab').click(function() {

        attrChangAsociarCitas(null);
        CrearPlanTratamientoIndependienteDependiente(null);
    });

    //Crear Plan de tratamiento desde una Cita
    $('#CrearPlanTratamientoPlantram').click(function() {

        if($('#citasPaciente').find(':selected').val() > 0)
        {
            CrearPlanTratamientoIndependienteDependiente(null);
        }else{

            $('#error_asociarCitas').text('Debe seleccionar una cita');
            setTimeout(function() {
                $('#error_asociarCitas').text(null);
            }, 3000);
        }
    });
    
    //CAMBIAR ATRIBUTO ASOCIAR CITAS A PLANES DE TRATAMIENTO
    function attrChangAsociarCitas($idPlanTratamiento)
    {
        var id = ($idPlanTratamiento==null) ? 0 : $idPlanTratamiento;
        $('#nuPlanTratamiento').attr('data-id', id);
    }

    //CREAR PLAN DE TRATAMIENTO CABEZERA INDEPENDIENTE ---------------------
    function CrearPlanTratamientoIndependienteDependiente(subaccion)
    {
        var CitasPacientes = $('#citasPaciente').find(':selected');

        //EL CREAR PLAN DE TRATAMIENTO
        //AGENDA CONTROLLER
        $.ajax({
            url: $DOCUMENTO_URL_HTTP + "/application/system/agenda/controller/agenda_controller.php",
            type:'POST',
            data: {
                'ajaxSend':'ajaxSend',
                'accion': 'nuevoUpdatePlantratamiento',
                'idpaciente': $id_paciente,
                'idcitadet' : (CitasPacientes.data('idcita') == "") ? 0 : CitasPacientes.data('idcita'),
                'iddoct': ( CitasPacientes.data('iddoct') == "" ) ? 0 : CitasPacientes.data('iddoct') ,
                'idplantramAsociar' : $('#nuPlanTratamiento').data('id') ,
                'subaccion' : ($('#nuPlanTratamiento').data('id') == 0) ? "CREATE" : "ASOCIAR_CITAS"
            },
            dataType:'json',
            async: false,
            success: function(resp){

                var idpacienteToken = resp.idpacientetoken;

                if(resp.error == ''){

                    notificacion('Plan de Tratamiento Creado - cargando...', 'success');

                }else {

                    //Error esta cita ya esta asociada a un plan de tratamiento
                    $('#error_asociarCitas').html(resp.error) ;

                    setTimeout(function() {

                        $('#error_asociarCitas').text(null);
                    },7000)
                }


                if( resp.error == '')
                {

                    var $tener = 0;
                    var $idtratamiento = 0;

                    if( resp.idtratamiento > 0){
                        $idtratamiento = resp.idtratamiento;
                        $tener++;
                    }

                    if( subaccion == null){

                        if($tener > 0){

                            if($idtratamiento > 0){
                                // alert(idpacienteToken);

                                setTimeout(function() {
                                    window.location = $DOCUMENTO_URL_HTTP + '/application/system/pacientes/pacientes_admin/?view=plantram&key=' + $keyGlobal + '&id=' + idpacienteToken + '&v=planform&idplan=' + $idtratamiento;
                                }, 1500);
                            }
                        }
                    }

                }

            }

        });

    }


    $('#citasPaciente').select2({
        placeholder: 'Seleccione una opcion',
        allowClear:true,
        language: 'es'
    });
}


//FORMULARIO TRTAMIENTO
if($accion == 'addplan')
{

    fetch_plantratamiento('consultar'); //Obtengo lso datos plan de tratamiento

    //LIMPIAR CARAS MODAL
    function clearModalDetalle(por)
    {

        if(por == 'soloActivas')
        {

            //desactiva las caras activadas
            $(".cara").each(function() {
                $(this).removeClass('activeCara');
            });
        }

        if(por == 'todo'){
            //desactiva las caras activadas
            $(".cara").each(function() {
                $(this).removeClass('activeCara');
            });

            $('#prestacionestratamiento').removeClass('disabled_link3');
            $('#addplantratamientodetalle').removeClass('disabled_link3');
            $('#detallemod').attr('data-iddet', 0);
            $('#detalle-prestacionesPlantram tr').remove();
        }

    }


    //ACTIVAR CARAS COLOREAR CARAS PIEZA -------------------------------------------------------------------------------

    //CARAS
    $('.CaraClickDenticionPermanente').click(function() {

        var $htmlCara= $(this);

        var ActiveCara = $htmlCara.find('.activeCara'); //verifico si esta activo la cara

        if(ActiveCara.length > 0) //activo
        {
            $htmlCara.removeClass('activeCara');
        }else{ //Desactivo
            $htmlCara.addClass('activeCara');
        }

        console.log(ActiveCara.length);
    });

    //PIEZAS
    $('.CheckPiezasDenticionPermanente').click(function() {

        var $htmlpieza= $(this).parents('table');

        var cara = $htmlpieza.find('.cara');

        if(cara.length == 5)
        {
            if($(this).is(':checked')) //si esta activo
            {
                cara.addClass('activeCara');
            }else{
                cara.removeClass('activeCara');
            }
        }
        console.log($htmlpieza);

    });

    //END CARAS PIEZAS -------------------------------------------------------------------------------------------------


    $('#prestacion_planform').select2({
       placeholder:'Seleccione una prestacion',
       allowClear: true,
       language:'es'
    });

    recalculoViewForm(); //RECALCULAR TOTAL PRESTACION


    //REALIZAR PRESTACION MODAL COMPORTAMIENTOS ------------------------------------------------------------------------
    $('#evolucionDoct').select2({
        placeholder:'Seleccione un doctor',
        allowClear: true,
        language:'es'
    });

    $('#actualizarOdontogramaPlantform').select2({
        placeholder:'Seleccione un estado del odontograma',
        allowClear: true,
        language:'es'
    })



}




//CARAS PIEZAS ACTIVAR FETCH  ------------------------------------------------------------------------------------------

function fetchPiezasCaras( seach_diente ){

    var dataPrincipal = [];
    var piezas = [];
    var numeroCaras = 0;
    var i = 0;
    //recorro las piezas
    $('.dientePermanente').each(function() {

        var activo = 0;
        var diente = $(this);
        var cara = diente.find('.cara');

        var CaraActivada = diente.find('.activeCara');


        var vestibular = 0;
        var distal     = 0;
        var palatino   = 0;
        var oclusal    = 0;
        var mesial     = 0;
        var lingual    = 0;

        var $puedopasar     = 0;

        //recorro las caras
        CaraActivada.each(function() {

            // alert( $(this).data('id') );

            if($(this).data('id') == 'vestibular'){
                vestibular++;
            }
            if($(this).data('id') == 'distal'){
                distal++;
            }
            if($(this).data('id') == 'palatino'){
                palatino++;
            }
            if($(this).data('id') == 'oclusal'){
                oclusal++;
            }
            if($(this).data('id') == 'mesial'){
                mesial++;
            }
            if($(this).data('id') == 'lingual'){
                lingual++;
            }

            $puedopasar++; //para capturar el diente
            numeroCaras++;
        });

        // PARA BUSCAR EL DIENTE
        if(seach_diente != null){

            if(seach_diente == diente.data('diente')){

                if( $puedopasar > 0){

                    piezas.push({
                        'diente': diente.data('diente'), //numero del diente
                        'caras' : {
                            'vestibular' : (vestibular > 0) ? true : false,
                            'distal'     : (distal > 0) ? true : false,
                            'palatino'   : (palatino > 0) ? true : false,
                            'oclusal'    : (oclusal > 0) ? true : false,
                            'mesial'     : (mesial > 0) ? true : false,
                            'lingual'    : (lingual > 0) ? true : false,
                        }
                    });

                    return piezas;
                }
            }
        }else{

            if( $puedopasar > 0){

                piezas.push({
                    'diente': diente.data('diente'), //numero del diente
                    'caras' : {
                        'vestibular' : (vestibular > 0) ? true : false,
                        'distal'     : (distal > 0) ? true : false,
                        'palatino'   : (palatino > 0) ? true : false,
                        'oclusal'    : (oclusal > 0) ? true : false,
                        'mesial'     : (mesial > 0) ? true : false,
                        'lingual'    : (lingual > 0) ? true : false,
                    }
                });

            }
        }

        i++;

    });



    dataPrincipal = {
        'piezas' : piezas,
        'numeroCaras' : numeroCaras,
    };

    return dataPrincipal;
}

