<?php

ob_start();
session_start();
$correo = $_SESSION['usernameadmi'];

if (!isset($correo)) {
  header('Location: index.php');
  ob_end_flush();
}

$servidor = "localhost";
$usuario = "root";
$passwd = "";
$dbname = "TecnoAutomotriz";

$conexion = mysqli_connect($servidor, $usuario, $passwd, $dbname);

$consulta='';

function listarVehiculos(){
	global $conexion, $consulta;
	$_POST['buscar'];
	$buscar = $_POST['palabra'];
	$sql="SELECT * FROM clientes WHERE placas like '%$buscar%'";
	return $conexion->query($sql);
}

?>