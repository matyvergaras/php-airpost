var cuentacampos = 0;
var listacampos = [];
var nombreArchivo = "";
var active = "inicio";
var listaenviar = "";
var disenoenviar = "";
var campanaenviar = "";
var listasEnviar = [];
var contactosCargados = 0;
var contactosErroneos = 0;
var dataAjax = "";
var basesCampana = [];
var editorHTML = "";

function activaCheckLightbox()
{
	if(basesCampana.length > 0)
	{
		$("#checkCampanasSeleccionadasLightbox").removeClass("fa-danger");
		$("#checkCampanasSeleccionadasLightbox").removeClass("fa-times");
		$("#checkCampanasSeleccionadasLightbox").addClass("fa-success");
		$("#checkCampanasSeleccionadasLightbox").addClass("fa-check");
	}
	else
	{
		$("#checkCampanasSeleccionadasLightbox").addClass("fa-danger");
		$("#checkCampanasSeleccionadasLightbox").addClass("fa-times");
		$("#checkCampanasSeleccionadasLightbox").removeClass("fa-success");
		$("#checkCampanasSeleccionadasLightbox").removeClass("fa-check");
	}
}

function activaChecks()
{
	contactosCargados = 0;
	contactosErroneos = 0;
	for(i=0; i<basesCampana.length; i++)
	{
		$.ajax({
			url: "controladorajax.php?data=contactoslistaporestado&id=" + basesCampana[i],
			async: false,
			success: function(data){
				data = $.parseJSON(data);
				contactosErroneos += parseInt(data[0]);
				contactosCargados += parseInt(data[1]);
				if(contactosErroneos%1!=0)
					contactosErroneos = 0;
				if(contactosCargados%1!=0)
					contactosCargados = 0;
			}
		});
		
	}
	renewContactos();
	
	if(basesCampana.length > 0 && contactosCargados > 0)
	{
		$("#checkCampanasSeleccionadas").removeClass("fa-times");
		$("#checkCampanasSeleccionadas").removeClass("fa-danger");
		$("#checkCampanasSeleccionadas").addClass("fa-check");
		$("#checkCampanasSeleccionadas").addClass("fa-success");
		$("#checkCampanasSeleccionadas2").removeClass("fa-times");
		$("#checkCampanasSeleccionadas2").removeClass("fa-danger");
		$("#checkCampanasSeleccionadas2").addClass("fa-check");
		$("#checkCampanasSeleccionadas2").addClass("fa-success");
		$("#textoListaSeleccionada").html("Lista seleccionadas");
	}
	else
	{
		$("#checkCampanasSeleccionadas").removeClass("fa-check");
		$("#checkCampanasSeleccionadas").removeClass("fa-success");
		$("#checkCampanasSeleccionadas").addClass("fa-times");
		$("#checkCampanasSeleccionadas").addClass("fa-danger");
		$("#checkCampanasSeleccionadas2").removeClass("fa-check");
		$("#checkCampanasSeleccionadas2").removeClass("fa-success");
		$("#checkCampanasSeleccionadas2").addClass("fa-times");
		$("#checkCampanasSeleccionadas2").addClass("fa-danger");
		$("#textoListaSeleccionada").html("No hay lista seleccionada...");
		$("#cargarc2").prop("onclick", "cambiaPaso(2)");
		$("#cargarc2").addClass("desactivado");
	}
}

function agregaBaseEnviar(id, efecto)
{
	if($("#seleccione" + id).is(":checked"))
	{
		var encontrado = false;
		for(i=0; i<basesCampana.length; i++)
		{
			if(basesCampana[i] == id)
				encontrado = true;
		}
		if(!encontrado)
			basesCampana.push(id);
	}
	else
	{
		for(i=0; i<basesCampana.length; i++)
		{
			if(basesCampana[i] == id)
				basesCampana.splice(i, 1);
		}
	}
	basesCampana.sort();
	if(efecto)
		activaCheckLightbox();
}

