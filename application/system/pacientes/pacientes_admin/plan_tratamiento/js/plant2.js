

//CUANDO LA PLANFORM - formulario asociar plan de tratamiento una prestaciones o varias


if($accion == 'addplan')
{



    //FORM DETALLE MUESTRA TODOS LOS DETALLES CON SUS ESTADO DE LAS PRESTACIONES GURADAS
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
                    $('#addcomment').val( cabezera.observacion );
                    var abonado              =  cabezera.abonado_cab;
                    var profecional          =  cabezera.nombre_doc;
                    var convenio             =  cabezera.convenio;
                    var Nomb_tratam          =  (cabezera.edit_nam == null) ? "Plan de Tratamiento No " + cabezera.numero : cabezera.edit_nam;

                    $convenioValor           = (cabezera.valorConvenio == "") ? "No asignado" : cabezera.valorConvenio; //% Porcentage del convenio asociado
                    $AbonadoGlob             = redondear(abonado, 2, false);

                    //SI EL PLAN DE TRATAMIENTO ESTA FINALIZADO
                    if(cabezera.estados_tratamiento == 'F'){
                        notificacion('Este plan de tratamiento se encuentra Finalizado, no puede modificarlo', 'question');
                        $('#asociarPrestacion').addClass('disabled_link3');
                        $('#addCommentario').addClass('disabled_link3');
                        $('#detalle-body').addClass('disabled_link3');
                    }

                    //PINTA LA CABEZERA --------------------
                    print_html_cabezera_viewPrincipal(profecional,convenio, Nomb_tratam);

                    //Hay prestaciones asignadas
                    if(respuesta.objetoDet.length > 0)
                    {
                        //PINTA EL DETALLE -----------------------
                        var detalle = respuesta.objetoDet;
                        print_html_detalle_viewPrincipal(detalle);

                    }

                }else{

                    notificacion(respuesta.error + ' NO SE PUDO OBTENER LA INFORMACION DETALLADA DE ESTE PLAN DE TRATAMIENTO', 'error');
                }
            }
        });

        recalculoViewForm();
    }


    //PINTA LAS PRESTACIONES GUARDAS EN EL FORMULARIO
    function print_html_detalle_viewPrincipal(tratramientodet)
    {

        var html               = "";
        var i = 0;
        while(i <= tratramientodet.length -1)
        {

            //id de la prestacion detalle
            var rowiddetalle              = tratramientodet[i]['rowid'];
            var usuarioCreatePrestacion   = tratramientodet[i]['usuario_creator']; //usuario quien creo la prestacion
            var usuarioRealizarPrestacion = tratramientodet[i]['usuario_realizado']; //usuario quien realizo la prestacion

            var iddiente           = tratramientodet[i]['diente'];
            var prestacion         = tratramientodet[i]['prestacion'];
            var fk_prestacion      = tratramientodet[i]['fk_prestacion'];
            var subtotal           = tratramientodet[i]['subtotal'];
            var descAdicional      = tratramientodet[i]['descadicional'];
            var realizacion        = (tratramientodet[i]['estadodet'] == 'R') ? 'Realizado' : 'Pendiente';
            var statusdet          = tratramientodet[i]['estadodet']; //estado de la prestacion
            var total1             = tratramientodet[i]['total'];

            var estado_pago        = tratramientodet[i]['estado_pago'];

            var estadoPago = "";
            if(estado_pago == 'PA')
            { estadoPago = '<i class="fa fa-dollar"></i> &nbsp;Pagado'; }
            if(estado_pago == 'PS')
            { estadoPago = '<i class="fa fa-dollar"></i> &nbsp;Saldo'; }

            //comportamiento realizar prestacion
            var ImgRealizadoChecked = $DOCUMENTO_URL_HTTP+"/logos_icon/logo_default/unchecked-checkbox.png"; //No realizado
            var onclickRealizadoModal = " data-toggle='modal' onclick='realizarPrestacionModal($(this))' title='Realizar esta prestación' "; //Click para realizar la prestacion
            if(tratramientodet[i]['estadodet'] == 'R'){
                ImgRealizadoChecked = $DOCUMENTO_URL_HTTP+"/logos_icon/logo_default/checked-checkbox.png";
                onclickRealizadoModal = " title='Prestación Realizada' ";
            }
            //end comportamiento realizar

            var valor1 = subtotal;
            var total  =  0;
            var valor2 =  0;

            if($convenioValor != 0){
                valor1 =  valor1 - ((subtotal * $convenioValor) / 100);
            }

            // alert(prestacion + subtotal);
            valor2 =  parseFloat(valor1) - ((parseFloat(valor1) * parseFloat(descAdicional)) /100);
            total = redondear(valor2, 2, false); //rendondear a los decimales del segundo parametro a 6 o a 2

            var smallUsuarioxCreate =  ""; //informativo muestra el usuario que creo o agrego esta prestacion al plan de trtam
            if(usuarioCreatePrestacion!="") {
                smallUsuarioxCreate = "<small  style='display: block;font-weight: bolder'>Creado x Usuario: " + usuarioCreatePrestacion + " </small>";
            }
            var smallUsuarioxRealizado = "";
            if(usuarioRealizarPrestacion!=""){
                smallUsuarioxRealizado = "<small  style='display: block;font-weight: bolder'>Realizado x Usuario: " + usuarioRealizarPrestacion + " </small>";
            }


            //ESTADO DE LAS PRESTACION
            // A = ACTIVO
            // E = ELIMINADO
            // R = PRESTACION REALIZADA
            html += "<tr class='detalleListaInsert'>";
            html += "" +

            "<td class='dientePieza' data-iddiente='"+iddiente+"'>  " +

            "   <div class='form-group col-md-12 col-xs-12 no-padding' style='padding: 0px !important;'>" +

                "     <div class='form-group col-xs-12 col-sm-1 no-padding' >  " +
                    "      <a  href='#modal_prestacion_realizada' style='font-size: 2rem; cursor:pointer;color: #9f191f'  class='terminarEstaPrestacionOpcion1' " + onclickRealizadoModal + " > " +
                    "           <img id='realizadoImg-"+i+"' class='checkedRealizado' src='"+ImgRealizadoChecked+"' width='20px' height='20px'>        " +  //Checkear prestacion
                    "       </a>" +
                "     </div>" +
                "     <div class='form-group col-sm-11 col-xs-12 no-padding no-margin' >" +
                "        <p class='' style='margin: 0px; font-size: 1.5rem' data-id='"+ fk_prestacion +"'> <b> "+ prestacion +" </b> &nbsp; <i class='fa fa-flag statusdet' data-estadodet='"+statusdet+"' data-iddet='"+rowiddetalle+"' ></i> </p>  ";

            //muetra el diente asociado a esta prestacion
            if(iddiente != 0){

                html += "       <p class='text-bold' style='margin: 0px' data-diente='"+iddiente+"' > Diente: "+iddiente+" &nbsp;&nbsp; " +
                        "           <img src='"+$DOCUMENTO_URL_HTTP+"/logos_icon/logo_default/diente.png' width='17px' height='17px' alt=''> " +
                        "       </p>"

            }


            html +=  "          <a class='btn btn-xs text-bold btnhover'  style='cursor:pointer;color: #9f191f' onclick='UpdateDeletePrestacionAsignada($(this))' > <i class='fa fa-trash'></i> Eliminar  </a>" +
                "               <a style='cursor: pointer' data-toggle='collapse' data-target='#masInformacion-"+i+"' class='btn btn-xs text-bold btnhover'> <i class='fa fa-info-circle'></i> Mas información</a> &nbsp;" +
                "               <a href='#detdienteplantram' data-toggle='modal' class='btn btn-xs text-bold btnhover hide'  style='cursor: pointer'  > <i class='fa fa-edit'></i> Modificar</a>" +
                "               <a class='btn btn-xs text-bold btnhover'  style='cursor: pointer'  > "+ estadoPago +" </a>" +

                "       <div class='masInformacion col-xs-12 col-md-12 collapse' id='masInformacion-"+i+"'>" +
                "           <p class='text-justify no-margin'> " +
                "              <p class='no-margin' > " +
                "                 "+smallUsuarioxCreate+"       " +
                "                 "+smallUsuarioxRealizado+"    " +
                "               </p>  " +
                "           </p>" +
                "       </div>"+

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

        //estado pagado
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

    function print_html_cabezera_viewPrincipal(profecional, convenio, nombTratam) {

        $('#profecional').text(profecional);
        $('#convenio').text(convenio);
        $('#nomb_plantram').text(nombTratam);
    }

    //PINTA LAS PRESTACIONES AGREGADAS  O GUARDADAS
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

                        "<td> <a class='btn btn-xs text-bold btnhover' style='cursor:pointer;color: #9f191f' > <i class='fa fa-trash'></i> Eliminar </a> </td>" +

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

                    "<td> <a class='btn btn-xs text-bold btnhover' style='cursor:pointer;color: #9f191f' > <i class='fa fa-trash'></i> Eliminar </a> </td>" +

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
    function invalicErrorPrestacionDiente(prestacion, diente, subaccion)
    {

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


    //RECALCULAR EN LA VISTA DEL FORMULARI DONDE MUESTRO LAS  PRESTACIONES GUARDADAS ----------- DETALLADO
    //SE SUMA LOS TOTALES DE LAS PRESTACIONES
    function recalculoViewForm()
    {
        var Total = 0;
        var TotalRealizado = 0;
        var Total_saldo = 0;
        var Total_Abonado = 0;

        //SE SUMA TODOS LOS TOTALES
        $('.detalleListaInsert').each(function() {

            var padre = $(this);
            var getEstado = padre.find('.statusdet').data('estadodet');
            var totales   = padre.find('.total').text();

            //Si el Plan de Tratamiento se encuentra en estado a A activo
            if(getEstado == 'A' || getEstado == 'R'){
                Total += parseFloat(totales);
            }
            if(getEstado == 'R'){
                TotalRealizado += parseFloat(totales);
            }
        });


        //TOTAL REDONDEAR RESULTADO DE LAS PRESTACION

        Total_saldo   = parseFloat(Total) - $AbonadoGlob;
        Total_Abonado = redondear($AbonadoGlob);

        var TOTAL_TO = redondear(Total, 2, false);
        var TOTAL_TO_REALIZADO = redondear(TotalRealizado, 2, false);
        var TOTAL_SALDO = redondear(  Total_saldo , 2 , false);
        var TOTAL_ABONADO = Total_Abonado;

        $('#Presu_totalPresu')
            .text( TOTAL_TO );

        $('#Presu_Abonado')
            .text( TOTAL_ABONADO );

        $('#Presu_Realizado')
            .text( TOTAL_TO_REALIZADO );

        $('#Presu_Saldo')
            .text( TOTAL_SALDO );

        $('#saldoPagado')
            .text( redondear(TOTAL_SALDO, 2, false) );


    }

    //GUARDAR LA INFORMACIO DE LAS PRESTACIONES

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


     // ------------------------------

}






if($accion == "principal")
{


    /** COMPORTAMIENTOS LISTA PRINCIPAL **/
    function  optionTratamiento(idplantratamiento, subaccion)
    {

        //edit name -- nombre del plan de tratamiento
        //edit name -- nombre del plan de tratamiento
        if(idplantratamiento!="" && subaccion == 'editname' )
        {
            $('#modnombPlantratamiento').modal('show');
            $('#idplanTratamientotitulo').attr('data-id', idplantratamiento);
            $('#nametratamiento').val(null);
        }

        // finalizar  plan de tratamiento
        if(idplantratamiento !="" && subaccion == 'finalizar_plantram' )
        {
            // finalizarPlanTratamiento(idplantratamiento, 'consultarfinalizado');
            $('#mg_finalizar_plantramiento').html( null );
            $('#confirm_finalizar_plantramiento').modal('show');
            $("#finalizar_plantramiento").attr('onclick', 'finalizarPlanTratamiento('+idplantratamiento+', \'finalizar_plantram\' )');
        }

    }

    function finalizarPlanTratamiento( idplantratamiento, subaccion )
    {
        $.ajax({
            url: $DOCUMENTO_URL_HTTP + "/application/system/pacientes/pacientes_admin/controller/controller_adm_paciente.php",
            type:'POST',
            data: {
                'ajaxSend'   : 'ajaxSend',
                'accion'     : 'finalizar_plantramento',
                'subaccion'  :  subaccion,
                'idplant'    :  idplantratamiento,
                'idpaciente' :  $id_paciente
            },
            dataType:'json',
            async: false,
            success: function(resp)
            {

                if(subaccion == 'finalizar_plantram')
                {
                    if(resp.error.toString() == ''){

                        $('#confirm_finalizar_plantramiento').modal('hide');
                        notificacion('Información Actualizada', 'success');

                    }else{
                        $('#mg_finalizar_plantramiento').html( resp.consultar );
                    }
                }
            }
        });
    }

        //comportamiento cambiar nombre del tratamiento
        $('#acetareditNomPlanT').click(function(){

            $.ajax({

                url: $DOCUMENTO_URL_HTTP + "/application/system/pacientes/pacientes_admin/controller/controller_adm_paciente.php",
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

    /*ESTA FUNCION ME PERMITE ELIMINAR EL PLAN DE TRATAMIENTO*/
    function eliminarPlan_tratamiento(padreDom, $idplantratamientoDom)
    {
        var Dom = padreDom.parents('.row_list_plantram');

        if($idplantratamientoDom > 0)
        {
            if(preguntar_confirm_eliminacion($idplantratamientoDom, 'eliminar_plantcab_preguntar'))
            {
                //Se cambia el atributo para confirmaar la eliminacion
                //se cambia el atributo con la funcion  delete_confirmar_true_plantram
                $('#delete_plantram_confirm').attr('onclick', 'delete_confirmar_true_plantram('+$idplantratamientoDom+')');
            }
        }
        console.log(Dom);
    }
    
    function preguntar_confirm_eliminacion($idplantDom, subaccion)
    {
        var preguntar = false;

        $.ajax({

            url: $DOCUMENTO_URL_HTTP +'/application/system/pacientes/pacientes_admin/controller/controller_adm_paciente.php',
            type:'POST',
            data: {'ajaxSend': 'ajaxSend', 'accion':'confirm_eliminar_plantratamiento', 'idplan':$idplantDom, 'idpaciente': $id_paciente ,  'subaccion': subaccion},
            dataType:'json',
            async: false,
            success:function(respuesta){

                if(respuesta.error > 0)
                {
                    notificacion(respuesta.errores, 'error');

                }else{

                    //CONFIRMAR - para la eliminacion
                    $('#confirm_eliminar_plantram').modal('show');
                    $('#msg_eliminar_plantram').html( respuesta.msgConfirm );
                    preguntar = true;

                    if(respuesta.acierto > 0)
                    {
                        //DATOS ACTUALIZADOS
                        $('#confirm_eliminar_plantram').modal('hide');

                        notificacion('Información Actualizada', 'success');

                        listplaneTratamiento();

                    }else{

                        $('#msg_eliminar_plantram').html( respuesta.msgConfirm );
                    }

                }
            }
        });


        return preguntar;

    }

    // eliminar plan de tratamiento confirmado
    function delete_confirmar_true_plantram(idplan)
    {
        preguntar_confirm_eliminacion(idplan, 'confirm_eliminar');
    }

    //MOSTRAR PRODUCTOS ANULADOS
    $('#mostrarAnuladosPlantram').change(function() {
        listplaneTratamiento();
    });
    $('#mostaraFinalizados').change(function() {
        listplaneTratamiento();
    });
}


//OBTENER EL ID DE UNA URL CON JQUERY         ---------------------------------------- --------------------------------
function Get_jquery_URL(Getparam)
{
    let paramsGet = new URLSearchParams(location.search);
    var idGetUrl = paramsGet.get(Getparam);

    return idGetUrl;
}