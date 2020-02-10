<!DOCTYPE html>
<html>
<head>
	<title>Registrar Usuario - Proceso</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="felystyles.css">
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
				if (isset($_POST['registrarBtn']))
				{
					include("conexion.php");
					$user = $_POST["user"];
					$email = $_POST["email"];
					$password = $_POST["password"];
					$password2 = $_POST["password2"];
					$level = $_POST["level"];
					$mensaje_error = "";
					$todo_bien = TRUE;
					$sql2 = "SELECT * FROM usuarios WHERE user = '$user'";
					$resultado2 = $conexion->query($sql2);
					$row2 = $resultado2->fetch_assoc();

					if ($row2['$user'])
					{
						$mensaje_error = $mensaje_error. "El usuario ya existe\n";
						$todo_bien = FALSE;
					}
					else
					{
						if ($user == "" or $email == "" or $password == "" or $password2 == "")
						{
							header("Location:register.php?proceso=campo_vacio");
						}
						else
						{
						// COMPROBACIÓN DE USUARIO
							if (strlen($user) > 30)
							{
								$mensaje_error = $mensaje_error. "Tu nombre de usuario no puede ser mayor a 30 caracteres<br>";
								$todo_bien = FALSE;
							}
							if (strlen($user) < 4)
							{
								$mensaje_error = $mensaje_error. "Tu nombre de usuario no puede ser menor a 4 caracteres<br>";
								$todo_bien = FALSE;
							}
						// COMPROBACIÓN DE USUARIO
						// COMPROBACIÓN DE CORREO
							if (strlen($email) > 40)
							{
								$mensaje_error = $mensaje_error. "Tu correo no puede ser mayor a 40 caracteres<br>";
								$todo_bien = FALSE;
							}

							if (filter_var($email, FILTER_VALIDATE_EMAIL) == FALSE)
							{
								$mensaje_error = $mensaje_error. "El correo ingresado no es válido<br>";
								$todo_bien = FALSE;
							}
						// COMPROBACIÓN DE CORREO
						// COMPROBACIÓN DE CONTRASEÑA
							if (strlen($password) > 20)
							{
								$mensaje_error = $mensaje_error. "Tu contraseña no puede ser mayor a 20 caracteres<br>";
								$todo_bien = FALSE;
							}
							if (strlen($password) < 4)
							{
								$mensaje_error = $mensaje_error. "Tu contraseña no puede ser menor a 4 caracteres<br>";
								$todo_bien = FALSE;
							}
							if ($password !== $password2)
							{
								$mensaje_error = $mensaje_error. "Las contraseñas no coinciden<br>";
								$todo_bien = FALSE;
							}
						// COMPROBACIÓN DE CONTRASEÑA
							if ($todo_bien == FALSE)
							{
								echo "<h4><strong><font color='red'>". $mensaje_error ."</font></strong></h4><br>";
								echo '<a class="btn btn-success" role="button" .disabled href="register.php">Regresar</a>';
							}
							else
							{
								$sql = "INSERT INTO `usuarios` (`user`, `email`, `password`, `level`) VALUES ('$user', '$email', '$password', '$level')";
								$resultado = $conexion->query($sql);
								if ($resultado)
								{
									mysqli_close($conexion);
									header("Location:register.php?proceso=exito");
								}
								else
								{
									mysqli_close($conexion);
									header("Location:register.php?proceso=error");
								} //SI EL RESULTADO TIENE DATOS
							} //SI TODO VA BIEN
						} //SI LOS CAMPOS NO ESTÁN VACÍOS
					} // SI EL USUARIO NO EXISTE
				} // Si no se presionó el botón de Registrar	
				else
				{
					header("Location:register.php");
				}
			} // SI EL USUARIO NO ES ADMIN
		} // SI LA SESIÓN ESTÁ PUESTA
		else
		{
			header("Location:login.php");
		} // SI NO HAY SESIÓN ACTIVA
		?>
	</center>
</body>
</html>