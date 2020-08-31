<?php
session_start();
require 'inc/conexion.php';

if (!isset($_SESSION["fb_access_token"])) // Si no encuentra el access token de la sesión, se enviará a login
{
	header("location: login.php");
}
else // Continuamos a la página

	if (!isset($_SESSION["rango"]) == '2') // Si no es administrador, se enviará a la página de usuario
	{
		header("location: perfil.php");
	}
	else // continuamos a la página
	header( 'Content-Type: text/html; charset=utf-8' );

	// Consulta para traer los datos de usuario generales
	$sql_datosusuariosgeneral = "SELECT nombres
	FROM 
		usuario
	WHERE 
		usuario_id = '".$_SESSION['usuario_id']."' "; 
	$rs_resultdatosgeneral = mysqli_query($conn, $sql_datosusuariosgeneral);
	$row_profile_general = mysqli_fetch_assoc($rs_resultdatosgeneral);
	

	// Contador ordenes pendientes de revisión - confirmación
	$sql_ordenes_pendientes_confirmacion = "SELECT * FROM ordencompra WHERE estado_orden = 'Pendiente de confirmación'";  
	$rs_result_ordenes_pendientes_confirmacion = mysqli_query($conn, $sql_ordenes_pendientes_confirmacion);  
	$cnt_ordenes_pendientes_confirmacion = $rs_result_ordenes_pendientes_confirmacion->num_rows;

	// Contador usuarios registrados
	$sql_usuarios_registrados = "SELECT * FROM usuario";  
	$rs_result_usuarios_registrados = mysqli_query($conn, $sql_usuarios_registrados);  
	$cnt_usuarios_registrados = $rs_result_usuarios_registrados->num_rows;

	// Contador archivos
	$cnt_archivos_total = '0';

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
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
		<script src="https://code.jquery.com/jquery-3.5.0.slim.min.js" integrity="sha256-MlusDLJIP1GRgLrOflUQtshyP0TwT/RHXsI1wWGnQhs=" crossorigin="anonymous"></script>
	</head>
<body class="text-center">

    <div class="container d-flex p-3 mx-auto flex-column">

	<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-color border-bottom box-shadow">
		<img class="logo" src="/images/Logo.png" width="32" height="32"><h5 class="my-0 mr-md-auto font-weight-normal">Gestión Pedagógica</h5>
      	<nav class="my-2 my-md-0 mr-md-3">
		<a href="http://repositorio.gestionpedagogica.cl"><button class="btn btn-secondary" type="button">Inicio</button></a>
		<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Hola <?php echo $row_profile_general["nombres"]; ?></button>
		<div class="dropdown-menu" aria-labelledby="dropdownMenu2">
			<a href="/perfil"><button class="dropdown-item" type="button">Perfil</button></a>
			<a href="/ordenes"><button class="dropdown-item" type="button">Mis ordenes</button></a>
			<a href="/logout"><button class="dropdown-item" type="button">Desconectar</button></a>
		</div>
		<?php 
			if (isset($_SESSION["rango"]) == '2')
			{ 
				echo '<a href="/administracion"><button class="btn btn-secondary" type="button">Administración</button></a>';
			}
		?>
        <a href="/contacto"><button class="btn btn-secondary" type="button">Contacto</button></a>
      </nav>
      <a class="btn btn-outline-success" href="#">Contactar por Whatsapp</a>
    </div>

      <div class="jumbotron">
        <div class="container">
		
		
		<h4 class="d-flex justify-content-between align-items-center mb-3">
            <span>Estadísticas</span>

			<div class="btn-group dropup btn-block options">
			<a href="/perfil"><button type="button" class="btn btn-primary"><span class="material-icons">person</span> Volver al perfil</button></a>
			</div>
				
        </h4>
		
			<div class="card mb-3">
			  <div class="row no-gutters">

				<div class="col">
				  <div class="card-body">


            <div class="row">
				<div class="col-sm text-center">
					<div class="row counter-profile">
						<div class="col-sm">
							<h2><strong><?php echo $cnt_archivos_total; ?></strong></h2>                    
							<p><small>archivos subidos</small></p>
							<hr class="mb-4">
							<a class="dropdown-item" href="/archivos"><button id="btnGroupDrop1" type="button" class="btn btn-secondary">Ver archivos</button></a>
						</div>
						<div class="col-sm">
							<h2><strong><?php echo $cnt_usuarios_registrados; ?></strong></h2>                    
							<p><small>usuarios registrados</small></p>
							<hr class="mb-4">
							<div class="btn-group" role="group">
								<button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones</button>
								<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
									<a class="dropdown-item" href="/usuarios">Ver usuarios</a>
									<a class="dropdown-item" href="/nuevousuario">Crear nuevo</a>
								</div>
  							</div> 
						</div>
						<div class="col-sm">
							<h2><strong><?php echo $cnt_ordenes_pendientes_confirmacion; ?></strong></h2>                    
							<p><small>ordenes pendientes de revisión</small></p>
							<hr class="mb-4">
							<a class="dropdown-item" href="/ordenes"><button id="btnGroupDrop1" type="button" class="btn btn-secondary">Ver ordenes</button></a>
						</div>
					</div>
                </div>            
            </div>
				  
				  
				  </div>
				</div>
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

    
    <script src="js/bootstrap.bundle.min.js"></script>
	
  </body>
</html>