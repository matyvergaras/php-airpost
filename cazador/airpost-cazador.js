var airpost_cazador_mostrado_cazador = 0;
var airpost_cazador_codigo_insertado = 0;
var fileref=document.createElement("link")
fileref.setAttribute("rel", "stylesheet")
fileref.setAttribute("type", "text/css")
fileref.setAttribute("href", "http://localhost/airpost/cazador/airpost-cazador.css")

document.getElementsByTagName("head")[0].appendChild(fileref);

var airpost_cazador_codigoHTML = "<div id='airpost-cazador-light' class='airpost-cazador-white_content'></div>";
airpost_cazador_codigoHTML += "<div id='airpost-cazador-fade' class='airpost-cazador-black_overlay' onclick='cierraFade()'></div>";
airpost_cazador_codigoHTML += "<div id='airpost-cazador-light_mensaje' class='airpost-cazador-white_content'>";
airpost_cazador_codigoHTML += "Ingresa tu correo<input type='text' name='airpostCazadorMail' id='airpostCazadorMail'>";
airpost_cazador_codigoHTML += "<input type='button' name='airpostCazadorRecibeMail' id='airpostCazadorRecibeMail' value='Suscribirte' onclick='airpost_cazador_registra_correo()'>";
airpost_cazador_codigoHTML += "</div>";
airpost_cazador_codigoHTML += "<div id='airpost-cazador-fade_mensaje' class='airpost-cazador-black_overlay'></div>";	

document.onmousemove = function(e){
	var airpost_cazador_cursorX = e.pageX;
	var airpost_cazador_cursorY = e.pageY;
    if(airpost_cazador_cursorY <= 100)
    {
    	if(airpost_cazador_mostrado_cazador == 0)
    	{
    		document.getElementById('airpost-cazador-light_mensaje').style.display='block';
    		document.getElementById('airpost-cazador-fade_mensaje').style.display='block';
    		airpost_cazador_mostrado_cazador = 1;
    	}
    }
    insertaCodigo();
}

function insertaCodigo()
{
	if(airpost_cazador_codigo_insertado == 0)
	{
		document.getElementsByTagName("body")[0].innerHTML += airpost_cazador_codigoHTML;
		document.getElementById("airpost-cazador-fade_mensaje").addEventListener("click", airpost_cazador_cierraFade);
		airpost_cazador_codigo_insertado = 1;
	}
}

function airpost_cazador_cierraFade()
{
	document.getElementById('airpost-cazador-light_mensaje').style.display='none';
    document.getElementById('airpost-cazador-fade_mensaje').style.display='none';
}

function airpost_cazador_registra_correo()
{
	var mailRecibidoPorAirpostCazador = document.getElementById('airpostCazadorMail').value;
	if(airpost_cazador_validarEmail(mailRecibidoPorAirpostCazador))
	{
		var xhttp = new XMLHttpRequest();
	  	xhttp.onreadystatechange = function() {
		    if (xhttp.readyState == 4 && xhttp.status == 200) {
		    	alert(xhttp.responseText);
		    }
	  	};
	  	
		xhttp.open("GET", "http://localhost/airpost/home/controladorajax.php?data=airpost-cazador-mail&airpostCazadorMail=" + mailRecibidoPorAirpostCazador+"&airpost_cazador_public_key="+airpost_cazador_public_key+"&airpost_cazador_public_validation="+airpost_cazador_public_validation, true);
		xhttp.send();
	}
	else
	{
		alert("Ingrese un correo v\u00E1lido");
	}
}

function airpost_cazador_validarEmail( email ) 
{
    airpost_cazador_expr_cazador = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !airpost_cazador_expr_cazador.test(email) )
        return false;
    else
    	return true;
}
	
	
    
