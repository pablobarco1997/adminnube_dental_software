

//LISTA DE PLAN DE TRATAMIENTO
function  listplaneTratamiento(){

    $('#listtratamientotable').DataTable({

        searching: true,
        ordering:false,
        destroy:true,
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

                    // console.log(full);

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

//VARIABLES GLOBALES DETALLES ------------------------------------------------------------------------------------------
$formatoIndexPrestacion = 0;
$convenioValor = 0;   //Porcentage del conveio asociado
$detalle_plantratm = [];

//FORM DETALLE
function fetch_plantratamiento(subaccion)
{

    // $formatIndex = 0;
    var datos = {

        'ajaxSend'     : 'ajaxSend',
        'accion'       : 'fetchnewtratamiento',
        'subaccion'    : 'consultar',

        'idpaciente'    : $id_paciente,
        'idtratamiento' : $ID_PLAN_TRATAMIENTO

    };

    $.ajax({
        url: $DOCUMENTO_URL_HTTP +'/application/system/pacientes/pacientes_admin/controller/controller_adm_paciente.php',
        type:'POST',
        data: datos,
        dataType:'json',
        async: false,
        success:function(respuesta) {

            if(respuesta.error == '')
            {

                var cabezera             = respuesta.objetoCab[0];

                //CABEZRA NOMBRE TRATAM - PROFECIONAL
                var profecional          =  cabezera.nombre_doc;
                var convenio             =  cabezera.convenio;
                var Nomb_tratam          =  (cabezera.edit_nam == null) ? "Plan de Tratamiento No " + cabezera.numero : cabezera.edit_nam;

                $convenioValor           = (cabezera.valorConvenio == "") ? "No asignado" : cabezera.valorConvenio; //% Porcentage del convenio asociado

                //PINTA LA CABEZERA
                print_html_cabezera_viewPrincipal(profecional,convenio, Nomb_tratam);

                //Hay prestaciones asignadas
                if(respuesta.objetoDet.length > 0)
                {
                    //PINTA EL DETALLE
                    var detalle = respuesta.objetoDet;
                    print_html_detalle_viewPrincipal(detalle);

                }
            }else{

                notificacion(respuesta.error + ' NO SE PUDO OBTENER LA INFORMACION DETALLADA DE ESTE PLAN DE TRATAMIENTO', 'error');
            }
        }
    }); 
}

function print_html_cabezera_viewPrincipal(profecional, convenio, nombTratam) {

    $('#profecional').text(profecional);
    $('#convenio').text(convenio);
    $('#nomb_plantram').text(nombTratam);
}

//PINTA LAS PRESTACIONES GUARDAS EN EL FORMULARIO
function print_html_detalle_viewPrincipal(tratramientodet)
{

    var html               = "";
    var i = 0;
    while(i <= tratramientodet.length -1)
    {

        //id de la prestacion detalle
        var rowiddetalle       = tratramientodet[i]['rowid'];

        var iddiente           = tratramientodet[i]['diente'];
        var prestacion         = tratramientodet[i]['prestacion'];
        var fk_prestacion      = tratramientodet[i]['fk_prestacion'];
        var subtotal           = tratramientodet[i]['subtotal'];
        var descAdicional      = tratramientodet[i]['descadicional'];
        var realizacion        = 'No realizado';
        var statusdet          = tratramientodet[i]['estadodet']; //estado de la prestacion
        var total1             = tratramientodet[i]['total'];

        var valor1 = subtotal;
        var total  =  0;
        var valor2 =  0;

        if($convenioValor != 0){
            valor1 =  valor1 - ((subtotal * $convenioValor) / 100);
        }

        // alert(prestacion + subtotal);
        valor2 =  parseFloat(valor1) - ((parseFloat(valor1) * parseFloat(descAdicional)) /100);

        total = redondear(valor2, 2, false); //rendondear a los decimales del segundo parametro a 6 o a 2

        //ESTADO DE LAS PRESTACION
        // A = ACTIVO
        // E = ELIMINADO
        html += "<tr class='detalleListaInsert'>";
        html += "" +

            "<td class='' data-iddiente='"+iddiente+"'>  " +
            "   <div class='form-group col-md-12 col-xs-12'>" +

                "     <a  href='#modal_prestacion_realizada' style='font-size: 2rem; cursor:pointer;color: #9f191f' data-toggle='modal' class='terminarEstaPrestacionOpcion1' title='Realizar esta prestación'> " +
                 "     <img src='"+$DOCUMENTO_URL_HTTP+"/logos_icon/logo_default/unchecked-checkbox.png' width='20px' height='20px'>        " +  //Checkear prestacion
                "     </a>" +

                "     &nbsp;&nbsp;" +
                "     <div style='display: inline-block'>" +
                "        <p class='' style='margin: 0px; font-size: 1.5rem' data-id='"+ fk_prestacion +"'> <b> "+ prestacion +" </b> &nbsp; <i class='fa fa-flag statusdet' data-estadodet='"+statusdet+"' data-iddet='"+rowiddetalle+"' ></i> </p>  ";

                if(iddiente != 0){

                    html += "       <p class='text-bold' style='margin: 0px' data-diente='"+iddiente+"' > Diente: "+iddiente+" &nbsp;&nbsp; " +
                            "           <img src='"+$DOCUMENTO_URL_HTTP+"/logos_icon/logo_default/diente.png' width='17px' height='17px' alt=''> " +
                            "       </p>"

                }


       html +=  "               <a class='btn btn-xs text-bold btnhover'  style='cursor:pointer;color: #9f191f' onclick='UpdateDeletePrestacionAsignada($(this))' > <i class='fa fa-trash'></i> Eliminar  </a>" +
                "               <a style='cursor: pointer' class='btn btn-xs text-bold btnhover'>Mas información</a> &nbsp;" +
                "               <a href='#detdienteplantram' data-toggle='modal' class='btn btn-xs text-bold btnhover hide'  style='cursor: pointer' onclick='ModificarEsteDetalle("+rowiddetalle+")' > <i class='fa fa-edit'></i> Modificar</a>" +

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
            "     <p class='' style='margin: 0px; font-size: 1.5rem'> $ <b class='total'>" + redondear(total1, 2) + " </b> </p> " +
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

    document.getElementById('detalle-body').innerHTML = html;

}

//ADD PRESTACION
function fetch_prestaciones(idprest)
{
    var dataPrest = [];

    $.ajax({
        url: $DOCUMENTO_URL_HTTP +'/application/system/pacientes/pacientes_admin/controller/controller_adm_paciente.php',
        type:'POST',
        data: {'ajaxSend': 'ajaxSend', 'accion':'fetch_prestaciones', 'idprest': idprest},
        dataType:'json',
        async: false,
        success: function(resp) {

            dataPrest = resp;
        }

    });

    return dataPrest;
}

//ELIMINAR ESTADO DE LA PRESTACION
function UpdateDeletePrestacionAsignada(html)
{
    var padre = html.parents('.detalleListaInsert');
    var status = padre.find('.statusdet');

}

function print_html_detallePrestacion(objectPresst, idprestacion)
{

    var puedoAdddet = 0;

    if($('#detalle-prestacionesPlantram').find('tr td').text() == $.trim('NO HAY DETALLE'))
    {
        //limpio las filas en caso no aya datos
        $('#detalle-prestacionesPlantram tr').remove();
    }

    //OBTENGO TODOS LAS PIEZAS Y CARAS SELECCIONADAS
    var objPiezas =  fetchPiezasCaras(null);
    var dientes   = objPiezas.piezas;
    console.log(objectPresst);

    var htmlpress = "";

    //CALCULO DE PRESTACIONES  -------------------
    var total = 0;
    total = parseFloat(objectPresst.valor) - (( parseFloat(objectPresst.valor) * parseFloat(objectPresst.convenio_valor) ) / 100) ;

    //ciclo por diente seleccionados
    if( dientes.length > 0){

        var io = 0;
        while(io < dientes.length)
        {

            var detalleDiente = dientes[io];

            // se valida el diente y la prestacion
            if( invalicErrorPrestacionDiente(idprestacion, detalleDiente.diente, 'diente') == 0 )
            {

                $formatoIndexPrestacion++;

                //obtengo solo las caras de las piezas seleccionadas
                var pieza = fetchPiezasCaras(detalleDiente.diente).piezas[0].caras;

                htmlpress += "" +
                    "<tr  data-idprestacion='" + idprestacion + "'  data-iddiente='" + detalleDiente.diente + "' name='detalleRow["+$formatoIndexPrestacion+"].detalle' class='detallePrincipalPrestacion' data-caras='"+JSON.stringify(pieza)+"' >" +

                            "<td> <a class=\"btn btn-xs text-bold btnhover\" style=\"cursor:pointer;color: #9f191f\" > <i class=\"fa fa-trash\"></i> Eliminar </a> </td>" +

                            //PRESTACION
                            "<td name='Prestacion[" + $formatoIndexPrestacion + "].detalle' class='prestacion' data-idprestacion='" + idprestacion + "'  data-iddiente='" + detalleDiente.diente + "'>" +
                                    "<p style='margin: 0px'>" + objectPresst.descripcion + "</p>" +
                                    "<small title='Diente: " + detalleDiente.diente + "'>Diente: &nbsp; " + detalleDiente.diente + " <img src='" + $DOCUMENTO_URL_HTTP + "/logos_icon/logo_default/diente.png' width='15px' height='15px' > </small>" +
                            "</td>" +

                            //subtotal
                            "<td name='subtotalPresst[" + $formatoIndexPrestacion + "].detalle' class='subtotal' >" + objectPresst.valor + "</td>" +

                            //desc de prestacion
                            "<td name='convenioPresst["+$formatoIndexPrestacion+"].detalle' class='convenioSubtotal'>"+ objectPresst.convenio_valor +"</td>" +

                            //cantidad
                            "<td> <input name='cantPresst["+$formatoIndexPrestacion+"].detalle' type='number' class='cantidadPrest input-sm' style='width: 150px;' value='1'> </td> "+

                            //desc adicional
                            "<td> <input name='descAdicional["+$formatoIndexPrestacion+"].detalle' type='text' class='adicional input-sm' style='width: 150px;'> </td>" +

                            //total
                            "<td name='totalPrestacion["+$formatoIndexPrestacion+"].detalle' class='totalprestacion'>"+ total +"</td>" +

                    "</tr>";


            }


            io++;
        }

    }else{

        //Se Ingresa Solo las Prestacion   -----------------------------------------------------------------------------

        if( invalicErrorPrestacionDiente(idprestacion, 0, 'prestacion') == 0 )
        {
            $formatoIndexPrestacion++;

            htmlpress += "" +
                "<tr data-idprestacion='"+idprestacion+"' name='detalleRow["+$formatoIndexPrestacion+"].detalle' data-iddiente='0' class='detallePrincipalPrestacion' data-caras='{\"vestibular\":false,\"distal\":false,\"palatino\":false,\"oclusal\":false,\"mesial\":false,\"lingual\":false}'>" +

                        "<td> <a class=\"btn btn-xs text-bold btnhover\" style=\"cursor:pointer;color: #9f191f\" > <i class=\"fa fa-trash\"></i> Eliminar </a> </td>" +

                        //PRESTACION
                        "<td name='Prestacion["+$formatoIndexPrestacion+"].detalle' class='prestacion' data-idprestacion='"+idprestacion+"'  data-iddiente='0'>" +
                        "<p style='margin: 0px'>"+objectPresst.descripcion+"</p>" +
                        "</td>" +

                        //subtotal
                        "<td name='subtotalPresst[" + $formatoIndexPrestacion + "].detalle' class='subtotal' >" + objectPresst.valor + "</td>" +
                        //desc de prestacion
                        "<td name='convenioPresst["+$formatoIndexPrestacion+"].detalle' class='convenioSubtotal' >"+ objectPresst.convenio_valor +"</td>" +

                        //cantidad
                        "<td> <input name='cantPresst["+$formatoIndexPrestacion+"].detalle' type='number' class='cantidadPrest input-sm' onkeyup='recalcularPrestacion($(this))'  style='width: 150px;' value='1'> </td> "+

                        //desc adicional
                        "<td> <input name='descAdicional["+$formatoIndexPrestacion+"].detalle' type='text' class='adicional input-sm' onkeyup='recalcularPrestacion($(this))' style='width: 150px;'> </td>" +

                        //total
                        "<td name='totalPrestacion["+$formatoIndexPrestacion+"].detalle' class='totalprestacion'>"+ total +"</td>" +


                "</tr>";

        }

    }

    //Se limpia el las piezas activas
    clearModalDetalle('soloActivas');

    $('#detalle-prestacionesPlantram').append(htmlpress);

    // CANTIDAD ONKEYUP
    $(".cantidadPrest").keyup(function() {
        recalcularPrestacion( $(this) )
    });
    //DESCUENTO ADICIONAL
    $(".adicional").keyup(function() {
        recalcularPrestacion( $(this) )
    });


}

//Se valida las prestacion ingresada con el mismo diente == no puede repetirse
function invalicErrorPrestacionDiente(prestacion, diente, subaccion) {

    var PuedoPasar = 0;

    if( $('#detalle-prestacionesPlantram tr').length > 0 )
    {

        $('#detalle-prestacionesPlantram tr').each(function(i, item)
        {

            if(subaccion == 'diente')
            {
                if($(this).data('idprestacion') == prestacion && $(this).data('iddiente') == diente )
                {
                    PuedoPasar++;
                    $('#errores_msg_addplantram').text( 'Esta prestación ya esta asignada');
                }
            }

            if(subaccion == 'prestacion')
            {
                if( $(this).data('idprestacion') == prestacion && $(this).data('iddiente') == 0)
                {
                    PuedoPasar++;
                    $('#errores_msg_addplantram').text( 'Esta prestación ya esta asignada');
                }
            }

        });

        if( PuedoPasar > 0){
            setTimeout(function() {

                $('#errores_msg_addplantram').text(null);

            },3000)
        }

    }


    //Tiempo real verificar prestaciones guardadas
    $.ajax({
        url: $DOCUMENTO_URL_HTTP +'/application/system/pacientes/pacientes_admin/controller/controller_adm_paciente.php',
        type:'POST',
        data: {
            'ajaxSend': 'ajaxSend',
            'accion':'invalic_prestacion_diente',
            'idplantram': $ID_PLAN_TRATAMIENTO,
            'prestacion': prestacion,
            'diente': diente,
            'subaccion' : subaccion
        },
        dataType:'json',
        async: false,
        success: function(resp) {
            if(resp.error != ''){

                $('#errores_msg_addplantram').text(resp.error);

                setTimeout(function() {

                    $('#errores_msg_addplantram').text(null);

                },3000)

                PuedoPasar++;

            }
        }

    });

    return PuedoPasar;

}

//OBTENER UN ARRAY DE LAS PRESTACION A AGREGAR
function fetch_objectPrestacionDetalle()
{
    var informacionPrestacion = []; //GUARDO LAS PRESTACIONES TEMPORAL

    var detencion = '';

    if($('#detencionPermanente').is('checked')){
        detencion = 'permanente';
    }
    if($('#detencionTemporal').is('checked')){
        detencion = 'temporal';
    }

    if( $('.detallePrincipalPrestacion').length > 0 )
    {
        for( var i = 0; i <= $formatoIndexPrestacion ; i++ )
        {
             var rowdet = $('[name="detalleRow[' + i + '].detalle"]');

             if(rowdet.length > 0)
             {

                 var iddiente = 0;
                 var idPrestacion     = $('[name="Prestacion[' + i + '].detalle"]').data('idprestacion');
                      iddiente        =  $('[name="Prestacion[' + i + '].detalle"]').data('iddiente');

                 var descConv        = $('[name="convenioPresst[' + i + '].detalle"]').text();
                 var subtotal        = $('[name="subtotalPresst[' + i + '].detalle"]').text();

                 var descAdicional   = $('[name="descAdicional[' + i + '].detalle"]').val();
                 var cantidad        = $('[name="cantPresst[' + i + '].detalle"]').val();

                 //JASON STRING CARAS
                 var Pieza =  rowdet.data('caras');

                 console.log(rowdet.data('caras'));

                 // alert(iddiente);
                 var total = $('[name="totalPrestacion[' + i + '].detalle"]').text();



                 informacionPrestacion.push({
                     'prestacion' : idPrestacion,
                     'iddiente' : iddiente ,
                     'pieza' : Pieza,
                     'subtotal' : subtotal,
                     'descConvenio': descConv ,
                     'descAdicional': descAdicional ,
                     'cantidad': cantidad ,
                     'total' : total ,
                     'detencion' : detencion
                 });

             }

        }

    }

    console.log(informacionPrestacion.filter(Boolean));

    return informacionPrestacion.filter(Boolean);

}


//RECALCULAR PRESTACION  -- CUANDO SE ESTA AGREGANDO DETALLES EN LA PRESTACION
function recalcularPrestacion(row)
{
    // console.log(row);
    var padre = row.parents('.detallePrincipalPrestacion');
    var subtotal = padre.find('.subtotal');
    var convenioSubtotal = padre.find('.convenioSubtotal');
    var cantidad = (padre.find('.cantidadPrest').val() == "") ? 0 : padre.find('.cantidadPrest').val();
    var descuentoAdicional = (padre.find('.adicional').val() == "") ? 0 : padre.find('.adicional').val();

    var TOTAL = padre.find('.totalprestacion');

    var subtotal2 = parseFloat(subtotal.text()) - (( parseFloat(subtotal.text()) * parseFloat(convenioSubtotal.text()) ) / 100) ;
    var subtotal3 = ( parseFloat(subtotal2) * parseFloat(cantidad) );
    var subtotal4 = parseFloat(subtotal3) -  ( ( parseFloat(subtotal3) * parseFloat(descuentoAdicional) ) / 100 )
    var total2 = redondear(subtotal4, 2 , false);

    // alert(subtotal4);
    TOTAL.text(total2);

}

//GUARDAR LA PRESTACION AGREGADA AL DETALLE NUEVO PLAN DE TRATAMIENTO DETALLE
$('#guardarPrestacionPLantram').click(function(){

     var objInformacion = fetch_objectPrestacionDetalle();

     var $puedoPasar = 0;
     var DetencionPermanente = 0;
     var DetencionTemporal = 0;
     var DetencionLabel = "";

    if($('#detencionPermanente').is(':checked')){
         DetencionPermanente++;
        DetencionLabel = "permanente";
    }

    if($('#detencionTemporal').is(':checked')){
        DetencionTemporal++;
        DetencionLabel = "temporal";
    }

    if($('#detencionTemporal').is(':checked') == false && $('#detencionPermanente').is(':checked') == false){
        $puedoPasar = 2
    }

    if($puedoPasar == 2){
        notificacion('Debe Seleccionar una Detención', 'error');
    }

    if(DetencionTemporal == 1 && DetencionPermanente == 1){
        $('#errores_msg_addplantram').text('Solo puede seleccionar una Detención');
        $puedoPasar++;
        setTimeout(function() {
            $('#errores_msg_addplantram').text(null);
        },3000);
    }

    if(objInformacion.length == 0 ){
        notificacion('No hay ningun detalle asignado', 'error');
    }

     if(objInformacion.length > 0 &&  $puedoPasar == 0)
     {

         $.ajax({
             url: $DOCUMENTO_URL_HTTP + "/application/system/agenda/controller/agenda_controller.php",
             type:'POST',
             data: {

                 'ajaxSend':'ajaxSend',
                 'accion': 'nuevoUpdatePlanTratamientoDetalle',
                 'datos': objInformacion ,
                 'idtratamiento': $ID_PLAN_TRATAMIENTO,
                 'idpaciente': $id_paciente, /*Id del paciente Global*/
                 'subaccion': 'create',
                 'detencion': DetencionLabel
             },
             dataType:'json',
             async: false,
             success: function(resp){

                 if( resp.error != ''){

                     notificacion(resp.error , 'error');

                 }else{
                     notificacion('Información Actualizada' , 'success');

                     clearModalDetalle('todo');
                     $('#detdienteplantram').modal('hide');
                     fetch_plantratamiento(); //reload lista de plantram form
                 }
             }
         });

     }

    recalculoViewForm(); //RECALCULAR EL TOTAL DE PRESTACION

});


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


//RECALCULAR EN LA VISTA DEL FORMULARI DONDE MUESTRO LAS  PRESTACIONES GUARDADAS ----------- DETALLADO
//SE SUMA LOS TOTALES DE LAS PRESTACIONES
function recalculoViewForm()
{
    var Total = 0;
    //SE SUMA TODOS LOS TOTALES
    $('.detalleListaInsert').each(function() {

        var padre = $(this);
        var getEstado = padre.find('.statusdet').data('estadodet');
        var totales   = padre.find('.total').text();

        //Si el Plan de Tratamiento se encuentra en estado a A activo
        if(getEstado == 'A'){
            Total += parseFloat(totales);
        }
    });

    //TOTAL REDONDEAR RESULTADO DE LAS PRESTACION
    var TOTAL_TO = redondear(Total, 2, false);
    $('#Presu_totalPresu').text( TOTAL_TO );
}

//FORMULARIO TRTAMIENTO
if($accion == 'addplan')
{

    fetch_plantratamiento('consultar'); //Obtengo lso datos plan de tratamiento

    //MODIFICAR EL DETALLE DE LA PRESTACION
    function  ModificarEsteDetalle(iddet)
    {

        clearModalDetalle('todo');
        $('#detallemod').attr('data-iddet', iddet); //aplico el id del detalle para modificar

        //disabled acciones
        $('#addplantratamientodetalle').addClass('disabled_link3');
        $('#prestacionestratamiento').addClass('disabled_link3');
    }

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


    //AGREGAR DETALLE PRESTACIONES ASOCIADAS A ESTE PLAN DE TRATAMIENTO
    $("#addprestacionPlantram").click(function() {

        if( $("#prestacion_planform").find(':selected').val() != "" )
        {
            var idprestacion = $("#prestacion_planform").find(':selected').val();

            if(idprestacion > 0){

                var objetoPrestacion = fetch_prestaciones(idprestacion);
                //Se pinta las prestaciones en el modal
                print_html_detallePrestacion(objetoPrestacion, idprestacion);
            }

        }else{
            notificacion('Debe seleccionar una prestación', 'error');
        }
    });


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