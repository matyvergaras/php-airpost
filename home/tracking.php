<?php
	require_once('apertura.php');
	$fecha = date("Y-m-d"); 
	$hora = date("H:i:s");
	$ip  = $_SERVER['REMOTE_ADDR'];
	$campana = $_GET["campana"];
	$correo = $_GET["correo"];
	$apertura = new Apertura();
	$apertura->setFecha($fecha);
	$apertura->setHora($hora);
	$apertura->setIp($ip);
	$apertura->setCampana($campana);
	$apertura->setCorreo($correo); 
	$apertura->aperturaCorreo();

	header("content-type: image/gif");
	//43byte 1x1 transparent pixel gif
	echo base64_decode("R0lGODlhAQABAIAAAAAAAAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==");
?>


