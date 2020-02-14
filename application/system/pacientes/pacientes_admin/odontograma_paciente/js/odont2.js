

//Obetner id Plan de tratamiento GET desde jquery
function Get_jquery_odontogramPlantram()
{
    let paramsGet = new URLSearchParams(location.search);
    var idplantratamiento = paramsGet.get('idplantram');

    return idplantratamiento;
}

// alert(Get_jquery_odontogramPlantram());
//EXECUTE FUNCION
fetchOdotogramaActual( Get_jquery_odontogramPlantram() ); //obtengo y pinto el estado del diente
// alert($accionOdontograma);
if( $accionOdontograma == "form_odont") //ACTUALIZAR ODONTOGRAMA FORMULARIO ODONTOGRAMA
{
    loaddingDom.addClass('cargando');
    loaddingload_XMLHttpRequest(loaddingDom);
    $(window).ready(function() {
        loaddingDom.removeClass('cargando');
    });
}