<?php
session_start();
require_once 'inc/database.php';

if (!isset($_SESSION["fb_access_token"])) // Si no encuentra el access token de la sesión, se enviará a login
{
	header("location: login.php");
}
else // Continuamos a la página
	header( 'Content-Type: text/html; charset=utf-8' );

    // Consulta para traer los datos de usuario generales
    $sql_datosusuariosgeneral = "SELECT nombres, apellidos, rango, avatar_url
    FROM 
        usuario
    WHERE 
        usuario_id = '".$_SESSION['usuario_id']."' "; 
    $rs_resultdatosgeneral = mysqli_query($conn, $sql_datosusuariosgeneral);
    $row_profile_general = mysqli_fetch_assoc($rs_resultdatosgeneral);

    // Box Actividad de ordenes
	$sql_actividad_ordenes = "SELECT ordencompra_historial.historial_id, ordencompra_historial.ordencompra_id, ordencompra_historial.accion, ordencompra_historial.fecha_creacion, usuario.nombres, usuario.apellidos
	FROM 
		ordencompra_historial 
	INNER JOIN 
		ordencompra
	ON
		ordencompra_historial.ordencompra_id=ordencompra.ordencompra_id
	INNER JOIN 
		usuario
	ON
		ordencompra.usuario_id=usuario.usuario_id
	ORDER BY 
		historial_id DESC 
	LIMIT 5";  
	$rs_result_actividad_ordenes = mysqli_query($conn, $sql_actividad_ordenes);
	
	// Box Últimos usuarios registrados
	$sql_actividad_usuarios = "SELECT usuario_id, nombres, apellidos, registrado_el
	FROM 
		usuario 
	ORDER BY 
		usuario_id DESC 
	LIMIT 10";  
	$rs_result_actividad_usuarios = mysqli_query($conn, $sql_actividad_usuarios);

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
		<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <link href="css/sidebar.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    	<script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/sidebar.js"></script>
        <script src="js/moment-with-locales.js"></script>
		<script src="js/chart.js"></script>
	</head>
<body>
<script>
window.addEventListener("load", pageFullyLoaded, false);

function pageFullyLoaded(e) {
    var dateFormat = 'YYYY-DD-MM HH:mm:ss';

	for (var i = 1; i < 6; i+=1) 
	{
		var fecha = "fecha" + i;
		console.log(fecha);
		var documento = document.getElementById(fecha).textContent;
		console.log(documento);
		var registrado_utctime = moment.utc(documento);
		var registrado_localdate = registrado_utctime.local();
		var registrado_localdate_locale = registrado_localdate.locale('es')

		var modificardivregistrado = document.getElementById(fecha);
		console.log(modificardivregistrado);
		modificardivregistrado.innerHTML =  moment(registrado_localdate_locale, "YYYY-MM-DD hh:mm:ss").fromNow();
	}
}
</script>
<div class="page-wrapper chiller-theme toggled">
  <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
    <i class="fas fa-bars"></i>
  </a>
  
  <?php require 'inc/sidebar.php'; ?>

  <main class="page-content">
    <div class="container-fluid">
      
        <div class="d-flex justify-content-between">
            <h4 class="titulo">Administración</h4>
            <div class="btn-group dropup btn-block options">
                <a href="/miperfil"><button type="button" class="btn btn-primary"><i class="fa fa-home"></i> Volver al perfil</button></a>
            </div>
        </div>
        <hr>

		<div class="container mb-4">
			<div class="row">
				<div class="col-sm-4 nopadding-left">
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
				<div class="col-sm-4">
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
				<div class="col-sm-4 nopadding-right">
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
			</div>
		</div>

        <div class="card mb-4">
			<div class="row no-gutters">
				<div class="col">
				  	<div class="card-body bg-azul-claro">
						<div class="row">
							<div class="col">
						
								<div id="chart-container">
									<canvas id="graphCanvas"></canvas>
								</div>

								<?PHP

										$json = file_get_contents("inc/json_ventas_guias.php");
											// Converts it into a PHP object
											$data2 = json_decode($json);

								?>

								<script>
								$(document).ready(function () {
									showGraph1();
								});


								function showGraph1()
								{
									{
										$.post("inc/json_ventas_guias.php",
										function (data)
										{
											var num_guias = [];
											var num_planificaciones = [];
                                            var mes = [];

											

												for (var i in data) {
													num_guias.push(data[i].num_registros_guias);
													num_planificaciones.push(<?php Print($data2); ?>[i].num_registros_planificaciones);
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
													scales: {
														y: {
															display: true,
															suggestedMin: 1
														}
													},
													responsive: true,
													plugins: {
													  legend: {
														position: 'top',
													  },
													  title: {
														display: true,
														text: 'Registros de usuarios de este año'
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


				<div class="container">
					<div class="row">
						<div class="col">
							<h4 class="titulo text-center">Actividad de ordenes</h4>
							<ul class="timeline">

								<?php  
									$counter = 0;
									while ($row = mysqli_fetch_assoc($rs_result_actividad_ordenes)) {
									$counter++;
								?>

								<li>
									<a href="/ordenes"><strong class="subtitulo">Orden:</strong> <?php echo $row['ordencompra_id']; ?> <strong class="subtitulo">Comprador:</strong></strong> <?php echo $row['nombres']." ". $row['apellidos'] ; ?></a>
									<a class="float-right" rel="tooltip" title="<?php echo $row['fecha_creacion']; ?>" id="fecha<?php echo $counter; ?>"><?php echo $row['fecha_creacion']; ?></a>
									<p><?php echo $row['accion']; ?></p>
								</li>

								<?php  
									};  
								?>

							</ul>
						</div>
						<div class="col">
							<h4 class="titulo text-center">Últimos usuarios registrados</h4>
							<ul class="timeline">

								<?php  
									$counter = 0;
									while ($row = mysqli_fetch_assoc($rs_result_actividad_usuarios)) {
									$counter++;
								?>

								<li>
									<a href="<?php echo $row['nombres']; ?>"><strong class="subtitulo">Usuario: <?php echo $row['nombres']." ". $row['apellidos'] ; ?> </strong></a>
									<a class="float-right" rel="tooltip" title="<?php echo $row['registrado_el']; ?>" id="fechausuario<?php echo $counter; ?>"><?php echo $row['registrado_el']; ?></a>
									<p>Texto</p>
								</li>

								<?php  
									};  
								?>

							</ul>
						</div>
					</div>
				</div>

      <hr>

      <footer class="text-center">
        <div class="mb-2">
          <small>
            © 2021 Gestión Pedagógica
            </a>
          </small>
        </div>
        <div>
          <a href="#" target="_blank">
            <i class="fa fa-heart" style="color:red"></i>
          </a>
          <a href="#" target="_blank">
            <i class="fa fa-heart" style="color:red"></i>
          </a>
        </div>
      </footer>
    </div>
  </main>
  <!-- page-content" -->
</div>
<!-- page-wrapper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
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
	</script>
</body>
</html>