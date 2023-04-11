<?php
	class Conexion
	{
		private static $instance;

		private $host = "localhost";
		private $user = "root";
		private $pass = "";
		private $db = "emailmarketing";

		/*private $host = "www.tree-solutions.cl";
		private $user = "treesolu_emailma";
		private $pass = "tptp3126904casa";
		private $db = "treesolu_emailmakerting";*/
		

		private function __construct()
		{
			
		}
		
		public static function getInstance()
		{
			if (  !self::$instance instanceof self)
		      {
		         self::$instance = new self;
		      }
		      return self::$instance;
		}

		public function openConnection()
		{
			try
			{
				$this->conexion = mysqli_init();
				$this->conexion->real_connect($this->host, $this->user, $this->pass, $this->db);
			}
			catch(Exception $e)
			{
				$this->conexion = NULL;
				return 0;
			}
		}

		public function useConnection()
		{
			if($this->conexion != NULL)
				return $this->conexion;
			else
				return 0;
		}

		public function closeConnection()
		{
			$this->conexion->close();
		}
	}
?>