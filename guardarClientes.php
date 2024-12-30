<?php

include("conexion.php");
ob_start();
session_start();
$correo = $_SESSION['usernameadmi'];

if (!isset($correo)) {
  header('Location: index.php');
  ob_end_flush();
}

if (isset($_POST['agregar'])) {
	
	$nombres = $_POST['nombres'];
	$cedula = $_POST['cedula'];
	$direccion = $_POST['direccion'];
	$telefono = $_POST['telefono'];
    $ciudad = $_POST['ciudad'];
	$placa = $_POST['placa'];

	$id_query = "SELECT vehi_id FROM tb_vehicles WHERE vehi_license_plate = '$placa'";
    $id_result = mysqli_query($conexion, $id_query);

	if (mysqli_num_rows($id_result) > 0) {
		$id_row = mysqli_fetch_assoc($id_result);
		if ($id_row) {
            $id = $id_row['vehi_id'];

			$query = "INSERT INTO tb_customers (cust_names, cust_card, cust_address, cust_phone_number, cust_city, cust_fk_vehicles) VALUES ('$nombres','$cedula','$direccion','$telefono','$ciudad','$id')";
			$result = mysqli_query($conexion, $query);


			if ($result) {
				$_SESSION['registro_exitoso'] = "El registro se ha completado con éxito.";
				header("Location: registrarClientes.php");
			} else {
				header("Location: registrarClientes.php"); 
			}
		}
	} else {
		$_SESSION['placa_error'] = "La placa no esta registrada";
		header("Location: registrarClientes.php"); 
	}

}

?> 