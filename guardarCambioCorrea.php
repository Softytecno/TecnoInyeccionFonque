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
	
	$placa = $_POST['placa'];
	$fecha = $_POST['fechaCambio'];
	$kmActual = $_POST['kmActual'];
	$proximoKm = $_POST['proximoCambio'];
    $descripcionCorrea = $_POST['descripcionCorrea'];
	$tipoCorrea = $_POST['tipoCorrea'];

	$id_query = "SELECT vehi_id FROM tb_vehicles WHERE vehi_license_plate = '$placa'";
    $id_result = mysqli_query($conexion, $id_query);

	if (mysqli_num_rows($id_result) > 0) {
		$id_row = mysqli_fetch_assoc($id_result);
		if ($id_row) {
            $id = $id_row['vehi_id'];

			$query = "INSERT INTO tb_belt_replacement (bere_change_date, bere_current_mileage, bere_next_change, bere_belt_description, bere_belt_type, bere_fk_vehicles) VALUES ('$fecha', '$kmActual','$proximoKm', '$descripcionCorrea', '$tipoCorrea', '$id')";
			$result = mysqli_query($conexion, $query);

			if ($result) {
				$_SESSION['registro_exitoso'] = "El registro se ha completado con éxito.";
				header("Location: registrarCambioCorrea.php");
			} else {
				header("Location: registrarCambioCorrea.php"); 
			}
		}
	} else {
		$_SESSION['placa_error'] = "La placa no esta registrada";
		header("Location: registrarCambioCorrea.php"); 
	}

}

?> 