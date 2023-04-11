<?php
	include_once('conexion.php');
	class Solicitud
	{
		private $nombre;
		private $apellido;
		private $correo;
		private $telefono;
		private $empresa;
		private $cargo;
		private $pagina;
		private $pais;
		private $contactos;
		private $enteraste;
		private $conexion;

		public function setNombre($nombre)
		{
			$this->nombre = $nombre;
		}

		public function getNombre()
		{
			return $this->nombre;
		}

		public function setApellido($apellido)
		{
			$this->apellido = $apellido;
		}

		public function getApellido()
		{
			return $this->apellido;
		}

		public function setCorreo($correo)
		{
			$this->correo = $correo;
		}

		public function getCorreo()
		{
			return $this->correo;
		}

		public function setTelefono($telefono)
		{
			$this->telefono = $telefono;
		}

		public function getTelefono()
		{
			return $this->telefono;
		}

		public function setEmpresa($empresa)
		{
			$this->empresa = $empresa;
		}

		public function getEmpresa()
		{
			return $this->empresa;
		}

		public function setCargo($cargo)
		{
			$this->cargo = $cargo;
		}

		public function getCargo()
		{
			return $this->cargo;
		}

		public function setPagina($pagina)
		{
			$this->pagina = $pagina;
		}

		public function getPagina()
		{
			return $this->pagina;
		}

		public function setPais($pais)
		{
			$this->pais = $pais;
		}

		public function getPais()
		{
			return $this->pais;
		}

		public function setContactos($contactos)
		{
			$this->contactos = $contactos;
		}

		public function getContactos()
		{
			return $this->contactos;
		}

		public function setEnteraste($enteraste)
		{
			$this->enteraste = $enteraste;
		}

		public function getEnteraste()
		{
			return $this->enteraste;
		}

		
		public function insertaSolicitud()
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			if($var->query("INSERT INTO solicitudes(nombre, apellido, correo, telefono, empresa, cargo, paginaweb, pais, cantcontactos".
				", enteraste) VALUES('".$this->nombre."','".$this->apellido."','".$this->correo."','".$this->telefono."','".$this->empresa."','".
				$this->cargo."','".$this->pagina."','".$this->pais."','".$this->contactos."','".$this->enteraste."')"))
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

		public function validaLogin()
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			if($resultado = $var->query("SELECT rut, clave FROM alumnos WHERE rut='".$this->rut."' AND clave='".$this->clave."'"))
			{
				while($fila = $resultado->fetch_array())
				{
					if($fila["rut"] == $this->rut && $fila["clave"] == $this->clave)
						return true;
				}
			}
			$this->conexion->closeConnection();
			return false;
		}

		function buscaRepetido()
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			if($resultado = $var->query("SELECT * FROM alumnos WHERE rut='".$this->rut."' OR correo='".$this->correo."'"))
			{
				while($fila = $resultado->fetch_array())
				{
					if($fila["rut"] == $this->rut || $fila["correo"] == $this->correo)
						return true;
				}
			}
			$this->conexion->closeConnection();
			return false;
		}

		private function limpiar_caracteres_especiales($string ){
			$string = htmlentities($string);
			$string = preg_replace('/\&(.)[^;]*;/', '\\1', $string);
			return $string;
		}

		private function buscaMayusculas($pass)
		{
			$valido = false;
			$string = $pass;
			$i = 0;
			$maxleng = strlen($string)-1;
			$string_sce = $this->limpiar_caracteres_especiales($string);
			for($i=0;$i < $maxleng ;$i++)
			{
			    if($string_sce[$i] == strtoupper($string_sce[$i]))
			    {
			        $valido = true;
			        break;
			    }
			}
			return $valido; 
		}

		private function buscaMinusculas($pass)
		{
			$valido = false;
			$string = $pass;
			$i = 0;
			$maxleng = strlen($string)-1;
			$string_sce = $this->limpiar_caracteres_especiales($string);
			for($i=0;$i < $maxleng ;$i++)
			{
			    if($string_sce[$i] == strtolower($string_sce[$i]))
			    {
			        $valido = true;
			        break;
			    }
			}
			return $valido; 
		} 
	}
?>