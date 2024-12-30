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
    $marca = $_POST['marca'];
    $linea = $_POST['linea'];
    $modelo = $_POST['modelo'];
    $cilindraje = $_POST['cilindraje'];

    $consultaPlaca = "SELECT vehi_license_plate FROM tb_vehicles WHERE vehi_license_plate = '$placa'";
    $resultadoPlaca = mysqli_query($conexion, $consultaPlaca);

    if (mysqli_num_rows($resultadoPlaca) > 0) {
        $_SESSION['placa_existente'] = "La placa ya existe en la base de datos.";
        header("Location: registrarVehiculo.php"); 
    } else {
        // La placa no existe en la base de datos, guarda el vehículo
        $query = "INSERT INTO tb_vehicles (vehi_license_plate, vehi_brand, vehi_line, vehi_model, vehi_engine_displacement) VALUES ('$placa','$marca','$linea','$modelo','$cilindraje')";
        $result = mysqli_query($conexion, $query);

        if ($result) {
            $_SESSION['registro_exitoso'] = "El registro se ha completado con éxito.";
            header("Location: registrarVehiculo.php"); 
        } else {
            header("Location: registrarVehiculo.php"); 
        }
    }

}

?> 
