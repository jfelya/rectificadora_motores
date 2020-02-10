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
		include("conexion.php");
		$agregar = $_REQUEST["agregar"];
		$part_id = $_REQUEST["part_id"];
		$query = "SELECT * FROM piezas WHERE part_id = '$part_id'";
		$resultado = $conexion->query($query);
		$row = $resultado->fetch_assoc();
		$name = $row["name"];
		$model = $row["model"];
		$brand = $row["brand"];
		$quantity = $row["quantity"];
		if ($quantity == "0" and $agregar == "quitar")
		{
			header("Location:mainpage.php?register=parttable&proceso=error_empty_item");
		}
		else
		{
			if ($agregar == "agregar")
			{
				$quantity = $quantity + "1";
			}
			if ($agregar == "quitar")
			{
				$quantity = $quantity - "1";
			}
			$mensaje_error = "";
			$todo_bien = TRUE;
			$sql = "UPDATE `piezas` SET name='$name', model='$model', brand='$brand', quantity='$quantity' WHERE part_id='$part_id'";
			$resultado = $conexion->query($sql);
			if ($resultado)
			{
				mysqli_close($conexion);
				header("Location:mainpage.php?register=parttable");
			}
			else
			{
				mysqli_close($conexion);
				header("Location:mainpage.php?proceso=error&register=arttable");
			}
		}
		?>
	</center>
</body>
</html>