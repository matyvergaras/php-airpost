<?php
	require_once('phpmailer/class.phpmailer.php');
	require_once('solicitud.php');
	require_once('cuenta.php');
	require_once('apertura.php');
	class Correo
	{
		private $dir = "localhost/";
		/*private $dir = "http://www.tree-solutions.cl/testcorreo/"*/
		private $correo;
		private $empresa;
		private $nombre;
		private $apellido;
		private $asunto;
		private $correoEnvio;
		private $campana;
		private $lista;

		public function setCorreo($correo)
		{
			$this->correo = $correo;
		}

		public function getCorreo()
		{
			return $this->correo;
		}

		public function setNombre($nombre)
		{
			$this->nombre = $nombre;
		}

		public function getNombre()
		{
			return $this->nombre;
		}

		public function setApellido($apellido)
		{
			$this->apellido = $apellido;
		}

		public function getApellido()
		{
			return $this->apellido;
		}

		public function setAsunto($asunto)
		{
			$this->asunto = $asunto;
		}

		public function getAsunto()
		{
			return $this->asunto;
		}

		public function setCorreoEnvio($correoEnvio)
		{
			$this->correoEnvio = $correoEnvio;
		}

		public function getCorreoEnvio()
		{
			return $this->correoEnvio;
		}

		public function setEmpresa($empresa)
		{
			$this->empresa = $empresa;
		}

		public function getEmpresa()
		{
			return $this->empresa;
		}

		public function setCampana($campana)
		{
			$this->campana = $campana;
		}

		public function getCampana()
		{
			return $this->campana;
		}

		public function setLista($lista)
		{
			$this->lista = $lista;
		}

		public function getLista()
		{
			return $this->lista;
		}

		public function avisoSolicitud()
		{
			$mail = new PHPMailer();

			$mail->IsSMTP();  // telling the class to use SMTP
			$mail->Host     = "servidor.hostingnet.cl"; // SMTP server
			$mail->Port 	= 587;
			$mail->Username = "avisoadministradores@tree-solutions.cl";
			$mail->Password = "tptp3126904casa";

			$mail->From     = "avisoadministradores@tree-solutions.cl";
			$mail->FromName = "Solicitud de demo";
			$mail->AddAddress("avisoadministradores@tree-solutions.cl", "Administradores");
			$mail->AddReplyTo($this->correo, $this->empresa);

			$mail->Subject  = "Solicitud de demo";
			$mensaje = "Estimados administradores:<br>".
			"Hemos recibido una solicitud de demo de parte de la empresa " .$this->empresa."<br>".
			"realizada por ".$this->nombre." ".$this->apellido."<br><br>".
			"Aviso administradores Tree Solutions"
			;
			$mail->Body     = $mensaje;
			$mail->IsHTML(true);
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = "tls";
			$mail->SMTPOptions = array(
									    'ssl' => array(
									        'verify_peer' => false,
									        'verify_peer_name' => false,
									        'allow_self_signed' => true
									    )
									);

			if(!$mail->Send()) {
			  return "notsent";
			} else {
			  return "sent";
			}
		}

		public function recuperaClave($link)
		{
			$mail = new PHPMailer();

			$mail->IsSMTP();  // telling the class to use SMTP
			$mail->Host     = "servidor.hostingnet.cl"; // SMTP server
			$mail->Port 	= 587;
			$mail->Username = "avisoadministradores@tree-solutions.cl";
			$mail->Password = "tptp3126904casa";

			$mail->From     = "avisoadministradores@tree-solutions.cl";
			$mail->FromName = "No responder";
			$mail->AddAddress($this->getCorreo(), "Recuperación");
			$mail->AddReplyTo("avisoadministradores@tree-solutions.cl", "Recuperación");

			$mail->Subject  = utf8_decode("Recuperación de clave");
			$mensaje = utf8_decode("Hemos recibido una solicitud de recuperación de clave.<br><br>
			Si usted no ha realizado esta petición, la seguridad de su cuenta<br>
			podria estar comprometida.<br><br>
			Si usted ha realizado esta petición entonces haga clic en el link<br>
			para recuperar su clave <a href='".$link."'>Recupere su clave aquí</a>.");
			$mail->Body     = $mensaje;
			$mail->IsHTML(true);
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = "tls";
			$mail->SMTPOptions = array(
									    'ssl' => array(
									        'verify_peer' => false,
									        'verify_peer_name' => false,
									        'allow_self_signed' => true
									    )
									);

			if(!$mail->Send()) {
			  return "notsent";
			} else {
			  return "sent";
			}	
		}

		public function enviaCampana()
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			$id = 0;

			$mail = new PHPMailer();

			$mail->IsSMTP();  // telling the class to use SMTP
			$mail->Host     = "servidor.hostingnet.cl"; // SMTP server
			$mail->Port 	= 587;
			$mail->Username = "avisoadministradores@tree-solutions.cl";
			$mail->Password = "tptp3126904casa";
			$mail->From     = $this->getCorreo();
			$mail->FromName = $this->getEmpresa();
			$mail->Subject  = utf8_decode($this->getAsunto());
			$mail->IsHTML(true);
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = "tls";
			$mail->SMTPOptions = array(
									    'ssl' => array(
									        'verify_peer' => false,
									        'verify_peer_name' => false,
									        'allow_self_signed' => true
									    )
									);
			if($resultado = $var->query("SELECT * FROM contactoslista WHERE idlista='".$this->getLista()."'"))
			{
				if(mysqli_num_rows($resultado) > 0)
				{
					while($fila = $resultado->fetch_array())
					{
						$this->setNombre($fila["campo1"]);
						$this->setApellido($fila["campo2"]);
						$this->setCorreoEnvio($fila["correo"]);

						$apertura = new Apertura();
						$apertura->setCampana($this->getCampana());
						$apertura->setCorreo($this->getCorreoEnvio());
						$apertura->insertaApertura();
						
						if($this->getNombre() != null && $this->getApellido() != null)
							$mail->AddAddress($this->getCorreoEnvio(), $this->getNombre()." ".$this->getApellido());
						else
							$mail->AddAddress($this->getCorreoEnvio(), "Contacto");
						$mail->AddReplyTo($this->getCorreo(), $this->getEmpresa());

						$mensaje = utf8_decode("Este es un correo penca generado por las primeras pruebas<br>
							de envío de correo usando Airpost, si recibe este correo por favor abralo para<br>
							que podamos comprobar que usted lo recibio.<br><br>
							Atentamente el equipo Airpost.<br>
							<img src='".$this->dir."airpost/home/tracking.php?campana=".$this->getCampana()."&correo=".$this->getCorreoEnvio()."' style='display:none'>");
						$mail->Body     = $mensaje;
						

						$mail->Send();
					}
				}
			}
		} 
	}
?>