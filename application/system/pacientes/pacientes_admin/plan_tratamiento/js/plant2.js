

//CUANDO LA PLANFORM

if($accion == 'addplan')
{






}

if($accion == "principal")
{



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

                    if(respuesta.acierto > 0){ //DATOS ACTUALIZADOS
                        $('#confirm_eliminar_plantram').modal('hide');
                        notificacion('Información Actualizada', 'success');
                        listplaneTratamiento();

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
}