function agregaCampo()
{
	if($('#nombrecampo').val() != '')
	{
		if(cuentacampos < 12)
		{
			$('#campos-lightbox').append('<div id="campo' + cuentacampos + '" class="campos" onclick="eliminacampo(' + cuentacampos + ')">' + $('#nombrecampo').val() + '</div>');
			listacampos[cuentacampos] = $('#nombrecampo').val();
			cuentacampos += 1;
			$("#nombrecampo").val("");
		}
		else
		{
			$("#nombrecampo").val("");
			openlightbox(0, "Haz llegado al limite máximo de 12 campos por lista");
		}
	}
	else
	{
		openlightbox(0, "Debes ingresar un nombre para el campo");
	}
	activaCheckLightbox();
}

function alertas(mensaje)
{
	var alertar = "<div id='fondo-alertas' class='col-xs-12'></div>";
	$("#lightbox-content-mensaje").html(alertar);
	$("#fondo-alertas").html(mensaje);
}
function barraCarga(porcentaje)
{
	$("#barracargaanimar1").css("width", porcentaje + "%");
}

function cambiaActive(sitio)
{
	active = sitio;
}

function cambiaCantidadContactos()
{
	$.ajax({
	        url: "controladorajax.php?data=correctos",
	        type: "get",
	      })
	        .done(function(data){
	        	if(parseInt(data) < 0)
	        	{
	        		openlightbox(0, "La lista no se encuentra registrada");
	        		$("#cargados").html(0);
	        	}
	        	else
	        	{
	        		$("#cargados").html(data);
	        	}
	        	$("#totalenviar").html(parseInt($("#cargados").html()) - parseInt($("#nocargados").html()));
	        });
}

function cargarBase()
{
	$.get('controladorajax.php?data=lightbox&tipodata=base', function(data){
		$('#light').html(data);
		document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block';
	});
}

function cambiadiseno()
{
	disenoenviar = $("#disenos").val();
}

function cambiaMenuActivo(botonMenu)
{
	$("#linkGetInicio").removeClass("active");
	$("#linkGetCampana").removeClass("active");
	$("#linkReporteCampana").removeClass("active");
	$("#linkBases").removeClass("active");
	$("#linkCazador").removeClass("active");
	$("#linkSms").removeClass("active");
	$("#linkPlantillas").removeClass("active");
	botonMenu.addClass("active");
}

function cambiaPagina(indice)
{
	$.get('controladorajax.php?data=construyecampana&link='+indice, function(data){
		$('#panelCentralUsoGeneal').html(data);
		switch(indice)
		{
			case 2:
				cambiaMenuActivo($("#linkGetCampana"));
				renewContactos();
				basesCampana = Array();
				construyeTablaBlue();
			break;
			case 3:
				cambiaMenuActivo($("#linkReporteCampana"));
			break;
			case 4:
				cambiaMenuActivo($("#linkBases"));
			break;
			case 5:
				cambiaMenuActivo($("#linkCazador"));
			break;
			case 6:
				cambiaMenuActivo($("#linkSms"));
			break;
			case 7:
				cambiaMenuActivo($("#linkPlantillas"));
			break;
		}
	});
}

function cambiaPaso(idPaso)
{
	$("#cargarc1").removeClass("active");
	$("#cargarc2").removeClass("active");
	$("#cargarc3").removeClass("active");
	$("#cargarc" + idPaso).addClass("active");
	$("#cargarpaso1").css("display", "none");
	$("#cargarpaso2").css("display", "none");
	$("#cargarpaso3").css("display", "none");
	$("#cargarpaso" + idPaso).css("display", "block");
	$("#cargarpaso" + idPaso).addClass("active");
	$("#cargarc" + idPaso).attr("onclick", "cambiaPaso(" + idPaso + ")");
	if(idPaso == 2)
	{
		$('#editorhtml').sceditor({
			plugins: 'hxtml',
			style: '../latest/minified/jquery.sceditor.default.min.css',
			locale: 'es'
		});
	}
}

