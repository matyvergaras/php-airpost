<?php
	require_once('conexion.php');
	class Cuenta
	{
		private $dir = "localhost/airpost/";
		//private $dir = "http://www.tree-solutions.cl/testcorreo/airpost/home/";
		private $correo;
		private $nombre;
		private $clave;
		private $perfil;
		private $activa;
		private $idplan;
		private $validacion;
		private $conexion;

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

		public function setClave($clave)
		{
			$this->clave = $clave;
		}

		public function getClave()
		{
			return $this->clave;
		}

		public function setPerfil($perfil)
		{
			$this->perfil = $perfil;
		}

		public function getPerfil()
		{
			return $this->perfil;
		}

		public function setActiva($activa)
		{
			$this->activa = $activa;
		}

		public function getActiva()
		{
			return $this->activa;
		}

		public function setIdPlan($idplan)
		{
			$this->idplan = $idplan;
		}

		public function getIdPlan()
		{
			return $this->idplan;
		}

		public function setValidacion($validacion)
		{
			$this->validacion = $validacion;
		}

		public function getValidacion()
		{
			return $this->validacion;
		}

		public function validaLogin()
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			$result = $var->query("SELECT nombre, correo, perfil, activa, idplan FROM cuentas WHERE correo='".$this->correo."' AND clave='".$this->clave."'");
			if(mysqli_num_rows($result) > 0)
			{
				$row = $result->fetch_assoc();
				$retorno = new Cuenta();
				$retorno->setCorreo($row["correo"]);
				$retorno->setNombre($row["nombre"]);
				$retorno->setPerfil($row["perfil"]);
				$retorno->setActiva($row["activa"]);
				$retorno->setIdPlan($row["idplan"]);
				$this->conexion->closeConnection();
				return $retorno;
			}
			else
			{
				$this->conexion->closeConnection();
				return false;
			}
		}

		function buscaRepetido()
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			if($resultado = $var->query("SELECT * FROM cuentas WHERE rut='".$this->rut."' OR correo='".$this->correo."'"))
			{
				while($fila = $resultado->fetch_array())
				{
					if($fila["rut"] == $this->rut || $fila["correo"] == $this->correo)
						return true;
				}
			}
			$this->conexion->closeConnection();
			return false;
		}

		private function limpiar_caracteres_especiales($string ){
			$string = htmlentities($string);
			$string = preg_replace('/\&(.)[^;]*;/', '\\1', $string);
			return $string;
		}

		private function buscaMayusculas($pass)
		{
			$valido = false;
			$string = $pass;
			$i = 0;
			$maxleng = strlen($string)-1;
			$string_sce = $this->limpiar_caracteres_especiales($string);
			for($i=0;$i < $maxleng ;$i++)
			{
			    if($string_sce[$i] == strtoupper($string_sce[$i]))
			    {
			        $valido = true;
			        break;
			    }
			}
			return $valido; 
		}

		private function buscaMinusculas($pass)
		{
			$valido = false;
			$string = $pass;
			$i = 0;
			$maxleng = strlen($string)-1;
			$string_sce = $this->limpiar_caracteres_especiales($string);
			for($i=0;$i < $maxleng ;$i++)
			{
			    if($string_sce[$i] == strtolower($string_sce[$i]))
			    {
			        $valido = true;
			        break;
			    }
			}
			return $valido; 
		}

		public function totalCorrectos()
		{
			$correctos = 0;
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			if($resultado = $var->query("SELECT COUNT(cl.correo) FROM contactoslista AS cl, listas AS l WHERE l.id=cl.idlista AND l.correo='".$this->correo."'"))
			{
				while($fila = $resultado->fetch_array())
				{
					if($resultado->num_rows > 0)
					{
						$correctos = $fila["COUNT(cl.correo)"];
					}
				}
			}
			$this->conexion->closeConnection();
			return $correctos;
		}

		public function totalErroneos()
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			$erroneos = 0;
			if($resultado = $var->query("SELECT COUNT(cl.correo) FROM contactoslista AS cl, listas AS l WHERE l.id=cl.idlista AND l.correo='".$this->correo."' AND cl.estado=0"))
			{
				while($fila = $resultado->fetch_array())
				{
					if($resultado->num_rows > 0)
					{
						$erroneos = $fila["COUNT(cl.correo)"];
					}
				}
			}
			$this->conexion->closeConnection();
			return $erroneos;
		}

		public function ifExiste()
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			if($resultado = $var->query("SELECT * FROM cuentas WHERE correo='".$this->correo."'"))
			{
				while($fila = $resultado->fetch_array())
				{
					if($fila["correo"] == $this->correo)
					{
						$this->conexion->closeConnection();
						return true;
					}
				}
			}
			$this->conexion->closeConnection();
			return false;
		}

		public function retornaPerfil($correo)
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			if($resultado = $var->query("SELECT * FROM cuentas WHERE correo='".$this->correo."'"))
			{
				while($fila = $resultado->fetch_array())
				{
					if($fila["correo"] == $this->correo)
					{
						$this->conexion->closeConnection();
						return $fila["perfil"];
					}
				}
			}
			$this->conexion->closeConnection();
			return false;
		}

		public function buscaUnaPorCorreo()
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			$account = null;
			if($resultado = $var->query("SELECT * FROM cuentas WHERE correo='".$this->correo."'"))
			{
				while($fila = $resultado->fetch_array())
				{
					if($resultado->num_rows > 0)
					{
						$account = new Cuenta();
						$account->setCorreo($fila["correo"]);
						$account->setNombre($fila["nombre"]);
						$account->setPerfil($fila["perfil"]);
						$account->setActiva($fila["activa"]);
						$account->setIdPlan($fila["idplan"]);	
					}
				}
			}
			$this->conexion->closeConnection();
			return $account;
		}

		public function buscaUnaPorCorreoEncriptado()
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			$account = null;
			if($resultado = $var->query("SELECT * FROM cuentas WHERE md5(correo)='".$this->getCorreo()."'"))
			{
				while($fila = $resultado->fetch_array())
				{
					if($resultado->num_rows > 0)
					{
						$account = new Cuenta();
						$account->setCorreo($fila["correo"]);
						$account->setNombre($fila["nombre"]);
						$account->setPerfil($fila["perfil"]);
						$account->setActiva($fila["activa"]);
						$account->setIdPlan($fila["idplan"]);	
					}
				}
			}
			$this->conexion->closeConnection();
			return $account;
		}

		public function buscaPorRestablecer()
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			$account = null;
			if($resultado = $var->query("SELECT * FROM cuentas WHERE correo='".$this->correo."'"))
			{
				while($fila = $resultado->fetch_array())
				{
					if($resultado->num_rows > 0)
					{
						$account = new Cuenta();
						$account->setValidacion($fila["validacion"]);
						$account->setCorreo($fila["correo"]);	
					}
				}
			}
			$this->conexion->closeConnection();
			return $account;
		}

		public function generarLinkRecuperacion()
		{
			
			$aleatorio1 = $this->aleatorio();
			$aleatorio2 = $this->aleatorio();
			$aleatorio3 = $this->aleatorio();
			$aleatorio4 = rand(1,3);

			if($aleatorio4 == 1)
			{
				$aleatorio4 = "71248b05b2a35abfacc72bb07cc651a3";
				$this->insertaVariableRecuperacion($aleatorio1);
			}
			else if($aleatorio4 == 2)
			{
				$aleatorio4 = "3ec3d8cde6e40d71013d8b8236a94cf9";
				$this->insertaVariableRecuperacion($aleatorio2);
			}
			else if($aleatorio4 == 3)
			{
				$aleatorio4 = "ac4e0b7ea021ecf237f6a0d78f4de1bd";
				$this->insertaVariableRecuperacion($aleatorio3);
			}
			
		    $link = $this->dir."restablecer.php?h89=".$aleatorio1."&h32=".$aleatorio2."&h56=".$aleatorio3."&h22=".$aleatorio4."&correo=".$this->correo;
		    return $link;
		}

		private function aleatorio()
		{
			//Se define una cadena de caractares. Te recomiendo que uses esta.
		    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		    //Obtenemos la longitud de la cadena de caracteres
		    $longitudCadena=strlen($cadena);
		     
		    //Se define la variable que va a contener la contraseña
		    $pass = "";
		    //Se define la longitud de la contraseña, en mi caso 10, pero puedes poner la longitud que quieras
		    $longitudPass=32;
		     
		    //Creamos la contraseña
		    for($i=1 ; $i<=$longitudPass ; $i++){
		        //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
		        $pos=rand(0,$longitudCadena-1);
		     
		        //Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
		        $pass .= substr($cadena,$pos,1);
		    }
		    return $pass;
		}

		public function insertaVariableRecuperacion($variable)
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			if($resultado = $var->query("UPDATE cuentas SET validacion='".$variable."' WHERE correo='".$this->getCorreo()."'") > 0)
			{
				$this->conexion->closeConnection();
				return true;
			}
			$this->conexion->closeConnection();
			return false;
		}

		public function restableceClave()
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			if($resultado = $var->query("UPDATE cuentas SET clave='".md5($this->getClave())."' WHERE correo='".$this->getCorreo()."'") > 0)
			{
				$this->conexion->closeConnection();
				return true;
			}
			$this->conexion->closeConnection();
			return false;
		}

		public function porcentajeCumplido()
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			$plan = array();
			$plan[0] = "sinvalores";
			if($resultado = $var->query("SELECT pc.fechainicio, pc.fechatermino, pc.correosEnviados, p.tiempo, p.cantcontactos FROM planes_por_cuenta AS pc, planes AS p WHERE pc.cuenta='".$this->getCorreo()."' AND pc.activo=1 AND pc.idPlan=p.idplan ORDER BY pc.fechainicio DESC LIMIT 1"))
			{
				while($fila = $resultado->fetch_array())
				{
					if($resultado->num_rows > 0)
					{
						if($fila["tiempo"] == 0)
						{
							if($fila["tiempo"] == 0)
							{
								$plan[0] = "contactos";
								$plan[1] = $fila["correosEnviados"];
								$plan[2] = $fila["cantcontactos"];
							}
							else
							{
								$plan[0] = "dias";
								$inicio = $fila["fechainicio"];
								$termino = $fila["fechatermino"];
								$delta = strtotime($termino) - strtotime($inicio);
								$plan[1] = $inicio;
								$plan[2] = $termino;
								$plan[3] = $delta;
								$plan[4] = $fila["tiempo"];
							}
						}
					}
				}
			}
			$this->conexion->closeConnection();
			return $plan;
		}

		public function tieneCampanas()
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			$tiene = "no tiene";
			if($resultado = $var->query("SELECT * FROM campana WHERE correo='".$this->getCorreo()."'"))
			{
				while($fila = $resultado->fetch_array())
				{
					if($resultado->num_rows > 0)
					{
						$tiene = "tiene";
					}
				}
			}
			$this->conexion->closeConnection();
			return $tiene;
		}
		
	}
?>