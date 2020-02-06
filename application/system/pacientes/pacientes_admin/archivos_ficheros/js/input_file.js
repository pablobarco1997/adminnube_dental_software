/*
	By Osvaldas Valutis, www.osvaldas.info
	Available for use under the MIT License
*/

'use strict';

;( function ( document, window, index )
{
    var inputs = document.querySelectorAll( '.inputfile' );
    Array.prototype.forEach.call( inputs, function( input )
    {
        var label	 = input.nextElementSibling,
            labelVal = label.innerHTML;

        input.addEventListener( 'change', function( e )
        {

            if( this.files.length > 1 )
            {
                notificacion('No puede seleccionar más de 1 fichero!', 'error');
                // this.files.value = '';
                this.value = null;

                var viewnone = document.getElementById('iconviewblock');
                viewnone.setAttribute('src', $DOCUMENTO_URL_HTTP + '/logos_icon/logo_default/file.png');
            }



            var fileName = '';
            if( this.files && this.files.length == 1 )
                fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
            else
                fileName = e.target.value.split( '\\' ).pop();

            if( fileName )
                label.querySelector( 'span' ).innerHTML = fileName;
            else
                label.innerHTML = labelVal;

            if(this.files.length == 1){

                var viewnone = document.getElementById('iconviewblock');
                // viewnone.setAttribute('src', this.files.);

                var src = '';
                var type = this.files[0].type;
                var puedo = 0;

                switch (type)
                {
                    case 'image/jpeg':

                        src = URL.createObjectURL( this.files[0] ); //convert url path data:url
                        puedo++;
                        break;

                    case 'image/png':

                        src = URL.createObjectURL( this.files[0] ); //convert url path data:url
                        puedo++;
                        break;

                    case 'application/pdf':

                        src = $DOCUMENTO_URL_HTTP + '/logos_icon/logo_default/pdf.png';
                        puedo++;
                        break;

                    default:

                        notificacion('Error, El sistema  no acepta este tipo de archivo: ' + this.files[0].name + ', consulte con soporte técnico'  , 'error');
                        viewnone.setAttribute('src', $DOCUMENTO_URL_HTTP + '/logos_icon/logo_default/file.png');
                        break;
                }

                if(puedo > 0){

                    viewnone.setAttribute('src', src);
                }
                // console.log(this.files[0].type);
                console.log(this.files);
            }

            if(this.files.length == 0){
                var viewnone = document.getElementById('iconviewblock');
                viewnone.setAttribute('src', $DOCUMENTO_URL_HTTP + '/logos_icon/logo_default/file.png');
            }


        });

        // Firefox bug fix
        input.addEventListener( 'focus', function(){ input.classList.add( 'has-focus' ); });
        input.addEventListener( 'blur', function(){ input.classList.remove( 'has-focus' ); });
    });
}( document, window, 0 ));