function cambiaRadiosOpcionesEnvio(radio)
{
	if(radio == 1)
	{
		$("#opcionenvio1").css("color", "black");
		$("#opcionenvio2").css("color", "gray");
		$("#opcionenvio3").css("color", "gray");
		$("#horasenvio").attr("disabled", true);
		$("#calendario").attr("disabled", true);
	}
	else if(radio == 2)
	{
		$("#opcionenvio2").css("color", "black");
		$("#opcionenvio1").css("color", "gray");
		$("#opcionenvio3").css("color", "gray");
		$("#horasenvio").attr("disabled", false);
		$("#calendario").attr("disabled", true);
	}
	else if(radio == 3)
	{
		$("#opcionenvio3").css("color", "black");
		$("#opcionenvio1").css("color", "gray");
		$("#opcionenvio2").css("color", "gray");
		$("#horasenvio").attr("disabled", true);
		$("#calendario").attr("disabled", false);
		$("#calendario").attr("readonly", true);
	}
}

function cargaDiseno()
{
	$.get('controladorajax.php?data=lightbox&tipodata=enviar', function(data){
		$('#light').html(data);
		document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block';
		var now = new Date();
		var anio = now.getFullYear();
		var mes = now.getMonth();
		var dia = now.getDate();
		$.get("controladorajax.php?data=nombrelista&id=" + listaenviar, function(data){
			$("#listaenviar").val(data);
		});
		$.get("controladorajax.php?data=nombrediseno&id=" + disenoenviar, function(data){
			$("#disenoenviar").val(data);
		});
		$("#calendario").datepicker({
			minDate: new Date(anio + '/' + (mes+1) + '/' + (dia+1)),
			maxDate: new Date(anio + '/' + (mes+7) + '/' + (dia+1))
		});
	});
}

function mostrarhtml()
{
	editorHTML = $('#editorhtml').sceditor('instance').val();
	alert(editorHTML);
	
}

function cargaListas(idLista)
{
	var largo = listasEnviar.length;
	var pos = -1;
	var hacer = false;

	if($("#" + idLista).is(":checked"))
	{
		listasEnviar[largo] = idLista;
		hacer = true;
	}
	else
	{
		for(i=0; i<largo; i++)
		{
			if(listasEnviar[i] == idLista)
				pos = i;
		}

		if(pos > -1)
		{
			listasEnviar.splice(pos, 1);
			hacer = false;
		}
	}
	
	activaChecks(idLista, hacer);
}

function cargaListasTabla()
{
	$("#tablaListas").append("<td><div id='textoListaSeleccionada'>No hay lista seleccionada...</div></td>" +
                              			  "<td class='text-right'>" +
                              	          "<div class='manitolink' onclick='traelistas()'><fa class='fa fa-search'></fa> Buscar</div>" +
                              			  "</td>");
	$("#tablaListas").removeClass("table table-striped");
	$("#tablaListas").addClass("table table-striped");

	closelightbox();
}

function cierraFade()
{
	$('#light').html('');
	document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none';
	cuentacampos = 0;
	if(active == "campana")
	{
		recargaListas();
	}
}

function closelightbox()
{
	if($("#lightbox").css("display") == "block")
		$("#lightbox").toggle();
	if($("#lightbox-content").css("display") == "block")
		$("#lightbox-content").toggle();
	if($("#lightbox-content-mensaje").css("display") == "block")
		$("#lightbox-content-mensaje").toggle();
}

function contactosLista()
{
	$.get("controladorajax.php?data=contactoslista&id=" + $("#miscampanasselect").val(), function(data){
		$("#miscontactoslista").val($("#miscontactoslista").html() + data);
	});
}

function consultaNombreLista(id)
{
	var nombre = "";
	
	$.ajax({
		url: "controladorajax.php?data=nombrelista&id=" + id,
		type: "GET",
		async: false,
		success: function(data){
			nombre = data;
		}
	});
	return nombre;
}

