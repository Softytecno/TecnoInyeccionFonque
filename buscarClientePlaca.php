<?php

ob_start();
session_start();
$correo = $_SESSION['usernameadmi'];

if (!isset($correo)) {
  header('Location: index.php');
  ob_end_flush();
}

	$servername = "localhost";
    $username = "root";
  	$password = "";
  	$dbname = "TecnoAutomotriz";

	$conn = new mysqli($servername, $username, $password, $dbname);
    // mysqli::set_charset'utf8', $conn);
      if($conn->connect_error){
        die("Conexión fallida: ".$conn->connect_error);
      }

    $tabla = "";

    mysqli_set_charset($conn,"utf8");

    $query = "SELECT * FROM tb_vehicles v JOIN tb_customers c ON v.vehi_id = c.cust_fk_vehicles";

    if (isset($_POST['consulta'])) {
    	$q = $conn->real_escape_string($_POST['consulta']);
    	$query = "SELECT * FROM tb_vehicles v 
                  JOIN tb_customers c ON v.vehi_id = c.cust_fk_vehicles 
                  WHERE v.vehi_license_plate LIKE '%$q%' ";
    }

    $resultado = $conn->query($query);

    if ($resultado->num_rows>0) {
    	$salida.='
        <div class="row">
        <div class="col-md-12 formulario"><br>
        <div class="scrollable">
        <table class="table table-bordered" >
            <thead >
                <tr>
                <th class="bg-info" style="text-align: center">PLACA</th>
                <th class="bg-info" style="text-align: center">NOMBRES</th>
                <th class="bg-info" style="text-align: center">CEDULA</th>
                <th class="bg-info" style="text-align: center">DIRECCION</th>
                <th class="bg-info" style="text-align: center">TELEFONO</th>
                <th class="bg-info" style="text-align: center">CIUDAD</th>
                <th class="bg-info" style="text-align: center">ACCIONES</th>
                </tr>
            </thead>';

            while ($fila = $resultado->fetch_assoc()) {
                $salida.='
                <tbody>
                  <tr>
                    <td align="center">'.$fila['vehi_license_plate'].'</td>
                    <td align="center">'.$fila['cust_names'].'</td>
                    <td align="center">'.$fila['cust_card'].'</td>
                    <td align="center">'.$fila['cust_address'].'</td>
                    <td align="center">'.$fila['cust_phone_number'].'</td>
                    <td align="center">'.$fila['cust_city'].'</td>
                    <td align="center"><a href="editarCliente.php?placa='.$fila['vehi_license_plate'].'" class="btn btn-warning"> <i class="fas fa-edit"></i> </a> </td>
                  </tr>
                  ';
    
            }
                $salida.="
                </tbody>
        </table>
        </div>
        </div>
        </div>";
    }else{
        $salida.='
        <div class="row">
        <div class="col-md-12 formulario"><br>
        <div class="scrollable">
        <table class="table table-bordered" >
            <thead >
                <tr>
                    <th class="bg-info" style="text-align: center">ID</th>
                    <th class="bg-info" style="text-align: center">NOMBRE COMPLETO</th>
                    <th class="bg-info" style="text-align: center">CEDULA</th>
                    <th class="bg-info" style="text-align: center">VEREDA</th>
                    <th class="bg-info" style="text-align: center">DIRECCION</th>
                    <th class="bg-info" style="text-align: center">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td align="center" colspan="6">EL REGISTRO NO ESTA EN BASE DE DATOS!</td>
                </tr>
            </tbody></table>
        </div>
        </div>
        </div>';
    }


    echo $salida;

    $conn->close();

?>