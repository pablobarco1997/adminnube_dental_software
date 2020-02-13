
function autocomplete(inp, arr)
{
    /*the autocomplete function takes two arguments,
    the text field element and an array of possible autocompleted values:*/
    var currentFocus;
    /*execute a function when someone writes in the text field:*/
    inp.addEventListener("input", function(e) {
        var a, b, i, val = this.value;
        /*close any already open lists of autocompleted values*/
        closeAllLists();
        if (!val) { return false;}
        currentFocus = -1;
        /*create a DIV element that will contain the items (values):*/
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        /*append the DIV element as a child of the autocomplete container:*/
        this.parentNode.appendChild(a);
        /*for each item in the array...*/
        for (i = 0; i < arr.length; i++) {
            /*check if the item starts with the same letters as the text field value:*/
            if (arr[i]['nomb'].substr(0, val.length).toUpperCase() == val.toUpperCase()) {

                var idPaciente = arr[i]['id'];
                /*create a DIV element for each matching element:*/
                b = document.createElement("DIV");
                b.setAttribute('data-id', arr[i]['id']);
                b.setAttribute('onclick', "valoresPacientes("+idPaciente+")");
                b.setAttribute('onkeypress', "valoresPacientes("+idPaciente+")");

                /*make the matching letters bold:*/
                b.innerHTML = "<strong>" + arr[i]['nomb'].substr(0, val.length) + "</strong>";
                b.innerHTML += arr[i]['nomb'].substr(val.length);
                /*insert a input field that will hold the current array item's value:*/
                b.innerHTML += "<input  data-id='"+arr[i]['id']+"' type='hidden' value='" + arr[i]['nomb'] + "'>";
                /*execute a function when someone clicks on the item value (DIV element):*/
                b.addEventListener("click", function(e) {
                    /*insert the value for the autocomplete text field:*/
                    inp.value = this.getElementsByTagName("input")[0].value;
                    /*close the list of autocompleted values,
                    (or any other open lists of autocompleted values:*/
                    closeAllLists();
                });
                a.appendChild(b);
            }
        }
    });
    /*execute a function presses a key on the keyboard:*/
    inp.addEventListener("keydown", function(e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {
            /*If the arrow DOWN key is pressed,
            increase the currentFocus variable:*/
            currentFocus++;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 38) { //up
            /*If the arrow UP key is pressed,
            decrease the currentFocus variable:*/
            currentFocus--;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 13) {
            /*If the ENTER key is pressed, prevent the form from being submitted,*/
            e.preventDefault();
            if (currentFocus > -1) {
                /*and simulate a click on the "active" item:*/
                if (x) x[currentFocus].click();
            }
        }
    });
    function addActive(x) {
        /*a function to classify an item as "active":*/
        if (!x) return false;
        /*start by removing the "active" class on all items:*/
        removeActive(x);
        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = (x.length - 1);
        /*add class "autocomplete-active":*/
        x[currentFocus].classList.add("autocomplete-active");
    }
    function removeActive(x) {
        /*a function to remove the "active" class from all autocomplete items:*/
        for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
        }
    }
    function closeAllLists(elmnt) {
        /*close all autocomplete lists in the document,
        except the one passed as an argument:*/
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }
    /*execute a function when someone clicks in the document:*/
    document.addEventListener("click", function (e) {
        closeAllLists(e.target);
    });
}

/*An array containing all the country names in the world:*/
// var countries = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia & Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre & Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","St Kitts & Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad & Tobago","Tunisia","Turkey","Turkmenistan","Turks & Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];

/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/

function InputSearcheIndex_1(inputText)
{
    var paciente = ObtenerPacienteslistaSearch();
    console.log(paciente);
    autocomplete(inputText, paciente);
}

function ObtenerPacienteslistaSearch()
{
    var data = [];
    $.ajax({
        url:  $DOCUMENTO_URL_HTTP + '/application/system/pacientes/directorio_paciente/controller/directorio_paciente_controller.php',
        type:'POST',
        data:{'ajaxSend':'ajaxSend', 'accion':'ObtenerPacienteslistaSearch'},
        dataType:'json',
        async:false,
        success:function(resp) {

            if( resp.length > 0)
            {
                data = resp
            }
        }
    });

    return data;
}

function valoresPacientes(id)
{
    $('#pacien').text(id);
}



