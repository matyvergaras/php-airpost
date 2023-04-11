<?php
	require_once('solicitud.php');
	require_once('cuenta.php');
	if(isset($_POST["botonsubmit"]))
	{
		$boton = $_POST["botonsubmit"];
		switch($boton)
		{
			case "Entrar":
				$cuenta = new Cuenta();
				$cuenta->setCorreo($_POST["txtCorreo"]);
				$cuenta->setClave(md5($_POST["txtClave"]));
				$retorno = $cuenta->validaLogin();
				session_start();
				if($retorno != false)
				{
					if($retorno->getActiva())
					{
						$_SESSION["correo"] = $retorno->getCorreo();
						$_SESSION["perfil"] = $retorno->getPerfil();
						$_SESSION["activa"] = $retorno->getActiva();
						$_SESSION["0f2Ap9B53MñÑ"] = md5(explode('@',$retorno->getCorreo())[1].$retorno->getActiva().explode('@',$retorno->getCorreo())[0].$retorno->getPerfil());
						unset($retorno);
						if($_SESSION["perfil"] == 2)
						{
							$_SESSION["NksñIwhaMwsDaoñpA"] = md5($_SESSION["perfil"]."niMdA".$_SESSION["correo"]);
						}
						header("Location: ../home");
					}
					else
					{
						$_SESSION["error"] = "La cuenta a la cual intenta acceder no se encuentra activa. Por favor contáctese con soporte";
						header("Location: ../");
					}
				}
				else
				{
					$_SESSION["error"] = "Las credenciales ingresadas son incorrectas";
					header("Location: ../");
				}
			break;
			case "Restablecer":
				session_start();
				if(isset($_SESSION["h22"]) && isset($_SESSION["h32"]) && isset($_SESSION["h56"]) && isset($_SESSION["h89"]) && isset($_SESSION["correo"]))
				{
					$clave = $_POST["txtClave"];
					$h22 = $_SESSION["h22"];
					$h32 = $_SESSION["h32"];
					$h56 = $_SESSION["h56"];
					$h89 = $_SESSION["h89"];
					$correo = $_SESSION["correo"];
					$verifica = "";
					if($h22 == "71248b05b2a35abfacc72bb07cc651a3")
						$verifica = $h89;
					else if($h22 == "3ec3d8cde6e40d71013d8b8236a94cf9")
						$verifica = $h32;
					else
						$verifica = $h56;
					$cuenta = new Cuenta();
					$cuenta->setCorreo($correo);
					$account = $cuenta->buscaPorRestablecer();
					
					session_destroy();
					session_start();
					if($verifica == $account->getValidacion())
					{
						$account->setClave($clave);
						$account->restableceClave();
						$_SESSION["error"] = "Se ha restablecido la clave de su cuenta";
					}
					else
						$_SESSION["error"] = "Error en la validacion";
					header("Location: ../");
				}
				else
				{
					session_destroy();
					session_start();
					$_SESSION["error"] = "Enlace incorrecto";
				}
				header("Location: ../");
			break;
			default:
				echo "No existe la opcion";
			break;
		}
	}
	else
	{
		echo "Error de envio de datos";
	}
?>