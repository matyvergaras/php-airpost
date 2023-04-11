<?php
	$upload_folder ='graphics';
	$nombre_archivo = $_FILES['archivo2']['name'];
	$tipo_archivo = $_FILES['archivo2']['type'];
	$tamano_archivo = $_FILES['archivo2']['size'];
	$tmp_archivo = $_FILES['archivo2']['tmp_name'];
	$extension = pathinfo($_FILES['archivo2']['name'], PATHINFO_EXTENSION);
	$archivador = $upload_folder . '/' . $nombre_archivo;
	echo "Nombre: ".$nombre_archivo." | Tamaño: ".$tamano_archivo;
?>