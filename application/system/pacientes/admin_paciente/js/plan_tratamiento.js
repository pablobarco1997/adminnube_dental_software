//FUNCIONES

$dataprodutos = '';  //array de prestaciones o servicios que ofrece
$descConvenio = 0;
$datadetallesprestaciones = '';
$dataBono = 0;

function  listplaneTratamiento(){

    $('#listtratamientotable').DataTable({

        searching: true,
        ordering:false,
        destroy:true,
        // scrollX: true,

        ajax:{
            url: $DOCUMENTO_URL_HTTP + '/application/system/pacientes/admin_paciente/controller/controller_adm_paciente.php',
            type:'POST',
            data:{'ajaxSend':'ajaxSend', 'accion':'list_tratamiento', 'idpaciente': $id_paciente} ,
            dataType:'json',
        },

        columnDefs:[
            {
                'targets': 0,
                'searchable':false,
                'orderable':false,
                'className': 'dt-body-center',
                'render': function (data, type, full, meta){

                    // console.log(full);

                    var idplantratamiento     = null;
                    var numeroPlantratamiento = null;
                    var profecionalCargo      = null;
                    var ultimaCitaFecha       = null;
                    var ultimaCitaHora        = null;

                    idplantratamiento     = full[6];
                    profecionalCargo      = full[1];
                    numeroPlantratamiento = full[0];
                    ultimaCitaFecha       = full[3];
                    ultimaCitaHora        = full[4];

                    //DROPDOWN MENU
                    var listaOpciones = "" +
                        "<ul class='dropdown-menu pull-right'>\n" +
                                "\n" +
                                "   <li><a href=\"#\" onclick='optionTratamiento("+idplantratamiento+", \"editname\")'>Cambiar Nombre de Plan Tratamiento</a></li>\n" +
                                "   <li><a href=\"#\">Financiamiento</a></li>\n" +
                                "   <li><a href=\"#\">Recaudar este Tratamiento</a></li>\n" +
                                "   <li><a href=\"#\">Eliminar</a></li>\n" +
                                "   <li><a href=\"#\">Finalizar</a></li>\n" +
                                "   <li><a href=\"#\">Duplicar este plan de tratamiento</a></li>\n" +
                                "\n" +
                        "   </ul>";

                    //------------------------html ------------------------------------
                    var html = "";

                    html += "<div id='boxtratamiento' class='box-ptratamiento' style=' padding: 7px' >";
                    html += "<div class='row'> " +


                                " <div class='col-md-11 col-sm-10 col-xs-10'>" +
                                "      " + numeroPlantratamiento + "  " +
                                " </div>" +


                                " <div class='col-md-1 col-sm-1 col-xs-1' style='padding: 6px 3px'>" +
                                    "   <div class='dropdown'>" +
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

//consulto la informacion de este plan de tratamiento y se digita todo el detalle de este plan t.
function fetchnewtratamiento(subaccion, datos, $idtratamiento, $idpaciente){

    var parametros = {
      'ajaxSend'  : 'ajaxSend',
      'accion'    : 'fetchnewtratamiento',
      'subaccion' :  $tratamientoOperacion,
      'idpaciente'    : $idpaciente,
      'idtratamiento' : $idtratamiento
    };

    $.ajax({
        url: $DOCUMENTO_URL_HTTP +'/application/system/pacientes/admin_paciente/controller/controller_adm_paciente.php',
        type:'POST',
        data: parametros,
        dataType:'json',
        async: false,
        success: function(resp) {

            //encontre datos
            if( resp.error == true){

                //pinto la cabezera de la lista
                if( resp.objetoCab.length > 0 ){

                    var tratamiento =  resp.objetoCab[0];
                    // console.log(tratamiento );

                    var labeltratamiento = null;

                    if(tratamiento.edit_name != null){

                        labeltratamiento = tratamiento.edit_name;
                    }else{
                        labeltratamiento = 'Plan de Tratamiento ' + tratamiento.numero;
                    }
                    $('#numtratamiento').text(  labeltratamiento );

                    $('#tratamiento_doctor').text( 'Dr(a): ' + tratamiento.nombre_doc  ).attr('data-id', tratamiento.fkdoc );

                    if(tratamiento.convenio != ""){

                        $('#tratamiento_convenio').text(tratamiento.convenio).attr('data-id', tratamiento.fk_convenio );
                        $descConvenio = tratamiento.valorConvenio; //Obtengo el valor del convenio

                    }else{
                        $('#tratamiento_convenio').text('Sin convenio').attr('data-id', '0' );
                    }

                }

                //pinto el detalle de la lista
                if( resp.objetoDet.length > 0 )
                {

                    $datadetallesprestaciones = resp.objetoDet;
                    var tratramientodet = resp.objetoDet;

                    var $html = '';
                    var i = 0;
                    while (i <= tratramientodet.length -1)
                    {

                        var iddiente   = tratramientodet[i]['diente'];
                        var prestacion = tratramientodet[i]['prestacion'];
                        var fk_prestacion = tratramientodet[i]['fk_prestacion'];
                        var subtotal = tratramientodet[i]['subtotal'];
                        var descAdicional = tratramientodet[i]['descadicional'];

                        var valor1 = subtotal;
                        var total =  0;
                        if($descConvenio != 0){
                             valor1 =  valor1 - ((subtotal * $descConvenio) / 100);
                        }
                        total = valor1 - ((valor1 * descAdicional) /100);
                        //ya sea diente permanente o Temporal
                        $('.dientePermanente').each(function()
                        {

                            var $padre = $(this);
                            var fkdiente = $padre.data('diente');


                            if( fkdiente == 0 )
                            {

                            }

                        });

                        i++;
                    }

                    //add el detalle construido
                    // var tabledetalle = $('.detallprestaciones');
                    // tabledetalle.find('tbody').append($html);

                    $('.moneyInput').maskMoney({precision:2,thousands:'', decimal:'.',allowZero:true,allowNegative:true, defaultZero:true,allowEmpty: true});
                    detallelistPrestaciones( tratramientodet ); //lista de detalles principal

                }
            }
        }

    });
}
//EVENTOS

//el envento click pinto o activo dicha cara Dentincion Permanente
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


//SeleccionarPieza Dentincion Permanente
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


function fetchproductos(){

    var dataproductos = [];

    $.ajax({
        url: $DOCUMENTO_URL_HTTP +'/application/system/pacientes/admin_paciente/controller/controller_adm_paciente.php',
        type:'POST',
        data: {'ajaxSend': 'ajaxSend', 'accion':'fetch_prestaciones'},
        dataType:'json',
        async: false,
        success: function(rep) {

            dataproductos = rep ;
            $dataprodutos = rep;

        }
    });

    return dataproductos;
}

fetchproductos();  //prestaciones

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

            console.log( $(this).data('id') );

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

        //para capturar solo el diente

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

$('#prestacionestratamiento').select2({
    placeholder: 'Seleccione una prestacion',
    allowClear: true,
    language: 'es'
});
$('#citaTratamiento').select2({
    placeholder: 'Seleccione la cita relacionada a este paciente',
    allowClear: true,
    language: 'es'
});


//EVENTOS
$('#createPlanTratamiento').click(function () {

    var $puedo = 0;

    if( $("#citaTratamiento").find(':selected').val() != ""){
        $puedo++;
    }else{

        notificacion("Debe seleccionar una cita", "error");
    }


    if($puedo > 0){

        var $tener = false;
        var $idtratamiento = 0;

        var iddoct = $("#citaTratamiento").find('option:selected').data('iddoct');
        var idcita = $("#citaTratamiento").find(':selected').val();

        //el crear plan de tratamiento apunta agenda controller
        $.ajax({
            url: $DOCUMENTO_URL_HTTP + "/application/system/agenda/controller/agenda_controller.php",
            type:'POST',
            data: {'ajaxSend':'ajaxSend', 'accion': 'nuevoUpdatePlantratamiento', 'idpaciente': $id_paciente, 'idcitadet' : idcita, 'iddoct':iddoct},
            dataType:'json',
            async: false,
            success: function(resp){

                if(resp.error == true){

                    $tener = true;
                    $idtratamiento = resp.idtratamiento;
                    notificacion('Plan de Tratamiento Creado', 'success');

                }else {
                    notificacion(resp.error , 'error');
                }

            }
        });

        if($tener == true){

            if($idtratamiento > 0){
                window.location = $DOCUMENTO_URL_HTTP + '/application/system/pacientes/admin_paciente/?view=form_plan_tratamiento&id=' + $id_paciente + '&ope=new&idtratam=' + $idtratamiento;
            }

        }

    }

});

//AGREGAR DETALLE A PLAN DE TRATAMIENTO
$("#addplantratamientodetalle").on('click', function() {

    // alert( $descConvenio );
    var obtengoPiezasCaras =  fetchPiezasCaras(null);

    var tabledetalle = $('.detallprestaciones');
    // console.log(obtengoPiezasCaras);

    var datos = [];

    var prestacion = $('#prestacionestratamiento').find('option:selected');

    var detalledientes = obtengoPiezasCaras.piezas;

    if(prestacion.val() != ""){

        var $html = "";

        var  idprestacion = prestacion.val();
        var  desc    = 0;
        var  subtotal      = 0;
        var  descProducto  = 0; //desc aplicado a la prestacion
        var  valorsubtotal = 0;
        var  total         = 0;

        $.each($dataprodutos, function (i, item) {

            if(item.rowid == idprestacion){

                subtotal    = item.valor;
                descProducto = item.convenio_valor;
                // alert(descProducto);
                if(item.convenio_valor > 0){
                    desc = (parseFloat(subtotal) * parseFloat(descProducto) / 100); //valor del descuento si en caso este producto tiene asociado un descuiento
                }

            }
        });

        valorsubtotal = ( parseFloat(subtotal) - parseFloat(desc));

        total = redondear(valorsubtotal, 2, false) ;

        if($descConvenio != 0){
            total =  valorsubtotal - (valorsubtotal * $descConvenio / 100);
        }

        var c = 0;
        while ( c <=  detalledientes.length -1 ){

            var diente = detalledientes[c]['diente']; //numero del diente
            var $puedoPasar = 0; //recorror las caras q ya estan activadas para no agregar la misma

            if( $('.detallePrestacionPiezas').length > 0){

                $('.detallePrestacionPiezas').each(function() { //recorro las prestaciones agregadas

                    var $dientePrestacion = $(this).find('.prestacionDiente').data('id');

                    //compruebo dientes ingresados ya a la prestacion
                    if($dientePrestacion == diente){

                        $puedoPasar++;  //si se acumula no puede agregar el diente por q ya esta ingresado
                    }

                });
            }

            if($puedoPasar == 0){

                $html += "<tr class='detallePrestacionPiezas'>";

                $html += "<td class='prestacionDiente' data-id='"+diente+"'>  " +
                    "   <div class='form-group col-md-12 col-xs-12'>" +
                    "     <a  style='font-size: 2rem; cursor:pointer;color: #9f191f' class='btn' onclick='delete_detalleprestacion($(this), \"modal\")'> <i class=\"fa fa-trash\"></i> </a>" +
                    "     &nbsp;&nbsp;" +
                    "     <div style='display: inline-block'>" +
                    "        <p class='prestacion_detalle' style='display: inline-block; margin: 0px; font-size: 1.5rem' data-id='"+ prestacion.val() +"'> <b> "+ prestacion.text() +" </b> </p>  " +
                    "        <p class='text-bold diente_detalle' data-diente='"+diente+"' > Diente: "+diente+" &nbsp;&nbsp; <img src='"+$DOCUMENTO_URL_HTTP+"/logos_icon/logo_default/diente.png' width='17px' height='17px' alt=''> </p>" +
                    "     </div> " +
                    "</div>  " +
                    " </td>";


                $html += "<td>  " +
                    "   <div class='form-group col-md-12 col-xs-12'>" +
                    "     <p class='subtotal' style='margin: 0px; font-size: 1.5rem'> $ <b class='subtotal_det'>" + valorsubtotal + "</b> </p> " +
                    "   </div>  " +
                    " </td>";


                $html += "<td>  " +
                    "   <div class='form-group col-md-12 col-xs-12'>" +
                    "     <p class='descConvenio' style='margin: 0px; font-size: 1.5rem'>  <b class='descuento_det'>" + $descConvenio + " </b> %</p> " +
                    "   </div>  " +
                    " </td>";

                $html += "<td>  " +
                    "   <div class='form-group col-md-12 col-xs-12'>" +
                    "     <p class='descAdicional' style='margin: 0px;  font-size: 1.5rem '> " + "<input type='text' onkeyup='desc_adicional($(this))' style='font-size: 1.5rem ;padding-left: 5px; background-color: #c1c1c1; font-weight: bolder; width: 150px; ' class='moneyInput input-sm descAdicional_det' id='descuAdicional'>" + " % </p> " +
                    "   </div>  " +
                    " </td>";

                $html += "<td>  " +
                    "   <div class='form-group col-md-12 col-xs-12'>" +
                    "     <p class='totaldetalle' style='margin: 0px; font-size: 1.5rem'>$ <b class='total_det'>" + total + "</b> </p> " +
                    "     <label style='display: none' class='subtotal_none'>"+ total +"</label>" +
                    "   </div>  " +
                    " </td>";

                $html += "</tr>";

            }


            c++;
        }


        tabledetalle.find('tbody').append($html);

        $('.moneyInput').maskMoney({precision:2,thousands:'', decimal:'.',allowZero:true,allowNegative:true, defaultZero:true,allowEmpty: true});
    }


});

function  desc_adicional(esto){

    var $padre = esto.parents('.detallePrestacionPiezas');
    var sub_total = $padre.find('.subtotal_none');
    var desc_adicional = $padre.find('.descAdicional_det');
    var total = (sub_total.text() - ( sub_total.text() * desc_adicional.val() / 100));

    var textotal = $padre.find('.total_det');
    textotal.text( redondear(total,2,false) );

    // console.log($padre);
}

function  delete_detalleprestacion($html, $mol)
{
    if($mol == 'modal'){

        var $padre = $html.parents('.detallePrestacionPiezas');
        $padre.remove();
    }
    if($mol == 'modificar'){

    }
    if($mol == 'detInsert'){ //detalle principal

        // var $padre = $html.parents('.detalleListaInsert');
        // $padre.remove();

        recalcular_detalle();
    }
}

$('#guardar_detalle_plantratamiento').click(function() {

    var puedo = 0;
    var nuevoUpdatedetId = ($('#detallemod').data('iddet') == 0) ? 0 : $('#detallemod').data('iddet');

    if( $('#detencionPermanente').is(':checked') == false && $('#detencionTemporal').is(':checked') == false ){
        notificacion('Debe selecionar un tipo de Detención', 'error');
        puedo++;
    }
    if( $('#detencionPermanente').is(':checked') == true && $('#detencionTemporal').is(':checked') == true ){
        notificacion('Debe selecionar solo un tipo Detención', 'error');
        puedo++;
    }

    if(puedo == 0){

        var datosInformaciondet = [];

        //recogo los datos ingresado al detalle guardandolos en una matriz de datos
        $('.detallePrestacionPiezas').each(function(){

            var $padre = $(this);
            var idprestacion    = $padre.find(".prestacion_detalle"); //prestacion id
            var diente          = $padre.find('.diente_detalle'); //id diente
            var subtotal        = $padre.find('.subtotal_det');
            var descConvenio    = $padre.find('.descuento_det');
            var descAdicional   = $padre.find('.descAdicional_det');
            var total_det       = $padre.find('.total_det');


            datosInformaciondet.push({
                'prestacion' : idprestacion.data('id'),
                'pieza'     : fetchPiezasCaras( diente.data('diente') ).piezas[0], //obtengo un objeto de numero de dientes y caras
                'subtotal'   : subtotal.text(),
                'descConvenio'  : descConvenio.text(),
                'descAdicional' : (descAdicional.val() == '') ? 0 : descAdicional.val(),
                'total' : total_det.text()
            });

        });

        //plan de tratamiento crear detalle o modificar detalle
        $.ajax({
            url: $DOCUMENTO_URL_HTTP + "/application/system/agenda/controller/agenda_controller.php",
            type:'POST',
            data: {
                'ajaxSend':'ajaxSend',
                'accion': 'nuevoUpdatePlanTratamientoDetalle',
                'idpaciente': $id_paciente,
                'idtratamiento': $idplantratamiento,
                'datos' : datosInformaciondet,
                'nuevoUpdatedetId': nuevoUpdatedetId
            },
            dataType:'json',
            async: false,
            success: function(resp){

                if(resp.error == ''){

                    notificacion('Información Actualizada', 'success');
                    fetchnewtratamiento($tratamientoOperacion, 0, $idplantratamiento, $id_paciente);
                    recalcular_detalle();
                    $('#ModalTratamiento_1').modal('hide');

                }else {
                    notificacion(resp.error , 'error');
                }

            }
        });
    }

});

//se agrega las lista de detalles seleccionadas en la vista principal del
function detallelistPrestaciones( tratramientodet )
{

    console.log('-----------detalles---------------');
    console.log( tratramientodet );

    var html = null;
    html = "";
    var i = 0;
    while (i <= tratramientodet.length -1){

        var rowiddetalle = tratramientodet[i]['rowid'];
        var iddiente   = tratramientodet[i]['diente'];
        var prestacion = tratramientodet[i]['prestacion'];
        var fk_prestacion = tratramientodet[i]['fk_prestacion'];
        var subtotal = tratramientodet[i]['subtotal'];
        var descAdicional = tratramientodet[i]['descadicional'];
        var realizacion = 'No realizado';
        var statusdet = tratramientodet[i]['estadodet'];

        var valor1 = subtotal;
        var total =  0;
        if($descConvenio != 0){
            valor1 =  valor1 - ((subtotal * $descConvenio) / 100);
        }


        var valor2 =  valor1 - ((valor1 * descAdicional) /100);
        total = redondear(valor2, 2, false); //rendondear a los decimales del segundo parametro a 6 o a 2

        //ESTADO DE LAS PRESTACION
        // A = ACTIVO
        // E = ELIMINADO
        html += "<tr class='detalleListaInsert'>";
            html += "<td class='' data-iddiente='"+iddiente+"'>  " +
                "   <div class='form-group col-md-12 col-xs-12'>" +
                    "     <a  style='font-size: 2rem; cursor:pointer;color: #9f191f' class='terminarEstaPrestacion' title='Realizar esta prestación'> " +
                    "     <img src='"+$DOCUMENTO_URL_HTTP+"/logos_icon/logo_default/unchecked-checkbox.png' width='20px' height='20px'>        " +  //Checkear prestacion
                    "     </a>" +
                    "     &nbsp;&nbsp;" +
                        "     <div style='display: inline-block'>" +
                        "        <p class='' style='display: inline-block; margin: 0px; font-size: 1.5rem' data-id='"+ fk_prestacion +"'> <b> "+ prestacion +" </b> &nbsp; <i class='fa fa-flag statusdet' data-estadodet='"+statusdet+"' data-iddet='"+rowiddetalle+"' ></i> </p>  " +
                        "        <p class='text-bold ' data-diente='"+iddiente+"' > Diente: "+iddiente+" &nbsp;&nbsp; <img src='"+$DOCUMENTO_URL_HTTP+"/logos_icon/logo_default/diente.png' width='17px' height='17px' alt=''> </p>" +
                        "        <a class='btn btn-xs text-bold btnhover'  style='cursor:pointer;color: #9f191f' onclick='delete_detalleprestacion($(this), \"detInsert\")' > <i class='fa fa-trash'></i> Eliminar  " +
                         "               </a> <a style='cursor: pointer' class='btn btn-xs text-bold btnhover'>Mas informacion</a> &nbsp;" +
                         "               </a> <a href='#ModalTratamiento_1' data-toggle='modal' class='btn btn-xs text-bold btnhover'  style='cursor: pointer' onclick='ModificarEsteDetalle("+rowiddetalle+")' > <i class='fa fa-edit'></i> Modificar</a>" +
                        "       <div class='masInformacion'></div>"+
                        "     </div> " +
                "   </div>  " +
                " </td>";

        html += "<td>  " +
            "   <div class='form-group col-md-12 col-xs-12'>" +
            "     <p class='' style='margin: 0px; font-size: 1.5rem'>  <b class=''>" + realizacion + "</b> </p> " +
            "   </div>  " +
            " </td>";

        html += "<td>  " +
            "   <div class='form-group col-md-12 col-xs-12'>" +
            "     <p class='descConvenio' style='margin: 0px; font-size: 1.5rem'>  <b class='descAdicional'>" + descAdicional + " </b> %</p> " +
            "   </div>  " +
            " </td>";

        html += "<td>  " +
            "   <div class='form-group col-md-12 col-xs-12'>" +
            "     <p class='' style='margin: 0px; font-size: 1.5rem'> $ <b class='total'>" + total + " </b> </p> " +
            "   </div>  " +
            " </td>";

        html += "<td>  " +
            "   <div class='form-group col-md-12 col-xs-12'>" +
            "       <div class='text-center'>" +
            "           <p style='display: inline-block; color: #00a157; font-size: 2rem'> <i class='fa fa-shopping-cart'> </i> </p> &nbsp; &nbsp;  &nbsp; &nbsp;" +
            "           <p style='display: inline-block; color: #d10d10'> <i class='fa fa-circle'> </i> </p>" +
            "       </div>" +
            "   </div>  " +
            " </td>";

        html += "</tr>";

        i++;
    }

    // console.log(html);
    $('#listdetalleplantramiento').html( html );

    recalcular_detalle();
}

function clearModalDetalle() {
    //desactiva las caras activadas
    $(".cara").each(function() {
        $(this).removeClass('activeCara');
    });

    $('#prestacionestratamiento').removeClass('disabled_link3');
    $('#addplantratamientodetalle').removeClass('disabled_link3');
    $('#detallemod').attr('data-iddet', 0);
    $('#listdetallenuew tr').remove();
}

function ModificarEsteDetalle(iddet) {

    clearModalDetalle(); //limpia la informacion del modal ... add informacion dinamica de este detalle

    $('#detallemod').attr('data-iddet', iddet); //aplico el id del detalle para modificar

    //disabled acciones
    $('#addplantratamientodetalle').addClass('disabled_link3');
    $('#prestacionestratamiento').addClass('disabled_link3');


    var $html = "";
    $.each($datadetallesprestaciones, function(i, item){

        var id = item.rowid;

        if( id == iddet )
        {

            var iddiente   = item.diente;
            var prestacion = item.prestacion;
            var fk_prestacion = item.fk_prestacion;
            var subtotal = item.subtotal;
            var descAdicional = item.descadicional;

            var jsonCaras = item.json_caras;
            var valor1 = subtotal;
            var total =  0;

            if($descConvenio != 0){
                valor1 =  valor1 - ((subtotal * $descConvenio) / 100);
            }

            var valor2 = valor1 - ((valor1 * descAdicional) /100);
            total = redondear(valor2, 2, false);

            ActivarCarasDiente(iddiente, jsonCaras); //pinto los caras seleccionadas de este diente
            // alert( total );

            $html += "<tr class='detallePrestacionPiezas'>";

            $html += "<td class='prestacionDiente' data-id='"+iddiente+"'>  " +
                        "<div class='form-group col-md-12 col-xs-12'>" +
                        "     <a  style='font-size: 2rem; cursor:pointer;color: #9f191f' class='btn disabled_link3' onclick='delete_detalleprestacion($(this), \"modal\")'> <i class=\"fa fa-trash\"></i> </a>" +
                        "     &nbsp;&nbsp;" +
                        "     <div style='display: inline-block'>" +
                        "        <p class='prestacion_detalle' style='display: inline-block; margin: 0px; font-size: 1.5rem' data-id='"+ fk_prestacion +"'> <b> "+ prestacion +" </b> </p>  " +
                        "        <p class='text-bold diente_detalle' data-diente='"+iddiente+"' > Diente: "+iddiente+" &nbsp;&nbsp; <img src='"+$DOCUMENTO_URL_HTTP+"/logos_icon/logo_default/diente.png' width='17px' height='17px' alt=''> </p>" +
                        "     </div> " +
                        "</div>  " +
                    " </td>";


                $html += "<td>  " +
                    "   <div class='form-group col-md-12 col-xs-12'>" +
                    "     <p class='subtotal' style='margin: 0px; font-size: 1.5rem'> $ <b class='subtotal_det'>" + subtotal + "</b> </p> " +
                    "   </div>  " +
                    " </td>";


                $html += "<td>  " +
                    "   <div class='form-group col-md-12 col-xs-12'>" +
                    "     <p class='descConvenio' style='margin: 0px; font-size: 1.5rem'>  <b class='descuento_det'>" + $descConvenio + " </b> %</p> " +
                    "   </div>  " +
                    " </td>";

                $html += "<td>  " +
                    "   <div class='form-group col-md-12 col-xs-12'>" +
                    "     <p class='descAdicional ' style='margin: 0px;  font-size: 1.5rem '> " +
                    "   <input type='text' onkeyup='desc_adicional($(this))' style='font-size: 1.5rem ;padding-left: 5px; background-color: #c1c1c1; font-weight: bolder; width: 150px; ' " +
                    "       class='moneyInput input-sm descAdicional_det' id='descuAdicional' value='"+descAdicional+"'>" + " % </p> " +
                    "   </div>  " +
                    " </td>";

                $html += "<td>  " +
                    "   <div class='form-group col-md-12 col-xs-12'>" +
                    "     <p class='totaldetalle' style='margin: 0px; font-size: 1.5rem'>$ <b class='total_det'>" + total + "</b> </p> " +
                    "     <label style='display: none' class='subtotal_none'>"+ valor1 +"</label>" +
                    "   </div>  " +
                    " </td>";

            $html += "</tr>";

        }

    });

    $("#listdetallenuew").html( $html);
    $('.moneyInput').maskMoney({precision:2,thousands:'', decimal:'.',allowZero:true,allowNegative:true, defaultZero:true,allowEmpty: true});

}


function ActivarCarasDiente(id, carasjson) {

    $('.dientePermanente').each(function()
    {

        var $padre = $(this);
        var fkdiente = $padre.data('diente');

        if( fkdiente == id )
        {
            var jsoncaras = JSON.parse(carasjson);
            var carasActivas = $padre.find('.cara');

            var vestibular = '';
            var distal     = '';
            var palatino   = '';
            var oclusal    = '';
            var mesial     = '';
            var lingual    = '';

            if( jsoncaras.distal == "true"){
                distal = 'distal';
            }
            if( jsoncaras.lingual ){
                lingual = 'lingual'
            }
            if(  jsoncaras.mesial == "true"){
                mesial = 'mesial';
            }
            if( jsoncaras.oclusal == 'true'){
                oclusal = 'oclusal'
            }
            if( jsoncaras.palatino == "true"){
                palatino = 'palatino';
            }
            if( jsoncaras.vestibular == 'true'){
                vestibular = 'vestibular'
            }

            carasActivas.each(function() {

                var cara = $(this).data('id');

                if( cara == distal){
                    $(this).addClass('activeCara');
                }
                if( cara == lingual){
                    $(this).addClass('activeCara');
                }
                if( cara == mesial){
                    $(this).addClass('activeCara');
                }
                if( cara == oclusal){
                    $(this).addClass('activeCara');
                }
                if( cara == palatino){
                    $(this).addClass('activeCara');
                }
                if( cara == vestibular){
                    $(this).addClass('activeCara');
                }
            });
        }

    });

}

//recalcular
function recalcular_detalle()
{
    var acu_subtotal = 0;
    var acu_descAdicional = 0;
    var acu_total = 0;
    var Abonado = ($('#abonado').val() == '') ? 0.00 : $('#abonado').val();
    var Saldo_pendiente = 0;


    //recorro las filas obteniendo los valores
    $('.detalleListaInsert').each(function() {

        var $padre = $(this);
        var desc_Adicional = $padre.find('.descAdicional');
        var total = $padre.find('.total');

        /*estado del detalle
        * A => Activo
        * E => Eliminado
        * R => Realizado */
        var statusDetalleActual = $padre.find('.statusdet');

        if(statusDetalleActual.data('estadodet') != 'E' && statusDetalleActual.data('estadodet') != 'R'){
            acu_subtotal += parseFloat(total.text());
            acu_total += parseFloat(total.text());
            acu_descAdicional += parseFloat(desc_Adicional.text());
        }

    });

    $('.subtotal_det').text( redondear(acu_subtotal, 2, false) );
    $('.descAdi_det').text( redondear(acu_descAdicional, 2, false) );
    $('.total_det').text( redondear(acu_total, 2, false) );

    var saldo_pendiente = ( acu_total - Abonado);
    $('.sald_pendiente').text( redondear(saldo_pendiente,2 , false) );

    $dataBono = redondear(saldo_pendiente , 2, false);
    AplicarBonoView();
}

//modal Cambiar nombre plan de tratamiento
function  optionTratamiento(idplantratamiento, subaccion) {

    if(idplantratamiento!="" && subaccion == 'editname' ){
        $('#modnombPlantratamiento').modal('show');
        $('#idplanTratamientotitulo').attr('data-id', idplantratamiento);
        $('#nametratamiento').val(null);
    }
}

//comportamiento cambiar nombre del tratamiento
$('#acetareditNomPlanT').click(function(){

    $.ajax({

        url: $DOCUMENTO_URL_HTTP + "/application/system/pacientes/admin_paciente/controller/controller_adm_paciente.php",
        type:'POST',
        data: {
            'ajaxSend':'ajaxSend',
            'accion': 'editnametratamiento',
            'id': $('#idplanTratamientotitulo').data('id'),
            'name' : $('#nametratamiento').val()
        },
        dataType:'json',
        async: false,
        success: function(resp){
            if(resp.error == ''){
                $('#modnombPlantratamiento').modal('hide');
                var table = $('#listtratamientotable').DataTable();
                table.ajax.reload();

            }
        }

    });
});

function AplicarBonoView() {

    var padre =  $('#contentBono');
    var textBono = padre.find('.labeltextBono');
    var NumBono  = padre.find('.labelBonoSaldo');

    if($dataBono != 0){
        padre.removeClass('disabled_link3').css('color', '#196F3D');
        textBono.text('Saldo Pendiente');
        NumBono.text("$ " + $dataBono);
    }else{

    }

}

// EXECUTE
//NUEVO PLAN DE TRATAMIENTO
if($tratamientoOperacion == 'new'){
    fetchnewtratamiento($tratamientoOperacion, 0, $idplantratamiento, $id_paciente);
    AplicarBonoView();
}

//MODIFICAR PLAN DE TRATAMIENTO
if($tratamientoOperacion == 'mod'){
    fetchnewtratamiento($tratamientoOperacion, 0, $idplantratamiento, $id_paciente);
    AplicarBonoView()
}

listplaneTratamiento(); //lista de planes de tratamiento
// console.log($dataprodutos);
