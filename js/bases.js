basesListadoBases = Array();

function agregaestabase(id)
{
	if($("#bdcheckbd" + id).is(":checked"))
	{
		var encontrado = false;
		for(i=0; i<basesListadoBases.length; i++)
		{
			if(basesListadoBases[i] == id)
				encontrado = true;
		}
		if(!encontrado)
			basesListadoBases.push(id);
	}
	else
	{
		for(i=0; i<basesListadoBases.length; i++)
		{
			if(basesListadoBases[i] == id)
				basesListadoBases.splice(i, 1);
		}
	}
	basesListadoBases.sort();
}

function bdaccionescargarbd(accion)
{
	switch(accion)
	{
		case 1:
			bdaccionDescargar();
		break;
		case 2:

		break;
		case 3:
			bdaccionEliminar();
		break;
	}
}

function bdaccionDescargar()
{
	var list = JSON.stringify(basesListadoBases);
	var ajaxData = {
		"data" : "descargabases",
		"lista" : list
	};
	$.ajax({
		type: "GET",
		url: "controladorajax.php",
		async: false,
		data: ajaxData,
		success: function(data){
			var link=document.createElement('a');
			document.body.appendChild(link);
			link.href=data;
			link.click();
		}
	});
}

function bdaccionEliminar()
{
	var list = JSON.stringify(basesListadoBases);
	var ajaxData = {
		"data" : "eliminabases",
		"lista" : list
	};
	$.ajax({
		type: "GET",
		url: "controladorajax.php",
		async: false,
		data: ajaxData,
		success: function(data){
			openlightbox(0, data);
			recargaTablaBDs();
		}
	});
}

function buscarbddesdetexto()
{
	var tabla = "";
	var ajaxData = {
		"data" : "buscarUnaBase",
		"nombre" : $("#buscarbd").val()
	};
	
	$.ajax({
		type: "GET",
		url: "controladorajax.php",
		data: ajaxData,
		success: function(data){
			data = $.parseJSON(data);
			tabla += "<table class='col-xs-12 miborde grisoscuro'>" +
	  					"<tr>" +
	  						"<td class='col-xs-1 mi-padding-11px'>" +
	  							"<div class='col-xs-10'><i class='fa fa-users'></i></div>"+
	  						"</td>" +
	  						"<td>" +
	  							"CARGAR BASE" +
	  						"</td>" +
	  					"</tr>";
	  					for(i=0; i<data.length; i++)
	  					{
	  						tabla += "<tr class='miborde grisoscuro'>";
							tabla += "<td class='mi-padding-11px col-xs-2'>";
							tabla += "	<div class='pull-left'><input onclick='agregaestabase("+ data[i][0] +")' type='checkbox' name='bdcheckbd"+ data[i][0] +"' id='bdcheckbd"+ data[i][0] +"'>"+ data[i][1] +"</div>";
							tabla += "</td>";
							tabla += "<td>";
							tabla += "	<div class='pull-right margin-right-15px'>"+ data[i][2] +"</div>";
							tabla += "</td>";
							tabla += "</tr>";
	  					}
	  		tabla += "</div>";
	  		$("#mipanel-tabla-bases").html(tabla);
		}
	});
}

function cambiaPasoBase(opcion)
{
	$("#cargarb1").removeClass("active");
	$("#cargarb2").removeClass("active");
	$("#cargarb3").removeClass("active");
	$("#cargarb" + opcion).addClass("active");
	$("#panel-ocultar-bd1").css("display", "none");
	$("#panel-ocultar-bd2").css("display", "none");
	$("#panel-ocultar-bd3").css("display", "none");
	$("#panel-ocultar-bd" + opcion).css("display", "block");
}

function limpiafilesubir()
{
	$("#archivo1").val("");
	muestrafile2();
}

function muestrafile2()
{
	var name = $("#archivo1").val().split('\\').pop();
	var ext = $("#archivo1").val().split('.').pop();
	if($("#archivo1").val() != "")
	{
		if(ext == "csv")
		{
			$("#nombrebaseexaminar").html(name);
			$("#checkBDSeleccionada").removeClass("fa-times");
			$("#checkBDSeleccionada").removeClass("fa-danger");
			$("#checkBDSeleccionada").addClass("fa-check");
			$("#checkBDSeleccionada").addClass("fa-success");
			$("#botonlimpiarbasesubir").toggle();
		}
		else
			openlightbox(0, "Suba su base de datos en formato 'CSV'");
	}
	else
	{
		$("#nombrebaseexaminar").html("Cargar base");
		$("#checkBDSeleccionada").addClass("fa-times");
		$("#checkBDSeleccionada").addClass("fa-danger");
		$("#checkBDSeleccionada").removeClass("fa-check");
		$("#checkBDSeleccionada").removeClass("fa-success");
		$("#botonlimpiarbasesubir").toggle();
	}
}

function recargaTablaBDs()
{
	var tabla = "";
	var ajaxData = {
		"data" : "getlistas"
	};
	$.ajax({
		type: "GET",
		url: "controladorajax.php",
		data: ajaxData,
		success: function(data){
			data = $.parseJSON(data);
			tabla += "<table class='col-xs-12 miborde grisoscuro'>" +
	  					"<tr>" +
	  						"<td class='col-xs-1 mi-padding-11px'>" +
	  							"<div class='col-xs-10'><i class='fa fa-users'></i></div>"+
	  						"</td>" +
	  						"<td>" +
	  							"CARGAR BASE" +
	  						"</td>" +
	  					"</tr>";
	  					for(i=0; i<data.length; i++)
	  					{
	  						tabla += "<tr class='miborde grisoscuro'>";
							tabla += "<td class='mi-padding-11px col-xs-2'>";
							tabla += "	<div class='pull-left'><input onclick='agregaestabase("+ data[i][0] +")' type='checkbox' name='bdcheckbd"+ data[i][0] +"' id='bdcheckbd"+ data[i][0] +"'>"+ data[i][1] +"</div>";
							tabla += "</td>";
							tabla += "<td>";
							tabla += "	<div class='pull-right margin-right-15px'>"+ data[i][2] +"</div>";
							tabla += "</td>";
							tabla += "</tr>";
	  					}
	  		tabla += "</div>";
	  		$("#mipanel-tabla-bases").html(tabla);
		}
	});
}

function textoInputBuscarBDFocusOn()
{
	if($("#buscarbd").val() == "BUSCAR")
		$("#buscarbd").val("");
}

function textoInputBuscarBDFocusOff()
{
	if($("#buscarbd").val() == "")
		$("#buscarbd").val("BUSCAR");
}
