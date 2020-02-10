<?php
session_start();
if (!isset($_SESSION["user"]) and $_SESSION["activeuser"] == FALSE)
{
	header("Location:login.php");
} //SI EL USUARIO NO EXISTE
else
{
	if (isset($_SESSION["level"]) and $_SESSION["level"] == "Control")
	{
		include("conexion.php");
		$motor_owner = $_REQUEST["motor_owner"];
		$query = "DELETE FROM factura WHERE motor_owner='$motor_owner'";
		$resultado = $conexion->query($query);
		if ($resultado) 
		{
			header("Location:consult.php");
		}
	}
	else
	{
		header("Location:login.php");
	}
}
?>