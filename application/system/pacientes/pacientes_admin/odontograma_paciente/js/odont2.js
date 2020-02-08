

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