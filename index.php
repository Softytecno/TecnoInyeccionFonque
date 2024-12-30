<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title></title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/formulario.css">
	<link rel="stylesheet" type="text/css" href="css/csss.css">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
</head>
<body background="img/Design.jpg"  style="margin-top: 150px" >

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-4 formulario"><br>
			<form action="login.php" method="POST">
				<div class="form-group text-center">
					<img class="logo" src="img/adm.svg" width="30%"><br><br>
					<h4 class="text-black">INICIAR SESIÓN</h4> 
				</div>
				<div class="form-group mx-sm-4 pt-2 inpu" >
					<input type="text" name="correo" class="form-control" placeholder="USUARIO">
					<i class="fas fa-user" aria-hidden="true"></i>
				</div>
				<div class="form-group mx-sm-4 pb-2 inpuu">
					<input type="password" name="contrasena" class="form-control" placeholder="CONTRASEÑA">
					<i class="fas fa-lock"></i>
        		</div><br>
				<div class="form-group mx-sm-4 pb-4">
					<input type="submit" value="INICIAR SESION" class="btn btn-block boton text-light">
				</div>
			</form>
		</div><br>
	</div><br>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>