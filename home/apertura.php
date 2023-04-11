<?php
	include_once('conexion.php');
	class Apertura
	{
		private $campana;
		private $correo;
		private $fecha;
		private $hora;
		private $ip;
		private $abierto;

		public function setCampana($campana)
		{
			$this->campana = $campana;
		}

		public function getCampana()
		{
			return $this->campana;
		}

		public function setCorreo($correo)
		{
			$this->correo = $correo;
		}

		public function getCorreo()
		{
			return $this->correo;
		}

		public function setFecha($fecha)
		{
			$this->fecha = $fecha;
		}

		public function getFecha()
		{
			return $this->fecha;
		}

		public function setHora($hora)
		{
			$this->hora = $hora;
		}

		public function getHora()
		{
			return $this->hora;
		}

		public function setIp($ip)
		{
			$this->ip = $ip;
		}

		public function getIp()
		{
			return $this->ip;
		}

		public function setAbierto($abierto)
		{
			$this->abierto = $abierto;
		}

		public function getAbierto()
		{
			return $this->abierto;
		}

		public function insertaApertura()
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			if($resultado = $var->query("INSERT INTO aperturas(campana, correo) VALUES('".$this->getCampana()."','".$this->getCorreo()."')") > 0)
			{
				$this->conexion->closeConnection();
				return true;
			}
			$this->conexion->closeConnection();
			return false;
		}

		public function aperturaCorreo()
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			if($resultado = $var->query("UPDATE aperturas SET fecha='".$this->getFecha()."', hora='".$this->getHora()."', ip='".$this->getIp()."', abierto='1' WHERE campana='".$this->getCampana()."' AND correo='".$this->getCorreo()."'") > 0)
			{
				$this->conexion->closeConnection();
				return true;
			}
			$this->conexion->closeConnection();
			return false;
		}
	}
?>