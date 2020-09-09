<?php
session_start();
require 'inc/conexion.php';

// Consulta para traer los datos de usuario generales
$sql_datosusuariosgeneral = "SELECT nombres
FROM 
	usuario
WHERE 
	usuario_id = '".$_SESSION['usuario_id']."' "; 
$rs_resultdatosgeneral = mysqli_query($conn, $sql_datosusuariosgeneral);
$row_profile_general = mysqli_fetch_assoc($rs_resultdatosgeneral);

// BOX planificaciones
$sql_planificaciones = "SELECT * FROM archivo WHERE tipo = '0' ORDER BY RAND() LIMIT 6";  
$rs_result_planificaciones = mysqli_query($conn, $sql_planificaciones);  

// BOX guias
$sql_guias = "SELECT * FROM archivo WHERE tipo = '1' ORDER BY RAND() LIMIT 6";  
$rs_result_guias = mysqli_query($conn, $sql_guias);  

// BOX Recomendados
$sql_recomendados = "SELECT * FROM archivo WHERE recomendado = '1' ORDER BY RAND() LIMIT 10";  
$rs_result_recomendados = mysqli_query($conn, $sql_recomendados);  

// Contador planificaciones
$cnt_planificaciones = $rs_result_planificaciones->num_rows;

// Contador guias
$cnt_guias = $rs_result_guias->num_rows;

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
    	<script src="js/bootstrap.bundle.min.js"></script>
		<script src="js/list.min.js"></script>
		<script src="js/carousel.js"></script>
		<script data-ad-client="ca-pub-2522486668045838" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	</head>
