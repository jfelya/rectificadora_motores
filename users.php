<!DOCTYPE html>
<html>
<head> 
	<title>Tabla</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
	<meta charset="utf-8">
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
			?>
			<table class="table table-dark" border="1px">
				<thead>
					<tr>
						<th class="title" colspan="6">
							Lista de usuarios
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th class="title">
							Usuario
						</th>
						<th class="title">
							Email
						</th>
						<th class="title">
							Nivel de Administración
						</th>
						<th class="title" colspan="2">
							Modificaciones
						</th>
					</tr>
					<?php
					include("conexion.php");
					$query = "SELECT * FROM usuarios";
					$resultado = $conexion->query($query);
					while ($row = $resultado->fetch_assoc())
					{
						?>
						<tr>
							<td>
								<?php echo $row['user']; ?>
							</td>
							<td>
								<?php echo $row['email']; ?>
							</td>
							<td>
								<?php echo $row['level']; ?>
							</td>
							<td>
								<a href="modify.php?user_id=<?php echo $row['user_id']; ?>">Modificar</a>
							</td>
								<td>
								<a href="delete.php?user_id=<?php echo $row['user_id']; ?>">Eliminar</a>
							</td>							
						</tr>
						<?php
					}
					?>
				</tbody>
			</table><br><br>
			<a class="btn btn-primary" role="button" .disabled href="register.php">Registro de Usuarios</a>
			<a class="btn btn-danger" role="button" .disabled href="logout.php">Cerrar Sesión</a>
			<?php
		}
		?>
	</center>
</body>
</html>