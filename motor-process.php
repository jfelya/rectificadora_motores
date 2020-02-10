<!DOCTYPE html>
<html>
<head> 
	<title>Registrar Motor - Proceso</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="felystyles.css">
</head>
<body>
	<center> 
		<?php
		if (isset($_POST['registrarBtn']))
		{
			include("conexion.php");
			$owner = $_POST["owner"];
			$model = $_POST["model"];
			$brand = $_POST["brand"];
			$year = $_POST["year"];
			$mensaje_error = "";
			$todo_bien = TRUE;
			$sql2 = "SELECT * FROM motores WHERE owner = '$owner'";
			$resultado2 = $conexion->query($sql2);
			$row2 = $resultado2->fetch_assoc();

			if ($row2['$owner'])
			{
				$mensaje_error = $mensaje_error. "El motor ya existe\n";
				$todo_bien = FALSE;
			}
			else
			{
				if ($owner == "" or $model == "" or $year == "" or $brand == "")
				{
					header("Location:mainpage.php?proceso=campo_vacio&register=motor");
				}
				else
				{
				// COMPROBACIÓN DEL DUEÑO
					if (strlen($owner) > 30)
					{
						$mensaje_error = $mensaje_error. "El nombre del dueño no puede ser mayor a 30 caracteres<br>";
						$todo_bien = FALSE;
					}
					if (strlen($owner) < 4)
					{
						$mensaje_error = $mensaje_error. "El nombre del dueño no puede ser menor a 4 caracteres<br>";
						$todo_bien = FALSE;
					}
				// COMPROBACIÓN DEL DUEÑO
				// COMPROBACIÓN DEL MODELO
					if (strlen($model) > 30)
					{
						$mensaje_error = $mensaje_error. "El nombre del modelo no puede ser mayor a 30 caracteres<br>";
						$todo_bien = FALSE;
					}
					if (strlen($model) < 2)
					{
						$mensaje_error = $mensaje_error. "El nombre del modelo no puede ser menor a 2 caracteres<br>";
						$todo_bien = FALSE;
					}
				// COMPROBACIÓN DEL MODELO
				// COMPROBACIÓN DE LA MARCA
					if (strlen($brand) > 30)
					{
						$mensaje_error = $mensaje_error. "El nombre del modelo no puede ser mayor a 30 caracteres<br>";
						$todo_bien = FALSE;
					}
					if (strlen($brand) < 2)
					{
						$mensaje_error = $mensaje_error. "El nombre del modelo no puede ser menor a 4 caracteres<br>";
						$todo_bien = FALSE;
					}
				// COMPROBACIÓN DE LA MARCA
				// COMPROBACIÓN DEL AÑO
					if (strlen($year) > 5)
					{
						$mensaje_error = $mensaje_error. "El año no puede ser mayor a 5 dígitos<br>";
						$todo_bien = FALSE;
					}

					if (!is_numeric($year)) {
						$mensaje_error = $mensaje_error. "El año solo puede ser expresado en números<br>";
						$todo_bien = FALSE;
					}
				// COMPROBACIÓN DEL AÑO
					if ($todo_bien == FALSE)
					{
						echo "<p class='alert2'>". $mensaje_error ."</p><br>";
						echo '<a class="btn btn-success" role="button" .disabled href="mainpage.php?register=motor">Regresar</a>';
					}
					else
					{
						$sql = "INSERT INTO `motores` (`owner`, `model`, `brand`, `year`) VALUES ('$owner', '$model', '$brand', '$year');";

						$resultado = $conexion->query($sql);

						if ($resultado)
						{
							mysqli_close($conexion);
							header("Location:mainpage.php?proceso=exito_motor&register=motor");
						}
						else
						{
							mysqli_close($conexion);
							header("Location:mainpage.php?proceso=error&register=motor");
						}
					}
				}
			}	
	// Si no se presionó el botón de Registrar regresar		
		}
		elseif (isset($_POST["modificarBtn"]))
		{
			include("conexion.php");
			$motor_id = $_REQUEST["motor_id"];
			$owner = $_POST["owner"];
			$model = $_POST["model"];
			$brand = $_POST["brand"];
			$year = $_POST["year"];
			$mensaje_error = "";
			$todo_bien = TRUE;
			if ($owner == "" or $model == "" or $year == "" or $brand == "")
			{
				header("Location:mainpage.php?proceso=campo_vacio&register=motor");
			}
			else
			{
				// COMPROBACIÓN DEL DUEÑO
				if (strlen($owner) > 30)
				{
					$mensaje_error = $mensaje_error. "El nombre del dueño no puede ser mayor a 30 caracteres<br>";
					$todo_bien = FALSE;
				}
				if (strlen($owner) < 4)
				{
					$mensaje_error = $mensaje_error. "El nombre del dueño no puede ser menor a 4 caracteres<br>";
					$todo_bien = FALSE;
				}
				// COMPROBACIÓN DEL DUEÑO
				// COMPROBACIÓN DEL MODELO
				if (strlen($model) > 30)
				{
					$mensaje_error = $mensaje_error. "El nombre del modelo no puede ser mayor a 30 caracteres<br>";
					$todo_bien = FALSE;
				}
				if (strlen($model) < 4)
				{
					$mensaje_error = $mensaje_error. "El nombre del modelo no puede ser menor a 4 caracteres<br>";
					$todo_bien = FALSE;
				}
				// COMPROBACIÓN DEL MODELO
				// COMPROBACIÓN DE LA MARCA
				if (strlen($brand) > 30)
				{
					$mensaje_error = $mensaje_error. "El nombre del modelo no puede ser mayor a 30 caracteres<br>";
					$todo_bien = FALSE;
				}
				if (strlen($brand) < 4)
				{
					$mensaje_error = $mensaje_error. "El nombre del modelo no puede ser menor a 4 caracteres<br>";
					$todo_bien = FALSE;
				}
				// COMPROBACIÓN DE LA MARCA
				// COMPROBACIÓN DEL AÑO
				if (strlen($year) > 5)
				{
					$mensaje_error = $mensaje_error. "El año no puede ser mayor a 5 dígitos<br>";
					$todo_bien = FALSE;
				}
				if (!is_numeric($year)) {
					$mensaje_error = $mensaje_error. "El año solo puede ser expresado en números<br>";
					$todo_bien = FALSE;
				}
				// COMPROBACIÓN DEL AÑO
				if ($todo_bien == FALSE)
				{
					echo "<p class='alert2'>". $mensaje_error ."</p><br>";
					echo '<a class="btn btn-success" role="button" .disabled href="mainpage.php?register=motor?motor_id='.$motor_id.'">Regresar</a>';
				}
				else
				{
					$sql = "UPDATE `motores` SET owner='$owner', model='$model', brand='$brand', year='$year' WHERE motor_id='$motor_id'";

					$resultado = $conexion->query($sql);

					if ($resultado)
					{
						mysqli_close($conexion);
						header("Location:mainpage.php?proceso=exito_motor_modify&register=motor&motor_id=". $motor_id ."");
					}
					else
					{
						mysqli_close($conexion);
						header("Location:mainpage.php?proceso=error&register=motor&motor_id=". $motor_id ."");
					} //IF $RESULT DOES NOT EXIST
				} // TODO BIEN = TRUE
			} //IF NOT EMPTY
		} //IF MODIFICARBTN IS NOT SET
		else
		{
			header("Location:mainpage.php?register=motor");
		}
		?>
	</center>
</body>
</html>