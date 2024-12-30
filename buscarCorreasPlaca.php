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
      if($conn->connect_error){
        die("Conexión fallida: ".$conn->connect_error);
      }

    $tabla = "";

    mysqli_set_charset($conn,"utf8");

    $query = "SELECT v.vehi_license_plate, c.bere_change_date, c.bere_current_mileage, c.bere_next_change, c.bere_belt_description,
                    CASE
                    WHEN c.bere_belt_type = 1 THEN 'Correa Distribución'
                    WHEN c.bere_belt_type = 2 THEN 'Correa Accesorios'
                    END AS bere_belt_type
                FROM tb_vehicles v
                JOIN tb_belt_replacement c ON v.vehi_id = c.bere_fk_vehicles";

    if (isset($_POST['consulta'])) {
    	$q = $conn->real_escape_string($_POST['consulta']);
    	$query = "SELECT * FROM tb_vehicles v JOIN tb_belt_replacement c ON v.vehi_id = c.bere_fk_vehicles WHERE v.vehi_license_plate LIKE '%$q%' ";
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
                <th class="bg-info" style="text-align: center">FECHA CAMBIO</th>
                <th class="bg-info" style="text-align: center">KM ACTUAL</th>
                <th class="bg-info" style="text-align: center">PROXIMO CAMBIO</th>
                <th class="bg-info" style="text-align: center">DESCRIPCION</th>
                <th class="bg-info" style="text-align: center">TIPO CORREA</th>
                <th class="bg-info" style="text-align: center">ACCIONES</th>
                </tr>
            </thead>';

            while ($fila = $resultado->fetch_assoc()) {
                $salida.='
                <tbody>
                  <tr>
                    <td align="center">'.$fila['vehi_license_plate'].'</td>
                    <td align="center">'.$fila['bere_change_date'].'</td>
                    <td align="center">'.$fila['bere_current_mileage'].'</td>
                    <td align="center">'.$fila['bere_next_change'].'</td>
                    <td align="center">'.$fila['bere_belt_description'].'</td>
                    <td align="center">'.$fila['bere_belt_type'].'</td>
                    <td align="center"><a href="editarCorrea.php?placa='.$fila['vehi_license_plate'].'" class="btn btn-warning"> <i class="fas fa-edit"></i> </a> </td>
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
                <th class="bg-info" style="text-align: center">PLACA</th>
                <th class="bg-info" style="text-align: center">FECHA CAMBIO</th>
                <th class="bg-info" style="text-align: center">KM ACTUAL</th>
                <th class="bg-info" style="text-align: center">PROXIMO CAMBIO</th>
                <th class="bg-info" style="text-align: center">DESCRIPCION</th>
                <th class="bg-info" style="text-align: center">TIPO CORREA</th>
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
