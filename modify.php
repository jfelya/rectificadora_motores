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
		session_start();
		if (!isset($_SESSION['user']) and $_SESSION['activeuser'] == FALSE and $_SESSION["level"] !== "Admin")
		{
			header("Location:mainpage.php");
		}
		else
		{
			$user_id = $_REQUEST['user_id'];
			include("conexion.php");
			$query = "SELECT * FROM usuarios WHERE user_id = '$user_id'";
			$resultado = $conexion->query($query);
			$row = $resultado->fetch_assoc();
			?>
				<p class="shadow">
					Modificar de Usuario
				</p>
				<p class="alert">
					Modifica solo dos datos que quieras cambiar
				</p>
			<div class="box">
				<form action="modify-process.php?user_id=<?php echo $row['user_id']; ?>" method="post">
					<div class="form-group">
						<label class="col-sm-2 col-form-label" for="user">
							Usuario
						</label>
						<div class="col-sm-7">
							<input class="form-control" id="user" type="text" name="user" placeholder="Ingrese su usuario" value="<?php echo $row['user']; ?>">
						</div>
						<small class="mini">Máximo de Caracteres: 30 / Mínimo de Caracteres: 4</small>
					</div>
					<div class="form-group">
						<label class="col-sm-2 col-form-label" for="email">
							Email
						</label>
						<div class="col-sm-7">
							<input class="form-control" id="email" type="email" name="email" placeholder="Ingrese su email" value="<?php echo $row['email']; ?>">
						</div>
						<small class="mini">Máximo de Caracteres: 40</small>
					</div>
					<div class="form-group">
						<label class="col-sm-2 col-form-label" for="password">
							Contraseña
						</label>
						<div class="col-sm-7">
							<input class="form-control" id="password" type="password" name="password" placeholder="Ingrese su contraseña" value="<?php echo $row['password']; ?>">
						</div>
						<small class="mini">Máximo de Caracteres: 20 / Mínimo de Caracteres: 4</small>
					</div>
					<div class="form-group">
						<label class="col-sm-2 col-form-label" for="password2">
							Confirmar contraseña
						</label>
						<div class="col-sm-7">
							<input class="form-control" id="password2" type="password" name="password2" placeholder="Ingrese su contraseña de nuevo">
						</div>
					</div>
					<div class="col-sm-5">
						Nivel de Administración
						<select class="form-control" name="level">
							<?php
							if ($row['level'] == "Control")
							{
								echo "<option>Control</option>
								<option>Jefe de Mecanicos</option>";
							}
							if ($row['level'] == "Jefe de Mecanicos")
							{
								echo "<option>Jefe de Mecanicos</option>
								<option>Control</option>";
							}
							?>			
						</select>
					</div><br>
					<div>
						<input class="btn btn-primary" type="submit" name="modificarBtn" value="Modificar usuario" .disabled>
					</div>
				</form>
			</div><br>
			<a class="btn btn-success" role="button" .disabled href="login.php">Registro de Usuarios</a>
			<a class="btn btn-secondary" role="button" .disabled href="users.php">Usuarios registrados</a><br><br>
			<a class="btn btn-danger" role="button" .disabled href="logout.php">Cerrar Sesión</a>
		</center>
		<?php
	}
	?>
</body>
</html>
<?php
if (isset($_REQUEST['proceso'])) 
{
	$proceso = $_REQUEST['proceso'];
	switch ($proceso) 
	{	
		case "campo_vacio":
		unset($_REQUEST['proceso']);
		echo "<script type='text/javascript'>alert('Debes llenar todos los campos, intenta de nuevo'); </script>";
		break;

		case "error":
		unset($_REQUEST['proceso']);
		echo "<script type='text/javascript'>alert('No se ha podido modificar tu usuario, intenta de nuevo'); </script>";
		break;

		case "exito":
		unset($_REQUEST['proceso']);
		echo "<script type='text/javascript'>alert('Tu usuario ha sido modificado con éxito'); </script>";
		break;
	}
}
?>