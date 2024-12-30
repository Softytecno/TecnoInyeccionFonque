<?php
include("conexion.php");
session_start();

$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];

$sqladmi = "SELECT count(*) as contaradmi FROM administrador WHERE correo='$correo' AND contrasena='$contrasena'";

$consultaadmi = mysqli_query($conexion, $sqladmi);
$arrayadmi = mysqli_fetch_array($consultaadmi);

if($arrayadmi['contaradmi']>0){
	$_SESSION['usernameadmi'] = $correo;
	header('Location: admi.php');

}else{
	header('Location: index.php');

}

?>