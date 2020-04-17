<?php
session_start();
require 'inc/conexion.php';

if (!isset($_SESSION["fb_access_token"])) // Si no encuentra el access token de la sesión, se enviará a login
{
	header("location: login.php");
}
else //Continue to current page
	header( 'Content-Type: text/html; charset=utf-8' );
	
	// Consulta que muestra todos los datos del archivo
	$url_id = trim(mysqli_real_escape_string($conn,$_GET['id'])); 
	$sql1 = "SELECT * FROM archivo where archivo_id = '".$url_id."' "; 
	$rs_result1 = mysqli_query($conn, $sql1);
	$consulta_planificacion = mysqli_fetch_assoc($rs_result1);

	// Se hace comprobación de si el ID en la url existe, si no existe se retorna a 404.php
	if(mysqli_num_rows($rs_result1)==0) 
	{
		header("location: 404.php");
	}
	else
	{
		// Consulta para traer los datos de usuario generales
		$sql_datosusuariosgeneral = "SELECT usuario_id, registrado_el, nombres, apellidos, correo, avatar_url, facebook_id
		FROM 
			usuario
		WHERE 
			usuario_id = '".$_SESSION['usuario_id']."' "; 
		$rs_resultdatosgeneral = mysqli_query($conn, $sql_datosusuariosgeneral);
		$row_profile_general = mysqli_fetch_assoc($rs_resultdatosgeneral);
	}
	
	// Funcion que crea la orden
	if(isset($_POST['crearorden-submit']))
	{

		$usuario_id = $_SESSION['usuario_id'];
		$fecha_compra = date("Y-m-d H:i:s");
		$fecha_actualizacion = date("Y-m-d H:i:s");
					
		$sql1 = "INSERT INTO ordencompra (ordencompra_id, usuario_id, archivo_id, fecha_compra, fecha_actualizacion, estado_orden) VALUES (DEFAULT, '$usuario_id', '$url_id', '$fecha_compra', '$fecha_actualizacion', 'Pendiente de pago')";

		if ($conn->query($sql1) === TRUE) 
		{
			// Seleccionamos el orden de la compra que acabamos de hacer
			$sql_selectordencompraid = "SELECT ordencompra_id from ordencompra WHERE usuario_id = '".$_SESSION['usuario_id']."' ORDER BY ordencompra_id DESC"; 
			
			$rs_ordencompra_id = mysqli_query($conn, $sql_selectordencompraid) or die ("(1) Problemas al seleccionar ".mysqli_error($conn));

			// Se guarda en un variable el usuario_id
			$row = mysqli_fetch_assoc($rs_ordencompra_id);
			// Guardamos el ordencompra_id del usuario en una variable
			$ultimaordencompra_id = $row['ordencompra_id'];
			
			// Enviamos al usuario a la siguiente pantalla
			header("Location: https://repositorio.gestionpedagogica.cl/orden?id=$ultimaordencompra_id");
		}
		else
		{
			echo "Error sql log.";
			echo "Error sql log." . $sql1 . "<br>" . $conn->error;
		}
	}

?> 
<!doctype html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<link rel="icon" href="favicon.ico">

		<title>Gestión Pedagógica</title>

		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/fontawesome.min.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
	</head>