function construyeTablaBlue()
{
	var tabla = "";
	tabla += "<div class='panel-heading'>" +
                    "<i class='fa fa-users'></i> CARGAR BASE" +
                "</div>" +
				"<table class='table table-striped' id='tablaListas'>" +
                  	"<tbody>" +
                  		"<tr>" +
	                      	"<td><div id='nombrebasesubir'>Subir base</div></td>" +
	                      	"<td class='text-right'>" +
		                      	"<div style='display:none;'>" +
		                      		"<input type='file' name='archivo1' id='archivo1' onchange='muestrafile()'>"+
		                      	"</div>" +
	                        	"<fa class='fa fa-folder-open'></fa> <label class='manitolink textoPesoLiviano' for='archivo1'>Examinar" +
	                      	"</td>" +
                    	"</tr>" +
                  		"<tr>" +
                      		"<td><div id='textoListaSeleccionada'>No hay lista seleccionada...</div></td>"+
                      		"<td class='text-right'>" +
                      			"<div class='manitolink' onclick='traelistas()'><fa class='fa fa-search'></fa> Buscar</div>" +
                      		"</td>" +
                    	"</tr>";
                    	for(i=0; i<basesCampana.length; i++)
                    	{
                    		if(i%2==0)
                    			tabla += "<tr> <td class='table-blue-light'>" + consultaNombreLista(basesCampana[i]) + "</td> <td class='table-blue-light'><input class='pull-right' type='checkbox' onclick='return false' checked='checked'></td> </tr>";
                    		else
                    			tabla += "<tr> <td class='table-blue-dark'>" + consultaNombreLista(basesCampana[i]) + "</td> <td class='table-blue-dark'><input class='pull-right' type='checkbox' onclick='return false' checked='checked'></td> </tr>";
                    	}
                    tabla += "</tbody>" +
                "</table>";
    tabla += "<div class='panel-footer'>" +
              	"<a class='btn btn-primary btn-highlight-nopadding pull-left' onclick='openlightbox(2)'>" +
                	"<i class='fa fa-minus fa-minus-mine'></i>" +
              	"</a>" +
              	"<a class='btn btn-primary btn-highlight-nopadding pull-left' onclick='openlightbox(1)'>" +
                	"<i class='fa fa-plus fa-plus-mine'></i>" +
              	"</a>" +	

              	"<a class='btn btn-primary btn-highlight pull-right'>" +
                	"<i id='checkCampanasSeleccionadas' class='fa fa-times fa-danger'></i> Seleccionar" +
              	"</a>" +
            "</div>";
    $("#replace-table-blue").html(tabla);
    closelightbox();
    activaChecks();
}

function eliminacampo(pos)
{
	if(listacampos.length > 0)
	{
		$("#campo" + pos).remove();
		cuentacampos -= 1;

		for(i=0; i<listacampos.length; i++)
		{
			 if(i > pos)
			 {
			 	listacampos[i - 1] = listacampos[i];
			 }
		}
		listacampos.pop();
		
		for(i=(pos+1); i<listacampos.length+1; i++)
		{
			$("#campo" + i).attr("onclick","eliminacampo(" + (i-1) + ")");
			$("#campo" + i).attr("id","campo" + (i-1));
		}

		/*
		
		*/
		var algo = "";
		for(i=0; i<listacampos.length; i++)
		{
			algo += listacampos[i] + "<br>";
		}
	}
	else
	{
		openlightbox(0, "Ya no quedan campos para eliminar");
	}
}

