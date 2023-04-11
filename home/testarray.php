<?php
	require_once('lista.php');
	require_once('arraylist.php');
	$lista = new Lista();
	$array = $lista->buscalistas("prueba@correo.cl");
	echo "<table border='1'>";
	for($i=0; $i<$array->size(); $i++)
	{
		echo "<tr><td>".$array->get($i)->getNombre()."</td></tr>";
	}
	echo "</table>";
?>