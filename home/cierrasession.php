<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<?php
	session_start();
	if(session_destroy())
		header("Location: ../");
	else
		echo "<a href='../'>Haga clic aquí para volver al inicio</a>";
?>