function eliminaListasTable()
{
	if(basesCampana.length > 0)
	{
		var tabla = "<table class='col-xs-12' id='tablaListasLightbox'>" +
	                    "<tbody>";
	                tabla += "<tr>" +
	                			"<td class='table-blue-dark texto-blanco'>" +
	                				"<div class='col-xs-1 fondo-iconos-azul'>" +
	                					"<i class='fa fa-users padding-table centrarX-div'></i>" +
	                				"</div>" +
	                				"<div class='col-xs-10 padding-top-table-blue'>CARGAR BASE</div>" +
	                			"</td>" +
	                		 "</tr>";    
	                    for(i=0; i<basesCampana.length; i++)
					    {
					    	if(i%2==0)
					    	{
					    		tabla += "<tr>" +
					    					"<td class='table-blue-light texto-blanco padding-elements-table-blue'>" +
					    						"<div class='manitolink textoPesoLiviano col-xs-11'>" + consultaNombreLista(basesCampana[i]) + "</div>" +
					    						"<div class='col-xs-1'><input type='checkbox' checked='checked' name='seleccione" + basesCampana[i] + "' id='seleccione" + basesCampana[i] + "' onclick='agregaBaseEnviar(" + basesCampana[i] + ", false)'></div>" +
					    					"</td>" +
					    				"</tr>";
					    	}
					    	else
					    	{
					    		tabla += "<tr>" +
					    					"<td class='table-blue-dark texto-blanco padding-elements-table-blue'>" +
					    						"<div class='manitolink textoPesoLiviano col-xs-11'>" + consultaNombreLista(basesCampana[i]) + "</div>" +
					    						"<div class='col-xs-1'><input type='checkbox' checked='checked' name='seleccione" + basesCampana[i] + "' id='seleccione" + basesCampana[i] + "' onclick='agregaBaseEnviar(" + basesCampana[i] + ", false)'></div>" +
					    					"</td>" +
					    				"</tr>";
					    	}
					    }
					    tabla+="</tbody>" +
	                "</table>";
	    tabla += "<div class='col-xs-12 no-padding'>" +
	    			"<a class='btn btn-primary btn-highlight pull-right' onclick='construyeTablaBlue()'>" +
	                    "<i id='checkCampanasSeleccionadasLightbox' class='fa fa-check fa-success'></i> Seleccionar" +
	                "</a>" +
	    		 "</div>";            
		$("#lightbox-content").html(tabla);
		$("#lightbox-content").addClass("col-sm-4 no-padding");
	}
	else
		openlightbox(0, "No hay bases seleccionadas");
}

function generaKeyCazador()
{
	$.get("controladorajax.php?data=generaKeyCazador", function(data){
		$("#panel-naranjo-body").html(data);
	});
}

function getBDPage()
{
	cambiaPaso(1);
}

function getDesignPage()
{
	cambiaPaso(2);
}

function getSendPage()
{
	cambiaPaso(3);
}

function getListasJsonToTable()
{
	$.get("controladorajax.php?data=getlistasjson", function(data){
		data = $.parseJSON(data);

		var tabla = "<table class='col-xs-12' id='tablaListasLightbox'>" +
                        "<tbody>";
                    tabla += "<tr>" +
                    			"<td class='table-blue-dark texto-blanco'>" +
                    				"<div class='col-xs-1 fondo-iconos-azul'>" +
                    					"<i class='fa fa-users padding-table centrarX-div'></i>" +
                    				"</div>" +
                    				"<div class='col-xs-10 padding-top-table-blue'>CARGAR BASE</div>" +
                    			"</td>" +
                    		 "</tr>";    
	                    for(i=0; i<data.length; i++)
					    {
					    	if(i%2==0)
					    	{
					    		tabla += "<tr>" +
					    					"<td class='table-blue-light texto-blanco padding-elements-table-blue'>" +
					    						"<div class='manitolink textoPesoLiviano col-xs-11'>" + data[i][1] + "</div>" +
					    						"<div class='col-xs-1'><input type='checkbox' name='seleccione" + data[i][0] + "' id='seleccione" + data[i][0] + "' onclick='agregaBaseEnviar(" + data[i][0] + ", true)'></div>" +
					    					"</td>" +
					    				"</tr>";
					    	}
					    	else
					    	{
					    		tabla += "<tr>" +
					    					"<td class='table-blue-dark texto-blanco padding-elements-table-blue'>" +
					    						"<div class='manitolink textoPesoLiviano col-xs-11'>" + data[i][1] + "</div>" +
					    						"<div class='col-xs-1'><input type='checkbox' name='seleccione" + data[i][0] + "' id='seleccione" + data[i][0] + "' onclick='agregaBaseEnviar(" + data[i][0] + ", true)'></div>" +
					    					"</td>" +
					    				"</tr>";
					    	}
					    }
					    tabla+="</tbody>" +
                    "</table>";
        tabla += "<div class='col-xs-12 no-padding'>" +
        			"<a class='btn btn-primary btn-highlight pull-right' onclick='construyeTablaBlue()'>" +
                        "<i id='checkCampanasSeleccionadasLightbox' class='fa fa-times fa-danger'></i> Seleccionar" +
                    "</a>" +
        		 "</div>";            
		$("#lightbox-content").html(tabla);
		$("#lightbox-content").addClass("col-lg-4 no-padding");
	});
}

