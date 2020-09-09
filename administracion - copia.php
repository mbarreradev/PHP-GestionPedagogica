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
	$sql_datosusuariosgeneral = "SELECT usuario_id, registrado_el, nombres, apellidos, correo, avatar_url, facebook_id
	FROM 
		usuario
	WHERE 
		usuario_id = '".$_SESSION['usuario_id']."' "; 
	$rs_resultdatosgeneral = mysqli_query($conn, $sql_datosusuariosgeneral);
	$row_profile_general = mysqli_fetch_assoc($rs_resultdatosgeneral);

		
	// PLANIFICACIONES
	// BOX: Tabla Matematica
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos
	$sql_matematicas_planificacion = "SELECT archivo_id, nombre, curso, unidad, precio, estado
	FROM 
		archivo
	WHERE 
		asignatura = 'Matemáticas' AND tipo = '0'
	ORDER BY estado DESC"; 
	$rs_result_matematica_planificacion = mysqli_query($conn, $sql_matematicas_planificacion);
		
	// BOX: Tabla Lenguaje
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos
	$sql_lenguaje_planificacion = "SELECT archivo_id, nombre, curso, unidad, precio, estado
	FROM
		archivo
	WHERE 
		asignatura = 'Lenguaje' AND tipo = '0'
	ORDER BY estado DESC"; 
	$rs_result_lenguaje_planificacion = mysqli_query($conn, $sql_lenguaje_planificacion);

	// BOX: Tabla Tecnología
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos
	$sql_tecnologia_planificacion = "SELECT archivo_id, nombre, curso, unidad, precio, estado
	FROM
		archivo
	WHERE 
		asignatura = 'Tecnología' AND tipo = '0'
	ORDER BY estado DESC"; 
	$rs_result_tecnologia_planificacion = mysqli_query($conn, $sql_tecnologia_planificacion);

	// BOX: Tabla Música
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos
	$sql_musica_planificacion = "SELECT archivo_id, nombre, curso, unidad, precio, estado
	FROM
		archivo
	WHERE 
		asignatura = 'Música' AND tipo = '0'
	ORDER BY estado DESC"; 
	$rs_result_musica_planificacion = mysqli_query($conn, $sql_musica_planificacion);

	// BOX: Tabla Artes Visuales
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos
	$sql_artesvisuales_planificacion = "SELECT archivo_id, nombre, curso, unidad, precio, estado
	FROM
		archivo
	WHERE 
		asignatura = 'Artes Visuales' AND tipo = '0'
	ORDER BY estado DESC"; 
	$rs_result_artesvisuales_planificacion = mysqli_query($conn, $sql_artesvisuales_planificacion);



	// GUIAS
	// BOX: Tabla Matematica
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos
	$sql_matematicas_guia = "SELECT archivo_id, nombre, curso, unidad, precio, estado
	FROM 
		archivo
	WHERE 
		asignatura = 'Matemáticas' AND tipo = '1'
	ORDER BY estado DESC"; 
	$rs_result_matematica_guia = mysqli_query($conn, $sql_matematicas_guia);
		
	// BOX: Tabla Lenguaje
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos
	$sql_lenguaje_guia = "SELECT archivo_id, nombre, curso, unidad, precio, estado
	FROM
		archivo
	WHERE 
		asignatura = 'Lenguaje' AND tipo = '1'
	ORDER BY estado DESC"; 
	$rs_result_lenguaje_guia = mysqli_query($conn, $sql_lenguaje_guia);

	// BOX: Tabla Tecnología
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos
	$sql_tecnologia_guia = "SELECT archivo_id, nombre, curso, unidad, precio, estado
	FROM
		archivo
	WHERE 
		asignatura = 'Tecnología' AND tipo = '1'
	ORDER BY estado DESC"; 
	$rs_result_tecnologia_guia = mysqli_query($conn, $sql_tecnologia_guia);

	// BOX: Tabla Música
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos
	$sql_musica_guia = "SELECT archivo_id, nombre, curso, unidad, precio, estado
	FROM
		archivo
	WHERE 
		asignatura = 'Música' AND tipo = '1'
	ORDER BY estado DESC"; 
	$rs_result_musica_guia = mysqli_query($conn, $sql_musica_guia);

	// BOX: Tabla Artes Visuales
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos
	$sql_artesvisuales_guia = "SELECT archivo_id, nombre, curso, unidad, precio, estado
	FROM
		archivo
	WHERE 
		asignatura = 'Artes Visuales' AND tipo = '1'
	ORDER BY estado DESC"; 
	$rs_result_artesvisuales_guia = mysqli_query($conn, $sql_artesvisuales_guia);



	// Contador ordenes pendientes de revisión - confirmación
	$sql_ordenes_pendientes_confirmacion = "SELECT * FROM ordencompra WHERE estado_orden = 'Pendiente de confirmación'";  
	$rs_result_ordenes_pendientes_confirmacion = mysqli_query($conn, $sql_ordenes_pendientes_confirmacion);  
	$cnt_ordenes_pendientes_confirmacion = $rs_result_ordenes_pendientes_confirmacion->num_rows;

	// sin usar
	// Contador ordenes pendientes de pago
	$sql_ordenes_pendientes_pago = "SELECT * FROM ordencompra WHERE estado_orden = 'Pendiente de pago'";  
	$rs_result_ordenes_pendientes_pago = mysqli_query($conn, $sql_ordenes_pendientes_pago);  
	$cnt_ordenes_pendientes_pago = $rs_result_ordenes_pendientes_pago->num_rows;

	// sin usar
	// Contador ordenes completadas
	$sql_ordenes_completados = "SELECT * FROM ordencompra WHERE estado_orden = 'Pagado'";  
	$rs_result_ordenes_completados = mysqli_query($conn, $sql_ordenes_completados);  
	$cnt_ordenes_completadas = $rs_result_ordenes_completados->num_rows;

	// Contador usuarios registrados
	$sql_usuarios_registrados = "SELECT * FROM usuario";  
	$rs_result_usuarios_registrados = mysqli_query($conn, $sql_usuarios_registrados);  
	$cnt_usuarios_registrados = $rs_result_usuarios_registrados->num_rows;

	// sin usar
	// Contador planificaciones
	$cnt_planificaciones1 = $rs_result_matematica_planificacion->num_rows;
	$cnt_planificaciones2 = $rs_result_lenguaje_planificacion->num_rows;
	$cnt_planificaciones3 = $rs_result_tecnologia_planificacion->num_rows;
	$cnt_planificaciones4 = $rs_result_musica_planificacion->num_rows;
	$cnt_planificaciones5 = $rs_result_artesvisuales_planificacion->num_rows;
	$cnt_planificaciones_total = ($cnt_planificaciones1 + $cnt_planificaciones2 + $cnt_planificaciones3 + $cnt_planificaciones4 + $cnt_planificaciones5);

	// sin usar
	// Contador guias
	$cnt_guias1 = $rs_result_matematica_guia->num_rows;
	$cnt_guias2 = $rs_result_lenguaje_guia->num_rows;
	$cnt_guias3 = $rs_result_tecnologia_guia->num_rows;
	$cnt_guias4 = $rs_result_musica_guia->num_rows;
	$cnt_guias5 = $rs_result_artesvisuales_guia->num_rows;
	$cnt_guias_total = ($cnt_guias1 + $cnt_guias2 + $cnt_guias3 + $cnt_guias4 + $cnt_guias5);

	$cnt_archivos_total = ($cnt_planificaciones_total + $cnt_guias_total);

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

	<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-color border-bottom box-shadow border-azul-claro">
		<img class="logo" src="/images/Logo.png" width="32" height="32"><h5 class="my-0 mr-md-auto font-weight-normal">Gestión Pedagógica</h5>
      	<nav class="my-2 my-md-0 mr-md-3">
		<a href="http://repositorio.gestionpedagogica.cl"><button class="btn btn-secondary" type="button">Inicio</button></a>
		<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Hola <?php echo $row_profile_general["nombres"]; ?></button>
		<div class="dropdown-menu" aria-labelledby="dropdownMenu2">
			<a href="/perfil"><button class="dropdown-item" type="button">Perfil</button></a>
			<a href="/misordenes"><button class="dropdown-item" type="button">Mis ordenes</button></a>
			<a href="/logout"><button class="dropdown-item" type="button">Desconectar</button></a>
		</div>
        <a href="/contacto"><button class="btn btn-secondary" type="button">Contacto</button></a>
      </nav>
      <a class="btn btn-outline-success" href="#">Contactar por Whatsapp</a>
    </div>

      <div class="rounded border border-azul-claro p-3">
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
									<a class="dropdown-item" href="/perfiles">Ver perfiles</a>
									<a class="dropdown-item" href="/nuevoperfil">Crear nuevo</a>
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

		<h4 class="d-flex justify-content-between align-items-center mb-3">
            <span>Planificaciones</span>

			<div class="btn-group dropup btn-block options">
			<a href="/nuevoarchivo"><button type="button" class="btn btn-primary"><span class="material-icons">add</span> Agregar nuevo</button></a>
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
											<th>Unidad</th>
                                            <th>Precio</th>
											<th>Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_matematica_planificacion)) {?>	

											<tr>
												<td><?php echo $row['nombre']; ?></td>
												<td><?php echo $row['curso']; ?></td>
												<td><?php echo $row['unidad']; ?></td>
												<td>$<?php echo $row['precio']; ?></td>
												<td><?php 
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
												<a href="/archivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">zoom_in</span> Ver</button></a>
												<a href="/editar?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-primary tabla"><span class="material-icons">edit</span> Modificar</button></a>
												<a href="/eliminar?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-danger tabla"><span class="material-icons">delete</span> Eliminar</button></a>
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
											<th>Unidad</th>
                                            <th>Precio</th>
											<th>Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_lenguaje_planificacion)) {?>	

											<tr>
												<td><?php echo $row['nombre']; ?></td>
												<td><?php echo $row['curso']; ?></td>
												<td><?php echo $row['unidad']; ?></td>
												<td>$<?php echo $row['precio']; ?></td>
												<td><?php 
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
												<a href="/archivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">zoom_in</span> Ver</button></a>
												<a href="/editar?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-primary tabla"><span class="material-icons">edit</span> Modificar</button></a>
												<a href="/eliminar?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-danger tabla"><span class="material-icons">delete</span> Eliminar</button></a>
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
											<th>Unidad</th>
                                            <th>Precio</th>
											<th>Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_tecnologia_planificacion)) {?>	

											<tr>
												<td><?php echo $row['nombre']; ?></td>
												<td><?php echo $row['curso']; ?></td>
												<td><?php echo $row['unidad']; ?></td>
												<td>$<?php echo $row['precio']; ?></td>
												<td><?php 
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
												<a href="/archivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">zoom_in</span> Ver</button></a>
												<a href="/editar?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-primary tabla"><span class="material-icons">edit</span> Modificar</button></a>
												<a href="/eliminar?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-danger tabla"><span class="material-icons">delete</span> Eliminar</button></a>
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
											<th>Unidad</th>
                                            <th>Precio</th>
											<th>Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_musica_planificacion)) {?>	

											<tr>
												<td><?php echo $row['nombre']; ?></td>
												<td><?php echo $row['curso']; ?></td>
												<td><?php echo $row['unidad']; ?></td>
												<td>$<?php echo $row['precio']; ?></td>
												<td><?php 
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
												<a href="/archivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">zoom_in</span> Ver</button></a>
												<a href="/editar?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-primary tabla"><span class="material-icons">edit</span> Modificar</button></a>
												<a href="/eliminar?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-danger tabla"><span class="material-icons">delete</span> Eliminar</button></a>
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
											<th>Unidad</th>
                                            <th>Precio</th>
											<th>Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_artesvisuales_planificacion)) {?>	

											<tr>
												<td><?php echo $row['nombre']; ?></td>
												<td><?php echo $row['curso']; ?></td>
												<td><?php echo $row['unidad']; ?></td>
												<td>$<?php echo $row['precio']; ?></td>
												<td><?php 
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
												<a href="/archivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">zoom_in</span> Ver</button></a>
												<a href="/editar?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-primary tabla"><span class="material-icons">edit</span> Modificar</button></a>
												<a href="/eliminar?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-danger tabla"><span class="material-icons">delete</span> Eliminar</button></a>
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

		<h4 class="d-flex justify-content-between align-items-center mb-3 margin-bottom">
            <span>Guías</span>

			<div class="btn-group dropup btn-block options">
			<a href="/nuevoarchivo"><button type="button" class="btn btn-primary"><span class="material-icons">add</span> Agregar nuevo</button></a>
			</div>

        </h4>	

		<section id="tabs" class="project-tab">
                <div class="row">
                    <div class="col-md-12">
                        <nav>
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-matematica-tab" data-toggle="tab" href="#nav-matematica-guia" role="tab" aria-controls="nav-matematica" aria-selected="true">Matemáticas</a>
								<a class="nav-item nav-link" id="nav-lenguaje-tab" data-toggle="tab" href="#nav-lenguaje-guia" role="tab" aria-controls="nav-lenguaje" aria-selected="false">Lenguaje</a>
								<a class="nav-item nav-link" id="nav-tecnologia-tab" data-toggle="tab" href="#nav-tecnologia-guia" role="tab" aria-controls="nav-tecnologia" aria-selected="false">Tecnología</a>
								<a class="nav-item nav-link" id="nav-musica-tab" data-toggle="tab" href="#nav-musica-guia" role="tab" aria-controls="nav-musica" aria-selected="false">Música</a>
								<a class="nav-item nav-link" id="nav-artesvisuales-tab" data-toggle="tab" href="#nav-artesvisuales-guia" role="tab" aria-controls="nav-artesvisuales" aria-selected="false">Artes Visuales</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-matematica-guia" role="tabpanel" aria-labelledby="nav-matematica-tab">
                                <table id="tabla-matematica-guias" class="table" cellspacing="0">
                                    <thead>
                                        <tr>
											<th>Tema</th>
											<th>Curso</th>
											<th>Unidad</th>
                                            <th>Precio</th>
											<th>Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_matematica_guia)) {?>	

											<tr>
												<td><?php echo $row['nombre']; ?></td>
												<td><?php echo $row['curso']; ?></td>
												<td><?php echo $row['unidad']; ?></td>
												<td>$<?php echo $row['precio']; ?></td>
												<td><?php 
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
												<a href="/archivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">zoom_in</span> Ver</button></a>
												<a href="/editar?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-primary tabla"><span class="material-icons">edit</span> Modificar</button></a>
												<a href="/eliminar?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-danger tabla"><span class="material-icons">delete</span> Eliminar</button></a>
												</td>
											</tr>

										<?php };  ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="nav-lenguaje-guia" role="tabpanel" aria-labelledby="nav-lenguaje-tab">
                                <table id="tabla-lenguaje-guias" class="table" cellspacing="0">
                                    <thead>
                                        <tr>
											<th>Tema</th>
											<th>Curso</th>
											<th>Unidad</th>
                                            <th>Precio</th>
											<th>Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_lenguaje_guia)) {?>	

											<tr>
												<td><?php echo $row['nombre']; ?></td>
												<td><?php echo $row['curso']; ?></td>
												<td><?php echo $row['unidad']; ?></td>
												<td>$<?php echo $row['precio']; ?></td>
												<td><?php 
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
												<a href="/archivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">zoom_in</span> Ver</button></a>
												<a href="/editar?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-primary tabla"><span class="material-icons">edit</span> Modificar</button></a>
												<a href="/eliminar?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-danger tabla"><span class="material-icons">delete</span> Eliminar</button></a>
												</td>
											</tr>

										<?php };  ?>
                                    </tbody>
                                </table>
							</div>
							<div class="tab-pane fade" id="nav-tecnologia-guia" role="tabpanel" aria-labelledby="nav-tecnologia-tab">
                                <table id="tabla-tecnologia-guias" class="table" cellspacing="0">
                                    <thead>
                                        <tr>
											<th>Tema</th>
											<th>Curso</th>
											<th>Unidad</th>
                                            <th>Precio</th>
											<th>Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_tecnologia_guia)) {?>	

											<tr>
												<td><?php echo $row['nombre']; ?></td>
												<td><?php echo $row['curso']; ?></td>
												<td><?php echo $row['unidad']; ?></td>
												<td>$<?php echo $row['precio']; ?></td>
												<td><?php 
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
												<a href="/archivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">zoom_in</span> Ver</button></a>
												<a href="/editar?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-primary tabla"><span class="material-icons">edit</span> Modificar</button></a>
												<a href="/eliminar?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-danger tabla"><span class="material-icons">delete</span> Eliminar</button></a>
												</td>
											</tr>

										<?php };  ?>
                                    </tbody>
                                </table>
							</div>
							<div class="tab-pane fade" id="nav-musica-guia" role="tabpanel" aria-labelledby="nav-musica-tab">
                                <table id="tabla-musica-guias" class="table" cellspacing="0">
                                    <thead>
                                        <tr>
											<th>Tema</th>
											<th>Curso</th>
											<th>Unidad</th>
                                            <th>Precio</th>
											<th>Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_musica_guia)) {?>	

											<tr>
												<td><?php echo $row['nombre']; ?></td>
												<td><?php echo $row['curso']; ?></td>
												<td><?php echo $row['unidad']; ?></td>
												<td>$<?php echo $row['precio']; ?></td>
												<td><?php 
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
												<a href="/archivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">zoom_in</span> Ver</button></a>
												<a href="/editar?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-primary tabla"><span class="material-icons">edit</span> Modificar</button></a>
												<a href="/eliminar?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-danger tabla"><span class="material-icons">delete</span> Eliminar</button></a>
												</td>
											</tr>

										<?php };  ?>
                                    </tbody>
                                </table>
							</div>
							<div class="tab-pane fade" id="nav-artesvisuales-guia" role="tabpanel" aria-labelledby="nav-artesvisuales-tab">
                                <table id="tabla-artesvisuales-guias" class="table" cellspacing="0">
                                    <thead>
                                        <tr>
											<th>Tema</th>
											<th>Curso</th>
											<th>Unidad</th>
                                            <th>Precio</th>
											<th>Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_artesvisuales_guia)) {?>	

											<tr>
												<td><?php echo $row['nombre']; ?></td>
												<td><?php echo $row['curso']; ?></td>
												<td><?php echo $row['unidad']; ?></td>
												<td>$<?php echo $row['precio']; ?></td>
												<td><?php 
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
												<a href="/archivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">zoom_in</span> Ver</button></a>
												<a href="/editar?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-primary tabla"><span class="material-icons">edit</span> Modificar</button></a>
												<a href="/eliminar?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-danger tabla"><span class="material-icons">delete</span> Eliminar</button></a>
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