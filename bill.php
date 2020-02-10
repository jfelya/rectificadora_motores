<!DOCTYPE html>
<html>
<head>
	<title>Factura</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="felystyles.css">
	<style>
		.table-dark
		{
			width: 35%;
			background-color: rgba(0, 0, 0, 0.7);
			text-align: center;
		}
	</style>
</head>
<body>
	<center>
		<?php
		session_start();
		if (!isset($_SESSION['user']) and $_SESSION['activeuser'] == TRUE)
		{
			header("Location:login.php");
		}
		else
		{
			if (isset($_REQUEST["proceder"]) and $_REQUEST["proceder"] == "1")
			{
				$owner = $_SESSION["carrito"]["owner"];
				$model = $_SESSION["carrito"]["model"];
				$brand = $_SESSION["carrito"]["brand"];
				$year = $_SESSION["carrito"]["year"];
				$name = $_SESSION["carrito2"]["name"];
				$partmodel = $_SESSION["carrito2"]["partmodel"];
				$partbrand = $_SESSION["carrito2"]["partbrand"];
				$quantity = $_SESSION["carrito2"]["quantity"];
				$price = $_SESSION["carrito2"]["price"];

				include("conexion.php");
				$sql = "SELECT * FROM motores WHERE owner = '$owner'";
				$resultado = $conexion->query($sql);
				$row = $resultado->fetch_assoc();
				$sql2 = "SELECT * FROM piezas WHERE name = '$name'";
				$resultado2 = $conexion->query($sql2);
				$row2 = $resultado2->fetch_assoc();
				$motor_id = $row["motor_id"];
				$part_id = $row2["part_id"];
				$quantityafter = $row2["quantity"] - $quantity;

				$query3 = "DELETE FROM motores WHERE motor_id='$motor_id'";
				$resultado3 = $conexion->query($query3);

				$sql4 = "UPDATE piezas SET name = '$name', model = '$partmodel', brand = '$partbrand', quantity = '$quantityafter' , price = '$price' WHERE part_id='$part_id'";
				$resultado4 = $conexion->query($sql4);

				$date = date("Y/m/d");

				$sql5 = "INSERT INTO `factura` (`company_name`, `motor_owner`, `motor_model`, `motor_brand`, `motor_year`, `part_name`, `part_model`, `part_brand`, `part_quantity`, `part_price`, `date`) VALUES ('Yadah Yireh C.A.', '$owner', '$model', '$brand', '$year', '$name', '$partmodel', '$partbrand', '$quantity', '$price', '$date')";
				$resultado5 = $conexion->query($sql5);
				?>
				<table class="table table-dark" border="0px">
					<thead>
						<tr>
							<th class="title" colspan="2">
								Factura
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
								echo $_SESSION["carrito"]["owner"];
								?>
							</td>
						</tr>
						<tr>
							<td>
								Modelo:
							</td>
							<td>
								<?php
								echo $_SESSION["carrito"]["model"];
								?>
							</td>
						</tr>
						<tr>
							<td>
								Marca:
							</td>
							<td>
								<?php
								echo $_SESSION["carrito"]["brand"];
								?>
							</td>
						</tr>
						<tr>
							<td>
								Año:
							</td>
							<td>
								<?php
								echo $_SESSION["carrito"]["year"];
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
								echo $_SESSION["carrito2"]["name"];
								?>
							</td>
						</tr>
						<tr>
							<td>
								Modelo:
							</td>
							<td>
								<?php
								echo $_SESSION["carrito2"]["partmodel"];
								?>
							</td>
						</tr>
						<tr>
							<td>
								Marca:
							</td>
							<td>
								<?php
								echo $_SESSION["carrito2"]["partbrand"];
								?>
							</td>
						</tr>
						<tr>
							<td>
								Cantidad:
							</td>
							<td>
								<?php
								echo $_SESSION["carrito2"]["quantity"];
								?>
							</td>
						</tr>
						<tr>
							<td>
								Precio de implementación:
							</td>
							<td>
								<?php
								echo $_SESSION["carrito2"]["price"];
								?> bsS
							</td>
						</tr>
						<tr>
							<td colspan="2">
								Fecha: <?php
								echo $date;
								?>
							</td>
						</tr>
					</tbody>
				</table><br>
			<a class="btn btn-primary" href="mainpage.php?bill=motor">Regresar</a>
			<a class="btn btn-danger" role="button" .disabled href="logout.php">Cerrar Sesión</a>
			<?php
		}
	}
	?>
	<center>
	</body>
	</html>