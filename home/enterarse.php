<?php
	include_once('conexion.php');
	/**
	* {}
	*/
	class Enterarse
	{
		private $id;
		private $descripcion;

		public function setId($id)
		{
			$this->id = $id;
		}

		public function getId()
		{
			return $this->id;
		}	

		public function setDescripcion($descripcion)
		{
			$this->descripcion = $descripcion;
		}

		public function getDescripcion()
		{
			return $this->descripcion;
		}

		public function buscaFormasSelect()
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			$result = $var->query("SELECT * FROM formasenterarse");
			$retornar = "";
			while($row = $result->fetch_assoc())
			{
				$retornar .= "<option value='".$row["idformas"]."'>".utf8_encode($row["descripcion"])."</option>";
			}
			$this->conexion->closeConnection();
			return $retornar;
		}

		function __construct()
		{
			
		}
	}
?>