function  guardacampana()
{
	var fecha = "";
	if($("#inmediatamente").is(":checked"))
	{
		fecha = "inmediatamente";
	}
	else if($("#horas").is(":checked"))
	{
		fecha = $("#horasenvio").val();
	}
	else if($("#fecha").is(":checked"))
	{
		fecha = $("#calendario").val();
	}
	$.get("controladorajax.php?data=guardacampana&nombre=" + window.btoa($("#nombrecampana").val()) + "&fecha=" + fecha + "&lista=" + listaenviar + "&diseno=" + disenoenviar, function(data){
		openlightbox(0, data);
	});
}

function limpiaArreglo()
{
	cuentacampos = 0;
	listacampos = [];
	nombreArchivo = "";
}

function limpiaCampaña()
{
	listaenviar = "";
	campanaenviar = "";
}

function llamarPaso1()
{
	var url = "controladorajax.php?data=guardacampana";
	$.get(url, function(data){
		openlightbox(0, data);
	});
}

function llamarPaso2()
{
	listaenviar = $("#listas").val();
	$.get("controladorajax.php?data=paso2", function(data){
		$("#derecha").html(data);
	});
}

function llamarPaso3()
{
	disenoenviar = $("#disenos").val();
	$.get("controladorajax.php?data=paso3", function(data){
		$("#derecha").html(data);
		var now = new Date();
		var anio = now.getFullYear();
		var mes = now.getMonth();
		var dia = now.getDate();
		$.get("controladorajax.php?data=nombrelista&id=" + listaenviar, function(data){
			$("#listaenviar").val(data);
		});
		$.get("controladorajax.php?data=nombrediseno&id=" + disenoenviar, function(data){
			$("#disenoenviar").val(data);
		});
		$("#calendario").datepicker({
			minDate: new Date(anio + '/' + (mes+1) + '/' + (dia+1)),
			maxDate: new Date(anio + '/' + (mes+7) + '/' + (dia+1))
		});
	});
}

function miAjax(url)
{
	$.get(url, function(data){
		if(data == "login")
			location.href = "php/home.php";
		else
		{
			$("#errores").css("display", "block");
			$("#errores").html(data);
		}
	});
}

function misCampanas()
{
	$.get("controladorajax.php?data=miscampanas", function(data){
		$("#miscampanas").html($("#miscampanas").html() + data);
		contactos();
	});
}

function muestrafile()
{
	/*var name = $("#archivo1").val().split('\\').pop();
	var ext = $("#archivo1").val().split('.').pop();
	if($("#archivo1").val() != "")
	{
		if(ext == "csv")
			$("#nombrebasesubir").html(name);
		else
			openlightbox(0, "Suba su base de datos en formato 'CSV'");
	}
	else
		$("#nombrebasesubir").html("Cargar base");¨*/
}

function openlightbox(option, mensaje)
{
	$("#lightbox").toggle();
	if(option !=0 )
		$("#lightbox-content").toggle();
	switch(option)
	{
		case 0:
			$("#lightbox-content-mensaje").toggle();
		break;
		case 1:
			getListasJsonToTable();
		break;
		case 2:
			eliminaListasTable();
		break;
	}
}

function resetea()
{
	limpiaArreglo();
	limpiaCampaña();
}

function recargaListas()
{
	$.get('controladorajax.php?data=recargalistas', function(data){
		$('#selectListas').html(data);
	});
}

