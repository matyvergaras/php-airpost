<?php
	require_once('conexion.php');
	require_once('arraylist.php');
	class Campana
	{
		private $id;
		private $nombre;
		private $correo;
		private $fechanenvio;
		private $lista;
		private $diseno;
		private $enviada;

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

		public function setCorreo($correo)
		{
			$this->correo = $correo;
		}

		public function getCorreo()
		{
			return $this->correo;
		}

		public function setFechaenvio($fechaenvio)
		{
			$this->fechaenvio = $fechaenvio;
		}

		public function getFechaenvio()
		{
			return $this->fechaenvio;
		}

		public function setLista($lista)
		{
			$this->lista = $lista;
		}

		public function getLista()
		{
			return $this->lista;
		}

		public function setDiseno($diseno)
		{
			$this->diseno = $diseno;
		}

		public function getDiseno()
		{
			return $this->diseno;
		}

		public function setEnviada($enviada)
		{
			$this->enviada = $enviada;
		}

		public function getEnviada()
		{
			return $this->enviada;
		}

		public function insertaCampana()
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			if($var->query("INSERT INTO campana(nombre, correo, fechaenvio, lista, diseno) VALUES('".$this->nombre."','".$this->correo."','".$this->fechaenvio."','".$this->lista."','".$this->diseno."')"))
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

		public function buscaUna()
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			$id = 0;
			if($resultado = $var->query("SELECT * FROM campana WHERE correo='".$this->getCorreo()." AND nombre='".$this->getNombre()."' ORDER BY id DESC"))
			{
				if(mysqli_num_rows($resultado) > 0)
				{
					while($fila = $resultado->fetch_array())
					{
						$id = $fila["lista"];
					}
					$this->conexion->closeConnection();
					return $id;
				}
			}
			$this->conexion->closeConnection();
			return false;
		}

		public function buscaId()
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			$id = 0;
			if($resultado = $var->query("SELECT id FROM campana WHERE correo='".$this->getCorreo()."' AND nombre='".$this->getNombre()."' ORDER BY id DESC"))
			{
				if(mysqli_num_rows($resultado) > 0)
				{
					while($fila = $resultado->fetch_array())
					{
						$id = $fila["id"];
					}
					$this->conexion->closeConnection();
					return $id;
				}
			}
			$this->conexion->closeConnection();
			return false;
		}

		public function buscaUnaCompleta()
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			$campaign = null;
			if($resultado = $var->query("SELECT * FROM campana WHERE correo='".$this->getCorreo()." AND nombre='".$this->getNombre()."' ORDER BY id DESC"))
			{
				if(mysqli_num_rows($resultado) > 0)
				{
					while($fila = $resultado->fetch_array())
					{
						$campaign = new Campana();
						$campaign->setId($fila["id"]);
						$campaign->setNombre($fila["nombre"]);
						$campaign->setCorreo($fila["correo"]);
						$campaign->setFechaenvio($fila["fechaenvio"]);
						$campaign->setLista($fecha["lista"]);
						$campaign->setDiseno($fecha["diseno"]);
						$campaign->setEnviada($fecha["enviada"]);
					}
					$this->conexion->closeConnection();
					return $campaign;
				}
			}
			$this->conexion->closeConnection();
			return false;
		}

		public function buscaCampanas($correo)
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			$lista = new ArrayList();
			if($resultado = $var->query("SELECT * FROM campana WHERE correo='".$correo."' ORDER BY id DESC"))
			{
				if(mysqli_num_rows($resultado) > 0)
				{
					while($fila = $resultado->fetch_array())
					{
						$micampana = new Campana();
						$micampana->setId($fila[0]);
						$micampana->setNombre(utf8_encode($fila[1]));
						$micampana->setCorreo($fila[2]);
						$micampana->setFechaenvio($fila[3]);
						$micampana->setLista($fila[4]);
						$micampana->setDiseno($fila[5]);
						$micampana->setEnviada($fila[6]);
						$lista->add($micampana);
					}
					$this->conexion->closeConnection();
					return $lista;
				}
			}
			$this->conexion->closeConnection();
			return false;
		}

		public function marcaEnviada()
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			if($var->query("UPDATE campana SET enviada=1 WHERE id='".$this->getId()."'"))
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
	}
?>