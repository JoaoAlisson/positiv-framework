function DigitaData(campo) {
    var data = new String( campo.value );
    var wData = '';
    var cont = 0;

    for (i=0; i<data.length ; i++) {
        if (i <= 1) {
            if ( data.charAt(i) >= '0' && data.charAt(i) <= '9' ) {
                wData += data.charAt(i);
            }
            else
            {
                cont++;
            }
        }
        if (i == 2) {
            if ( data.charAt(i) == '/' ) {
                wData += data.charAt(i);
            }
            else {
                if ( data.charAt(i) >= '0' && data.charAt(i) <= '9' ) {
                    wData += '/';
                    wData += data.charAt(i);
                    cont ++;
                }
                else {
                    wData += '/';
                    cont ++;
                }
            }
        }

        if (i > 2 && i <= 4) {
            if ( data.charAt(i) >= '0' && data.charAt(i) <= '9' ) {
                wData += data.charAt(i);
            }
            else
            {
                cont++;
            }
        }

        if (i == 5) {
            if ( data.charAt(i) == '/' ) {
                wData += data.charAt(i);
            }
            else {
                if ( data.charAt(i) >= '0' && data.charAt(i) <= '9' ) {
                    wData += '/';
                    wData += data.charAt(i);
                    cont++;
                }
                else {
                    wData += '/';
                    cont++;
                }
            }
        }

        if (i > 5 && i <= 9) {
            if ( data.charAt(i) >= '0' && data.charAt(i) <= '9' ) {
                wData += data.charAt(i);
            }
            else
            {
                cont++;
            }
        }

        if (i > 9 )
        {
            cont++;
        }
    }

    if ( cont > 0 ){
        // Atualiza o campo
        campo.value = wData;
    }
}

function pegaEmail(){
	document.formCadCurriculo.email2.defaultValue = document.formCadCurriculo.email.value;
}

function x() {  
   document.formCadCurriculo.nivelIdiomaItaliano.disabled = 1;
}