<body class="text-center">

    <div class="d-flex h-100 p-3 mx-auto flex-column">

	<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-color border-bottom box-shadow">
      <h5 class="my-0 mr-md-auto font-weight-normal">Gestión Pedagógica</h5>
      <nav class="my-2 my-md-0 mr-md-3">
		<a href="http://repositorio.gestionpedagogica.cl"><button class="btn btn-secondary" type="button">Inicio</button></a>
		<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Hola <?php echo $row_profile_general["nombres"]; ?></button>
		<div class="dropdown-menu" aria-labelledby="dropdownMenu2">
			<a href="https://repositorio.gestionpedagogica.cl/perfil"><button class="dropdown-item" type="button">Perfil</button></a>
			<a href="https://repositorio.gestionpedagogica.cl/logout"><button class="dropdown-item" type="button">Desconectar</button></a>
		</div>
        <a href="#"><button class="btn btn-secondary" type="button">Contacto</button></a>
      </nav>
      <a class="btn btn-outline-success" href="#">Contactar por Whatsapp</a>
    </div>

      <div class="jumbotron">
        <div class="container">
          <h1 class="display-4">Proceso de compra</h1>
          <p class="index-description">En esta página podrás validar los datos para la compra de tu planificación. Posteriormente podrás ver los datos para realizar la transferecia a la cuenta asignada.</p>
		
		<div class="row">
		<div class="container">
		  <ul class="progressbar">
			<li><p class="compraactiva">Creación de orden</p></li>
			<li>Pago</li>
			<li>Confirmación de pago</li>
		  </ul>
		</div>
		</div>
				
	<div class="row">
        <div class="col-md-4 order-md-2 mb-4">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span>Tu carro</span>
          </h4>
          <ul class="list-group mb-3">
            <li class="list-group-item d-flex justify-content-between lh-condensed">
              <div>
                <h6 class="my-0"><?php echo $consulta_planificacion["nombre"]; ?></h6>
                <small class="text-muted"><?php echo $consulta_planificacion["descripcion_corta"]; ?></small>
              </div>
              <span class="text-muted">$<?php echo $consulta_planificacion["precio"]; ?></span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span>Total a transferir</span>
              <strong>$<?php echo $consulta_planificacion["precio"]; ?></strong>
            </li>
          </ul>
		  
		  <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span>Descripción</span>
          </h4>
		  <ul class="list-group mb-3">
            <li class="list-group-item d-flex lh-condensed">
                <h6 class="my-0"><?php echo $consulta_planificacion["descripcion_larga"]; ?></h6>
            </li>
          </ul>
		  
        </div>
        <div class="col-md-8 order-md-1">
          <h4 class="mb-3">Datos de tu perfil</h4>
          <form method="post" action="">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="nombres">Nombres</label>
                <input type="text" class="form-control" id="nombres" placeholder="" value="<?php echo $row_profile_general["nombres"]; ?>" required disabled>
                <div class="invalid-feedback">
                  Valid first name is required.
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="apellidos">Apellidos</label>
                <input type="text" class="form-control" id="apellidos" placeholder="" value="<?php echo $row_profile_general["apellidos"]; ?>" required disabled>
                <div class="invalid-feedback">
                  Valid last name is required.
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="email">Correo Electrónico</label>
              <input type="email" class="form-control" id="email" placeholder="" value="<?php echo $row_profile_general["correo"]; ?>" disabled>
              <div class="invalid-feedback">
                Please enter a valid email address for shipping updates.
              </div>
            </div>
            <hr class="mb-4">

            <h4 class="mb-3">Método de Pago</h4>

            <div class="d-block my-3">
              <div class="custom-control custom-radio">
                <input id="transferenciaelectronica" name="paymentMethod" type="radio" class="custom-control-input" checked required>
                <label class="custom-control-label" for="transferenciaelectronica">Transferencia electrónica</label>
              </div>
            </div>
			<hr class="mb-4">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="same-address">
              <label class="custom-control-label" for="same-address">Acepto los <a href="#">Términos y Condiciones</a>.</label>
            </div>
            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" name="crearorden-submit" type="submit">Comprar</button>
          </form>
        </div>
      </div>
	
	</div>
    </div>

      <footer class="mastfoot mt-auto">
        <div class="inner">
          <p class="footer">Copyright © 2020 Gestión Pedagógica</p>
        </div>
      </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.0.slim.min.js" integrity="sha256-MlusDLJIP1GRgLrOflUQtshyP0TwT/RHXsI1wWGnQhs=" crossorigin="anonymous"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
  </body>
</html>