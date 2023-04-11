<?php
	require('conexion.php');
	/**
	* {}
	*/
	class Pais
	{
		private $id;
		private $nombre;

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

		public function buscaPaisesSelect()
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			$result = $var->query("SELECT * FROM paises");
			$retornar = "";
			while($row = $result->fetch_assoc())
			{
				if($row["nombre"] == "Chile")
					$retornar .= "<option value='".$row["idpais"]."' selected>".utf8_encode($row["nombre"])."</option>";
				else
					$retornar .= "<option value='".$row["idpais"]."'>".utf8_encode($row["nombre"])."</option>";
			}
			$this->conexion->closeConnection();
			return $retornar;
		}

		function __construct()
		{
			
		}
	}
?>