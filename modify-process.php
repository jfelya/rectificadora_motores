<!DOCTYPE html>
<html>
<head>
	<title>Modificar Usuario - Proceso</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="felystyles.css">
</head>
<body>
	<center>
		<?php
		session_start();
		if (!isset($_SESSION['user']) and $_SESSION['activeuser'] == FALSE and $_SESSION["level"] !== "Admin")
		{
			header("Location:mainpage.php");
		}
		else
		{
			if (isset($_POST['modificarBtn']))
			{
				include("conexion.php");
				$user_id = $_REQUEST['user_id'];
				$user = $_POST["user"];
				$email = $_POST["email"];
				$password = $_POST["password"];
				$password2 = $_POST["password2"];
				$level = $_POST["level"];
				$mensaje_error = "";
				$todo_bien = TRUE;

				if ($user == "" or $email == "" or $password == "" or $password2 == "")
				{
					header("Location:modify.php?proceso=campo_vacio&user_id=". $user_id. "");
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
						echo '<a class="btn btn-success" role="button" .disabled href="modify.php?user_id='. $user_id. '">Regresar</a>';
					}
					else
					{						
						$sql = "UPDATE usuarios SET user = '$user', email = '$email', password = '$password', level = '$level' WHERE user_id='$user_id'";
						$resultado = $conexion->query($sql);
						if ($resultado)
						{
							mysqli_close($conexion);
							header("Location:modify.php?proceso=exito&user_id=". $user_id. "");
						}
						else
						{
							mysqli_close($conexion);
							header("Location:modify.php?proceso=error&user_id=". $user_id. "");
						}
					}
				}				
			// Si no se presionó el botón de Registrar regresar		
			}
			else
			{
				header("Location:modify.php?user_id=". $user_id. "");
			}
		}
		?>
	</center>
</body>
</html>