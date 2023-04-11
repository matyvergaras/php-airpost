<?php
	require_once('lista.php');
	session_start();
	if(isset($_GET["lista"]) && isset($_SESSION["correo"]))
	{
		//$lista = new Lista();
		//echo $lista->descargaBases($_GET["lista"]);
	}
	else
	{
		session_destroy();
		header("../index.php");
	}
?>