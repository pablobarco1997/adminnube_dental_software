
//FORMULARIO DE ODONTOGRAMA PINTAR LAS IMAGENES DE DIENTES CON SUS ESTADOS Y CARAS SELECCIONADAS
if($accionOdontograma == 'form_odont')
{

    //Consultar datos del odontograma actual
    function  fetchOdotogramaActual($idtratamiento) {

        if( $idtratamiento > 0 )
        {
            // alert($idtratamiento);
            $("#idtratamientolabel").attr('data-idtratamiento', $idtratamiento);

            $.ajax({
                url: $DOCUMENTO_URL_HTTP +'/application/system/pacientes/pacientes_admin/controller/controller_adm_paciente.php',
                type:'POST',
                data: {'ajaxSend':'ajaxSend', 'accion':'fecht_odontograma', 'idtratamiento':$idtratamiento, 'idpaciente': $id_paciente} ,
                dataType:'json',
                async:false,
                success:function(resp){

                    if(resp.error == "")
                    {
                        $dataOdontograma = resp.dataprincipal;

                        for( var i = 0; i<= resp.dataprincipal.length -1; i++ )
                        {
                            var obj = resp.dataprincipal[i];

                            var numeroDiente = obj.fk_diente;
                            var estadoPieza  = obj.fk_estado_pieza;

                            console.log(numeroDiente);

                            if($('.diente-'+numeroDiente).length > 0) //RECORRO LOS DIENTES ASIGNADO LAS CARAS SELECCIONADAS Y SU ESTADO
                            {
                                var $padre = $('.diente-'+numeroDiente);
                                var cara = $padre.find('.cara');
                                var jsoncaras = JSON.parse(obj.json_caras);
                                var estaImag = $padre.find('.dropbtn-diente'); //Para capturar la imagen
                                // console.log(jsoncaras.vestibular);
                                console.log(cara);

                                $.each(cara, function() {

                                    var label = $(this).data('id'); //el nombre de la cara

                                    if(label  == 'vestibular'){
                                        if(jsoncaras.vestibular == "true"){
                                            $(this).addClass('activeCara');
                                        }
                                    }
                                    if(label  == 'distal'){
                                        if(jsoncaras.distal == "true"){
                                            $(this).addClass('activeCara');
                                        }
                                    }
                                    if(label  == 'mesial'){
                                        if(jsoncaras.mesial == "true"){
                                            $(this).addClass('activeCara');
                                        }
                                    }
                                    if(label  == 'oclusal'){
                                        if(jsoncaras.oclusal == "true"){
                                            $(this).addClass('activeCara');
                                        }
                                    }
                                    if(label  == 'palatino'){
                                        if(jsoncaras.palatino == "true"){
                                            $(this).addClass('activeCara');
                                        }
                                    }
                                    if(label  == 'lingual'){
                                        if(jsoncaras.lingual == "true"){
                                            $(this).addClass('activeCara');
                                        }
                                    }

                                });

                                UpdatestatusDientes(parseInt(estadoPieza), numeroDiente, estaImag.find('img'));
                                console.log(estaImag.find('img'));
                                // console.log( $padre );
                            }
                        }

                        // console.log('data principal de odontograma');
                        // console.log($dataOdontograma);

                    }else{

                        notificacion(resp.error, 'error');
                    }

                    detallesOdontogramasEstados(); //detalles list estados
                }
            });

        }else{

            notificacion('Ocurrió un error inesperado , LA PAGINA SE RECARGARA EL SEGUNDOS ...', 'error');
        }
    }

    function UpdatestatusDientes( $estadodiente, pieza, $estaImagen  )
    {

        // alert($estadodiente);
        switch ($estadodiente){
            case 1: //lesión de caries
                var $label = 'lesión de caries';
                $estaImagen.attr('src', $DOCUMENTO_URL_HTTP + '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza'+pieza+'/'+$estadodiente+'.png')
                    .attr('title', $label)
                    .addClass('imgdiente')
                    .attr('data-idestado', $estadodiente);
                break;
            case 2: //Infección Pulpar
                var $label = 'Infección Pulpar';
                $estaImagen.attr('src', $DOCUMENTO_URL_HTTP + '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza'+pieza+'/'+$estadodiente+'.png')
                    .attr('title', $label)
                    .addClass('imgdiente')
                    .attr('data-idestado', $estadodiente);
                break;
            case 3: //Fractura
                var $label = 'Fractura'
                $estaImagen.attr('src', $DOCUMENTO_URL_HTTP + '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza'+pieza+'/'+$estadodiente+'.png')
                    .attr('title', $label)
                    .addClass('imgdiente')
                    .attr('data-idestado', $estadodiente);
                break;
            case 4: //Indicación de extracción
                var $label = 'Indicación de extracción';
                $estaImagen.attr('src', $DOCUMENTO_URL_HTTP + '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza'+pieza+'/'+$estadodiente+'.png')
                    .attr('title', $label)
                    .addClass('imgdiente')
                    .attr('data-idestado', $estadodiente);
                break;
            case 5: //Ausente
                var $label = 'Ausente';
                $estaImagen.attr('src', $DOCUMENTO_URL_HTTP + '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza'+pieza+'/'+$estadodiente+'.png')
                    .attr('title', $label)
                    .addClass('imgdiente')
                    .attr('data-idestado', $estadodiente);
                break;
            case 6: //Ausente
                var $label = 'Restauración';
                $estaImagen.attr('src', $DOCUMENTO_URL_HTTP + '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza'+pieza+'/'+$estadodiente+'.png')
                    .attr('title', $label)
                    .addClass('imgdiente')
                    .attr('data-idestado', $estadodiente);
                break;
            case 7: //Endodoncia
                var $label = 'Endodoncia';
                $estaImagen.attr('src', $DOCUMENTO_URL_HTTP + '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza'+pieza+'/'+$estadodiente+'.png')
                    .attr('title', $label)
                    .addClass('imgdiente')
                    .attr('data-idestado', $estadodiente);
                break;
            case 8: //Corona
                var $label = 'Corona';
                $estaImagen.attr('src', $DOCUMENTO_URL_HTTP + '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza'+pieza+'/'+$estadodiente+'.png')
                    .attr('title', $label)
                    .addClass('imgdiente')
                    .attr('data-idestado', $estadodiente);
                break;
            case 9: //Implante
                var $label = 'Implante';
                $estaImagen.attr('src', $DOCUMENTO_URL_HTTP + '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza'+pieza+'/'+$estadodiente+'.png')
                    .attr('title', $label)
                    .addClass('imgdiente')
                    .attr('data-idestado', $estadodiente);
                break;
            case 10: //Perno muñon
                var $label = 'Perno muñon';
                $estaImagen.attr('src', $DOCUMENTO_URL_HTTP + '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza'+pieza+'/'+$estadodiente+'.png')
                    .attr('title', $label)
                    .addClass('imgdiente')
                    .attr('data-idestado', $estadodiente);
                break;
            default:
                $estaImagen.attr('src', $DOCUMENTO_URL_HTTP + '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza'+pieza+'/pieza'+pieza+'-ai.png')
                    .removeAttr('data-idestado')
                    .removeAttr('title')
                    .removeClass('imgdiente');
                // alert(pieza);
                break;
        }
    }


    function pintarImgOdontogramaDiente($iddiente, $estaImagen, $estadodiente){

        switch ($iddiente)
        {
            case 18:
                console.log($estaImagen);
                UpdatestatusDientes($estadodiente, $iddiente, $estaImagen );
                break;
            case 17:
                console.log($estaImagen);
                UpdatestatusDientes($estadodiente, $iddiente, $estaImagen );
                break;
            case 16:
                console.log($estaImagen);
                UpdatestatusDientes($estadodiente, $iddiente, $estaImagen );
                break;
            case 15:
                console.log($estaImagen);
                UpdatestatusDientes($estadodiente, $iddiente, $estaImagen );
                break;
            case 14:
                console.log($estaImagen);
                UpdatestatusDientes($estadodiente, $iddiente, $estaImagen );
                break;
            case 13:
                console.log($estaImagen);
                UpdatestatusDientes($estadodiente, $iddiente, $estaImagen );
                break;
            case 12:
                console.log($estaImagen);
                UpdatestatusDientes($estadodiente, $iddiente, $estaImagen );
                break;
            case 11:
                console.log($estaImagen);
                UpdatestatusDientes($estadodiente, $iddiente, $estaImagen );
                break;
            case 21:
                console.log($estaImagen);
                UpdatestatusDientes($estadodiente, $iddiente, $estaImagen );
                break;
            case 22:
                console.log($estaImagen);
                UpdatestatusDientes($estadodiente, $iddiente, $estaImagen );
                break;
            case 23:
                console.log($estaImagen);
                UpdatestatusDientes($estadodiente, $iddiente, $estaImagen );
                break;
            case 24:
                console.log($estaImagen);
                UpdatestatusDientes($estadodiente, $iddiente, $estaImagen );
                break;
            case 25:
                console.log($estaImagen);
                UpdatestatusDientes($estadodiente, $iddiente, $estaImagen );
                break;
            case 26:
                console.log($estaImagen);
                UpdatestatusDientes($estadodiente, $iddiente, $estaImagen );
                break;
            case 27:
                console.log($estaImagen);
                UpdatestatusDientes($estadodiente, $iddiente, $estaImagen );
                break;
            case 28:
                console.log($estaImagen);
                UpdatestatusDientes($estadodiente, $iddiente, $estaImagen );
                break;


            case 48:
                console.log($estaImagen);
                UpdatestatusDientes($estadodiente, $iddiente, $estaImagen );
                break;
            case 47:
                console.log($estaImagen);
                UpdatestatusDientes($estadodiente, $iddiente, $estaImagen );
                break;
            case 46:
                console.log($estaImagen);
                UpdatestatusDientes($estadodiente, $iddiente, $estaImagen );
                break;
            case 45:
                console.log($estaImagen);
                UpdatestatusDientes($estadodiente, $iddiente, $estaImagen );
                break;
            case 44:
                console.log($estaImagen);
                UpdatestatusDientes($estadodiente, $iddiente, $estaImagen );
                break;
            case 43:
                console.log($estaImagen);
                UpdatestatusDientes($estadodiente, $iddiente, $estaImagen );
                break;
            case 42:
                console.log($estaImagen);
                UpdatestatusDientes($estadodiente, $iddiente, $estaImagen );
                break;
            case 41:
                console.log($estaImagen);
                UpdatestatusDientes($estadodiente, $iddiente, $estaImagen );
                break;
            case 31:
                console.log($estaImagen);
                UpdatestatusDientes($estadodiente, $iddiente, $estaImagen );
                break;
            case 32:
                console.log($estaImagen);
                UpdatestatusDientes($estadodiente, $iddiente, $estaImagen );
                break;
            case 33:
                console.log($estaImagen);
                UpdatestatusDientes($estadodiente, $iddiente, $estaImagen );
                break;
            case 34:
                console.log($estaImagen);
                UpdatestatusDientes($estadodiente, $iddiente, $estaImagen );
                break;
            case 35:
                console.log($estaImagen);
                UpdatestatusDientes($estadodiente, $iddiente, $estaImagen );
                break;
            case 36:
                console.log($estaImagen);
                UpdatestatusDientes($estadodiente, $iddiente, $estaImagen );
                break;
            case 37:
                console.log($estaImagen);
                UpdatestatusDientes($estadodiente, $iddiente, $estaImagen );
                break;
            case 38:
                console.log($estaImagen);
                UpdatestatusDientes($estadodiente, $iddiente, $estaImagen );
                break;

        }

        // if($iddiente == '18'){
        //     console.log($estaImagen);
        //     UpdatestatusDientes($estadodiente, $iddiente, $estaImagen );
        // }

    }


    //Muestra la lista de plan
//lista de estados por fecha comentario y hermiarcada pieza
    function  detallesOdontogramasEstados()
    {
        $("#detalles_estados_odontograma").DataTable({
            searching: false,
            ordering:false,
            destroy: true,
            // scrollY:    "200px",
            // paging:false,
            // scrollCollapse: true,
            ajax:{
                url: $DOCUMENTO_URL_HTTP + '/application/system/pacientes/pacientes_admin/controller/controller_adm_paciente.php',
                type:'POST',
                data:{'ajaxSend':'ajaxSend', 'accion':'list_detalles_odont_estados', 'idtratamiento': Get_jquery_odontogramPlantram(), 'idpaciente': $id_paciente },
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

    /**ACTUALIZAR ODONTOGRAMA ACTUAL ------------------------------------------------------------------------------------**/
    function fetch_diente_odontograma($html)
    {
        var pieza = [];

        //accedo al  padre directamente
        var $padre = $html.parents('.dientePermanente');
        var $numeroDiente  = $padre.data('diente'); //id del diente
        var btnImagen  = $padre.find('.dropbtn-diente');
        var imgdiente = btnImagen.find('img');
        //accedo al hijo directamento
        var estadosDiente  = $html; //item del menu de los estados del diente

        var CaraActiva = $padre.find('.activeCara');

        console.log(CaraActiva.length);
        // console.log(estadosDiente.data('id'));

        var i = 0;
        if(CaraActiva.length>0)
        {


            notificacion('Desea Actualizar el Odontograma ?', 'question');

            $(".swal2-confirm").click(function() {

                $('#UpdateInformacionCommentOdontograma').modal('show'); //Muestro el modal a Actualizar Informacion

                //Actualizo y Guardo Informacion
                //Si confirma entonces dice si

                var $puedopasar = 0; //para q no ejecute el mismo click varias veces
                // alert($puedopasar);
                $("#AceptarUpdateOdontogram").click(function() {

                    $puedopasar++;
                    if($puedopasar == 1 ){

                        var vestibular = 0;
                        var distal     = 0;
                        var palatino   = 0;
                        var oclusal    = 0;
                        var mesial     = 0;
                        var lingual    = 0;

                        var labelCarasactive = '';

                        CaraActiva.each(function() {

                            if($(this).data('id') == 'vestibular'){
                                vestibular++;

                                labelCarasactive += " " + $(this).data('id');
                            }
                            if($(this).data('id') == 'distal'){
                                distal++;

                                labelCarasactive += " " + $(this).data('id');
                            }
                            if($(this).data('id') == 'palatino'){
                                palatino++;

                                labelCarasactive += " " + $(this).data('id');
                            }
                            if($(this).data('id') == 'oclusal'){
                                oclusal++;

                                labelCarasactive += " " + $(this).data('id');
                            }
                            if($(this).data('id') == 'mesial'){
                                mesial++;

                                labelCarasactive += " " + $(this).data('id');
                            }
                            if($(this).data('id') == 'lingual'){
                                lingual++;
                                // alert(lingual);
                                labelCarasactive += " " + $(this).data('id');
                            }

                        });

                        pieza.push({
                            'diente' : $numeroDiente,
                            'caras' : {
                                'vestibular' : (vestibular > 0) ? true : false,
                                'distal'     : (distal > 0) ? true : false,
                                'palatino'   : (palatino > 0) ? true : false,
                                'oclusal'    : (oclusal > 0) ? true : false,
                                'mesial'     : (mesial > 0) ? true : false,
                                'lingual'    : (lingual > 0) ? true : false,
                            }
                        });

                        console.log(pieza);

                        var datoPiezas = pieza;
                        var fk_diente = $numeroDiente;
                        var fk_estadodiente = estadosDiente.data('id');
                        var fk_plantratamiento = Get_jquery_odontogramPlantram(); //OBTENGO EL ID DEL PLAN DE TRATAMIENTO
                        var Observacion = $('#observacionOpcional').val();

                        //nuevo Update Informacion
                        var error = nuevoUpdate_detalleOdontograma(fk_diente, datoPiezas[0].caras , fk_estadodiente, fk_plantratamiento, Observacion, labelCarasactive);

                        // var error =  true;
                        if(error == true){


                            //pinto el odontograma segun lo seleccionado
                            pintarImgOdontogramaDiente( $numeroDiente, imgdiente, estadosDiente.data('id') );

                            //Update Odontograma secuencial -esta funcion pinta el odontograma TODO LAS PIEZAS CONSTANTEMENTA CADA VES CON UN UPDATE HACIA CUANQUIER PIEZA
                            UpdateSeguidoOdontograma( fk_plantratamiento );

                            detallesOdontogramasEstados(); //reload los estado detalles del odontograma

                            $('#UpdateInformacionCommentOdontograma').modal('hide');

                            notificacion('Infomación Actualizada', 'success');

                        }else{

                            $('#UpdateInformacionCommentOdontograma').modal('hide');
                            notificacion('Ocurrió un problema con la Operción, consulte con soporte Técnico', 'error');

                        }
                    }

                });

            });

            i++;

        }else{
            notificacion('Debe seleccionar alguna cara', 'question');
        }

    }

    //nuevoUpdate Odontograma
    function nuevoUpdate_detalleOdontograma(fk_diente, $datosPiezas, fk_estadoDiente, fk_trataminto, observacion, labelCaras){

        var error = false;

        var inform = {
            'fk_diente'          :  fk_diente,
            'datosPiezas'        :  $datosPiezas,
            'fk_estadoDiente'    :  fk_estadoDiente,
            'fk_trataminto'      :  fk_trataminto,
            'observacion'        :  observacion,
            'labelCaras'         :  labelCaras,
        };

        $.ajax({
            url: $DOCUMENTO_URL_HTTP +'/application/system/pacientes/pacientes_admin/controller/controller_adm_paciente.php',
            type:'POST',
            data: { 'ajaxSend':'ajaxSend', 'accion':'nuevo_odontograma_detalle', 'info': inform } ,
            dataType:'json',
            async:false,
            success:function(resp) {

                if(resp.error == ''){
                    error = true;
                }else {
                    error = false;
                }
            }
        });

        return error;
    }

    //ACTUALIZAR ODONTOGRAMA SEGIDO -- SE ACTUALIZA EL ODONTOGRAMA SEGUIDO CADA VEZ QUE ACTUALIZO UNA PIEZA
    function UpdateSeguidoOdontograma(fk_plantratamiento,)
    {
        var $datos = fetchPiezasCaras();

        // alert(fk_plantratamiento);
        OdontogramaUpdate($datos, fk_plantratamiento);
        console.log('-------------------------------------');
        console.log($datos);
    }

    // obtengo la pieza y caras seleccionada
    function fetchPiezasCaras(){

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
            // var CaraActivada = diente.find('.cara'); //todas las caras

            var estadoDiente = diente.find('.imgdiente');

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
            /*
            if( $puedopasar > 0){
                piezas.push({
                    'diente': diente.data('diente'), //numero del diente
                    'estado_diente': estadoDiente.data('idestado'),
                    'caras' : {
                        'vestibular' : (vestibular > 0) ? true : false,
                        'distal'     : (distal > 0) ? true : false,
                        'palatino'   : (palatino > 0) ? true : false,
                        'oclusal'    : (oclusal > 0) ? true : false,
                        'mesial'     : (mesial > 0) ? true : false,
                        'lingual'    : (lingual > 0) ? true : false,
                    }
                });
            }*/

            piezas.push({
                'diente': diente.data('diente'), //numero del diente
                'estado_diente': ( (estadoDiente.data('idestado') == undefined) ? 0 : estadoDiente.data('idestado') ),
                'caras' : {
                    'vestibular' : (vestibular > 0) ? true : false,
                    'distal'     : (distal > 0) ? true : false,
                    'palatino'   : (palatino > 0) ? true : false,
                    'oclusal'    : (oclusal > 0) ? true : false,
                    'mesial'     : (mesial > 0) ? true : false,
                    'lingual'    : (lingual > 0) ? true : false,
                }
            });

            i++;

        });



        dataPrincipal = {
            'piezas' : piezas,
            'numeroCaras' : numeroCaras,
        };

        return dataPrincipal;
    }

    //Actualizo el Odontograma por cada Comportamiento al cambiar el estado
    function OdontogramaUpdate($datos, fk_tratamiento) {

        var $parametros = {
            'accion': 'odontograma_update',
            'ajaxSend': 'ajaxSend',
            'piezas': $datos,
            'fk_tratamiento': fk_tratamiento,
            'idpaciente': $id_paciente,

        };

        $.ajax({
            url: $DOCUMENTO_URL_HTTP +'/application/system/pacientes/pacientes_admin/controller/controller_adm_paciente.php',
            type:'POST',
            data: $parametros ,
            dataType:'json',
            async:false,
            success:function(resp){

                if(resp.error != ''){
                    notificacion('Ocurrió un error con la Operación , Odontograma Update, Consulte con soperte Técnico');
                }
            }
        });
    }


    //Información de Estados anular dinamico
    function anular_estado_update(id)
    {

        if(id != ""){
            $.ajax({
                url: $DOCUMENTO_URL_HTTP +'/application/system/pacientes/pacientes_admin/controller/controller_adm_paciente.php',
                type:'POST',
                data: {
                    'accion' : 'anular_estado_odontogramadet',
                    'ajaxSend':'ajaxSend',
                    'id': id,
                } ,
                dataType:'json',
                async:false,
                success:function(resp){

                    if(resp.error != ''){
                        notificacion(resp.error , 'error');
                    }else{
                        detallesOdontogramasEstados();
                    }
                }
            });
        }else{
            notificacion('error, no se pudo obtener los paramtros para la anulación consulte con soporte técnico', 'error');
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


}


