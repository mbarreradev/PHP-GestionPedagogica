<?php
session_start();
require 'inc/database.php';

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

	// Box actividad de ordenes
	$sql_actividad_ordenes = "SELECT ordencompra_historial.historial_id, ordencompra_historial.ordencompra_id, ordencompra_historial.accion, ordencompra_historial.fecha_creacion, archivo.nombre
	FROM 
		ordencompra_historial 
	INNER JOIN 
		ordencompra
	ON
		ordencompra_historial.ordencompra_id=ordencompra.ordencompra_id
	INNER JOIN 
		archivo
	ON
		ordencompra.archivo_id=archivo.archivo_id
	ORDER BY 
		historial_id DESC 
	LIMIT 5";  
	$rs_result_actividad_ordenes = mysqli_query($conn, $sql_actividad_ordenes);  
	

	// Contador ordenes pendientes de revisión - confirmación
	$sql_ordenes_pendientes_confirmacion = "SELECT * FROM ordencompra WHERE estado_orden = 'Pendiente de confirmación'";  
	$rs_result_ordenes_pendientes_confirmacion = mysqli_query($conn, $sql_ordenes_pendientes_confirmacion);  
	$cnt_ordenes_pendientes_confirmacion = $rs_result_ordenes_pendientes_confirmacion->num_rows;

	// Contador usuarios registrados
	$sql_usuarios_registrados = "SELECT * FROM usuario";  
	$rs_result_usuarios_registrados = mysqli_query($conn, $sql_usuarios_registrados);  
	$cnt_usuarios_registrados = $rs_result_usuarios_registrados->num_rows;

	// Contador archivos
	$sql_archivos_totales = "SELECT * FROM archivo";  
	$rs_result_archivos_totales = mysqli_query($conn, $sql_archivos_totales);  
	$cnt_archivos_total = $rs_result_archivos_totales->num_rows;

?>
<!doctype html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<link rel="icon" href="favicon.ico">

		<title>Administración - Gestión Pedagógica</title>

		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
		<script src="js/moment-with-locales.js"></script>
		<script src="js/chart.js"></script>
	</head>
