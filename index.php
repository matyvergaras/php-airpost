<!DOCTYPE html> 
<html>
	<head>
		<title>Entrar</title>
		
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
		<link rel='shortcut icon' href='img/Logo-Airpost-Final-05.jpg' type='image/ico' />
		<link rel="stylesheet" href="css/demo.css">
		<link rel="stylesheet" href="css/font-awesome.css">
		<link rel="stylesheet" href="css/sky-forms.css">
		
		<script src="js/jquery.js" type="text/javascript"></script>
		<script src="js/funciones.js" type="text/javascript"></script>
		<script src="js/jquery.base64.js" type="text/javascript"></script>
		<script src="js/jquery.validate.min.js" type="text/javascript"></script>
		
		<script type="text/javascript">
			$(function()
			{
				// Validation for login form
				$("#login").validate(
				{					
					// Rules for form validation
					rules:
					{
						txtCorreo:
						{
							required: true,
							email: true
						},
						txtClave:
						{
							required: true,
							minlength: 8,
							maxlength: 20
						}
					},
										
					// Messages for form validation
					messages:
					{
						txtCorreo:
						{
							required: 'Por favor ingrese su correo',
							email: 'Por favor ingrese un correo válido'
						},
						txtClave:
						{
							required: 'Por favor ingrese su clave'
						}
					},					
					
					// Do not change code below
					errorPlacement: function(error, element)
					{
						error.insertAfter(element.parent());
					}
				});
			});
		</script>
	</head>
	
	<body class="bg-cyan">
		<div class="body body-s">		
				<form action="home/controladorpost.php" id="login" class="sky-form" name="login" method="post">
					<header>Entrar</header>
					
					<fieldset>					
						<section>
							<label class="input">
								<i class="icon-append fa fa-user"></i>
								<input type="text" name="txtCorreo" placeholder="Correo">
								<b class="tooltip tooltip-bottom-right">Por favor ingrese su correo</b>
							</label>
						</section>
						
						<section>
							<label class="input">
								<i class="icon-append fa fa-lock"></i>
								<input type="password" name="txtClave" placeholder="Clave" id="password">
								<b class="tooltip tooltip-bottom-right">Por favor ingrese su clave</b>
							</label>
							<div class="note"><a href="recuperar.html" class="modal-opener">Olvidó su clave?</a></div>
							<div id='mensajerror'>
								<?php
									session_start();
									if(isset($_SESSION["error"]))
										echo $_SESSION["error"];
									session_destroy();
								?>
							</div>
						</section>
						
					</fieldset>
					<footer>
						<button type="submit" class="button" name="botonsubmit" value="Entrar">Entrar</button>
						<a href="registro.html" class="button button-secondary">Solicitar Demo</a>
					</footer>
				</form>			
			</div>
	</body>
</html>