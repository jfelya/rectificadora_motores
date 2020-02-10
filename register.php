<!DOCTYPE html>
<html>
<head>
	<title>Registrar Usuario</title>
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
			?>
				<p class="shadow">
					Registro de Usuario
				</p>
			<div class="box">
				<form action="register-process.php" method="post">
					<div class="form-group">
						<label class="col-sm-2 col-form-label" for="user">
							Usuario
						</label>
						<div class="col-sm-7">
							<input class="form-control" id="user" type="text" name="user" placeholder="Ingrese su usuario">
						</div>
						<small class="mini">Máximo de Caracteres: 30 / Mínimo de Caracteres: 4</small>
					</div>
					<div class="form-group">
						<label class="col-sm-2 col-form-label" for="email">
							Email
						</label>
						<div class="col-sm-7">
							<input class="form-control" id="email" type="email" name="email" placeholder="Ingrese su email">
						</div>
						<small class="mini">Máximo de Caracteres: 40</small>
					</div>
					<div class="form-group">
						<label class="col-sm-2 col-form-label" for="password">
							Contraseña
						</label>
						<div class="col-sm-7">
							<input class="form-control" id="password" type="password" name="password" placeholder="Ingrese su contraseña">
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
							<option>Control</option>
							<option>Jefe de Mecanicos</option>
							<option>Admin</option>				
						</select>
					</div><br>
					<div>
						<input class="btn btn-primary" type="submit" name="registrarBtn" value="Registrar" .disabled>
					</div>
				</form>
			</div><br>
			<a class="btn btn-secondary" role="button" .disabled href="users.php">Usuarios registrados</a>4
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
		echo "<script type='text/javascript'>alert('No se ha podido registrar tu usuario, intenta de nuevo'); </script>";
		break;

		case "exito":
		unset($_REQUEST['proceso']);
		echo "<script type='text/javascript'>alert('Tu usuario ha sido registrado con éxito'); </script>";
		break;
	}
}
?>