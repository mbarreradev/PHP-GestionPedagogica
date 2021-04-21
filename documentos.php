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

    // PLANIFICACIONES
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos
	$sql_planificacion = "SELECT archivo_id, nombre, curso, unidad, precio, estado, asignatura
	FROM 
		archivo
	WHERE 
		tipo = '0'
	ORDER BY estado DESC"; 
	$rs_result_planificacion = mysqli_query($conn, $sql_planificacion);

	// GUIAS
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos
	$sql_guia = "SELECT archivo_id, nombre, curso, unidad, precio, estado, asignatura
	FROM 
		archivo
	WHERE 
		tipo = '1'
	ORDER BY estado DESC"; 
	$rs_result_guia = mysqli_query($conn, $sql_guia);

	// Contadores
	$cnt_planificaciones = $rs_result_planificacion->num_rows;
	$cnt_guias = $rs_result_guia->num_rows;

	$cnt_archivos_total = ($cnt_planificaciones + $cnt_guias);

?>
<!doctype html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<link rel="icon" href="favicon.ico">
		<title>Documentos - Gestión Pedagógica</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <link href="css/sidebar.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    	<script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/sidebar.js"></script>
		<script src="js/list.min.js"></script>
        <script src="js/moment-with-locales.js"></script>
	</head>
