<?php
	include_once('conexion.php');
	class Diseno
	{
		private $id;
		private $correo;
		private $nombre;
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

		public function setCorreo($correo)
		{
			$this->correo = $correo;
		}

		public function getCorreo()
		{
			return $this->correo;
		}

		public function setNombre($nombre)
		{
			$this->nombre = $nombre;
		}

		public function getNombre()
		{
			return $this->nombre;
		}

		public function setArchivo($archivo)
		{
			$this->archivo = $archivo;
		}

		public function getArchivo()
		{
			return $this->archivo;
		}

		public function insertaDiseno()
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			if($var->query("INSERT INTO disenos(correo, nombre, archivo) VALUES('".$this->correo."','".$this->nombre."','".$this->archivo."')"))
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

		public function buscaDisenos($correo)
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			$ll = array();
			if($resultado = $var->query("SELECT * FROM disenos WHERE correo='".$correo."' ORDER BY id DESC"))
			{
				if(mysqli_num_rows($resultado) > 0)
				{
					while($fila = $resultado->fetch_array())
					{
						$midiseno = new Lista();
						$midiseno->setId($fila[0]);
						$midiseno->setCorreo($fila[1]);
						$midiseno->setNombre($fila[2]);
						$midiseno->setArchivo($fila[3]);
						array_push($ll, $midiseno);
					}
					$this->conexion->closeConnection();
					return serialize($ll);
				}
			}
			$this->conexion->closeConnection();
			return false;
		}

		public function consultaNombreDiseno($id)
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			
			if($resultado = $var->query("SELECT nombre FROM disenos WHERE id=".$id))
			{
				if(mysqli_num_rows($resultado) > 0)
				{
					while($fila = $resultado->fetch_array())
					{
						$midiseno = $fila[0];
					}
				}
			}
			$this->conexion->closeConnection();
			return $midiseno;
		}
	}
?>