function recuperar()
{
	var correo = $("#txtCorreo").val();
	$.get('home/controladorajax.php?data=recuperar&correo=' + correo, function(data){
		alert(data);
	});
}

function renewContactos()
{
	$("#cantidadContactosCorrectos").html(parseInt(contactosCargados));
	$("#cantidadContactosErroneos").html(parseInt(contactosErroneos));
	
	if(contactosCargados > 0)
	{
		$("#totalContactosEnviar").removeClass("fa-times");
		$("#totalContactosEnviar").removeClass("fa-danger");
		$("#totalContactosEnviar").addClass("fa-check");
		$("#totalContactosEnviar").addClass("fa-success");
		$("#step1confirm").removeClass("desactivado");
		$("#step1confirm").attr("onclick", "getDesignPage()");
		$("#cargarc2").removeClass("desactivado");
	}
	else
	{
		$("#totalContactosEnviar").removeClass("fa-check");
		$("#totalContactosEnviar").removeClass("fa-success");
		$("#totalContactosEnviar").addClass("fa-times");
		$("#totalContactosEnviar").addClass("fa-danger");
		$("#step1confirm").addClass("desactivado");
		$("#step1confirm").prop("onclick", null);
		$("#cargarg").addClass("desactivado");
		total = 0;
	}
	$("#cantidadContactosEnviar").html(parseInt(contactosCargados));
}

function solicitud()
{
	var nombre = $("#txtNombre").val();
	var apellido = $("#txtApellido").val();
	var correo = $("#txtCorreo").val();
	var telefono = $("#txtTelefono").val();
	var empresa = $("#txtEmpresa").val();
	var cargo = $("#txtCargo").val();
	var pagina = $("#txtPagina").val();
	var contactos = $("#txtContactos").val();
	var pais = $("#cmbPais").val();
	var formas = $("#cmbFormas").val();
	$.get('home/controladorajax.php?data=solicitud&nombre='+nombre+'&apellido='+apellido+'&correo='+correo+'&telefono='+telefono+'&empresa='+empresa+'&cargo='+cargo+'&pagina='+pagina+'&contactos='+contactos+'&pais='+pais+'&contactos='+contactos+'&formas='+formas, function(data){
		alert(data);
	});
}

function subearchivo()
{
	if($("#txtNombreLista").val() == "")
	{
		openlightbox(0, "Debe ingresar un nombre para su lista");
	}
	else if($("#archivo1").val() == "")
	{
		openlightbox(0, "Debe seleccionar un archivo");
	}
	else
	{
		nombreArchivo = $('#archivo1').val();
		document.getElementById('light_cargando').style.display='block';document.getElementById('fade_cargando').style.display='block';
		$(".black_overlay").css("opacity","0");
		$(".black_overlay").css("-moz-opacity","0");
		$(".black_overlay").css("filter","alpha(opacity=0)");
		var f = $(this);
	    var formData = new FormData();
	    formData.append("archivo1", $("#archivo1").prop("files")[0]);
	    
		$.ajax({
	        url: "recibe.php",
	        type: "post",
	        data: formData,
	        cache: false,
	        contentType: false,
	 		processData: false,
	 		async: true
	    })
	        .done(function(res){
	        	alert("subido");
	        	$.get("controladorajax.php?data=idlista&archivo=" + nombreArchivo, function(data){
	        		listaenviar = data;
	        		alert(listaenviar);
	        	});
	        	document.getElementById('light_cargando').style.display='none';document.getElementById('fade_cargando').style.display='none';
	        	$(".black_overlay").css("opacity","0.80");
				$(".black_overlay").css("-moz-opacity","0.8");
				$(".black_overlay").css("filter","alpha(opacity=80)");
	        	
	            if(res == "Lista guardada")
	            {
	            	$.get('controladorajax.php?data=lightbox&tipodata=base', function(data){
						$('#light').html(data);
					});
					if(listacampos.length > 0)
		        	{
		        		var jsonString = JSON.stringify(listacampos);
		        		$.get('controladorajax.php?data=lightbox&tipodata=arreglo&arreglo=' + jsonString + '&archivo=' + nombreArchivo + '&lista=' + $("#txtNombreLista").val(), function(data){
							//alertas(data);
						});
		        	}
		        	else
		        	{
		        		$.get('controladorajax.php?data=lightbox&tipodata=cambionombre&archivo=' + nombreArchivo + '&lista=' + $("#txtNombreLista").val(), function(data){
							//alertas(data);
						});
		        	}
		        	limpiaArreglo();    
		        }
				openlightbox(0, res);
	        });
	}
}

