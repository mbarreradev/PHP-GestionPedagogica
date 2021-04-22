<?php
session_start();
require 'inc/database.php';

if (!isset($_SESSION["fb_access_token"])) // Si no encuentra el access token de la sesión, se enviará a login
{
	header("location: login.php");
}
else // Continuamos a la página
	header( 'Content-Type: text/html; charset=utf-8' );
	
	// Consulta para traer los datos de usuario generales
	$sql_datosusuariosgeneral = "SELECT usuario_id, registrado_el, nombres, apellidos, correo, avatar_url, facebook_id, rango
	FROM 
		usuario
	WHERE 
		usuario_id = '".$_SESSION['usuario_id']."' "; 
	$rs_resultdatosgeneral = mysqli_query($conn, $sql_datosusuariosgeneral);
	$row_profile_general = mysqli_fetch_assoc($rs_resultdatosgeneral);
		

	// PLANIFICACIONES
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos, luego entramos a usuarios con la condición de que usuario_id sea iguales y luego filtramos todos los datos para que aparescan los que tienen el mismo facebook_id
	$sql_planificacion = "SELECT ordencompra.ordencompra_id, ordencompra.fecha_compra, archivo.unidad AS archivo_unidad, archivo.asignatura AS archivo_asignatura, archivo.archivo_id AS archivo_id, archivo.nombre AS archivo_nombre, archivo.curso AS archivo_curso
	FROM 
		ordencompra
	INNER JOIN 
		archivo
	ON
		ordencompra.archivo_id=archivo.archivo_id
	INNER JOIN 
		usuario
	ON
		ordencompra.usuario_id=usuario.usuario_id
	WHERE 
		ordencompra.usuario_id = '".$_SESSION['usuario_id']."' AND ordencompra.estado_orden = 'Pagado' AND tipo = '0'
	ORDER BY ordencompra.ordencompra_id DESC"; 
	$rs_result_planificacion = mysqli_query($conn, $sql_planificacion);

	// GUIAS
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos, luego entramos a usuarios con la condición de que usuario_id sea iguales y luego filtramos todos los datos para que aparescan los que tienen el mismo facebook_id
	$sql_guia = "SELECT ordencompra.ordencompra_id, ordencompra.fecha_compra, archivo.unidad AS archivo_unidad, archivo.asignatura AS archivo_asignatura, archivo.archivo_id AS archivo_id, archivo.nombre AS archivo_nombre, archivo.curso AS archivo_curso
	FROM 
		ordencompra
	INNER JOIN 
		archivo
	ON
		ordencompra.archivo_id=archivo.archivo_id
	INNER JOIN 
		usuario
	ON
		ordencompra.usuario_id=usuario.usuario_id
	WHERE 
		ordencompra.usuario_id = '".$_SESSION['usuario_id']."' AND ordencompra.estado_orden = 'Pagado' AND tipo = '1'
	ORDER BY ordencompra.ordencompra_id DESC"; 
	$rs_result_guia = mysqli_query($conn, $sql_guia);

	// Contador documentos disponibles
	$sql_documentos_disponibles = "SELECT * FROM ordencompra INNER JOIN usuario ON ordencompra.usuario_id=usuario.usuario_id WHERE ordencompra.usuario_id = '".$_SESSION['usuario_id']."' AND estado_orden = 'Pagado' ";  
	$rs_result_documentos_disponibles = mysqli_query($conn, $sql_documentos_disponibles);  
	$cnt_documentos_disponible_total = $rs_result_documentos_disponibles->num_rows;

	// Contador compras realizadas
	$sql_compras_realizadas = "SELECT * FROM ordencompra INNER JOIN usuario ON ordencompra.usuario_id=usuario.usuario_id WHERE ordencompra.usuario_id = '".$_SESSION['usuario_id']."' AND estado_orden = 'Pagado' ";  
	$rs_result_compras_realizadas = mysqli_query($conn, $sql_compras_realizadas);  
	$cnt_compras_realizadas = $rs_result_compras_realizadas->num_rows;

	// Contador ordenes pendientes
	$sql_ordenes_pendientes = "SELECT * FROM ordencompra INNER JOIN usuario ON ordencompra.usuario_id=usuario.usuario_id WHERE ordencompra.usuario_id = '".$_SESSION['usuario_id']."' AND estado_orden = 'Pendiente de confirmación' ";  
	$rs_result_ordenes_pendientes = mysqli_query($conn, $sql_ordenes_pendientes);  
	$cnt_ordenes_pendientes = $rs_result_ordenes_pendientes->num_rows;

?>
<!doctype html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<link rel="icon" href="favicon.ico">
		<title>Mi perfil - Gestión Pedagógica</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" rel="stylesheet">
        <link href="css/sidebar.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    	<script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/sidebar.js"></script>
        <script src="js/moment-with-locales.js"></script>
		<script src="js/list.min.js"></script>
	</head>
<body>
<script>
window.addEventListener("load", pageFullyLoaded, false);