<body>
<div class="page-wrapper chiller-theme toggled">
  <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
    <i class="fas fa-bars"></i>
  </a>
  
  <?php require 'inc/sidebar.php'; ?>

  <main class="page-content">
    <div class="container-fluid">
      
        <div class="d-flex justify-content-between">
            <h4 class="titulo">Estadísticas</h4>
            <div class="btn-group dropup btn-block options">
                <a href="/administracion"><button type="button" class="btn btn-primary"><i class="fa fa-tachometer-alt"></i> Volver a la administración</button></a>
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
									<span class="material-icons stats">sticky_note_2</span>
								</div>
								<div class="col-9 text-right">
									<div class="Count"><?php echo $cnt_guias; ?></div>
									<h4>guías</h4>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="card border-plomo">
						<div class="card-body bg-naranjo-especial text-white">
							<div class="row">
								<div class="col-3">
									<span class="material-icons stats">sticky_note_2</span>
								</div>
								<div class="col-9 text-right">
									<div class="Count"><?php echo $cnt_planificaciones; ?></div>
									<h4>planificaciones</h4>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-4 nopadding-right">
                    <div class="card border-plomo">
						<div class="card-body bg-azul-especial text-white">
							<div class="row">
								<div class="col-3">
									<span class="material-icons stats">source</span>
								</div>
								<div class="col-9 text-right">
									<div class="Count"><?php echo $cnt_archivos_total; ?></div>
									<h4>documentos subidos</h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

        <div class="d-flex justify-content-between mb-3">
        <h4 class="titulo">Planificaciones</h4>
		</div>

        <section id="tabs" class="project-tab">
                <div class="row">
                    <div class="col-md-12" id="nav-planificacion">
								<div class="buscador">
									<input type="search" class="search form-control" placeholder="Puedes buscar por temática, curso, unidad, precio o estado"/>
								</div>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-light" id="filter-none-planificacion">Ver todos</button>
                                    <button type="button" class="btn btn-light" id="filter-matematicas-planificacion">Matemáticas</button>
                                    <button type="button" class="btn btn-light" id="filter-lenguaje-planificacion">Lenguaje</button>
                                    <button type="button" class="btn btn-light" id="filter-tecnologia-planificacion">Tecnología</button>
                                    <button type="button" class="btn btn-light" id="filter-musica-planificacion">Música</button>
                                    <button type="button" class="btn btn-light" id="filter-artesvisuales-planificacion">Artes Visuales</button>
                                </div>
                                <table id="tabla-matematica-planificacion" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
											<th class="sort" data-sort="tema">Tema</th>
											<th class="sort" data-sort="curso">Curso</th>
											<th class="sort" data-sort="unidad">Unidad</th>
                                            <th class="sort" data-sort="asignatura">Asignatura</th>
                                            <th class="sort" data-sort="precio">Monto</th>
											<th class="sort" data-sort="estado">Estado</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_planificacion)) { 
										$precio_final = number_format($row['precio'],0, '', '.');
											?>	

											<tr>
												<td class="tema"><?php echo $row['nombre']; ?></td>
												<td class="curso"><?php echo $row['curso']; ?></td>
												<td class="unidad"><?php echo $row['unidad']; ?></td>
                                                <td class="asignatura"><?php echo $row['asignatura']; ?></td>
												<td class="precio">$<?php echo $precio_final; ?></td>
												<td class="estado"><?php 
												if($row['estado'] == '0') // desactivado
												{
													echo 'Activado';
												}
												else // será 1 - activado
												{
													echo 'Desactivado';
												}

												?></td>
												<td>
												<div class="btn-group" role="group">
													<button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle tabla" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													Opciones
													</button>
													<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
													<a class="dropdown-item" href="/verdocumento?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">library_books</span> Ver</button></a>
													<a class="dropdown-item" href="/estadisticas?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons"><span class="material-icons-outlined">trending_up</span></span> Estadísticas</button></a>
													<a class="dropdown-item" href="/editardocumento?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-primary tabla"><span class="material-icons">edit</span> Modificar</button></a>
													</div>
												</div>
												</td>
											</tr>

										<?php };  ?>
                                    </tbody>
                                </table>

								<div class="container">
									<div class="row text-center justify-content-center">
										<ul class="pagination"></ul>
									</div>
								</div>
                        
                    </div>
                </div>
        </section>

        <div class="d-flex justify-content-between mt-3 mb-3">
        <h4 class="titulo">Guías</h4>
		</div>

        <section id="tabs" class="project-tab">
                <div class="row">
                    <div class="col-md-12" id="nav-guia">
								<div class="buscador">
									<input type="search" class="search form-control" placeholder="Puedes buscar por temática, curso, unidad, precio o estado"/>
								</div>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-light" id="filter-none-guia">Ver todos</button>
                                    <button type="button" class="btn btn-light" id="filter-matematicas-guia">Matemáticas</button>
                                    <button type="button" class="btn btn-light" id="filter-lenguaje-guia">Lenguaje</button>
                                    <button type="button" class="btn btn-light" id="filter-tecnologia-guia">Tecnología</button>
                                    <button type="button" class="btn btn-light" id="filter-musica-guia">Música</button>
                                    <button type="button" class="btn btn-light" id="filter-artesvisuales-guia">Artes Visuales</button>
                                </div>
                                <table id="tabla-matematica-guia" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
											<th class="sort" data-sort="tema">Tema</th>
											<th class="sort" data-sort="curso">Curso</th>
											<th class="sort" data-sort="unidad">Unidad</th>
                                            <th class="sort" data-sort="asignatura">Asignatura</th>
                                            <th class="sort" data-sort="precio">Monto</th>
											<th class="sort" data-sort="estado">Estado</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_guia)) {
										$precio_final = number_format($row['precio'],0, '', '.');	
										?>	

											<tr>
												<td class="tema"><?php echo $row['nombre']; ?></td>
												<td class="curso"><?php echo $row['curso']; ?></td>
												<td class="unidad"><?php echo $row['unidad']; ?></td>
                                                <td class="asignatura"><?php echo $row['asignatura']; ?></td>
												<td class="precio">$<?php echo $precio_final; ?></td>
												<td class="estado"><?php 
												if($row['estado'] == '0') // desactivado
												{
													echo 'Activado';
												}
												else // será 1 - activado
												{
													echo 'Desactivado';
												}

												?></td>
												<td>
												<div class="btn-group" role="group">
													<button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle tabla" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													Opciones
													</button>
													<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
													<a class="dropdown-item" href="/verdocumento?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">library_books</span> Ver</button></a>
													<a class="dropdown-item" href="/estadisticas?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons"><span class="material-icons-outlined">trending_up</span></span> Estadísticas</button></a>
													<a class="dropdown-item" href="/editardocumento?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-primary tabla width100"><span class="material-icons">edit</span> Modificar</button></a>
													</div>
												</div>
												</td>
											</tr>

										<?php };  ?>
                                    </tbody>
                                </table>

								<div class="container">
									<div class="row text-center justify-content-center">
										<ul class="pagination"></ul>
									</div>
								</div>
                    </div>
                </div>
        </section>

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
		var options = {
    valueNames: [ 'tema', 'curso', 'unidad', 'precio', 'estado', 'asignatura'],
    page: 10,
    pagination: true
	};

	var tablaPlanificaciones = new List('nav-planificacion', options);
	var tablaGuias = new List('nav-guia', options);

    // Planificaciones
    $('#filter-matematicas-planificacion').click(function() {
    tablaPlanificaciones.filter(function(item) {
        if (item.values().asignatura == "Matemáticas") {
        return true;
        } else {
        return false;
        }
    });
    return false;
    });

    $('#filter-lenguaje-planificacion').click(function() {
    tablaPlanificaciones.filter(function(item) {
        if (item.values().asignatura == "Lenguaje") {
        return true;
        } else {
        return false;
        }
    });
    return false;
    });

    $('#filter-tecnologia-planificacion').click(function() {
    tablaPlanificaciones.filter(function(item) {
        if (item.values().asignatura == "Tecnología") {
        return true;
        } else {
        return false;
        }
    });
    return false;
    });

    $('#filter-musica-planificacion').click(function() {
    tablaPlanificaciones.filter(function(item) {
        if (item.values().asignatura == "Música") {
        return true;
        } else {
        return false;
        }
    });
    return false;
    });

    $('#filter-artesvisuales-planificacion').click(function() {
    tablaPlanificaciones.filter(function(item) {
        if (item.values().asignatura == "Artes Visuales") {
        return true;
        } else {
        return false;
        }
    });
    return false;
    });

    $('#filter-none-planificacion').click(function() {
    tablaPlanificaciones.filter();
    return false;
    });

    // Guias
    $('#filter-matematicas-guia').click(function() {
    tablaGuias.filter(function(item) {
        if (item.values().asignatura == "Matemáticas") {
        return true;
        } else {
        return false;
        }
    });
    return false;
    });

    $('#filter-lenguaje-guia').click(function() {
    tablaGuias.filter(function(item) {
        if (item.values().asignatura == "Lenguaje") {
        return true;
        } else {
        return false;
        }
    });
    return false;
    });

    $('#filter-tecnologia-guia').click(function() {
    tablaGuias.filter(function(item) {
        if (item.values().asignatura == "Tecnología") {
        return true;
        } else {
        return false;
        }
    });
    return false;
    });

    $('#filter-musica-guia').click(function() {
    tablaGuias.filter(function(item) {
        if (item.values().asignatura == "Música") {
        return true;
        } else {
        return false;
        }
    });
    return false;
    });

    $('#filter-artesvisuales-guia').click(function() {
    tablaGuias.filter(function(item) {
        if (item.values().asignatura == "Artes Visuales") {
        return true;
        } else {
        return false;
        }
    });
    return false;
    });

    $('#filter-none-guia').click(function() {
    tablaGuias.filter();
    return false;
    });

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