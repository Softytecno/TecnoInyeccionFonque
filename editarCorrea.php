<?php
include("conexion.php");
ob_start();
session_start();
$correo = $_SESSION['usernameadmi'];

if (!isset($correo)) {
  header('Location: index.php');
  ob_end_flush();
}

if (isset($_GET['placa'])) {

    $placa = $_GET['placa'];

    $id_query = "SELECT * FROM tb_vehicles v JOIN tb_belt_replacement c ON v.vehi_id = c.bere_fk_vehicles WHERE v.vehi_license_plate = '$placa'";
    $id_result = mysqli_query($conexion, $id_query);

    if ($id_result) {
        $id_row = mysqli_fetch_assoc($id_result);
        
        if ($id_row) {
            $id_placa = $id_row['bere_fk_vehicles'];

            $query = "SELECT * FROM tb_vehicles v JOIN tb_belt_replacement c ON v.vehi_id = c.bere_fk_vehicles WHERE v.vehi_id = $id_placa";
            $resultado = mysqli_query($conexion, $query);
  
            if (mysqli_num_rows($resultado) == 1) {
        
            $row = mysqli_fetch_array($resultado);
            $placa = $row['vehi_license_plate'];
            $fechaCambio = $row['bere_change_date'];
            $kmActual = $row['bere_current_mileage'];
            $proximoKm = $row['bere_next_change'];
            $descripcionCorrea = $row['bere_belt_description'];
            $tipoCorrea = $row['bere_belt_type'];

            }
        }
    }

  }
  
  if (isset($_POST['update'])) {
  
    $placa = $_GET['placa'];

    $id_query = "SELECT * FROM tb_vehicles v JOIN tb_belt_replacement c ON v.vehi_id = c.bere_fk_vehicles WHERE v.vehi_license_plate = '$placa'";
    $id_result = mysqli_query($conexion, $id_query);
    $id_row = mysqli_fetch_assoc($id_result);
    $fk_vehiculo = $id_row['bere_fk_vehicles'];

    $fechaCambio = $_POST['bere_change_date'];
    $kmActual = $_POST['bere_current_mileage'];
    $proximoKm = $_POST['bere_next_change'];
    $descripcionCorrea = $_POST['bere_belt_description'];
    $tipoCorrea = $_POST['bere_belt_type'];
  
    $query = "UPDATE tb_belt_replacement set bere_change_date = '$fechaCambio', bere_current_mileage = '$kmActual', bere_next_change = '$proximoKm', bere_belt_description = '$descripcionCorrea', bere_belt_type = '$tipoCorrea' WHERE bere_fk_vehicles = $fk_vehiculo";
    $result = mysqli_query($conexion, $query);

    if ($result > 0) {
        $_SESSION['modificacion_exitoso'] = "La modificacion se ha completado con éxito";
    } else {
    }
    

  }

?>

<!DOCTYPE html>
<html lang="es">

<head>

  <title>Administrador</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" type="text/css" href="css/formulario.css">
  <link rel="stylesheet" type="text/css" href="css/scroll.css">
  <link rel="stylesheet" type="text/css" href="css/menu.css">

  <script src="https://kit.fontawesome.com/a81368914c.js"></script>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/duotone.css" integrity="sha384-R3QzTxyukP03CMqKFe0ssp5wUvBPEyy9ZspCB+Y01fEjhMwcXixTyeot+S40+AjZ" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/fontawesome.css" integrity="sha384-eHoocPgXsiuZh+Yy6+7DsKAerLXyJmu2Hadh4QYyt+8v86geixVYwFqUvMU8X90l" crossorigin="anonymous" />

  <!-- Bootstrap core CSS -->
  <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

  <!-- JS, Popper.js, and jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

  <script type="text/javascript">
    /// some script

    // jquery ready start
    $(document).ready(function() {
      // jQuery code

      //////////////////////// Prevent closing from click inside dropdown
      $(document).on('click', '.dropdown-menu', function(e) {
        e.stopPropagation();
      });


    }); // jquery end
  </script>

  <style type="text/css">
    @media all and (min-width: 992px) {
      .navbar {
        padding-top: 0;
        padding-bottom: 0;
      }

      .navbar .has-megamenu {
        position: static !important;
      }

      .navbar .megamenu {
        left: 0;
        right: 0;
        width: 100%;
        padding: 20px;
      }

      .navbar .nav-link {
        padding-top: 1rem;
        padding-bottom: 1rem;
      }
    }

    .navbar-nav li a {
      color: #050505;
      text-decoration: none;
      font-size: 15px;
      font-weight: 400;
      padding: 4px 8px;
      border-radius: 15px;
      transition: all 0.3s ease;
    }

    .dropdown-menu a:hover {
      background: #00E7CA;
      /* color: #000000; */
    }
  </style>

