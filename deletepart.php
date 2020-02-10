<!DOCTYPE html>
<html>
<head>
	<title>Modificar Usuario</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="felystyles.css">
</head>
<body>
	<center>
		<?php
		$part_id = $_REQUEST['part_id'];
		include("conexion.php");
		$query = "DELETE FROM piezas WHERE part_id='$part_id'";
		$resultado = $conexion->query($query);

		if ($resultado) 
		{
			header("Location:mainpage.php?register=parttable");
		} else
		{
			echo "<h3>Error eliminando los datos</h3><br>";
			echo '<br><a class="btn btn-primary" role="button" .disabled href="users.php">Mostrar datos</a>
			<a class="btn btn-info" role="button" .disabled href="mainpage.php?register=parttable">Inicio</a>';
		}
		?>
	</center>
</body>
</html>