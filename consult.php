<!DOCTYPE html>
<html>
<head>
	<title>Consulta de Facturas</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="felystyles.css">
	<style>
		.table-dark
		{
			width: 35%;
			background-color: rgba(0, 0, 0, 0.8);
			text-align: center;
		}
	</style>
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
					include("conexion.php");
					$sql = "SELECT * FROM factura";
					$resultado = $conexion->query($sql);
					$row = $resultado->fetch_assoc();

					if (!$row)
					{
						?>
						<p class="alert">No hay facturas que mostrar, por favor haga una transacción y regrese</p>
						<br>
						<a class="btn btn-light" href="mainpage.php?bill=motor">Regresar</a>
						<?php
					}
					else
					{
						if (isset($_REQUEST["consult"]) and $_REQUEST["consult"] !== "")
						{
							$motor_owner = $_REQUEST["consult"];
							$sql2 = "SELECT * FROM factura WHERE motor_owner = '$motor_owner'";
							$resultado2 = $conexion->query($sql2);
							$row2 = $resultado2->fetch_assoc();
							$_SESSION["bill_owner"] = $row2["motor_owner"];
							?>

							<table class="table table-dark" border="0px">
								<thead>
									<tr>
										<th class="title" colspan="2">
											Factura de <?php echo $row2["motor_owner"]; ?>
										</th>
									</tr>
								</thead>
								<tbody align="left">
									<tr>
										<td class="title" colspan="2">
											Yadah Yireh C.A.
										</td>
									</tr>
									<tr>
										<td class="title" colspan="2">
											Motor
										</td>
									</tr>
									<tr>
										<td>
											Dueño:
										</td>
										<td>
											<?php
											echo $row2["motor_owner"];
											?>
										</td>
									</tr>
									<tr>
										<td>
											Modelo:
										</td>
										<td>
											<?php
											echo $row2["motor_model"];
											?>
										</td>
									</tr>
									<tr>
										<td>
											Marca:
										</td>
										<td>
											<?php
											echo $row2["motor_brand"];
											?>
										</td>
									</tr>
									<tr>
										<td>
											Año:
										</td>
										<td>
											<?php
											echo $row2["motor_year"];
											?>
										</td>
									</tr>
									<tr>
										<td colspan="2" class="title">
											Piezas
										</td>
									</tr>
									<tr>
										<td>
											Nombre:
										</td>
										<td>
											<?php
											echo $row2["part_name"];
											?>
										</td>
									</tr>
									<tr>
										<td>
											Modelo:
										</td>
										<td>
											<?php
											echo $row2["part_model"];
											?>
										</td>
									</tr>
									<tr>
										<td>
											Marca:
										</td>
										<td>
											<?php
											echo $row2["part_brand"];
											?>
										</td>
									</tr>
									<tr>
										<td>
											Cantidad:
										</td>
										<td>
											<?php
											echo $row2["part_quantity"];
											?>
										</td>
									</tr>
									<tr>
										<td>
											Precio de implementación:
										</td>
										<td>
											<?php
											echo $row2["part_price"];
											?> bsS
										</td>
									</tr>
									<tr>
										<td colspan="2">
											Fecha: <?php
											echo $row2["date"];
											?>
										</td>
									</tr>
								</tbody>
							</table><br>

							<a class="btn btn-danger" href="consultdelete.php?motor_owner=<?php
							echo $row2["motor_owner"];
							?>">Eliminar Factura</a>
							<a class="btn btn-light" href="consult.php?consult=">Lista de Facturas</a>
							<?php
						}
						else
						{
							?>

							<table class="table table-dark" border="1px" style="width: 50%">
								<thead>
									<tr>
										<th class="title" colspan="6">
											Lista de Facturas
										</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th class="title">
											Fecha
										</th>
										<th class="title">
											Dueño del Motor
										</th>
									</tr>
									<?php
									include("conexion.php");
									$query = "SELECT * FROM factura";
									$resultado = $conexion->query($query);
									while ($row = $resultado->fetch_assoc())
									{
										?>
										<tr>
											<td>
												<?php echo $row['date']; ?>
											</td>
											<td>
												<a href="consult.php?&consult=<?php echo $row['motor_owner']; ?>"><?php echo $row['motor_owner']; ?></a>
											</td>
										</tr>
										<?php
									}
									?>
								</tbody>
							</table><br>
							<a class="btn btn-light" href="mainpage.php?bill=motor">Regresar</a>
							<a class="btn btn-danger" role="button" .disabled href="logout.php">Cerrar Sesión</a>
							<?php
						}
					}	
				}
				else
				{
					header("Location:login.php");
				} //SI NO ESTÁ PUESTO EL CONTROL
			}
			else
			{
				header("Location:login.php");
			} // SI NO ESTÁ PUESTO EL NIVEL
		} //SI EL USUARIO NO ESTÁ PUESTO
		?>
	</center>
</body>
</html>