</head>

<body background="img/Production.jpeg" style="margin-top: 30px;">

  <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light" style="border-radius: 5px; box-shadow: 0 0 30px rgb(0, 0, 0, .568); background: #F8F9FA;">

        <a class="navbar-brand" href="admi.php"><img src="img/inyeccion.png" alt="" width="120px;"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="main_nav">

          <ul class="navbar-nav">
            <li class="nav-item dropdown has-megamenu">
              <a class="nav-link dropdown-toggle bg-light text-dark" href="#" data-toggle="dropdown" style="font-size: 15px; font-weight: 500; border-radius: 15px;"> VEHICULO </a>
              <div class="dropdown-menu megamenu" role="menu">

                <div class="row">
                  <div class="col-md-3">
                    <div class="col-megamenu">
                      <h6 class="title" style="font-size: 20px;">GUARDAR</h6>
                      <ul class="list-unstyled">
                        <li><a href="registrarVehiculo.php">Registrar Vehiculo</a></li>
                      </ul>
                    </div> <!-- col-megamenu.// -->
                  </div><!-- end col-3 -->
                  <div class="col-md-3">
                    <div class="col-megamenu">
                      <h6 class="title" style="font-size: 20px;">BUSCAR</h6>
                      <ul class="list-unstyled">
                        <li><a href="buscarVehiculo.php">Buscar Información</a></li>
                      </ul>
                    </div> <!-- col-megamenu.// -->
                  </div><!-- end col-3 -->
                </div><!-- end row -->

              </div> <!-- dropdown-mega-menu.// -->
            </li>
          </ul>

          <ul class="navbar-nav">
            <li class="nav-item dropdown has-megamenu">
              <a class="nav-link dropdown-toggle bg-light text-dark" href="#" data-toggle="dropdown" style="font-size: 15px; font-weight: 500;"> CLIENTES </a>
              <div class="dropdown-menu megamenu" role="menu">

                <div class="row">
                  <div class="col-md-3">
                    <div class="col-megamenu">
                      <h6 class="title" style="font-size: 20px;">GUARDAR</h6>
                      <ul class="list-unstyled">
                        <li><a href="registrarClientes.php">Registrar Clientes</a></li>
                      </ul>
                    </div> <!-- col-megamenu.// -->
                  </div><!-- end col-3 -->
                  <div class="col-md-3">
                    <div class="col-megamenu">
                      <h6 class="title" style="font-size: 20px;">BUSCAR</h6>
                      <ul class="list-unstyled">
                        <li><a href="buscarCliente.php">Buscar Información</a></li>
                      </ul>
                    </div> <!-- col-megamenu.// -->
                  </div><!-- end col-3 -->
                </div><!-- end row -->

              </div> <!-- dropdown-mega-menu.// -->
            </li>
          </ul>

          <ul class="navbar-nav">
            <li class="nav-item dropdown has-megamenu">
              <a class="nav-link dropdown-toggle text-dark bg-light" href="#" data-toggle="dropdown" style="font-size: 15px; font-weight: 500;">CAMBIO CORREAS </a>
              <div class="dropdown-menu megamenu" role="menu">

                <div class="row">
                  <div class="col-md-3">
                    <div class="col-megamenu">
                      <h6 class="title" style="font-size: 20px;">GUARDAR</h6>
                      <ul class="list-unstyled">
                        <li><a href="registrarCambioCorrea.php">Registrar Cambio Correas</a></li>
                      </ul>
                    </div> <!-- col-megamenu.// -->
                  </div><!-- end col-3 -->
                  <div class="col-md-3">
                    <div class="col-megamenu">
                      <h6 class="title" style="font-size: 20px;">BUSCAR</h6>
                      <ul class="list-unstyled">
                        <li><a href="buscarCorreas.php">Buscar Información</a></li>
                      </ul>
                    </div> <!-- col-megamenu.// -->
                  </div><!-- end col-3 -->
                </div><!-- end row -->

              </div> <!-- dropdown-mega-menu.// -->
            </li>
          </ul>

          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
              <a class="nav-link  dropdown-toggle text-dark" href="#" data-toggle="dropdown" style="font-size: 15px;"><?php echo $correo ?></a>
              <ul class="dropdown-menu dropdown-menu-right">
                <li><a class="dropdown-item" href="cerrarSesion.php">Cerrar Sesión</a></li>
              </ul>
            </li>
          </ul>

        </div> <!-- navbar-collapse.// -->

    </nav>
  </div>

  <div class="container">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4"><br>
                <div class="card card-body" style="border-radius: 5px; box-shadow: 0 0 30px rgb(0, 0, 0, .568);">
                    <form action="editarCorrea.php?placa=<?php echo $_GET['placa']; ?>" method="post">
                    <div class="alert alert-light col-md" role="alert" style="text-align: center;">
                            <a class="alert-link">
                                <h5 style="font-family:'Courier New'; font-size: 22px;">EDITAR CORREA</h5>
                            </a>
                        </div>

                        <!-- Bandera de registro exitoso -->
                        <?php
                        if (isset($_SESSION['modificacion_exitoso'])) {
                          echo '<div class="alert alert-success" id="modificacionExitoso">';
                          echo $_SESSION['modificacion_exitoso'];
                          echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                          echo '<span aria-hidden="true">&times;</span>';
                          echo '</button>';
                          echo '</div>';
                          unset($_SESSION['modificacion_exitoso']);
                        }
                        ?>

                    <div class="form-group">
                        <input type="text" name="placa" value="<?php echo $placa; ?>" class="form-control" placeholder="Placa" autofocus="" disabled>
                    </div>
                    <div class="form-group">
                        <input type="date" name="fechaCambio" value="<?php echo $fechaCambio; ?>" class="form-control" autofocus="">
                    </div>
                    <div class="form-group">
                        <input type="text" name="kmActual" value="<?php echo $kmActual; ?>" class="form-control" placeholder="Km Actual" autofocus="">
                    </div>
                    <div class="form-group">
                        <input type="text" name="proximoCambio" value="<?php echo $proximoKm; ?>" class="form-control" placeholder="Proximo Cambio" autofocus="">
                    </div>
                    <div class="form-group">
                      <textarea name="descripcionCorrea" class="form-control" placeholder="Descripcion Cambio Correa" 
                      autofocus=""><?php echo $descripcionCorrea; ?></textarea>
                    </div>
                    <div class="form-group">
                      <select class="form-control" id="selectTipoCorrea" name="tipoCorrea">
                          <option value="1" <?php if ($tipoCorrea == 1) echo 'selected'; ?>>Correa Distribución</option>
                          <option value="2" <?php if ($tipoCorrea == 2) echo 'selected'; ?>>Correa Accesorios</option>
                      </select>
                    </div>
                    <input type="submit" name="update" class="btn btn-warning btn-block" value="Modificar">
                    </form>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
  

</body>

</html>