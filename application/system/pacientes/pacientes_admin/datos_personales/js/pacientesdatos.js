
//OBTENER DATOS DE INFORMACION DEL PACIENTE
function obtenerDatosP($id)
{

    $.ajax({
        url: $DOCUMENTO_URL_HTTP +'/application/system/pacientes/pacientes_admin/controller/controller_adm_paciente.php',
        type:'POST',
        data: {'accion':'fetchPaciente','ajaxSend':'ajaxSend', 'id':$id},
        dataType:'json',
        async:false,
        // contentType: false,
        // processData: false,
        success:function(resp) {


            if(resp['error'] == '')
            {

                var data = resp['data'];

                $('#nombre').val(data['nombre']);
                $('#apellido').val(data['apellido']);
                $('#rud_dni').val(data['rut_dni']);
                $('#email').val(data['email']);
                $('#convenio').val(data['fk_convenio']).trigger('change');
                $('#n_interno').val(data['numero_interno']);
                $('#sexo').val(data['sexo']).trigger('change');
                $('#fech_nacimit').val(data['fecha_nacimiento']);
                $('#ciudad').val(data['fk_ciudad']);
                $('#comuna').val(data['comuna']);
                $('#direcc').val(data['direccion']);
                $('#t_fijo').val(data['telefono_fijo']);
                $('#t_movil').val(data['telefono_movil']);
                $('#act_profec').val(data['actividad_profecion']);
                $('#empleado').val(data['empleador']);
                $('#obsrv').val(data['observacion']);
                $('#apoderado').val(data['apoderado']);
                $('#refer').val(data['referencia']);

                if($.trim( data['icon'] ) != ""){

                    $('#fileIcon').css('display',  'none');

                    var img = document.createElement('img'); //creo el elmento img
                    img.setAttribute('width', '140px'); //agrego attr y css
                    img.setAttribute('height', '140px'); //agrego setAttribute y css
                    img.setAttribute('class', 'iconpaciente'); //agrego setAttribute y css
                    img.classList.add('img-circle'); //agrego setAttribute y css

                    //$HTTP_DIRECTORIO_ENTITY esta variable global de js contiene el directorio si alguna vez fue creado
                    img.setAttribute('src', $DOCUMENTO_URL_HTTP + '/logos_icon/' + $HTTP_DIRECTORIO_ENTITY + '/' + data['icon']);
                    $('#imgpaciente').append(img);

                }else{

                }

                console.log(data);

                document.getElementById('tituloInfo').scrollIntoView(); //me recorre hacia ese id

            }

            if(resp['error'] != '')
            {
                notificacion(resp['error'], 'question');
            }

            // alert(resp['data']);

        }

    });
}

//SUBIDA DE ICONO DEL PACIENTE
$('#file_icon').change(function(e){

    // var img = '<img src="" class="img-circle img-md img-sm" class="img-circle" width="107.16px" height="140px">';
    var $padre = $(this).parents('#imgpaciente');

    var fontIcon = $padre.find('#fileIcon');
    var Icon = $padre.find('#file_icon');

    if(Icon.val() != '') //cuando tenga valores
    {

        var iconpaciente = $padre.find(".iconpaciente");

        if(iconpaciente.length >0){
            iconpaciente.remove();
        }

        fontIcon.css('display', 'none');
        var img = document.createElement('img'); //creo el elmento img
        img.setAttribute('width', '140px'); //agrego attr y css
        img.setAttribute('height', '140px'); //agrego setAttribute y css
        img.setAttribute('class', 'iconpaciente'); //agrego setAttribute y css
        img.classList.add('img-circle'); //agrego setAttribute y css
        $padre.append(img); //lo agrego dentro del padre

        var iconpaciente = $padre.find(".iconpaciente");

        //compruebo si existe ese elemento
        if(iconpaciente.length > 0){

            console.log(this.files);
            SubirImagenes( this , iconpaciente , '');

            //si aparecece un mensaje de error entonces se ejecuta la funcion regresar
            if($('.swal2-show').length > 0 ){
                invalic_Icon_default();
            }

        }else{

        }

    }else{

        invalic_Icon_default();
    }

    function  invalic_Icon_default(){

        var iconpaciente =  $padre.find('.iconpaciente');

        if(iconpaciente.length > 0){
            iconpaciente.remove();
        }

        fontIcon.css('display', 'block');
        Icon.val('');

    }

});

//UPDATE PACIENTES FORM_DATOPS_PACIENTE
$('#form_update_paciente').submit(function(e) {

    e.preventDefault();


    var formulario = $('#form_update_paciente');
    var form = new FormData(formulario[0]);
    form.append('ajaxSend','ajaxSend');
    form.append('accion','updatePaciente');
    form.append('id', $id_paciente);


    $.ajax({

        url: $DOCUMENTO_URL_HTTP +'/application/system/pacientes/pacientes_admin/controller/controller_adm_paciente.php',
        type:'POST',
        data: form,
        dataType:'json',
        async: false,
        contentType: false,
        processData: false,
        success:function(resp)
        {
            if (resp.error == '')
            {
                notificacion("Informcaión Actualizada", "success");

                location.reload(true);
                document.getElementById('tituloInfo').scrollIntoView(); //me recorre hacia ese id

            }else{

                notificacion(resp.error, 'error');
            }
        }

    });

    // alert($id_paciente);

});


//EXECUTE   ------------------------------------------------------------------------------------------------------------
obtenerDatosP($id_paciente);