function subegraphic()
{
	var formData = new FormData();
	formData.append("archivo2", $("#archivo2").prop("files")[0]);
	
	$.ajax({
        url: "subegraphic.php",
        type: "post",
        data: formData,
        cache: false,
        contentType: false,
 		processData: false,
 		async: true
    })
    	.done(
    		function(data)
    		{
    			alert(data);
    		}
    	);
    	
}

function traeCamapana()
{
	resetea();
	$.get('controladorajax.php?data=paso1', function(data){
		$('#derecha').html(data);
	});
	cambiaActive("campana");
}

function traelistas()
{
	/*$.get("controladorajax.php?data=listasusuario", function(data){
		openlightbox();
		var tablaMostrar = "<div class='container'>" + 
                  			"<div class='row'>" +
                    		"<div class='col-sm-4 col-sm-offset-4'>";
		tablaMostrar += "<div class='panel panel-default panel-blue'>" + 
                        	"<div class='panel-heading height-auto'>" + 
                          	"<i class='fa fa-users pull-left'></i> CARGAR BASE" +
                         	"</div>";
		tablaMostrar += "<table class='table table-striped'>";
		tablaMostrar += "<tbody>";
		tablaMostrar += data;
		tablaMostrar += "</tbody>";
		tablaMostrar += "</table>";
		tablaMostrar += "<a class='btn btn-primary btn-highlight pull-right'>" +
                        "<div id='botonSeleccionarListasLightbox' onclick='cargaListasTabla()'><i id='checkCampanasSeleccionadas2' class='fa fa-times fa-danger'></i> Seleccionar</div>" +
                        "</a>";
		tablaMostrar += "</div>";
		tablaMostrar += "</div>";
		tablaMostrar += "</div>";
		tablaMostrar += "</div>";
		$("#lightbox-content").html(tablaMostrar);
		dataAjax = data;
	});*/
	openlightbox(1);
}

function validaLogeo()
{
	if($("#txtRutLogin").val() == "" || $("#txtClaveLogin").val() == "")
		alert("Debe completar todos los campos");
	else
	{
		var url = "home/entrar.php?" +
		"accion=2&" +
		"rut=" + $.base64.encode($("#txtRutLogin").val()) + "&" +
		"clave=" + $.base64.encode($("#txtClaveLogin").val());
		miAjax(url);
	}
}

function validaRegistro()
{
	if($("#txtRut").val() == "" || $("#txtNombre").val() == "" || $("#txtApellido").val() == "" || $("#txtCorreo").val() == "" || $("#txtClave").val() == "" || $("#txtRClave").val() == "")
		alert("Debe completar todos los campos");
	else
	{
		if($("#txtClave").val() != $("#txtRClave").val())
			alert("Las claves no coinciden");
		else
		{
			var url = "home/entrar.php?" +
			"accion=1&" + 
			"txtRut=" + $.base64.encode($("#txtRut").val()) + "&" +
			"txtNombre=" + $.base64.encode($("#txtNombre").val()) + "&" +
			"txtApellido=" + $.base64.encode($("#txtApellido").val()) + "&" +
			"txtCorreo=" + $.base64.encode($("#txtCorreo").val()) + "&" +
			"txtClave=" + $.base64.encode($("#txtClave").val()) + "&" +
			"txtRClave=" + $.base64.encode($("#txtRClave").val());
			miAjax(url);
		}
	}
}




