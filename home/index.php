<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<?php
	include_once('construye.php');
	session_start();
	if(isset($_SESSION["correo"]) && isset($_SESSION["0f2Ap9B53MñÑ"]))
	{
		if(md5(explode('@',$_SESSION["correo"])[1].$_SESSION["activa"].explode('@',$_SESSION["correo"])[0].$_SESSION["perfil"]) == $_SESSION["0f2Ap9B53MñÑ"])
		{
			$pAdminP = "DESACTIVADO";
			if($_SESSION["activa"] == 1)
			{
				if($_SESSION["perfil"] == 2)
				{
					if($_SESSION["NksñIwhaMwsDaoñpA"] = md5($_SESSION["perfil"]."niMdA".$_SESSION["correo"]))
					{
						$pAdminP = "ACTIVADO";
					}
					else
					{
						session_destroy();
						session_start();
						$_SESSION["Error"] = "Posible ingreso forzoso de credenciales administrador";
						header("Location: ../index.php");
					}
				}

				?>
					<?php
						if($pAdminP == "ACTIVADO")
							echo "Administrador";
						$build = new Construye();
						if(isset($_GET['sitio']))
						{
							switch($_GET['sitio'])
							{
								case "campaña":
									echo $build->campaign($build->devuelveSitio($_SESSION["correo"]));
								break;
								case "lista":
									echo $build->lista($build->devuelveSitio($_SESSION["correo"]));
								break;
							}
							
						}
						else
						{
							echo $build->plantilla();
						}
					?>
					
				<?php
			}
			else
			{
				session_destroy();
				session_start();
				$_SESSION["error"] = "La cuenta a la cual intenta acceder no se encuentra activa. Por favor contáctese con soporte";
				header("Location: ../index.php");
			}
		}
		else
		{
			session_destroy();
			session_start();
			$_SESSION["error"] = "Error de ingreso forzoso";
			header("Location: ../index.php");
		}
	}
	else
	{
		session_destroy();
		session_start();
		$_SESSION["error"] = "Debe realizar el acceso con sus credenciales primero";
		header("Location: ../index.php");
	}
?>