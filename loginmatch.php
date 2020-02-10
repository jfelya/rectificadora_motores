<!DOCTYPE html>
<html>
<head>
	<title>Procesado de Datos</title>
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
			header("Location:mainpage.php");
		}
		else
		{
			if (isset($_POST['ingresarBtn']))
			{ 
				include("conexion.php");
				$user = $_POST["user"];
				$password = $_POST["password"];
				$level = "";
				$mensaje_error = "";
				$todo_bien = TRUE;
				if ($user == "")
				{
					$mensaje_error = $mensaje_error. "No puedes ingresar sin tu usuario<br>";
					$todo_bien = FALSE;
				}
				if ($password == "")
				{
					$mensaje_error = $mensaje_error. "No puedes ingresar sin tu contraseña<br>";
					$todo_bien = FALSE;
				}
			//VALIDACIÓN PRINCIPAL
				if ($todo_bien == FALSE)
				{
					echo "<h4><strong><font color='red'>". $mensaje_error ."</font></strong></h4><br>";
					echo '<a class="btn btn-success" role="button" .disabled href="login.php">Regresar</a>';
				}
				else
				{
					$sql2 = "SELECT * FROM usuarios WHERE user = '$user'";
					$resultado2 = $conexion->query($sql2);
					$row2 = $resultado2->fetch_assoc();

					if (!$row2['user'] || $row2['user'] == "")
					{
						header("Location:login.php?error=no_existe_usuario");
					}
					else
					{
						$sql = "SELECT * FROM usuarios WHERE user = '$user'";
						$resultado = $conexion->query($sql);

						if ($resultado->num_rows > 0)
						{
							$row = $resultado->fetch_assoc();
						}

						if ($password !== $row['password'])
						{
							header("Location:login.php?error=contrasena_incorrecta");
						}
						else
						{
							$level = $row2['level'];
							mysqli_close($conexion);
							$_SESSION['activeuser'] = TRUE;
							$_SESSION['user'] = $user;
							$_SESSION['level'] = $level;

							if ($level == "Control") 
							{
								header("Location:mainpage.php?bill=motor");
							}
							if ($level == "Jefe de Mecanicos")
							{
								header("Location:mainpage.php");
							}
							if ($level == "Admin")
							{
								header("Location:register.php");
							}
						}	
					}
				}
			}	
		// Si el botón de ingresar no ha sido presionado redireccionar
			else
			{
				header("Location:login.php");
			}
		}
		
		?>
	</center>
</body>
</html>