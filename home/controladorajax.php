<?php
	require_once('pais.php');
	require_once('enterarse.php');
	require_once('lista.php');
	require_once('diseno.php');
	require_once('campana.php');
	require_once('correo.php');
	require_once('cuenta.php');
	require_once('construye.php');
	require_once('cazador.php');
	if(isset($_GET["data"]))
	{
		$data = $_GET["data"];
		switch($data)
		{
			case "airpost-cazador-mail":
				$key = $_GET["airpost_cazador_public_key"];
				$cuenta = new Cuenta();
				$cuenta->setCorreo($_GET["airpost_cazador_public_validation"]);
				$cuenta = $cuenta->buscaUnaPorCorreoEncriptado();
				if($cuenta != null)
				{
					$cazador = new Cazador();
					$cazador->setCuenta($cuenta->getCorreo());
					if($cazador->retornaKey() != "")
					{
						$correo = $_GET["airpostCazadorMail"];
						$cazador->setRecibido($correo);
						if($cazador->insertaCorreoCazador())
							echo "insertado";
						else
							echo "noinsertado";
					}
					else
					{
						echo "key invalida";
					}
				}
				else
				{
					echo "Clave de validación incorrecta";
				}
			break;
			case "buscarUnaBase":
				session_start();
				$listas = new Lista();
				$listas->setCorreo($_SESSION["correo"]);
				echo $listas->buscarTablaPorLike($_GET["nombre"]);
			break;
			case "descargabases":
				session_start();
				$lista = new Lista();
				echo $lista->descargaBases($_GET["lista"]);
			break;
			case "correctos":
				$cuenta = new Cuenta();
				$cuenta->setCorreo($_SESSION["correo"]);
				echo $cuenta->totalCorrectos();
			break;
			case "construyecampana":
				$build = new Construye();
				switch($_GET["link"])
				{
					case 2:
						echo $build->campaign();
					break;
					case 3:

					break;
					case 4:
						echo $build->bases();
					break;
					case 5:
						echo $build->cazador();
					break;
					case 6:

					break;
					case 7:

					break;
				}
			break;
			case "contactoslista":
				$listas = new Lista();
				echo $listas->contactosLista($_GET["id"]);
			break;
			case "contactoslistaporestado":
				$listas = new Lista();
				echo json_encode($listas->consutaContactosListaPorEstado($_GET["id"]));
			break;
			case "eliminabases":
				session_start();
				$listas = new Lista();
				$listas->setCorreo($_SESSION["correo"]);
				echo $listas->eliminaBases($_GET["lista"]);
			break;
			case "erroneos":
				$cuenta = new Cuenta();
				$cuenta->setCorreo($_SESSION["correo"]);
				echo $cuenta->totalErroneos();
			break;
			case "formas":
				$formas = new Enterarse();
				echo $formas->buscaFormasSelect();
			break;
			case "generaKeyCazador":
				session_start();
				$cazador = new Cazador();
				$cazador->setCuenta($_SESSION["correo"]);
				$key = $cazador->revisaKey();
				if($key >= 0)
				{
					$key++;
					$cazador->actualizaGeneradas($key);
					$key = $cazador->generaKeyCazador($key);
					if($key == "Error de registro de clave")
					{
						echo "Se produjo un error al generar la clave. Por favor contáctese con soporte";
					}
					else if($key == "generadas <0")
					{
						echo "mal numero generadas";
					}
					else
					{
						echo $key;
						$build = new Construye();
						echo $build->generada($key);
					}
				}
				else
				{
					echo "Generadas: ".$key;
				}
			break;
			case "getlistas":
				session_start();
				$listas = new Lista();
				$listas->setCorreo($_SESSION["correo"]);
				echo $listas->listasToArray();
			break;
			case "getlistasjson":
				session_start();
				$lista = new Lista();
				$lista->setCorreo($_SESSION["correo"]);
				echo $lista->consultaListaToJson();
			break;
			case "guardacampana":
				session_start();
				$nombre = $_GET["nombre"];
				$fecha = $_GET["fecha"];
				$lista = $_GET["lista"];
				$diseno = $_GET["diseno"];
				$campana = new Campana();
				$campana->setNombre(base64_decode(utf8_decode($nombre)));
				$campana->setCorreo($_SESSION["correo"]);
				$campana->setFechaenvio($fecha);
				$campana->setLista($lista);
				$campana->setDiseno($diseno);
				if($campana->insertaCampana())
				{
					$id = $campana->buscaId();
					echo "Su campanaña se ha registrado y se será enviada según las preferencias que usted seleccionó";
					$cuenta = new Cuenta();
					$cuenta->setCorreo($campana->getCorreo());
					$cuenta = $cuenta->buscaUnaPorCorreo();
					$correo = new Correo();
					$correo->setCorreo($campana->getCorreo());
					$correo->setEmpresa($cuenta->getNombre());
					$correo->setAsunto("Probando correo");
					$correo->setLista($campana->getLista());
					$correo->setCampana($id);
					$correo->enviaCampana();
					$campana->marcaEnviada();
				}
				else
				{
					echo "Error al intentar registrar su campaña, por favor intente nuevamente. Si el problema persiste contáctese con soporte";
				}
			break;
			case "idlista":
				session_start();
				$listas = new Lista();
				echo $listas->consultaIdLista($_SESSION["correo"], $_GET["archivo"]);
			break;
			case "listasusuario":
				session_start();
				$listas = new Lista();
				echo json_encode($listas->listasToTable());
			break;
			case "miscampanas":
				session_start();
				$campana = new Campana();
				$campanas = $campana->buscaCampanas($_SESSION["correo"]);
				echo "<select name='miscampanasselect' id='miscampanasselect' onchange='contactos()'>";
				for($i=0; $i<count($campanas); $i++)
				{
					$campaign = $campanas[$i];
					echo "<option value='".$campaign->getId()."'>".$campaign->getNombre()."</option>";
				}
				echo "</select>";
			break;
			case "nombrediseno":
				$diseno = new Diseno();
				echo utf8_encode($diseno->consultaNombreDiseno($_GET["id"]));
			break;
			case "nombrelista":
				$listas = new Lista();
				echo utf8_encode($listas->consultaNombreLista($_GET["id"]));
			break;
			case "paises":
				$pais = new Pais();
				echo $pais->buscaPaisesSelect();
			break;
			case "paso1":
				session_start();
				echo '
					Cargar Base:<br>
					<input type="button" name="subir" value="Cargar Base" onclick="cargarBase()"><br>
					<div id="selectListas">';
				$listas = new Lista();
				$misListas = $listas->buscalistas($_SESSION["correo"]);
				echo '<select name="listas" id="listas" onchange="cambiaCantidadContactos()">';
				for($i=0; $i<count($misListas); $i++)
				{
					$list = $misListas[$i];
					echo '<option value="'.$list->getId().'">'.$list->getNombre().'</option>';
				}
				echo '</select>
				</div><br>';
				$listaContactos = $misListas[0];
				$contactos = $listas->consultaContactosLista($listaContactos->getId());
				$erroneos = 0;	
				echo '
				<table border="1">
					<tr>
						<th colspan="2" align="center">
							Contactos Cargados
						</th>
					</tr>
					<tr>
						<td>
							Contactos cargados
						</td>
						<td>
							<div id="cargados" align="center">'.$contactos.'</div>
						</td>
					</tr>
					<tr>
						<td>
							Contactos no cargados y/o Erroneos
						</td>
						<td align="center">
							<div id="nocargados">'.$erroneos.'</div>
						</td>
					</tr>
				</table>
				<table border="1">
					<tr>
						<td>
							Total a enviar
						</td>
						<td>
							<div id="totalenviar">'.($contactos - $erroneos).'</div>
						</td>
					</tr>
				</table>
				<input type="button" name="btnPaso2" id="btnPaso2" onclick="llamarPaso2()" value="Paso 2">
				';	
			break;
			case "paso2":
				session_start();
				echo "Carga aqui tu diseño<br>
				Diseño: <select name='disenos' id='disenos' onchange='cambiadiseno()'>";
				$disenos = new Diseno();
				$misDisenos = (array)$disenos->buscaDisenos($_SESSION["correo"]);
				echo "<option value='1'>Sin Diseño</option>";
				for($i=0; $i<count($misDisenos); $i++) {
					$ar = $misDisenos[$i];
					echo "<option value='".$ar["id"]."'>".utf8_encode($ar["nombre"])."</option>";
				}	
				echo "</select><br>
				<input type='button' name='btnPaso3' id='btnPaso3' onclick='llamarPaso3()' value='Paso 3'>";
			break;
			case "paso3":
				echo 
				'
					Nombra tu campaña: <input type="text" name="nombrecampana" id="nombrecampana"><br><br>
					Datos campaña:<br>
					Lista: <input type="text" name="listaenviar" id="listaenviar" readonly><br>
					Diseño: <input type="text" name="disenoenviar" id="disenoenviar" readonly><br><br>

					Enviar en:<br>
					<div id="opcionenvio1"><input type="radio" id="inmediatamente" name="fechaenvio" checked onclick="cambiaRadiosOpcionesEnvio(1)">Inmediatamente</div><br>
					<div id="opcionenvio2"><input type="radio" id="horas" name="fechaenvio" onclick="cambiaRadiosOpcionesEnvio(2)">En <input type="text" name="horasenvio" id="horasenvio" size="2" maxlength="2" disabled> horas</div><br>
					<div id="opcionenvio3"><input type="radio" id="fecha" name="fechaenvio" onclick="cambiaRadiosOpcionesEnvio(3)">Seleccionar fecha 
					<input type="date" name="calendario" id="calendario" disabled></div><br>
					<input type="button" name="enviartest" id="enviartest" value="Enviar Test" onclick="guardacampana()"><br>
					<input type="button" name="enviardefinitivo" id="enviardefinitivo" value="Enviar Definitivo" onclick="guardacampana()">
				';
			break;
			case "recargalistas":
				session_start();
				$listas = new Lista();
				$misListas = $listas->buscalistas($_SESSION["correo"]);
				echo '<select name="listas">';
				for($i=0; $i<count($misListas); $i++)
				{
					$list = $misListas[$i];
					echo '<option value="'.$list->getId().'">'.$list->getNombre().'</option>';
				}
				echo "</select>";
			break;
			case "recuperar":
				$correo = $_GET["correo"];
				$cuenta = new Cuenta();
				$cuenta->setCorreo($correo);
				$account = $cuenta->buscaUnaPorCorreo();
				if($account != null)
				{
					$mail = new Correo();
					$mail->setCorreo($correo);
					echo $link = $account->generarLinkRecuperacion();
					$mail->recuperaClave($link);
				}
				echo "Se ha enviado un correo a la dirección que acabas de ingresar con las instrucciones para reestablecer tu clave";
			break;
			case "solicitud":
				$solicitud = new Solicitud();
				$solicitud->setNombre($_GET["nombre"]);
				$solicitud->setApellido($_GET["apellido"]);
				$solicitud->setCorreo($_GET["correo"]);
				$solicitud->setEmpresa($_GET["empresa"]);
				$solicitud->setTelefono($_GET["telefono"]);
				$solicitud->setCargo($_GET["cargo"]);
				$solicitud->setPagina($_GET["pagina"]);
				$solicitud->setPais($_GET["pais"]);
				$solicitud->setContactos($_GET["contactos"]);
				$solicitud->setEnteraste($_GET["formas"]);
				
				if($solicitud->insertaSolicitud())
				{
					$mail = new Correo();
					$mail->setEmpresa($solicitud->getEmpresa());
					$mail->setCorreo($solicitud->getCorreo());
					$mail->setNombre($solicitud->getNombre());
					$mail->setApellido($solicitud->getApellido());
					$mail->avisoSolicitud();
					echo "Gracias por su solicitud. En breve nos contactaremos con usted";
				}
				else
					echo "Se produjo un error al realizar la solicitud. Por favor intentelo nuevamente";
			break;



			case "lightbox":
				if(isset($_GET["tipodata"]))
				{
					$tipodata = $_GET["tipodata"];
					switch($tipodata)
					{
						case "arreglo":
							$data = json_decode($_GET['arreglo'], true);
							$nombreArchivo = $_GET["archivo"];
							$nombreLista = $_GET["lista"];
							$lista = new Lista();
							session_start();
							$idLista = $lista->consultaIdLista($_SESSION["correo"], $nombreArchivo);
							if($lista->mueveNombreArchivo($nombreLista, $nombreArchivo, $idLista))
							{
								if($lista->insertaNombreCampos($data, $idLista))
								{
									echo "insertado";
								}
								else
								{
									echo "error al insertar nombre campos";
								}
							}
							else
							{
								echo "error en el cambio";
							}
						break;
						case "base":
							echo '
								Nombra tu lista: &nbsp;<input type="text" name="txtNombreLista" id="txtNombreLista"><br><br>
								<form action="file.php" method="post" enctype="multipart/form-data" id="formuploadajax">
									<input type="file" name="archivo1" id="archivo1" value="Buscar">
									<input type="button" value="Subir archivo" onclick="subearchivo()">
								</form>
								<div id="mensaje"></div>
								<div id="campos-lightbox">
									Si desea agregar un nuevo campo, ingrese el nombre y presione el boton<br>
									<input type="text" name="nombrecampo" id="nombrecampo"> <input type="button" name="agregarcampo" value="Agregar Campo" id="agregarcampo" onclick="agregaCampo()"><br>
									<div id="relleno-campo">
										<div id="campobase" class="campobase">
											Correo
										</div>
									</div>
								</div>';
						break;
						case "enviar":
							echo 
							'
								Nombra tu campaña: <input type="text" name="nombrecampana" id="nombrecampana"><br><br>
								Datos campaña:<br>
								Lista: <input type="text" name="listaenviar" id="listaenviar" readonly><br>
								Diseño: <input type="text" name="disenoenviar" id="disenoenviar" readonly><br><br>

								Enviar en:<br>
								<div id="opcionenvio1"><input type="radio" name="fechaenvio" checked onclick="cambiaRadiosOpcionesEnvio(1)">Inmediatamente</div><br>
								<div id="opcionenvio2"><input type="radio" name="fechaenvio" onclick="cambiaRadiosOpcionesEnvio(2)">En <input type="text" name="horasenvio" id="horasenvio" size="2" maxlength="2" disabled> horas</div><br>
								<div id="opcionenvio3"><input type="radio" name="fechaenvio" onclick="cambiaRadiosOpcionesEnvio(3)">Seleccionar fecha 
								<input type="date" name="calendario" id="calendario" disabled></div><br>
								<input type="button" name="enviartest" id="enviartest" value="Enviar Test" onclick="guardacampana()"><br>
								<input type="button" name="enviardefinitivo" id="enviardefinitivo" value="Enviar Definitivo" onclick="guardacampana()">
							';
						break;
						case "cambionombre":
							$nombreArchivo = $_GET["archivo"];
							$nombreLista = $_GET["lista"];
							$lista = new Lista();
							session_start();
							$idLista = $lista->consultaIdLista($_SESSION["correo"], $nombreArchivo);
							if($lista->mueveNombreArchivo($nombreLista, $nombreArchivo, $idLista))
							{
								echo "cambiado";
							}
							else
							{
								echo "error cambio";
							}
						break;
						case "diseno":
							session_start();
							echo "Carga aqui tu diseño<br>
							Diseño: <select name='disenos' id='disenos' onchange='cambiadiseno()'>
								<option value='0'>Seleccione un diseño</option>
							";
							$disenos = new Diseno();
							$misDisenos = $disenos->buscaDisenos($_SESSION["correo"]);
							for($i=0; $i<count($misDisenos);$i++)
							{
								$design = $misDisenos[$i];
								echo "<option value='".$design->getId()."'>".utf8_encode($design->getNombre())."</option>";
							}	
							echo "</select><br>";
						break;
						case "enviar":
							echo "Aqui se podra configurar la hora o enviar inmediatamente la campaña cuando el envio de correos este listo";
						break;
					}
				}
				else
				{
					echo "Error de envio de información al controlador";
				}
			break;
		}
	}
	else
	{
		echo "Datos no recibidos";
	}

?>