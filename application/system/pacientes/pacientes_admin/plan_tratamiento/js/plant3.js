
/** JAVASCRIP DE PRESTACION REALIZADA **/

//REALIZAR PRESTACION -----------------------
function  realizarPrestacionModal($Dom)
{
    var idcabplantram = 0;
    var iddetplantram = 0;
    var iddiente      = 0;

    var padre = $Dom.parents('.detalleListaInsert');

    // alert( padre.find('.dientePieza').data('iddiente') );
    //si no hat diente asociado a la prestacion no se puede selecionar un estado con la evolucion
    if(parseInt(padre.find('.dientePieza').data('iddiente')) ==  0)
    {
        $('#actualizarOdontogramaPlantform').addClass('disabled_link3');

    }else{
        $('#actualizarOdontogramaPlantform').removeClass('disabled_link3');
    }

    //limpias el modal de realizar prestacion
    $('#evolucionDoct').val(null).trigger('change');
    $('#actualizarOdontogramaPlantform').val(null).trigger('change');
    $('#descripEvolucion').val(null);


    idcabplantram = $ID_PLAN_TRATAMIENTO;
    iddetplantram = padre.find('.statusdet').data('iddet');
    iddiente      = padre.find('.dientePieza').data('iddiente');

    //se ejecuta un attr onclick para crear la evolucion
    $('#RealizarPrestacion').attr('onclick', 'RealizarPrestacionDetallePLantram('+idcabplantram+','+iddetplantram+','+iddiente+')');

}

//REALIZA LA PRESTACION
function RealizarPrestacionDetallePLantram(idcabplantram, iddetplantram, iddiente)
{

    $.ajax({
        url: $DOCUMENTO_URL_HTTP +'/application/system/pacientes/pacientes_admin/controller/controller_adm_paciente.php',
        type:'POST',
        data: {
            'ajaxSend': 'ajaxSend',
            'accion':'realizarPrestacion',
            'idcabplantram' : idcabplantram,
            'iddetplantram' : iddetplantram,
            'iddiente' : iddiente , //esta opcion puede ser 0
            'idpaciente' : $id_paciente,

            'fk_doct'        : $('#evolucionDoct').find(':selected').val() ,
            'observacion'    : $('#descripEvolucion').val() ,
            'fk_estadodiente': ($('#actualizarOdontogramaPlantform').find(':selected').val() == "") ? 0 : $('#actualizarOdontogramaPlantform').find(':selected').val()
        },
        dataType: 'json',
        async: false,
        success: function(resp) {

            console.log(resp);

            if(resp.error == ""){

                notificacion('Información Actualizada' + resp.tieneOdontograma  , 'success');
                fetch_plantratamiento('consultar'); //Obtengo lso datos plan de tratamiento

                $('#modal_prestacion_realizada').modal('hide');

            }else{

            }

        }
    });

}

//ELIMINAR PRESTACION
//ELIMINAR ESTADO DE LA PRESTACION
function UpdateDeletePrestacionAsignada(html)
{
    var padre      = html.parents('.detalleListaInsert');
    var status     = padre.find('.statusdet');
    var iddetplant = status.data('iddet');

    //Prestacion realizada
    if( status.data('estadodet')  == 'R' )
    {
        notificacion('Esta prestación se encuentra en estado realizado no se puede Eliminar', 'error');
    }

    //pendiente o activo
    if( status.data('estadodet') == 'A')
    {
        $('#modDeletePrestacion').modal('show');
        $('#AceptarDeletePrestacion').attr('onclick', 'DeletePrestacion('+iddetplant+')');
    }

}

// alert($ID_PLAN_TRATAMIENTO);

function DeletePrestacion(iddetplant)
{

    $.ajax({
        url: $DOCUMENTO_URL_HTTP +'/application/system/pacientes/pacientes_admin/controller/controller_adm_paciente.php',
        type:'POST',
        data: {
            'ajaxSend': 'ajaxSend',
            'accion' : 'eliminar_prestacion_plantram' ,
            'iddetplantram' : iddetplant,
            'idplanCab'  : $ID_PLAN_TRATAMIENTO,
            'idpaciente' : $id_paciente,
        },
        dataType: 'json',
        async: false,
        success: function(resp)
        {
            if( resp.error == ''){

                notificacion('Información Actualizada', 'success');
                fetch_plantratamiento('consultar');

            }else{

                notificacion(resp.error , 'error');
            }
        }
    });

}