function pageFullyLoaded(e) {
    var dateFormat = 'YYYY-DD-MM HH:mm:ss';
	var registrado_utctime = moment.utc('<?php echo $row_profile_general["registrado_el"]; ?>');
	var registrado_localdate = registrado_utctime.local();
	var registrado_localdate2 = registrado_localdate.locale('es')
	
	var modificardivregistrado = document.getElementById('registrado');
	modificardivregistrado.innerHTML =  moment(registrado_localdate2, "YYYY-MM-DD hh:mm:ss").fromNow();
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
        <h4 class="titulo">Mi perfil</h4>
		</div>
		<hr>

		<div class="card profile border-plomo bg-azul-claro">
			<div class="row no-gutters">
				<div class="col-md">
				  	<div class="card-body">
						<div class="row">
							<div class="col-sm">
								<h4><?php echo $row_profile_general["nombres"]; ?> <?php echo $row_profile_general["apellidos"]; ?></h4>
								Registrado: <span id="registrado"><?php echo $row_profile_general["registrado_el"]; ?></span></br>
								Correo electrónico: <span><?php echo $row_profile_general["correo"]; ?></span></br>
								<hr class="bg-azul"/>
								<span class="tags">Conectado desde Facebook</span>
							</div>             
							<div class="col-sm text-center">
								<div class="row counter-profile">
									<div class="col-sm">
										<div class="Count"><?php echo $cnt_documentos_disponible_total; ?></div>                    
											<p>documentos disponibles</p>
										</div>
										<div class="col-sm">
											<div class="Count"><?php echo $cnt_compras_realizadas; ?></div>                    
											<p>compras realizadas</p>
										</div>
										<div class="col-sm">
											<div class="Count"><?php echo $cnt_ordenes_pendientes; ?></div>                    
											<p>ordenes pendientes</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
			  	</div>
			</div>

		<div class="d-flex justify-content-between mt-3 mb-3">
			<h4 class="titulo">Mis planificaciones</h4>
		</div>

		<section id="tabs" class="project-tab">
                <div class="row">
                    <div class="col-md-12" id="nav-planificacion">
								<div class="buscador">
									<input type="search" class="search form-control" placeholder="Puedes buscar por temática, curso o unidad"/>
								</div>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-light" id="filter-none-planificacion">Ver todos</button>
                                    <button type="button" class="btn btn-light" id="filter-matematicas-planificacion">Matemáticas</button>
                                    <button type="button" class="btn btn-light" id="filter-lenguaje-planificacion">Lenguaje</button>
                                    <button type="button" class="btn btn-light" id="filter-tecnologia-planificacion">Tecnología</button>
                                    <button type="button" class="btn btn-light" id="filter-musica-planificacion">Música</button>
                                    <button type="button" class="btn btn-light" id="filter-artesvisuales-planificacion">Artes Visuales</button>
                                </div>
                                <table id="tabla-planificacion" class="table" cellspacing="0">
                                    <thead>
                                        <tr class="bg-azul">
                                            <th class="sort" data-sort="tema">Tema</th>
											<th class="sort" data-sort="curso">Curso</th>
											<th class="sort" data-sort="unidad">Unidad</th>
                                            <th class="sort" data-sort="asignatura">Asignatura</th>
                                            <th>Fecha de compra</th>
											<th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_planificacion)) {?>	

											<tr>
												<td class="tema"><?php echo $row['archivo_nombre']; ?></td>
												<td class="curso"><?php echo $row['archivo_curso']; ?></td>
												<td class="unidad"><?php echo $row['archivo_unidad']; ?></td>
                                                <td class="asignatura"><?php echo $row['archivo_asignatura']; ?></td>
												<td><?php echo $row['fecha_compra']; ?></td>
												<td>
												<div class="btn-group" role="group">
													<button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle tabla" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													Opciones
													</button>
													<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                        <a class="dropdown-item" href="/verdocumento?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-success tabla"><i class="fas fa-cloud-download-alt"></i> Descargar</button></a>
                                                        <a class="dropdown-item" href="/verorden?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-info tabla"><i class="fas fa-folder"></i> Ver orden</button></a>
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
			<h4 class="titulo">Mis guías</h4>
		</div>

		<section id="tabs" class="project-tab">
                <div class="row">
                    <div class="col-md-12" id="nav-guia">
								<div class="buscador">
									<input type="text" class="search form-control" placeholder="Puedes buscar por temática, curso o unidad"/>
								</div>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-light" id="filter-none-guia">Ver todos</button>
                                    <button type="button" class="btn btn-light" id="filter-matematicas-guia">Matemáticas</button>
                                    <button type="button" class="btn btn-light" id="filter-lenguaje-guia">Lenguaje</button>
                                    <button type="button" class="btn btn-light" id="filter-tecnologia-guia">Tecnología</button>
                                    <button type="button" class="btn btn-light" id="filter-musica-guia">Música</button>
                                    <button type="button" class="btn btn-light" id="filter-artesvisuales-guia">Artes Visuales</button>
                                </div>
                                <table id="tabla-guia" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
                                            <th class="sort" data-sort="tema">Tema</th>
											<th class="sort" data-sort="curso">Curso</th>
											<th class="sort" data-sort="unidad">Unidad</th>
                                            <th class="sort" data-sort="asignatura">Asignatura</th>
                                            <th>Fecha de compra</th>
											<th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_guia)) {?>	

											<tr>
												<td class="tema"><?php echo $row['archivo_nombre']; ?></td>
												<td class="curso"><?php echo $row['archivo_curso']; ?></td>
												<td class="unidad"><?php echo $row['archivo_unidad']; ?></td>
                                                <td class="asignatura"><?php echo $row['archivo_asignatura']; ?></td>
												<td><?php echo $row['fecha_compra']; ?></td>
												<td>
												<div class="btn-group" role="group">
													<button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle tabla" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													Opciones
													</button>
													<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                        <a class="dropdown-item" href="/verdocumento?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-success tabla"><i class="fas fa-cloud-download-alt"></i> Descargar</button></a>
                                                        <a class="dropdown-item" href="/verorden?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-info tabla"><i class="fas fa-folder"></i> Ver orden</button></a>
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
    valueNames: [ 'tema', 'curso', 'unidad', 'asignatura'],
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