$('#buscarPaciente').on('click', function() {

    var $id =  $('#pacien').text();
    if($id!="" && $('#myInput').val() !="")
    {
        var $url = $DOCUMENTO_URL_HTTP + '/application/system/pacientes/admin_paciente/?view=form_datos_personales&id='+$id;
        // alert($url);
        location.href = $url;
    }

});

function notificacion(mensage, accion)
{
    var label = "";

    if(accion == "error")
    {
        label="Error!";
    }
    if(accion == "success")
    {
        label="Exito!";
    }
    if(accion == "question")
    {
        label = "Información";
    }
    if(accion == "warning")
    {
        label = "Advertencia";
    }

    Swal.fire(label, mensage, accion);

}

//CARGAR LOGO E GUARDAR INFOMACION COMPLETA DE LA EMPRESA
$("#subirLogo").change(function(event){

    console.log(this.files);
    SubirImagenes( this, $("#imgLogo"), $DOCUMENTO_URL_HTTP + '/logos_icon/logo_default/icon_software_dental.png');

});

function SubirImagenes(Este,imageid,url)
{
    // var file     = event.target.files[0]; //Img
    var file = Este.files[0];

    if( Este.files.length > 0)
    {
        var preview = imageid;
        var reader   = new FileReader();

        // console.log(preview);
        var puede = false;

        // var image = file["type"].substr(0,5); //solo imagenes
        var image = file.type; //solo imagenes

        if(image == "image/png")
        {
            reader.onloadend = function(){
                preview.attr("src", reader.result);
            };

            if( Este.files.length > 0){     reader.readAsDataURL( Este.files[0] ); }


        }else{
            notificacion("Error de Fichero, Solo admite Ficheros tipo imagenes .png", "error");
        }

        // console.log(file);

    }else{
        imageid.attr("src", url );
    }

    return file;
}

//Modal informacion citas
function ObtenerInformacionNotificaion(html, $id)
{
    var $padre = html.parents('.notificacion_list');
    var nombre = $padre.find('#notifi_nombre');

    $("#modalnotifi_nombre").text(nombre.data('nomb'));
    $("#modalnotifi_horario").text(nombre.data('hora'));
    $("#modalnotifi_observacion").text(nombre.data('coment'));

    console.log($padre);
}

// MASKARA BLOBAL DE MONEY
$('.mask').maskMoney({precision:2,thousands:'', decimal:'.',allowZero:true,allowNegative:true, defaultZero:true,allowEmpty: true});
// $(document).ajaxStart(function() { Pace.restart(); });

//Update Informacion Entidad
$("#Update_entidad").click(function() {

    var form = new FormData();
    var input = document.getElementById('subirLogo');

    // console.log(input.files[0]);
    form.append('accion',   'UpdateEntidad');
    form.append('ajaxSend', 'ajaxSend');

    form.append('nombre'    , $("#entidad_clinica").val());
    form.append('pais'      , $("#entidad_pais").val() );
    form.append('ciudad'    , $("#entidad_ciudad").val() );
    form.append('direccion' , $("#entidad_direccion").val() );
    form.append('telefono'  , $("#entidad_telefono").val());
    form.append('celular'   , $("#entidad_celular").val());
    form.append('email'     , $("#entidad_email").val());
    form.append('logo'      , input.files[0]);

    //configuracion de email para envios de correo
    form.append('conf_emil'      ,     $("#conf_email_entidad").val());
    form.append('conf_password'      , $("#conf_password_entidad").val());

    $.ajax({
        url:  $DOCUMENTO_URL_HTTP + '/application/controllers/controller_peticiones_globales.php',
        type:'POST',
        data: form,
        dataType:'json',
        async:false,
        contentType: false,
        processData:false,
        success:function(resp) {

            if(resp.error == 1)
            {
                location.reload();
            }
        }
    });

});

//recarga la pagina con f5
function reloadPagina(){
    setTimeout(function() {
        location.reload(true);
    },1000)
}

//redondear decimales glob
function redondear(numero, decimales = 2, usarComa = false) {
    var opciones = {
        maximumFractionDigits: decimales,
        useGrouping: false
    };
    usarComa = usarComa ? "es" : "en";
    return new Intl.NumberFormat(usarComa, opciones).format(numero);
}