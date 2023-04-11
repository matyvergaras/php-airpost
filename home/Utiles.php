<?php
	require('Conexion.php');
	require('Alumno.php');
	session_start();
	class Utiles
	{
		private function __construct()
		{
			
		}

		public static login($rut, $validacion)
		{
			if(md5($rut) == $validacion)
			{
				$conexion = Conexion::getInstance();
				$alumno = new Alumno();
				$alumno->setRut($rut);
				$_SESSION["0x25Fp9x8K"];
			}
			else
			{
				session_destroy();
				header("Location: index.php");
			}
		}

		//Recibe fecha en formato dd/mm/aaaa y lo convierte a formato aaaa/mm/dd
		public static fechaPhpBd($fecha) 
		{
			$newFecha = explode("/", $fecha);
			return $newFecha[2]."/".newFecha[1]."/".newFecha[0];
		}

		//Recibe fecha en formato aaaa/mm/dd y lo convierte a formato dd/mm/aaaa
		public static fechaBdPhp($fecha)
		{
			$newFecha = explode("/", $fecha);
			return $newFecha[0]."/".newFecha[1]."/".newFecha[2];
		}
	}
?>