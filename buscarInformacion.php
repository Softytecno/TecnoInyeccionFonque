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
if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}

$tabla = "";
mysqli_set_charset($conn, "utf8");
$query = "SELECT * FROM tb_vehicles v 
  LEFT JOIN tb_customers c ON (v.vehi_id = c.cust_fk_vehicles) 
  LEFT JOIN tb_belt_replacement cc ON (v.vehi_id = cc.bere_fk_vehicles) 
  GROUP BY v.vehi_id";

if (isset($_POST['consulta'])) {
  $q = $conn->real_escape_string($_POST['consulta']);
  $query = "SELECT * FROM tb_vehicles v 
    LEFT JOIN tb_customers c ON (v.vehi_id = c.cust_fk_vehicles) 
    LEFT JOIN tb_belt_replacement cc ON (v.vehi_id = cc.bere_fk_vehicles)
    WHERE v.vehi_license_plate LIKE '%$q%'";
}

$resultado = $conn->query($query);

if ($resultado->num_rows > 0) {

  $filas = []; // Matriz para almacenar las filas

  while ($fila = $resultado->fetch_assoc()) {
    $filas[] = $fila; // Agregar cada fila a la matriz
  }

  $tabla .= '
        <div class="row">
          <div class="col-md-12 formulario"><br>
            <div class="scrollable">
              <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th class="bg-info style="text-align: center; ">PLACA</th>
                      <th class="bg-info style="text-align: center;">MARCA</th>
                      <th class="bg-info style="text-align: center;">LINEA</th>
                      <th class="bg-info style="text-align: center;">MODELO</th>
                      <th class="bg-info style="text-align: center;">CILINDRAJE</th>
                    </tr>
                  </thead>';

  foreach ($filas as $fila) {
    $tabla .= '<tbody>
                      <tr>
                        <td align="center">' . $fila['vehi_license_plate'] . '</td>
                        <td align="center">' . $fila['vehi_brand'] . '</td>
                        <td align="center">' . $fila['vehi_line'] . '</td>
                        <td align="center">' . $fila['vehi_model'] . '</td>
                        <td align="center">' . $fila['vehi_engine_displacement'] . '</td>
                      </tr> ';
  }
  $tabla .= "</tbody>
              </table>
            </div>
          </div>
        </div><br>";

  $tabla .= '
        <div class="row">
          <div class="col-md-12 formulario"><br>
            <div class="scrollable">
              <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th class="bg-info style="text-align: center;">NOMBRES</th>
                      <th class="bg-info style="text-align: center;">CEDULA</th>
                      <th class="bg-info style="text-align: center;">TELEFONO</th>
                      <th class="bg-info style="text-align: center;">DIRECCION</th>
                      <th class="bg-info style="text-align: center;">CIUDAD</th>
                    </tr>
                  </thead>';

  foreach ($filas as $fila) {
    $tabla .= '<tbody>
                                  <tr>
                                    <td align="center">' . $fila['cust_names'] . '</td>
                                    <td align="center">' . $fila['cust_card'] . '</td>
                                    <td align="center">' . $fila['cust_phone_number'] . '</td>
                                    <td align="center">' . $fila['cust_address'] . '</td>
                                    <td align="center">' . $fila['cust_city'] . '</td>
                                  </tr> ';
  }
  $tabla .= "</tbody>
                          </table>
                        </div>
                      </div>
                    </div>";
} else {
  $tabla .=
    '<div class="row">
          <div class="col-md-12 formulario"><br>
            <div class="scrollable">
              <table class="table table-bordered" >
                <thead >
                  <tr>
                    <th style="text-align: center">PLACA</th>
                    <th style="text-align: center">MARCA</th>
                    <th style="text-align: center">LINEA</th>
                    <th style="text-align: center">MODELO</th>
                    <th style="text-align: center">CILINDRAJE</th>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                      <td align="center" colspan="5">EL REGISTRO NO ESTA EN BASE DE DATOS!</td>
                    </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>';

  $tabla .=
    '<div class="row">
          <div class="col-md-12 formulario"><br>
            <div class="scrollable">
              <table class="table table-bordered" >
                <thead >
                  <tr>
                    <th style="text-align: center">NOMBRES</th>
                    <th style="text-align: center">CEDULA</th>
                    <th style="text-align: center">TELEFONO</th>
                    <th style="text-align: center">DIRECCION</th>
                    <th style="text-align: center">CIUDAD</th>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                      <td align="center" colspan="5">EL REGISTRO NO ESTA EN BASE DE DATOS!</td>
                    </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>';
}

echo $tabla;

$conn->close();
