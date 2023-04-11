<?php  
	require_once('conexion.php');
	class Cazador
	{
		private $recibido;
		private $cuenta;
		private $fecha;
		private $guardado;

		public function setRecibido($recibido)
		{
			$this->recibido = $recibido;
		}

		public function getRecibido()
		{
			return $this->recibido;
		}

		public function setCuenta($cuenta)
		{
			$this->cuenta = $cuenta;
		}

		public function getCuenta()
		{
			return $this->cuenta;
		}

		public function setFecha($fecha)
		{
			$this->fecha = $fecha;
		}

		public function getFecha()
		{
			return $this->fecha;
		}

		public function setGuardado($guardado)
		{
			$this->guardado = $guardado;
		}

		public function getGuardado()
		{
			return $this->guardado;
		}

		public function actualizaGeneradas($generadas)
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			$query = "UPDATE cuentas SET keysgeneradas='".$generadas."' WHERE correo='".$this->getCuenta()."'";
			if($resultado = $var->query($query) > 0)
			{
				$this->conexion->closeConnection();
				return true;
			}
			$this->conexion->closeConnection();
			return false;
		}

		public function insertaCorreoCazador()
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			$query = "INSERT INTO correoscazador(correorecibido,correocuenta) VALUES('".$this->getRecibido()."','".$this->getCuenta()."')";
			if($resultado = $var->query($query) > 0)
			{
				$this->conexion->closeConnection();
				return true;
			}
			$this->conexion->closeConnection();
			return false;
		}

		public function generaKeyCazador($generadas)
		{
			if($generadas >= 0)
			{
				$key = md5("cazador".explode("@", $this->getCuenta())[1]."airpost".explode("@", $this->getCuenta())[0].$generadas);
				$this->conexion = Conexion::getInstance();
				$this->conexion->openConnection();
				$var = $this->conexion->useConnection();
				$query = "UPDATE cuentas SET cazador='".$key."' WHERE correo='".$this->getCuenta()."'";
				if($resultado = $var->query($query) > 0)
				{
					$this->conexion->closeConnection();
					return $key;
				}
				else
				{
					$this->conexion->closeConnection();
					return "Error de registro de clave";
				}
			}
			else
			{
				$this->conexion->closeConnection();
				return "generadas <0";
			}
		}

		public function retornaKey()
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			$result = $var->query("SELECT cazador FROM cuentas WHERE correo='".$this->getCuenta()."'");
			$key = "";
			if(mysqli_num_rows($result) > 0)
			{
				while($row = $result->fetch_array())
				{
					$key = $row["cazador"];
				}
				$this->conexion->closeConnection();
				return $key;
			}
			else
			{
				$this->conexion->closeConnection();
				return $key;
			}
		}

		// public function retornaKeyCorreoEncriptado()
		// {
		// 	$this->conexion = Conexion::getInstance();
		// 	$this->conexion->openConnection();
		// 	$var = $this->conexion->useConnection();
		// 	$result = $var->query("SELECT cazador FROM cuentas WHERE md5(correo)='".$this->getCuenta()."'");
		// 	$key = "";
		// 	if(mysqli_num_rows($result) > 0)
		// 	{
		// 		while($row = $result->fetch_array())
		// 		{
		// 			$key = $row["cazador"];
		// 		}
		// 		$this->conexion->closeConnection();
		// 		return $key;
		// 	}
		// 	else
		// 	{
		// 		$this->conexion->closeConnection();
		// 		return $key;
		// 	}
		// }

		public function revisaKey()
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			$result = $var->query("SELECT keysgeneradas FROM cuentas WHERE correo='".$this->getCuenta()."'");
			if(mysqli_num_rows($result) > 0)
			{
				$key = -1;
				while($row = $result->fetch_array())
				{
					$key = $row["keysgeneradas"];
				}
				$this->conexion->closeConnection();
				return $key;
			}
			else
			{
				$this->conexion->closeConnection();
				return -1;
			}
		}

		public function validaKeyCazador($key)
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			$result = $var->query("SELECT * FROM cuentas WHERE correo='".$this->getCuenta()."' AND cazador='".$key."'");
			if(mysqli_num_rows($result) > 0)
			{
				$this->conexion->closeConnection();
				return "validado";
			}
			else
			{
				$this->conexion->closeConnection();
				return "errorclave";
			}
		}
	}	
?>