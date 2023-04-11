<?php
	require_once('lista.php');
	session_start();
	$return = "";
	$upload_folder ='listas';
	$nombre_archivo = $_FILES['archivo1']['name'];
	$tipo_archivo = $_FILES['archivo1']['type'];
	$tamano_archivo = $_FILES['archivo1']['size'];
	$tmp_archivo = $_FILES['archivo1']['tmp_name'];
	$extension = pathinfo($_FILES['archivo1']['name'], PATHINFO_EXTENSION);
	$archivador = $upload_folder . '/' . $nombre_archivo;
	if($extension == "csv")
	{
		if (!move_uploaded_file($tmp_archivo, $archivador)) 
			$return = "Error al subir el archivo";
		else
		{
			if($tamano_archivo <= 10485760)
			{
				if(mime_content_type($archivador) == "text/plain" || mime_content_type($archivador) == "text/x-c")
				{
					$lista = new Lista();
					$lista->setNombre($nombre_archivo);
					$lista->setCorreo($_SESSION["correo"]);
					if(!$lista->buscaRepetido())
					{
						if($lista->insertaLista())
						{
							$lista->cambiaMaxPacket(524288000); // Se aumenta el tamaño del max_allowed_packet para que se pueda enviar el query completo, ya que este pesa mas de 64MB en algunos casos
							$maxCampos = 12;
							$fp = fopen ( $archivador , "r" );
							$i = 0;
							$query = "INSERT INTO contactoslista VALUES";
							$agregar = "(";
							$ciclos = 0;
							while (( $data = fgetcsv ( $fp , 1000 , "," )) !== FALSE ) { // Mientras hay líneas que leer...
								if($ciclos == 0)
								{
									$query = "INSERT INTO contactoslista VALUES";
								}
							    
							    foreach($data as $row) {
							    	$arre = explode(";",$row);
							    	$largo = count($arre);

							    	for($i=$largo; $i<$maxCampos+1; $i++)
							    	{
							    		$arre[$i] = "";
							    	}

							    	for($i=0; $i<count($arre); $i++)
							    	{
							    		if($i==0)
							    		{
							    			$agregar .= "\"idlista\",\"".$arre[$i]."\",";
							    		}
							    		else if($i==(count($arre)-1))
							    		{
							    			$agregar .= "\"".$arre[$i]."\"";
							    		}
							    		else
							    		{
							    			$agregar .= "\"".$arre[$i]."\",";
							    		}
							    	}
							    	$agregar .= "),(";
							    }
							}
							fclose ( $fp );
							$agregar = substr($agregar, 0, -2);
							$query = $query.$agregar;
							$nuevoId = $lista->consultaIdLista($_SESSION["correo"], $nombre_archivo);
							$query = str_replace("idlista", $nuevoId, $query);
							$query = utf8_decode($query);
							inserta($query, $nombre_archivo);
							$return = "Lista guardada";
							$lista->cambiaMaxPacket(10485760);
						}
						else
						{
							unlink($archivador);
							$return = "Ocurrio un error al guardar la lista";
						}
					}
					else
					{
						unlink($archivador);
						$return = "Ya existe una lista con ese nombre";
					}
				}
				else
				{
					unlink($archivador);
					$return = "El tipo de archivo no coincide con su extension";
				}
			}
			else
			{
				unlink($archivador);
				$return = "El archivo supera el tamaño maximo";
			}
		}
	}
	else
	{
		$return = "Este tipo de archivo no esta permitido";
	}
	echo $return;

	function inserta($query, $archivo)
	{
		$algo = new Lista();
		$algo->insertaCamposLista($_SESSION["correo"], $archivo, $query);
		unset($algo);
	}
?>