<body class="text-center">

    <div class="container d-flex p-3 mx-auto flex-column">

	<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-color border-azul-claro">
		<img class="logo" src="/images/Logo.png" width="32" height="32"><h5 class="my-0 mr-md-auto font-weight-normal">Gestión Pedagógica</h5>
      	<nav class="my-2 my-md-0 mr-md-3">
		<a href="http://repositorio.gestionpedagogica.cl"><button class="btn btn-secondary" type="button">Inicio</button></a>
		<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Hola <?php echo $row_profile_general["nombres"]; ?></button>
		<div class="dropdown-menu" aria-labelledby="dropdownMenu2">
			<a href="/perfil"><button class="dropdown-item" type="button">Perfil</button></a>
			<a href="/misordenes"><button class="dropdown-item" type="button">Mis ordenes</button></a>
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

      <div class="rounded border border-azul-claro p-3">
        <div class="container">
		
		
		<h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="titulo">Estadísticas</span>

			<div class="btn-group dropup btn-block options">
			<a href="/perfil"><button type="button" class="btn btn-primary"><span class="material-icons">person</span> Volver al perfil</button></a>
			</div>
				
        </h4>
		
		<div class="mb-4">
			<div class="row no-gutters">
				<div class="col">
						<div class="row">
							<div class="col-sm">
								<div class="card border-plomo">
									<div class="card-body bg-azul-especial text-white">
										<div class="row">
											<div class="col-3">
												<span class="material-icons stats">sticky_note_2</span>
											</div>
											<div class="col-9 text-right">
												<div class="Count"><?php echo $cnt_archivos_total; ?></div>
												<h4>archivos subidos</h4>
											</div>
										</div>
									</div>
									<a href="/archivos">
									<div class="card-footer text-info">
										<span class="float-center">Ver todos los archivos</span>
										<span class="float-right"><i class="fa fa-arrow-circle-right"></i></span>
										<div class="clearfix"></div>
									</div>
									</a>
								</div>
							</div>
							<div class="col-sm">
								<div class="card border-plomo">
									<div class="card-body bg-naranjo-especial text-white">
										<div class="row">
											<div class="col-3">
												<span class="material-icons stats">people</span>
											</div>
											<div class="col-9 text-right">
												<div class="Count"><?php echo $cnt_usuarios_registrados; ?></div>
												<h4>usuarios registrados</h4>
											</div>
										</div>
									</div>
									<a href="/usuarios">
										<div class="card-footer bg-light text-info">
											<span class="float-center">Ver todos los usuarios</span>
											<span class="float-right"><i class="fa fa-arrow-circle-right"></i></span>
											<div class="clearfix"></div>
										</div>
									</a>
								</div>
							</div>
							<div class="col-sm">
								<div class="card border-plomo">
									<div class="card-body bg-rosado-especial text-white">
										<div class="row">
											<div class="col-3">
												<span class="material-icons stats">library_books</span>
											</div>
											<div class="col-9 text-right">
												<div class="Count"><?php echo $cnt_ordenes_pendientes_confirmacion; ?></div>
												<h4>ordenes pendientes</h4>
											</div>
										</div>
									</div>
									<a href="/ordenes">
										<div class="card-footer bg-light text-info">
											<span class="float-center">Ver todas las ordenes</span>
											<span class="float-right"><i class="fa fa-arrow-circle-right"></i></span>
											<div class="clearfix"></div>
										</div>
									</a>
								</div>
							</div>
						</div>
				</div>
			</div>
		</div>


		<div class="card mb-3">
			<div class="row no-gutters">
				<div class="col">
				  	<div class="card-body bg-azul-claro">
						<div class="row">
							<div class="col">
						
								<div id="chart-container">
									<canvas id="graphCanvas"></canvas>
								</div>

								<script>
								$(document).ready(function () {
									showGraph1();
								});


								function showGraph1()
								{
									{
										$.post("inc/json_ventas_por_tipo.php",
										function (data)
										{
											console.log(data);
											var num_guias = [];
											var num_planificaciones = [];
                                            var mes = [];

											for (var i in data) {
												num_guias.push(data[i].num_registros_guias);
                                                num_planificaciones.push(data[i].num_registros_planificaciones);
                                                mes.push(data[i].mes);
											}

											var chartdata = {
												labels: mes,
												datasets: [
													{
														label: 'Planificaciones',
														data: num_planificaciones,
														borderColor: '#36a2eb',
														backgroundColor: '#9ad0f5',
													},
													{
														label: 'Guías',
														data: num_guias,
														borderColor: '#ff6c8b',
														backgroundColor: '#ffb1c1',
													}
												]
											};

											var graphTarget1 = $("#graphCanvas");

											var barGraph1 = new Chart(graphTarget1, {
												type: 'line',
												data: chartdata,
												options: {
													responsive: true,
													plugins: {
													  legend: {
														position: 'top',
													  },
													  title: {
														display: true,
														text: 'Ventas por tipo de archivo'
													  }
													}
												  },
											});
										});
									}
								}
								</script>
							</div>
							<div class="col">
							
								<div id="chart-container">
									<canvas id="graphCanvas2"></canvas>
								</div>

								<script>
								$(document).ready(function () {
									showGraph2();
								});


								function showGraph2()
								{
									{
										$.post("inc/json_usuarios_registrados.php",
										function (data)
										{
											console.log(data);
											var num_registros = [];
                                            var mes = [];

											for (var i in data) {
												num_registros.push(data[i].num_registros);
                                                mes.push(data[i].mes);
											}

											var chartdata2 = {
												labels: mes,
												datasets: [
													{
														label: 'Número de registros',
														data: num_registros,
														borderColor: '#36a2eb',
														backgroundColor: '#9ad0f5',
													}
												]
											};

											var graphTarget2 = $("#graphCanvas2");

											var barGraph2 = new Chart(graphTarget2, {
												type: 'bar',
												data: chartdata2,
												options: {
													responsive: true,
													plugins: {
													  legend: {
														position: 'top',
													  },
													  title: {
														display: true,
														text: 'Registros de usuarios'
													  }
													}
												  },
											});
										});
									}
								}
								</script>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

			<h4 class="d-flex justify-content-between align-items-center mb-3 margin-bottom">
            <span class="titulo">Última actividad</span>
        	</h4>	


			<div class="rounded border border-azul-claro p-3">
				<div class="container">
					<div class="row">
						<div class="col">
							<h4 class="titulo">Actividad de ordenes</h4>
							<ul class="timeline">

								<?php  
									$counter = 0;
									while ($row = mysqli_fetch_assoc($rs_result_actividad_ordenes)) {
									$counter++;
								?>

								<li>
									<a href="/ordenes"><strong class="titulo">Orden:</strong> <?php echo $row['ordencompra_id']; ?> <strong class="titulo">Archivo:</strong></strong> <?php echo $row['nombre']; ?></a>
									<a href="#" class="float-right" rel="tooltip" title="<?php echo $row['fecha_creacion']; ?>" id="fecha<?php echo $counter; ?>"><?php echo $row['fecha_creacion']; ?></a>
									<p><?php echo $row['accion']; ?></p>
								</li>

								<?php  
									};  
								?>

							</ul>
						</div>
						<div class="col">
							<h4 class="titulo">Actividad de usuarios</h4>
							<ul class="timeline">
								<li>
									<a href="#"><strong class="titulo">Usuario: </strong></a>
									<a href="#" class="float-right">Fecha</a>
									<p>Texto</p>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>

	</div>
    </div>

      <footer class="mastfoot margin-top">
        <div class="inner">
          <p class="footer">Copyright © 2020 Gestión Pedagógica</p>
        </div>
      </footer>
    </div>

    
    <script src="js/bootstrap.bundle.min.js"></script>
	
	<script type="text/javascript">

	$('.Count').each(function () {
		$(this).prop('Counter',0).animate({
			Counter: $(this).text()
		}, {
			duration: 3000,
			easing: 'swing',
			step: function (now) {
				$(this).text(Math.ceil(now));
			}
		});
	});

	var dateFormat = 'YYYY-DD-MM HH:mm:ss';

	for (var i = 1; i < 6; i+=1) 
	{
		var fecha = "fecha" + i;
		var documento = document.getElementById(fecha).value;
		var registrado_utctime = moment.utc(documento);
		var registrado_localdate = registrado_utctime.local();
		var registrado_localdate_locale = registrado_localdate.locale('es')

		var modificardivregistrado = document.getElementById("fecha" + i);
		modificardivregistrado.innerHTML =  moment(registrado_localdate_locale, "YYYY-MM-DD hh:mm:ss").fromNow();
	}

	</script>

  </body>
</html>