<?php
$host="KAHNCERBERO\\SQLEXPRESS";
$base= "PDI";
$usuario="viajes";
$password= "Ad123";


//Conexión a SQL
$fuente_datos ="Driver= {SQL Server}; Server='$host'; Database='$base'; Integrated Security = SSPI; Persist Security Info = False;";

$conn =odbc_connect($fuente_datos, $usuario, $password);

//Si falla la conexión, se muestra un mensaje de error
if ($conn )
{

echo "conexion exitosa ";
}
else{ //Caso contrario, podremos realizar cualquier consulta

echo "fallo la conexion ";
}
?>