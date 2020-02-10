<!DOCTYPE html>
<html>
<head>  
	<title>Página Princial</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="felystyles.css">
</head>
<body>
	<center>
		<?php
		session_start();
		if (!isset($_SESSION["user"]) and $_SESSION["activeuser"] == FALSE)
		{
			header("Location:login.php");
		} //SI EL USUARIO NO EXISTE
		else
		{
			if (isset($_SESSION["level"]))
			{
				if ($_SESSION["level"] == "Control")
				{
					?>
					<p class="shadow">Proceso de Facturado</p>
					<?php
					include("conexion.php");
					$sql = "SELECT * FROM motores";
					$resultado = $conexion->query($sql);
					$row = $resultado->fetch_assoc();

					if ($row['motor_id'] == "")
					{
						echo "<p class='alert'>No hay motores en la base de datos.<br>
						Por favor contacte al Jefe de Mecánicos	para agregar motores a la base de datos</p>";
						?>
						<br>
						<a class="btn btn-primary" href="consult.php">Consultar Facturas</a>
						<a class="btn btn-warning" role="button" .disabled href="logout.php">Cerrar Sesión</a>
						<?php
					}
					else
					{
						if (isset($_REQUEST["motor_id"]) and $_REQUEST["motor_id"] !== "")
						{
							$motor_id = $_REQUEST["motor_id"];
							include("conexion.php");
							$query = "SELECT * FROM motores WHERE motor_id = '$motor_id'";
							$resultado = $conexion->query($query);
							$row = $resultado->fetch_assoc();
							$owner = $row["owner"];
							$model = $row["model"];
							$brand = $row["brand"];
							$year = $row["year"];
							$carrito = array('owner' => $owner, 'model' => $model, 'brand' => $brand, 'year' => $year);
							$_SESSION["carrito"] = $carrito;

							header("Location:mainpage.php?bill=part");
						}
						if (isset($_REQUEST["part_id"]) and $_REQUEST["part_id"] !== "")
						{
							$part_id = $_REQUEST["part_id"];
							include("conexion.php");
							$query = "SELECT * FROM piezas WHERE part_id = '$part_id'";
							$resultado = $conexion->query($query);
							$row = $resultado->fetch_assoc();
							$name = $row["name"];
							$model = $row["model"];
							$brand = $row["brand"];
							$price = $row["price"];
							$_SESSION["counter"] = $_SESSION["counter"] + 1;
							$quantity = $_SESSION["counter"];
							if ($quantity > $row["quantity"])
							{
								$quantity = $row["quantity"];
								$_SESSION["counter"] = $_SESSION["counter"] - 1;
								header("Location:mainpage.php?bill=part&error_empty_part");
							}
							$carrito2 = array('name' => $name, 'partmodel' => $model, 'partbrand' => $brand, 'quantity' => $quantity, 'price' => $price);
							$_SESSION["carrito2"] = $carrito2;

							header("Location:mainpage.php?bill=part");
						}
						if (isset($_REQUEST["bill"]) and $_REQUEST["bill"] == "motor")
						{
							if (isset($_SESSION["carrito2"]) or isset($_SESSION["carrito1"]) or isset($_SESSION["counter"]))
							{
								unset($_SESSION["carrito2"]);
								unset($_SESSION["carrito"]);
								unset($_SESSION["counter"]);
							}
							?>
							<!-- MOTORES -->
							<table class="table table-dark" border="1px">
								<thead>
									<tr>
										<th class="title" colspan="6">
											Motores Disponibles
										</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th class="title">
											Dueño
										</th>
										<th class="title">
											Modelo
										</th>
										<th class="title">
											Marca
										</th>
										<th class="title">
											Año
										</th>
									</tr>
									<?php
									include("conexion.php");
									$query = "SELECT * FROM motores";
									$resultado = $conexion->query($query);
									while ($row = $resultado->fetch_assoc())
									{
										?>
										<tr>
											<td>
												<a href="mainpage.php?motor_id=<?php echo $row['motor_id']; ?>"><?php echo $row['owner']; ?></a> 
											</td>
											<td>
												<?php echo $row['model']; ?>
											</td>
											<td>
												<?php echo $row['brand']; ?>
											</td>
											<td>
												<?php echo $row['year']; ?>
											</td>
										</tr>
										<?php
									} //SI LA TABLA DE MOTORES NO ESTÁ VACÍA
									?>
								</tbody>
							</table>
							<?php
						} //SI BILL = MOTOR
						if (isset($_REQUEST["bill"]) and $_REQUEST["bill"] == "part")
						{	
							if (isset($_REQUEST["erase"]) and $_REQUEST["erase"] == "part")
							{
								unset($_SESSION["counter"]);
								unset($_SESSION["carrito2"]);
							}
							?>
							<!-- PIEZAS -->
							<table class="table table-dark" border="1px">
								<thead>
									<tr>
										<th class="title" colspan="6">
											Piezas Disponibles
										</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th class="title">
											Nombre
										</th>
										<th class="title">
											Modelo
										</th>
										<th class="title">
											Marca
										</th>
										<th class="title">
											Cantidad
										</th>
										<th class="title">
											Precio de Implementación
										</th>
									</tr>
									<?php
									include("conexion.php");
									$query = "SELECT * FROM piezas";
									$resultado = $conexion->query($query);
									while ($row = $resultado->fetch_assoc())
									{
										?>
										<tr>
											<td>
												<a href="mainpage.php?part_id=<?php echo $row['part_id']; ?>"><?php echo $row['name']; ?></a> 
											</td>
											<td>
												<?php echo $row['model']; ?>
											</td>
											<td>
												<?php echo $row['brand']; ?>
											</td>
											<td>
												<?php echo $row['quantity'];
												?>
											</td>
											<td>
												<?php echo $row['price']; ?> bsS
											</td>
										</tr>
										<?php
									} //SI LA TABLA DE LAS PIEZAS NO ESTÁ VACÍA
									?>
								</tbody>
							</table>

							<table class="table table-dark" style="width: 70%; background-color: rgba(10,20,50, 0.7); color: white;">
								<tbody>
									<tr>
										<th class="title">
											Motor
										</th>
										<?php
										if (isset($_SESSION["carrito2"]))
										{
											?>
											<th class="title">
												Piezas
											</th>
											<?php
							} //SI EL SEGUNDO CARRITO ESTÁ ESTABLECIDO
							?>
						</tr>
						<tr>
							<td>
								<span style="color: lightblue">DUEÑO:</span> <?php
								echo $_SESSION["carrito"]["owner"];
								?>
							</td>
							<?php
							if (isset($_SESSION["carrito2"]))
							{
								?>
								<td>
									<span style="color: lightblue">NOMBRE:</span> <?php
									echo $_SESSION["carrito2"]["name"];
									?>
								</td>
								<?php
							} //SI EL SEGUNDO CARRITO ESTÁ ESTABLECIDO
							?>
						</tr>
						<tr>
							<td>
								<span style="color: lightblue">MODELO:</span> <?php
								echo $_SESSION["carrito"]["model"];
								?>
							</td>
							<?php
							if (isset($_SESSION["carrito2"]))
							{
								?>
								<td>
									<span style="color: lightblue">MODELO:</span> <?php
									echo $_SESSION["carrito2"]["partmodel"];
									?>
								</td>
								<?php
							} //SI EL SEGUNDO CARRITO ESTÁ ESTABLECIDO
							?>
						</tr>
						<tr>
							<td>
								<span style="color: lightblue">MARCA:</span> <?php
								echo $_SESSION["carrito"]["brand"];
								?>
							</td>
							<?php
							if (isset($_SESSION["carrito2"]))
							{
								?>
								<td>
									<span style="color: lightblue">MARCA:</span> <?php
									echo $_SESSION["carrito2"]["partbrand"];
									?>
								</td>
								<?php
							} //SI EL SEGUNDO CARRITO ESTÁ ESTABLECIDO
							?>
						</tr>
						<tr>
							<td>
								<span style="color: lightblue">AÑO:</span> <?php
								echo $_SESSION["carrito"]["year"];
								?>
							</td>
							<?php
							if (isset($_SESSION["carrito2"]))
							{
								?>
								<td>
									<span style="color: lightblue">CANTIDAD:</span> <?php
									if (isset($_SESSION["counter"]))
									{
										echo $_SESSION["counter"];
									}
									?>
								</td>
								<?php
							} //SI EL SEGUNDO CARRITO ESTÁ ESTABLECIDO
							?>
						</tr>

						
						<?php
						if (isset($_SESSION["carrito2"]))
						{
							?>
							<tr>
								<td>

								</td>
								<td>
									<span style="color: lightblue">PRECIO DE IMPLEMENTACIÓN:</span>
									<?php
									if (isset($_SESSION["counter"]))
									{
										$counter = $_SESSION["counter"];
										$price = $_SESSION["carrito2"]["price"];
										$_SESSION["carrito2"]["price"] = $price * $counter;
									}
									echo $_SESSION["carrito2"]["price"];
									?> bsS
								</td>
							</tr>
							<?php
							} //SI EL SEGUNDO CARRITO ESTÁ ESTABLECIDO
							?>	
						</tbody>
					</table>
					<a class="btn btn-light" role="button" .disabled href="mainpage.php?bill=motor">Regresar</a>
					<?php
					if (isset($_SESSION["carrito"]) and isset($_SESSION["carrito2"]))
					{
						?>
						<a class="btn btn-primary" role="button" .disabled href="bill.php?proceder=1">Proceder</a>
						<a class="btn btn-warning" role="button" .disabled href="mainpage.php?bill=part&erase=part">Eliminar piezas</a><br><br>
						<?php
							} // SI YA ESTÁN ESTABLECIDOS LOS DOS CARRITOS
						} //SI BILL = PART
						?>
						<a class="btn btn-secondary" href="consult.php">Consultar Facturas</a>
						<a class="btn btn-danger" role="button" .disabled href="logout.php">Cerrar Sesión</a>
						<?php
				} //IF THERE ARE MOTORS AND PARTS
			} //IF SET LEVEL=CONTROL
			//JEFE DE MECANICOS
			elseif ($_SESSION["level"] == "Jefe de Mecanicos")
			{
				?>
				<?php
				if (!isset($_REQUEST["register"]))
				{
					?>
					<p class="shadow">Registro de Motores y Piezas</p>

					<a class="btn btn-warning" role="button" .disabled href="mainpage.php?register=motor">Registrar Motores</a>
					<a class="btn btn-warning" role="button" .disabled href="mainpage.php?register=parttable">Lista de Piezas</a><br><br>
					<a class="btn btn-danger" role="button" .disabled href="logout.php">Cerrar Sesión</a>
					<?php
				}
				if (isset($_REQUEST["register"]))
				{
					if ($_REQUEST["register"] == "motor")
					{
						if (!isset($_REQUEST["motor_id"]))
						{
							?>
							<p class="shadow">Registro de Motores</p>
							<div class="box">
								<form action="motor-process.php" method="post">
									<div class="form-group">
										<label class="col-sm-2 col-form-label" for="owner">
											Dueño
										</label>
										<div class="col-sm-8">
											<input class="form-control" id="owner" type="text" name="owner" placeholder="Ingrese el nombre del dueño">
										</div>
										<small class="mini">Máximo de Caracteres: 30 / Mínimo de Caracteres: 4</small>
									</div>

									<div class="form-group">
										<label class="col-sm-2 col-form-label" for="model">
											Modelo
										</label>
										<div class="col-sm-8">
											<input class="form-control" id="model" type="text" name="model" placeholder="Ingrese el modelo del motor">
										</div>
										<small class="mini">Máximo de Caracteres: 40 / Mínimo de Caracteres: 2</small>
									</div>

									<div class="form-group">
										<label class="col-sm-2 col-form-label" for="brand">
											Marca
										</label>
										<div class="col-sm-8">
											<input class="form-control" id="brand" type="text" name="brand" placeholder="Ingrese la marca del motor">
										</div>
										<small class="mini">Máximo de Caracteres: 40 / Mínimo de Caracteres: 2</small>
									</div>

									<div class="form-group">
										<label class="col-sm-2 col-form-label" for="year">
											Año
										</label>
										<div class="col-sm-8">
											<input class="form-control" id="year" type="text" name="year" placeholder="Ingrese el modelo del motor">
										</div>
										<small class="mini">Máximo de Números: 5 / Solo se permiten Números</small>
									</div>

									<div>
										<input class="btn btn-primary" type="submit" name="registrarBtn" value="Registrar motor" .disabled>
									</div>
								</form>
							</div><br>
							<a class="btn btn-light" role="button" .disabled href="mainpage.php">Inicio</a>
							<a class="btn btn-secondary" role="button" .disabled href="mainpage.php?register=motortable">Motores registrados</a><br><br>
							<a class="btn btn-danger" role="button" .disabled href="logout.php">Cerrar Sesión</a>
							<?php
					} //IF IS NOT SET MOTOR_ID
					else
					{
						$motor_id = $_REQUEST['motor_id'];
						include("conexion.php");
						$query = "SELECT * FROM motores WHERE motor_id = '$motor_id'";
						$resultado = $conexion->query($query);
						$row = $resultado->fetch_assoc();			
						?>
						<p class="shadow">Modificar Motores</p>
						<div class="box">
							<form action="motor-process.php?motor_id=<?php echo $row['motor_id']; ?>" method="post">
								<div class="form-group">
									<label class="col-sm-2 col-form-label" for="owner">
										Dueño
									</label>
									<div class="col-sm-8">
										<input class="form-control" id="owner" type="text" name="owner" placeholder="Ingrese el nombre del dueño" value="<?php echo $row['owner']; ?>">
									</div>
									<small class="mini">Máximo de Caracteres: 30 / Mínimo de Caracteres: 4</small>
								</div>

								<div class="form-group">
									<label class="col-sm-2 col-form-label" for="model">
										Modelo
									</label>
									<div class="col-sm-8">
										<input class="form-control" id="model" type="text" name="model" placeholder="Ingrese el modelo del motor" value="<?php echo $row['model']; ?>">
									</div>
									<small class="mini">Máximo de Caracteres: 40 / Mínimo de Caracteres: 2</small>
								</div>

								<div class="form-group">
									<label class="col-sm-2 col-form-label" for="brand">
										Marca
									</label>
									<div class="col-sm-8">
										<input class="form-control" id="brand" type="text" name="brand" placeholder="Ingrese la marca del motor" value="<?php echo $row['brand']; ?>">
									</div>
									<small class="mini">Máximo de Caracteres: 40 / Mínimo de Caracteres: 2</small>
								</div>

								<div class="form-group">
									<label class="col-sm-2 col-form-label" for="year">
										Año
									</label>
									<div class="col-sm-8">
										<input class="form-control" id="year" type="text" name="year" placeholder="Ingrese el modelo del motor" value="<?php echo $row['year']; ?>">
									</div>
									<small class="mini">Máximo de Números: 5 / Solo se permiten Números</small>
								</div><br>
								<input class="btn btn-primary" type="submit" name="modificarBtn" value="Modificar motor" .disabled>
							</form>
						</div><br>
						<a class="btn btn-light" role="button" .disabled href="mainpage.php">Inicio</a>
						<a class="btn btn-secondary" role="button" .disabled href="mainpage.php?register=motortable">Motores registrados</a><br><br>
						<a class="btn btn-danger" role="button" .disabled href="logout.php">Cerrar Sesión</a>
						<?php
					} //IF IS SET MOTOR_ID
				} //IF IS SET REGISTER=MOTOR
				if ($_REQUEST["register"] == "motortable")
				{
					?>
					<p class="shadow">Motores existentes</p>
					<table class="table table-dark" border="1px">
						<thead>
							<tr>
								<th class="title" colspan="6">
									Lista de motores en existencia
								</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="title">
									Dueño
								</th>
								<th class="title">
									Modelo
								</th>
								<th class="title">
									Marca
								</th>
								<th class="title">
									Año
								</th>
								<th class="title" colspan="2">
									Modificaciones
								</th>
							</tr>
							<?php
							include("conexion.php");

							$query = "SELECT * FROM motores";
							$resultado = $conexion->query($query);
							while ($row = $resultado->fetch_assoc())
							{
								?>
								<tr>
									<td>
										<?php echo $row['owner']; ?>
									</td>
									<td>
										<?php echo $row['model']; ?>
									</td>
									<td>
										<?php echo $row['brand']; ?>
									</td>
									<td>
										<?php echo $row['year']; ?>
									</td>
									<td>
										<a href="mainpage.php?register=motor&motor_id=<?php echo $row['motor_id']; ?>">Modificar</a>
									</td>
									<td>
										<a href="deletemotor.php?motor_id=<?php echo $row['motor_id']; ?>">Eliminar</a>
									</td>
								</tr>
								<?php
							}
							?>
						</tbody>
					</table>
				</div>
			</form>
		</div><br>
		<a class="btn btn-light" role="button" .disabled href="mainpage.php">Inicio</a>
		<a class="btn btn-primary" role="button" .disabled href="mainpage.php?register=motor">Ingresar motores</a><br><br>
		<a class="btn btn-danger" role="button" .disabled href="logout.php">Cerrar Sesión</a>
		<?php
					} //IF IS SET REGISTER=MOTORTABLE
					if ($_REQUEST["register"] == "parttable")
					{
						?>
						<p class="shadow">Piezas existentes</p>
						<table class="table table-dark" border="1px">
							<thead>
								<tr>
									<th class="title" colspan="6">
										Lista de piezas en existencia
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th class="title">
										Nombre
									</th>
									<th class="title">
										Modelo
									</th>
									<th class="title">
										Marca
									</th>
									<th class="title">
										Cantidad
									</th>
									<th class="title">
										Precio de Implementación
									</th>
									<th class="title" colspan="2">
										Modificaciones
									</th>
								</tr>
								<?php
								include("conexion.php");
								$query = "SELECT * FROM piezas";
								$resultado = $conexion->query($query);
								while ($row = $resultado->fetch_assoc())
								{
									?>
									<tr>
										<td>
											<?php echo $row['name']; ?>
										</td>
										<td>
											<?php echo $row['model']; ?>
										</td>
										<td>
											<?php echo $row['brand']; ?>
										</td>
										<td>
											<?php echo $row['quantity']; ?>
										</td>
										<td>
											<?php echo $row['price']; ?> bsS
										</td>
										<td>
											<a href="part-process.php?agregar=agregar&part_id=<?php echo $row['part_id']; ?>">Agregar</a>
										</td>
										<td>
											<a href="part-process.php?agregar=quitar&part_id=<?php echo $row['part_id']; ?>">Quitar</a>
										</td>
									</tr>
									<?php
								}
								?>
							</tbody>
						</table>
					</div>
				</form>
			</div><br>
			<a class="btn btn-light" role="button" .disabled href="mainpage.php">Regresar</a>
			<a class="btn btn-danger" role="button" .disabled href="logout.php">Cerrar Sesión</a>
			<?php
					} //IF IS SET REGISTER=PARTTABLE
				} //IF IS SET REGISTER
			} //IF IS SET LEVEL="JEFE DE MECANICOS"
		} //IF IS SET LEVEL
	} //IF IS SET USER
	?>
</center>
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
		echo "<script type='text/javascript'>alert('No se ha podido registrar tu motor, intenta de nuevo'); </script>";
		break;

		case "exito_part":
		unset($_REQUEST['proceso']);
		echo "<script type='text/javascript'>alert('Tu pieza ha sido registrado con éxito'); </script>";
		break;

		case "exito_motor":
		unset($_REQUEST['proceso']);
		echo "<script type='text/javascript'>alert('Tu motor ha sido registrado con éxito'); </script>";
		break;

		case "exito_part_modify":
		unset($_REQUEST['proceso']);
		echo "<script type='text/javascript'>alert('Tu pieza ha sido modificado con éxito'); </script>";
		break;

		case "exito_motor_modify":
		unset($_REQUEST['proceso']);
		echo "<script type='text/javascript'>alert('Tu motor ha sido modificado con éxito'); </script>";
		break;

		case 'error_empty_item':
		unset($_REQUEST['proceso']);
		echo "<script type='text/javascript'>alert('Debes agregar más piezas al almacen'); </script>";
		break;

		case 'error_empty_part':
		unset($_REQUEST['proceso']);
		echo "<script type='text/javascript'>alert('No puedes seleccionar más piezas'); </script>";
		break;
	}
}
?>