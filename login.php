<!DOCTYPE html>
<html>
<head> 
	<title>Rectificadora de Motores Yadah Yireh C.A.</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="felystyles.css">
	<script src="../../FRAMEWORKS/SmoothScroll.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<center>
		<?php
		session_start();
		if (isset($_SESSION["user"]) and $_SESSION["activeuser"] == True)
		{
			if ($_SESSION["level"] == "Control" or $_SESSION["level"] == "Jefe de Mecanicos")
			{
				header("Location:mainpage.php");
			}
			if ($_SESSION["level"] == "Admin")
			{
				header("Location:register.php");
			}
		}
		else
		{
			?>
				<p class="shadow">
					Bienvenido a la Rectificadora de Motores Yadah Yireh C.A.
				</p>
			<div class="box">
				<form action="loginmatch.php" method="post">
					<br><div class="form-group">
						<div class="col-sm-6">
							<input class="form-control" id="user" type="text" name="user" placeholder="Usuario" autofocus="yes">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-6">
							<input class="form-control" id="password" type="password" name="password" placeholder="Contraseña">
						</div>
					</div><br>
					<div>
						<input class="btn btn-primary" type="submit" name="ingresarBtn" value="Ingresar" .disabled>
						<br><br>
						<a href="#">Olvidé mi contraseña</a>
						<br><br>
					</div>
				</form>
			</div>	
			<?php
		}
		?>
	</center>
</body>
</html>
<?php
if (isset($_REQUEST['error'])) 
{
	$error = $_REQUEST['error'];
	switch ($error) 
	{
		case "expirado":
		unset($_REQUEST['error']);
		echo "<script type='text/javascript'>alert('Tu sesión ha expirado, vuelve a iniciar sesión'); </script>";
		break;
		case "sin_sesion":
		unset($_REQUEST['error']);
		echo "<script type='text/javascript'>alert('Debes iniciar sesión primero para acceder al inicio'); </script>";
		break;

		case "no_existe_usuario":
		unset($_REQUEST['error']);
		echo "<script type='text/javascript'>alert('El usuario no existe'); </script>";
		break;

		case "contrasena_incorrecta":
		unset($_REQUEST['error']);
		echo "<script type='text/javascript'>alert('Tu contraseña es incorrecta'); </script>";
		break;
	}
}
?>