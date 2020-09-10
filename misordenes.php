<?php
session_start();
require 'inc/conexion.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION["fb_access_token"])) // Si no encuentra el access token de la sesión, se enviará a login
{
	header("location: login.php");
}
else // Continuamos a la página
	header( 'Content-Type: text/html; charset=utf-8' );
	
	// Consulta para traer los datos de usuario generales
	$sql_datosusuariosgeneral = "SELECT usuario_id, registrado_el, nombres, apellidos, correo, avatar_url, facebook_id
	FROM 
		usuario
	WHERE 
		usuario_id = '".$_SESSION['usuario_id']."' "; 
	$rs_resultdatosgeneral = mysqli_query($conn, $sql_datosusuariosgeneral);
	$row_profile_general = mysqli_fetch_assoc($rs_resultdatosgeneral);

		
	// MIS ORDENES
	// BOX: Tabla Matematica
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos
	$sql_matematicas_orden = "SELECT ordencompra.estado_orden AS ordencompra_estadoorden, ordencompra.fecha_compra AS ordencompra_fechacompra, ordencompra.ordencompra_id AS ordencompra_id, archivo.archivo_id AS archivo_id, archivo.nombre AS archivo_nombre, archivo.curso AS archivo_curso, archivo.unidad AS archivo_unidad, archivo.precio AS archivo_precio, archivo.estado AS archivo_estado, archivo.tipo AS archivo_tipo FROM 
		ordencompra
	INNER JOIN 
		usuario ON ordencompra.usuario_id=usuario.usuario_id 
	INNER JOIN 
		archivo ON ordencompra.archivo_id=archivo.archivo_id 
	WHERE 
		ordencompra.usuario_id = '".$_SESSION['usuario_id']."' AND archivo.asignatura = 'Matematicas'
	ORDER BY estado DESC";
	$rs_result_matematica_orden = mysqli_query($conn, $sql_matematicas_orden);
		
	// BOX: Tabla Lenguaje
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos
	$sql_lenguaje_orden = "SELECT ordencompra.estado_orden AS ordencompra_estadoorden, ordencompra.fecha_compra AS ordencompra_fechacompra, ordencompra.ordencompra_id AS ordencompra_id, archivo.archivo_id AS archivo_id, archivo.nombre AS archivo_nombre, archivo.curso AS archivo_curso, archivo.unidad AS archivo_unidad, archivo.precio AS archivo_precio, archivo.estado AS archivo_estado, archivo.tipo AS archivo_tipo FROM 
		ordencompra
	INNER JOIN 
		usuario ON ordencompra.usuario_id=usuario.usuario_id 
	INNER JOIN 
		archivo ON ordencompra.archivo_id=archivo.archivo_id 
	WHERE 
		ordencompra.usuario_id = '".$_SESSION['usuario_id']."' AND archivo.asignatura = 'Lenguaje'
	ORDER BY estado DESC";
	$rs_result_lenguaje_orden = mysqli_query($conn, $sql_lenguaje_orden);

	// BOX: Tabla Tecnología
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos
	$sql_tecnologia_orden = "SELECT ordencompra.estado_orden AS ordencompra_estadoorden, ordencompra.fecha_compra AS ordencompra_fechacompra, ordencompra.ordencompra_id AS ordencompra_id, archivo.archivo_id AS archivo_id, archivo.nombre AS archivo_nombre, archivo.curso AS archivo_curso, archivo.unidad AS archivo_unidad, archivo.precio AS archivo_precio, archivo.estado AS archivo_estado, archivo.tipo AS archivo_tipo FROM 
		ordencompra
	INNER JOIN 
		usuario ON ordencompra.usuario_id=usuario.usuario_id 
	INNER JOIN 
		archivo ON ordencompra.archivo_id=archivo.archivo_id 
	WHERE 
		ordencompra.usuario_id = '".$_SESSION['usuario_id']."' AND archivo.asignatura = 'Tecnología'
	ORDER BY estado DESC";
	$rs_result_tecnologia_orden = mysqli_query($conn, $sql_tecnologia_orden);

	// BOX: Tabla Música
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos
	$sql_musica_orden = "SELECT ordencompra.estado_orden AS ordencompra_estadoorden, ordencompra.fecha_compra AS ordencompra_fechacompra, ordencompra.ordencompra_id AS ordencompra_id, archivo.archivo_id AS archivo_id, archivo.nombre AS archivo_nombre, archivo.curso AS archivo_curso, archivo.unidad AS archivo_unidad, archivo.precio AS archivo_precio, archivo.estado AS archivo_estado, archivo.tipo AS archivo_tipo FROM 
		ordencompra
	INNER JOIN 
		usuario ON ordencompra.usuario_id=usuario.usuario_id 
	INNER JOIN 
		archivo ON ordencompra.archivo_id=archivo.archivo_id 
	WHERE 
		ordencompra.usuario_id = '".$_SESSION['usuario_id']."' AND archivo.asignatura = 'Música'
	ORDER BY estado DESC";
	$rs_result_musica_orden = mysqli_query($conn, $sql_musica_orden);

	// BOX: Tabla Artes Visuales
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos
	$sql_artesvisuales_orden = "SELECT ordencompra.estado_orden AS ordencompra_estadoorden, ordencompra.fecha_compra AS ordencompra_fechacompra, ordencompra.ordencompra_id AS ordencompra_id, archivo.archivo_id AS archivo_id, archivo.nombre AS archivo_nombre, archivo.curso AS archivo_curso, archivo.unidad AS archivo_unidad, archivo.precio AS archivo_precio, archivo.estado AS archivo_estado, archivo.tipo AS archivo_tipo FROM 
		ordencompra
	INNER JOIN 
		usuario ON ordencompra.usuario_id=usuario.usuario_id 
	INNER JOIN 
		archivo ON ordencompra.archivo_id=archivo.archivo_id 
	WHERE 
		ordencompra.usuario_id = '".$_SESSION['usuario_id']."' AND archivo.asignatura = 'Artes Visuales'
	ORDER BY estado DESC";
	$rs_result_artesvisuales_orden = mysqli_query($conn, $sql_artesvisuales_orden);

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
		<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
		<script src="https://code.jquery.com/jquery-3.5.0.slim.min.js" integrity="sha256-MlusDLJIP1GRgLrOflUQtshyP0TwT/RHXsI1wWGnQhs=" crossorigin="anonymous"></script>
		<script type="text/javascript" charset="utf8" src="js/jquery.dataTables.js"></script>
		<script src="js/functions.js"></script>
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
			<span class="titulo">Mis ordenes</span>

			<div class="btn-group dropup btn-block options">
			<a href="/perfil"><button type="button" class="btn btn-primary"><span class="material-icons">person</span> Volver al perfil</button></a>
			</div>

        </h4>	

		<section id="tabs" class="project-tab">
                <div class="row">
                    <div class="col-md-12">
                        <nav>
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-matematica-tab" data-toggle="tab" href="#nav-matematica-planificacion" role="tab" aria-controls="nav-matematica" aria-selected="true">Matemáticas</a>
								<a class="nav-item nav-link" id="nav-lenguaje-tab" data-toggle="tab" href="#nav-lenguaje-planificacion" role="tab" aria-controls="nav-lenguaje" aria-selected="false">Lenguaje</a>
								<a class="nav-item nav-link" id="nav-tecnologia-tab" data-toggle="tab" href="#nav-tecnologia-planificacion" role="tab" aria-controls="nav-tecnologia" aria-selected="false">Tecnología</a>
								<a class="nav-item nav-link" id="nav-musica-tab" data-toggle="tab" href="#nav-musica-planificacion" role="tab" aria-controls="nav-musica" aria-selected="false">Música</a>
								<a class="nav-item nav-link" id="nav-artesvisuales-tab" data-toggle="tab" href="#nav-artesvisuales-planificacion" role="tab" aria-controls="nav-artesvisuales" aria-selected="false">Artes Visuales</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-matematica-planificacion" role="tabpanel" aria-labelledby="nav-matematica-tab">
                                <table id="tabla-matematica-planificaciones" class="table" cellspacing="0">
                                    <thead>
                                        <tr>
											<th>Tema</th>
											<th>Curso</th>
                                            <th>Tipo</th>
											<th>Pagado</th>
											<th>Fecha</th>
											<th>Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_matematica_orden)) {?>	

											<tr>
												<td><?php echo $row['archivo_nombre']; ?></td>
												<td><?php echo $row['archivo_curso']; ?></td>
												<td><?php 
												if($row['archivo_tipo'] == '0')
												{
													echo 'Planificación';
												}
												else
												{
													echo 'Guía';
												}
												
												?></td>
												<td>$<?php echo $row['archivo_precio']; ?></td>
												<td><?php echo $row['ordencompra_fechacompra']; ?></td>
												<td><?php echo $row['ordencompra_estadoorden']; ?></td>
												<td>
												<a href="/verorden?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">zoom_in</span> Ver orden</button></a>
												<a href="/verarchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">zoom_in</span> Ver archivo</button></a>
												</td>
											</tr>

										<?php };  ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="nav-lenguaje-planificacion" role="tabpanel" aria-labelledby="nav-lenguaje-tab">
                                <table id="tabla-lenguaje-planificaciones" class="table" cellspacing="0">
                                    <thead>
										<tr>
											<th>Tema</th>
											<th>Curso</th>
                                            <th>Tipo</th>
											<th>Pagado</th>
											<th>Fecha</th>
											<th>Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_lenguaje_orden)) {?>	

											<tr>
												<td><?php echo $row['archivo_nombre']; ?></td>
												<td><?php echo $row['archivo_curso']; ?></td>
												<td><?php 
												if($row['archivo_tipo'] == '0')
												{
													echo 'Planificación';
												}
												else
												{
													echo 'Guía';
												}
												
												?></td>
												<td>$<?php echo $row['archivo_precio']; ?></td>
												<td><?php echo $row['ordencompra_fechacompra']; ?></td>
												<td><?php echo $row['ordencompra_estadoorden']; ?></td>
												<td>
												<a href="/verorden?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">zoom_in</span> Ver orden</button></a>
												<a href="/verarchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">zoom_in</span> Ver archivo</button></a>
												</td>
											</tr>

										<?php };  ?>
                                    </tbody>
                                </table>
							</div>
							<div class="tab-pane fade" id="nav-tecnologia-planificacion" role="tabpanel" aria-labelledby="nav-tecnologia-tab">
                                <table id="tabla-tecnologia-planificaciones" class="table" cellspacing="0">
                                    <thead>
										<tr>
											<th>Tema</th>
											<th>Curso</th>
                                            <th>Tipo</th>
											<th>Pagado</th>
											<th>Fecha</th>
											<th>Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_tecnologia_orden)) {?>	

											<tr>
											<td><?php echo $row['archivo_nombre']; ?></td>
												<td><?php echo $row['archivo_curso']; ?></td>
												<td><?php 
												if($row['archivo_tipo'] == '0')
												{
													echo 'Planificación';
												}
												else
												{
													echo 'Guía';
												}
												
												?></td>
												<td>$<?php echo $row['archivo_precio']; ?></td>
												<td><?php echo $row['ordencompra_fechacompra']; ?></td>
												<td><?php echo $row['ordencompra_estadoorden']; ?></td>
												<td>
												<a href="/verorden?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">zoom_in</span> Ver orden</button></a>
												<a href="/verarchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">zoom_in</span> Ver archivo</button></a>
												</td>
											</tr>

										<?php };  ?>
                                    </tbody>
                                </table>
							</div>
							<div class="tab-pane fade" id="nav-musica-planificacion" role="tabpanel" aria-labelledby="nav-musica-tab">
                                <table id="tabla-musica-planificaciones" class="table" cellspacing="0">
                                    <thead>
										<tr>
											<th>Tema</th>
											<th>Curso</th>
                                            <th>Tipo</th>
											<th>Pagado</th>
											<th>Fecha</th>
											<th>Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_musica_orden)) {?>	

											<tr>
												<td><?php echo $row['archivo_nombre']; ?></td>
												<td><?php echo $row['archivo_curso']; ?></td>
												<td><?php 
												if($row['archivo_tipo'] == '0')
												{
													echo 'Planificación';
												}
												else
												{
													echo 'Guía';
												}
												
												?></td>
												<td>$<?php echo $row['archivo_precio']; ?></td>
												<td><?php echo $row['ordencompra_fechacompra']; ?></td>
												<td><?php echo $row['ordencompra_estadoorden']; ?></td>
												<td>
												<a href="/verorden?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">zoom_in</span> Ver orden</button></a>
												<a href="/verarchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">zoom_in</span> Ver archivo</button></a>
												</td>
											</tr>

										<?php };  ?>
                                    </tbody>
                                </table>
							</div>
							<div class="tab-pane fade" id="nav-artesvisuales-planificacion" role="tabpanel" aria-labelledby="nav-artesvisuales-tab">
                                <table id="tabla-artesvisuales-planificaciones" class="table" cellspacing="0">
                                    <thead>
										<tr>
											<th>Tema</th>
											<th>Curso</th>
                                            <th>Tipo</th>
											<th>Pagado</th>
											<th>Fecha</th>
											<th>Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_artesvisuales_orden)) {?>	

											<tr>
												<td><?php echo $row['archivo_nombre']; ?></td>
												<td><?php echo $row['archivo_curso']; ?></td>
												<td><?php 
												if($row['archivo_tipo'] == '0')
												{
													echo 'Planificación';
												}
												else
												{
													echo 'Guía';
												}
												
												?></td>
												<td>$<?php echo $row['archivo_precio']; ?></td>
												<td><?php echo $row['ordencompra_fechacompra']; ?></td>
												<td><?php echo $row['ordencompra_estadoorden']; ?></td>
												<td>
												<a href="/verorden?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">zoom_in</span> Ver orden</button></a>
												<a href="/verarchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">zoom_in</span> Ver archivo</button></a>
												</td>
											</tr>

										<?php };  ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        </section>

	</div>
    </div>

      <footer class="mastfoot margin-top">
        <div class="inner">
          <p class="footer">Copyright © 2020 Gestión Pedagógica</p>
        </div>
      </footer>
    </div>

    
    <script src="js/bootstrap.bundle.min.js"></script>
	
  </body>
</html>