<body class="text-center">
    <div class="container shadow d-flex p-3 mx-auto flex-column">
		<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-color border-azul-claro">
			<img class="logo" src="/images/Logo.png" width="32" height="32"><h5 class="my-0 mr-md-auto font-weight-normal">Gestión Pedagógica</h5>
			<nav class="my-2 my-md-0 mr-md-3">
				<a href="http://repositorio.gestionpedagogica.cl"><button class="btn btn-secondary" type="button">Inicio</button></a>
					<?php
						if (!isset($_SESSION["fb_access_token"]))
						{
							echo '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Panel de usuario</button>';
							echo '<div class="dropdown-menu" aria-labelledby="dropdownMenu2">';
							echo '<a href="/login"><button class="dropdown-item" type="button">Ingresar con Facebook</button></a>';
							echo '</div>';
						}
						else
						{
							echo '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Hola '.$row_profile_general["nombres"].'</button>';
							echo '<div class="dropdown-menu" aria-labelledby="dropdownMenu2">';
							echo '<a href="/perfil"><button class="dropdown-item" type="button">Perfil</button></a>';
							echo '<a href="/misordenes"><button class="dropdown-item" type="button">Mis ordenes</button></a>';
							echo '<a href="/logout"><button class="dropdown-item" type="button">Desconectar</button></a>';
							echo '</div>';
						}
					?>

					<?php
						if (isset($_SESSION["rango"]) == '2')
						{ 
							echo '<a href="/administracion"><button class="btn btn-secondary" type="button">Administración</button></a>';
						}
					?>
				<a href="/contacto"><button class="btn btn-secondary" type="button">Contacto</button></a>
			</nav>
			<a class="btn btn-outline-success" href="https://api.whatsapp.com/send?phone=56912345678">Contactar por WhatsApp</a>
		</div>

    	<div class="rounded border border-azul-claro p-3">
        	<div class="container">
				<h1 class="display-4">Bienvenido a Gestión Pedagógica</h1>
				<p class="index-description">En esta página encontrarás más de <?php echo $cnt_planificaciones; ?> planificaciones y <?php echo $cnt_guias; ?> guías para casi todos los cursos de enseñanza básica.</p>

				<!-- GestionPedagogica Index -->
				<ins class="adsbygoogle"
					style="display:block"
					data-ad-client="ca-pub-2522486668045838"
					data-ad-slot="5055589516"
					data-ad-format="auto"
					data-full-width-responsive="true"></ins>
				<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
				</script>

				<div id="tabla-lista-recomendados">
					<h4 class="d-flex justify-content-between align-items-center mb-3">
						<span>Recomendados</span>
					</h4>

					<div class="row">
						<div class="MultiCarousel" data-items="1,3,5,6" data-slide="1" id="MultiCarousel"  data-interval="1000">
							<div class="MultiCarousel-inner">
								
								<?php  
									while ($row = mysqli_fetch_assoc($rs_result_recomendados)) {
								?>
							
								<div class="item">
									<div class="pad15">
										<p class="lead"><?php echo $row['asignatura']; ?></p>
										<p><?php echo $row['nombre']; ?></p>
										<p><?php echo $row['curso']; ?></p>
										<?php
									if($row["estado"] === '1' AND isset($_SESSION["fb_access_token"])) // 1 disponible 0 no disponible
									{
										echo '<a href="/comprar?id='.$row["archivo_id"].'"><button type="button" class="btn btn-sm btn-block btn-outline-primary">Seleccionar</button></a>';
									}
									else
									{
										echo '<button type="button" class="btn btn-sm btn-block btn-outline-secondary" disabled>No disponible</button>';
									}
									?>
									</div>
								</div>

								<?php  
									};  
								?>

							</div>
							<button class="btn btn-primary leftLst"><</button>
							<button class="btn btn-primary rightLst">></button>
						</div>
					</div>
				</div>
		
				<div id="tabla-lista-planificaciones">
				
					<h4 class="d-flex justify-content-between align-items-center mb-3">
						<span>Lista de planificaciones</span>
						<div class="btn-group dropup btn-block options">
							<a href="/planificaciones"><button type="button" class="btn btn-primary"><span class="material-icons">select_all</span> Ver todos</button></a>
						</div>
					</h4>	
				
					<div class="container-separado">
						<input type="text" class="search form-control" placeholder="Puedes buscar por curso, asignatura, unidad o temática"/>
					</div>

					<div class="card-deck mb-3 text-center justify-content-center">
						<ul class="list">
						
						<?php  
							while ($row = mysqli_fetch_assoc($rs_result_planificaciones)) {
						?>

						<div class="card mb-4 box-shadow">
							<div class="card-header bg-azul">
								<h4 class="my-0 font-weight-normal nombre"><?php echo $row['asignatura']; ?></h4>
							</div>
							<div class="card-body">
								<h1 class="card-title pricing-card-title asignatura"><?php echo $row['nombre']; ?></h1>
								<hr class="bg-azul"/>
								<ul class="list-unstyled mt-3 mb-4">
									<li class="unidad"><?php echo $row['curso']; ?></li>
									<li class="unidad"><?php echo $row['unidad']; ?></li>
								</ul>
								<h1 class="card-title pricing-card-title price">Precio $<?php echo $row['precio']; ?></h1>
								<?php
									if($row["estado"] === '1' AND isset($_SESSION["fb_access_token"])) // 1 disponible 0 no disponible
									{
										echo '<a href="/comprar?id='.$row["archivo_id"].'"><button type="button" class="btn btn-xs btn-outline-primary">Seleccionar</button></a>';
									}
									else
									{
										echo '<button type="button" class="btn btn-xs btn-outline-secondary" disabled>No disponible</button>';
									}
								?>
							</div>
						</div>
						
						<?php  
							};  
						?>
						</ul>
					</div>
				</div>
		
				<div id="tabla-lista-guias">

					<h4 class="d-flex justify-content-between align-items-center mb-3">
						<span>Lista de guías</span>
						<div class="btn-group dropup btn-block options">
							<a href="/guias"><button type="button" class="btn btn-primary"><span class="material-icons">select_all</span> Ver todos</button></a>
						</div>
					</h4>

					<div class="container-separado">
						<input type="text" class="search form-control" placeholder="Puedes buscar por curso, asignatura, unidad o temática"/>
					</div>
				
					<div class="card-deck mb-3 text-center justify-content-center">
						<ul class="list">
						
						<?php  
							while ($row = mysqli_fetch_assoc($rs_result_guias)) {
						?>

						<div class="card mb-4 box-shadow">
							<div class="card-header bg-azul">
								<h4 class="my-0 font-weight-normal nombre"><?php echo $row['asignatura']; ?></h4>
							</div>
							<div class="card-body">
								<h1 class="card-title pricing-card-title asignatura"><?php echo $row['nombre']; ?></h1>
								<hr class="bg-azul"/>
								<ul class="list-unstyled mt-3 mb-4">
									<li class="unidad"><?php echo $row['curso']; ?></li>
									<li class="unidad"><?php echo $row['unidad']; ?></li>
								</ul>
								<h1 class="card-title pricing-card-title price">Precio $<?php echo $row['precio']; ?></h1>
								<?php
									if($row["estado"] === '1' AND isset($_SESSION["fb_access_token"])) // 1 disponible 0 no disponible
									{
										echo '<a href="/comprar?id='.$row["archivo_id"].'"><button type="button" class="btn btn-xs btn-outline-primary">Seleccionar</button></a>';
									}
									else
									{
										echo '<button type="button" class="btn btn-xs btn-outline-secondary" disabled>No disponible</button>';
									}
								?>
							</div>
						</div>
						
						<?php  
							};  
						?>
						</ul>
					</div>
				</div>
			</div>

			<footer class="mastfoot margin-top">
				<div class="inner">
					<p class="footer">Copyright © 2020 Gestión Pedagógica</p>
				</div>
			</footer>
			</div>
		</div>
	</div>

    
	
	<SCRIPT type="text/javascript">
		var options = {
  valueNames: [ 'nombre', 'asignatura', 'unidad', 'curso' ]
};

var tablaPlanificaciones = new List('tabla-lista-planificaciones', options);
var tablaGuias = new List('tabla-lista-guias', options);
	</script>
  </body>
</html>