<?php
	include_once('conexion.php');
	require_once('arraylist.php');
	class Lista
	{
		private $id;
		private $nombre;
		private $cantidad;
		private $correo;
		private $archivo;

		public function __construct()
		{
			 	
		}

		public function setId($id)
		{
			$this->id = $id;
		}

		public function getId()
		{
			return $this->id;
		}

		public function setNombre($nombre)
		{
			$this->nombre = $nombre;
		}

		public function getNombre()
		{
			return $this->nombre;
		}

		public function setCantidad($cantidad)
		{
			$this->cantidad = $cantidad;
		}

		public function getCantidad()
		{
			return $this->cantidad;
		}

		public function setCorreo($correo)
		{
			$this->correo = $correo;
		}

		public function getCorreo()
		{
			return $this->correo;
		}

		public function setArchivo($archivo)
		{
			$this->archivo = $archivo;
		}

		public function getArchivo()
		{
			return $this->archivo;
		}

		public function insertaLista()
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			if($var->query("INSERT INTO listas(nombre, cantidad, correo, archivo) VALUES('".$this->nombre."','".$this->cantidad."','".$this->correo."','".$this->archivo."')"))
			{
				$this->conexion->closeConnection();
				return true;
			}
			else
			{
				$this->conexion->closeConnection();
				return false;
			}
		}

		function buscaRepetido()
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			$resultado = $var->query("SELECT * FROM listas WHERE nombre='".$this->nombre."'");
			if(mysqli_num_rows($resultado) > 0)
			{
				return true;
			}
			$this->conexion->closeConnection();
			return false;
		}

		public function buscalistas($correo)
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			$lista = new ArrayList();
			if($resultado = $var->query("SELECT * FROM listas WHERE correo='".$correo."' ORDER BY id DESC")) //id DESC
			{
				if(mysqli_num_rows($resultado) > 0)
				{
					while($fila = $resultado->fetch_array())
					{
						$milista = new Lista();
						$milista->setId($fila[0]);
						$milista->setNombre($fila[1]);
						$milista->setCantidad($fila[2]);
						$milista->setCorreo($fila[3]);
						$lista->add($milista);
					}
				}
			}
			$this->conexion->closeConnection();
			return $lista;
		}

		public function buscarTablaPorLike($nombre)
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			$milista = Array();
			if($resultado = $var->query("SELECT id, nombre, cantidad FROM listas WHERE correo='".$this->getCorreo()."' AND nombre LIKE '%".$nombre."%' ORDER BY id DESC"))
			{
				if(mysqli_num_rows($resultado) > 0)
				{
					$cont = 0;
					while($fila = $resultado->fetch_array())
					{
						$milista[$cont][0] = $fila[0];
						$milista[$cont][1] = $fila[1];
						$milista[$cont][2] = $fila[2];
						$cont++;
					}
				}
			}
			$this->conexion->closeConnection();
			return json_encode($milista);
		}

		public function consultaContactosLista($id)
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			$contactos = -1;
			
			if($resultado = $var->query("SELECT COUNT(idlista) FROM contactoslista WHERE idlista='".$id."'"))
			{
				if(mysqli_num_rows($resultado) > 0)
				{
					while($fila = $resultado->fetch_array())
					{
						$contactos = $fila[0];
					}
				}
			}
			$this->conexion->closeConnection();
			return $contactos;
		}

		private function contactosPorEstadoUno($id)
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			$contactos = 0;
			
			if($resultado = $var->query("SELECT COUNT(idlista) FROM contactoslista WHERE idlista='".$id."' AND estado='1' GROUP BY estado"))
			{
				if(mysqli_num_rows($resultado) > 0)
				{
					while($fila = $resultado->fetch_array())
					{
						$contactos = $fila[0];
					}
				}
			}
			$this->conexion->closeConnection();
			return $contactos;
		}

		private function contactosPorEstadoCero($id)
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			$contactos = 0;
			
			if($resultado = $var->query("SELECT COUNT(idlista) FROM contactoslista WHERE idlista='".$id."' AND estado='0' GROUP BY estado"))
			{
				if(mysqli_num_rows($resultado) > 0)
				{
					while($fila = $resultado->fetch_array())
					{
						$contactos = $fila[0];
					}
				}
			}
			$this->conexion->closeConnection();
			return $contactos;
		}

		public function consutaContactosListaPorEstado($id)
		{
			$estadoUno = $this->contactosPorEstadoUno($id);
			$estadoCero = $this->contactosPorEstadoCero($id);
			$retorno = Array();
			if($estadoCero > 0)
				$retorno[0] = $estadoCero;
			else
				$retorno[0] = 0;
			if($estadoUno > 0)
				$retorno[1] = $estadoUno;
			else
				$retorno[1] = 0;
			return $retorno;
		}

		public function consultaIdLista($correo, $nombre)
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			$ll = array();
			$milista = null;
			
			if($resultado = $var->query("SELECT id FROM listas WHERE (nombre='".$nombre."' OR archivo='".$nombre."') AND correo='".$correo."'"))
			{
				if(mysqli_num_rows($resultado) > 0)
				{
					while($fila = $resultado->fetch_array())
					{
						$milista = new Lista();
						$milista->setId($fila[0]);
					}
				}
			}
			$this->conexion->closeConnection();
			return $milista->getId();
		}

		public function consultaNombreLista($id)
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			$milista = "";
			if($resultado = $var->query("SELECT nombre FROM listas WHERE id=".$id))
			{
				if(mysqli_num_rows($resultado) > 0)
				{
					while($fila = $resultado->fetch_array())
					{
						$milista = $fila[0];
					}
				}
			}
			$this->conexion->closeConnection();
			return $milista;
		}

		public function consultaListaToJson()
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			$misListas = Array();
			$cont = 0;
			if($resultado = $var->query("SELECT id, nombre FROM listas WHERE correo='".$this->getCorreo()."' ORDER BY id DESC"))
			{
				if(mysqli_num_rows($resultado) > 0)
				{
					while($fila = $resultado->fetch_array())
					{
						$misListas[$cont][0] = $fila[0];
						$misListas[$cont][1] = $fila[1];
						$cont++;
					}
				}
			}
			$this->conexion->closeConnection();
			$misListas = json_encode($misListas);
			return $misListas;
		}

		public function contactosLista($id)
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			$milista = "";
			if($resultado = $var->query("SELECT * FROM contactoslista WHERE id=".$id))
			{
				if(mysqli_num_rows($resultado) > 0)
				{
					$milista .= "<table border='1'>";
					while($fila = $resultado->fetch_array())
					{
						$milista .= "<tr><td>".$fila[0]."</td><td>".$fila[1]."</td><td>".$fila[2]."</td></tr>";
					}
					$milista .= "</table>";
				}
			}
			$this->conexion->closeConnection();
			return $milista;
		}

		public function descargaBases($listado)
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			$milista = Array();
			$listado = json_decode($listado);
			$ids = "";
			for($i=0; $i<count($listado); $i++)
			{
				if($i==0)
					$ids .= $listado[$i];
				else
					$ids .= ", ".$listado[$i];
			}
			if($resultado = $var->query("SELECT archivo FROM listas WHERE id IN ($ids)"))
			{
				if(mysqli_num_rows($resultado) > 0)
				{
					$cont = 0;
					while($fila = $resultado->fetch_array())
					{
						$milista[$cont] = $fila[0];
						$cont++; 
					}
				}
			}
			$this->conexion->closeConnection();

			$zip = new ZipArchive();
			$fecha = new DateTime();
			$zipName = "descargas/bases".$_SESSION['correo'].$fecha->getTimestamp().".zip";
			$downloadName = "http://localhost/airpost/home/".$zipName;
			if($zip->open($zipName, ZIPARCHIVE::CREATE) === true)
			{
				for($i=0; $i<count($milista); $i++)
				{
					$zip->addFile("listas/".$milista[$i]);
				}
				$zip->close();
				return $downloadName;
			}
		}

		public function eliminaBases($listado)
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			$milista = Array();
			$listado = json_decode($listado);
			$ids = "";
			for($i=0; $i<count($listado); $i++)
			{
				if($i==0)
					$ids .= $listado[$i];
				else
					$ids .= ", ".$listado[$i];
			}

			$mensaje = "";
			$resultado = $var->query("DELETE FROM listas WHERE id IN ($ids)");
			if($resultado)
				$mensaje = "Bases eliminadas correctamente";
			else
				$mensaje = "Error al intentar eliminar las bases. Por favor intentelo nuevamente";
			$this->conexion->closeConnection();
			return $mensaje;
		}

		public function insertaCamposLista($correo, $nombre, $consulta)
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			
			if($var->query($consulta))
			{
				$this->conexion->closeConnection();
				return true;
			}
			else
			{
				$this->conexion->closeConnection();
				return false;
			}
		}

		public function listasToArray()
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			$milista = Array();
			if($resultado = $var->query("SELECT id, nombre, cantidad FROM listas WHERE correo='".$this->getCorreo()."'"))
			{
				if(mysqli_num_rows($resultado) > 0)
				{
					$cont = 0;
					while($fila = $resultado->fetch_array())
					{
						$milista[$cont][0] = $fila[0];
						$milista[$cont][1] = $fila[1];
						$milista[$cont][2] = $fila[2];
						$cont++;
					}
				}
			}
			$this->conexion->closeConnection();
			return json_encode($milista);
		}

		public function listasToTable()
		{
            $retornar = "";
            $misListas = new Lista();
            $lista = new ArrayList();
            $lista = $misListas->buscaListas($_SESSION["correo"]);
            $retornar = array();
            for($i=0; $i<$lista->size(); $i++)
            {
            	$retornar[$i] = array();
            	$retornar[$i][0] = $lista->get($i)->getId();
            	$retornar[$i][1] = $lista->get($i)->getNombre();
            }
            /*for($i=0; $i<$lista->size(); $i++)
            {
            	$retornar .= "<td>".$lista->get($i)->getNombre()."</td>";
            	$retornar .= "<td class='text-right'>";
            	$retornar .= "<input type='checkbox' value='".$lista->get($i)->getId()."' id='".$lista->get($i)->getId()."' onchange='cargaListas(".$lista->get($i)->getId().")'></td>";
            }*/
            return $retornar;
		}

		public function mueveNombreArchivo($nombre, $archivo, $id)
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();

			if($resultado = $var->query("UPDATE listas SET archivo = '".$archivo."', nombre='".$nombre."' WHERE id='".$id."'"))
			{
				$this->conexion->closeConnection();
				return true;
			}
			else
			{
				$this->conexion->closeConnection();
				return false;
			}
		}

		public function insertaNombreCampos($nombres, $id)
		{
			$consulta = "INSERT INTO camposlista VALUES('".$id."', '".$_SESSION["correo"]."',";
			$nombre = "";
			$name = array();
			for($i=0; $i<12; $i++)
			{
				$name[$i] = "";
			}

			for($i=0; $i<count($nombres); $i++)
			{
				$name[$i] = $nombres[$i];
			}

			for($i=0; $i<count($name); $i++)
			{
				$nombre.="'".$name[$i]."',";
			}

			$nombre = substr($nombre, 0, -1);
			$consulta .= $nombre.")";
			
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			echo $consulta;
			if($resultado = $var->query($consulta))
			{
				$this->conexion->closeConnection();
				return true;
			}
			else
			{
				$this->conexion->closeConnection();
				return false;
			}	
		}

		public function cambiaMaxPacket($size)
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			$resultado = $var->query("SET GLOBAL max_allowed_packet=".$size);
			$this->conexion->closeConnection();
		}
	}
?>