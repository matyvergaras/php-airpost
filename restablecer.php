<?php
	if(isset($_GET["h32"]) && isset($_GET["h56"]) && isset($_GET["h89"]))
	{
		session_start();
		$_SESSION["h89"] = $_GET["h89"];
		$_SESSION["h32"] = $_GET["h32"];
		$_SESSION["h56"] = $_GET["h56"];
		$_SESSION["h22"] = $_GET["h22"];
		$_SESSION["correo"] = $_GET["correo"];

?>
<!DOCTYPE html> 
<html>
	<head>
		<title>Restablecer Clave</title>
		
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
						txtClave:
						{
							required: true,
							minlength: 8,
							maxlength: 20
						},
						txtRepetir:
						{
							required: true,
							minlength: 8,
							maxlength: 20,
							equalTo: '#txtClave'
						}
					},
										
					// Messages for form validation
					messages:
					{
						txtClave:
						{
							required: 'Por favor ingrese su clave',
							minlength: 'La clave debe tener entre 8 y 20 carácteres',
							minlength: 'La clave debe tener entre 8 y 20 carácteres'
						},
						txtRepetir:
						{
							required: 'Por favor ingrese su clave',
							minlength: 'La clave debe tener entre 8 y 20 carácteres',
							minlength: 'La clave debe tener entre 8 y 20 carácteres',
							equalTo: 'Ambas claves deben coincidir'
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
					<header>Restablecer Clave</header>
					
					<fieldset>					
						<section>
							<label class="input">
								<i class="icon-append fa fa-user"></i>
								<input type="password" name="txtClave" placeholder="Clave" id="txtClave">
								<b class="tooltip tooltip-bottom-right">Por favor ingrese su correo</b>
							</label>
						</section>
						
						<section>
							<label class="input">
								<i class="icon-append fa fa-lock"></i>
								<input type="password" name="txtRepetir" placeholder="Repetir">
								<b class="tooltip tooltip-bottom-right">Por favor ingrese su clave</b>
							</label>
							
						</section>
						
					</fieldset>
					<footer>
						<button type="submit" class="button" name="botonsubmit" value="Restablecer">Restablecer</button>
					</footer>
				</form>			
			</div>
	</body>
</html>
<?php
	}
	else
	{
		header("Location: index.php");
	}
?>