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
	$sql_datosusuariosgeneral = "SELECT usuario_id, registrado_el, nombres, apellidos, correo, avatar_url, facebook_id, rango
	FROM 
		usuario
	WHERE 
		usuario_id = '".$_SESSION['usuario_id']."' "; 
	$rs_resultdatosgeneral = mysqli_query($conn, $sql_datosusuariosgeneral);
	$row_profile_general = mysqli_fetch_assoc($rs_resultdatosgeneral);

		
	// MIS ORDENES
	// BOX: Tabla Matematica
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos
	$sql_matematicas_orden = "SELECT ordencompra.estado_orden AS ordencompra_estadoorden, ordencompra.fecha_compra AS ordencompra_fechacompra, ordencompra.ordencompra_id AS ordencompra_id, archivo.archivo_id AS archivo_id, archivo.nombre AS archivo_nombre, archivo.curso AS archivo_curso, archivo.unidad AS archivo_unidad, ordencompra.pagado AS ordencompra_pagado, archivo.estado AS archivo_estado, archivo.tipo AS archivo_tipo 
	FROM 
		ordencompra
	INNER JOIN 
		archivo ON ordencompra.archivo_id=archivo.archivo_id
	INNER JOIN 
		usuario ON ordencompra.usuario_id=usuario.usuario_id
	WHERE 
		ordencompra.usuario_id = '".$_SESSION['usuario_id']."' AND archivo.asignatura = 'Matemáticas'
	ORDER BY archivo_estado DESC";
	$rs_result_matematica_orden = mysqli_query($conn, $sql_matematicas_orden);
		
	// BOX: Tabla Lenguaje
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos
	$sql_lenguaje_orden = "SELECT ordencompra.estado_orden AS ordencompra_estadoorden, ordencompra.fecha_compra AS ordencompra_fechacompra, ordencompra.ordencompra_id AS ordencompra_id, archivo.archivo_id AS archivo_id, archivo.nombre AS archivo_nombre, archivo.curso AS archivo_curso, archivo.unidad AS archivo_unidad, ordencompra.pagado AS ordencompra_pagado, archivo.estado AS archivo_estado, archivo.tipo AS archivo_tipo 
	FROM 
		ordencompra
	INNER JOIN 
		archivo ON ordencompra.archivo_id=archivo.archivo_id
	INNER JOIN 
		usuario ON ordencompra.usuario_id=usuario.usuario_id
	WHERE 
		ordencompra.usuario_id = '".$_SESSION['usuario_id']."' AND archivo.asignatura = 'Lenguaje'
	ORDER BY archivo_estado DESC";
	$rs_result_lenguaje_orden = mysqli_query($conn, $sql_lenguaje_orden);

	// BOX: Tabla Tecnología
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos
	$sql_tecnologia_orden = "SELECT ordencompra.estado_orden AS ordencompra_estadoorden, ordencompra.fecha_compra AS ordencompra_fechacompra, ordencompra.ordencompra_id AS ordencompra_id, archivo.archivo_id AS archivo_id, archivo.nombre AS archivo_nombre, archivo.curso AS archivo_curso, archivo.unidad AS archivo_unidad, ordencompra.pagado AS ordencompra_pagado, archivo.estado AS archivo_estado, archivo.tipo AS archivo_tipo 
	FROM 
		ordencompra
	INNER JOIN 
		archivo ON ordencompra.archivo_id=archivo.archivo_id
	INNER JOIN 
		usuario ON ordencompra.usuario_id=usuario.usuario_id
	WHERE 
		ordencompra.usuario_id = '".$_SESSION['usuario_id']."' AND archivo.asignatura = 'Tecnología'
	ORDER BY archivo_estado DESC";
	$rs_result_tecnologia_orden = mysqli_query($conn, $sql_tecnologia_orden);

	// BOX: Tabla Música
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos
	$sql_musica_orden = "SELECT ordencompra.estado_orden AS ordencompra_estadoorden, ordencompra.fecha_compra AS ordencompra_fechacompra, ordencompra.ordencompra_id AS ordencompra_id, archivo.archivo_id AS archivo_id, archivo.nombre AS archivo_nombre, archivo.curso AS archivo_curso, archivo.unidad AS archivo_unidad, ordencompra.pagado AS ordencompra_pagado, archivo.estado AS archivo_estado, archivo.tipo AS archivo_tipo 
	FROM 
		ordencompra
	INNER JOIN 
		archivo ON ordencompra.archivo_id=archivo.archivo_id
	INNER JOIN 
		usuario ON ordencompra.usuario_id=usuario.usuario_id
	WHERE 
		ordencompra.usuario_id = '".$_SESSION['usuario_id']."' AND archivo.asignatura = 'Música'
	ORDER BY archivo_estado DESC";
	$rs_result_musica_orden = mysqli_query($conn, $sql_musica_orden);

	// BOX: Tabla Artes Visuales
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos
	$sql_artesvisuales_orden = "SELECT ordencompra.estado_orden AS ordencompra_estadoorden, ordencompra.fecha_compra AS ordencompra_fechacompra, ordencompra.ordencompra_id AS ordencompra_id, archivo.archivo_id AS archivo_id, archivo.nombre AS archivo_nombre, archivo.curso AS archivo_curso, archivo.unidad AS archivo_unidad, ordencompra.pagado AS ordencompra_pagado, archivo.estado AS archivo_estado, archivo.tipo AS archivo_tipo 
	FROM 
		ordencompra
	INNER JOIN 
		archivo ON ordencompra.archivo_id=archivo.archivo_id
	INNER JOIN 
		usuario ON ordencompra.usuario_id=usuario.usuario_id
	WHERE 
		ordencompra.usuario_id = '".$_SESSION['usuario_id']."' AND archivo.asignatura = 'Artes Visuales'
	ORDER BY archivo_estado DESC";
	$rs_result_artesvisuales_orden = mysqli_query($conn, $sql_artesvisuales_orden);

	// Contador de ordenes con pendiente de confirmación
	$sql_pendientes_confirmacion = "SELECT * FROM ordencompra WHERE ordencompra.usuario_id = '".$_SESSION['usuario_id']."' AND estado_orden ='Pendiente de Confirmación' ";  
	$rs_result_pendientes_confirmacion = mysqli_query($conn, $sql_pendientes_confirmacion);  
	$cnt_pendientesconfirmacion = $rs_result_pendientes_confirmacion->num_rows;
?>
<!doctype html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<link rel="icon" href="favicon.ico">
		<title>Mis ordenes - Gestión Pedagógica</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <link href="css/sidebar.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    	<script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/sidebar.js"></script>
		<script src="js/list.min.js"></script>
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
        <h4 class="titulo">Mis ordenes</h4>
        <div class="btn-group dropup btn-block options">
            <a href="/perfil"><button type="button" class="btn btn-primary"><i class="fa fa-home"></i> Volver al perfil</button></a>
        </div>
      </div>
      <hr>

        <?
        if($cnt_pendientesconfirmacion > 0)
		{
		?>
			<div class="alert alert-warning" role="alert">
			<h4 class="alert-heading"><i class="fas fa-exclamation-circle"></i> Importante</h4>
			<p>Actualmente tienes una o más ordenes <strong>pendiente de confirmación</strong>, mientras un miembro de nuestro equipo verifica la información, el archivo no estará disponible en tu perfil.</p>
			<hr>
			<p class="mb-0">En el momento que el pago sea confirmado y validado, se te notificará por correo electrónico y estará disponible en tu perfil.</p>
			</div>
		<?php
		}
		?>

        <hr>

        <section id="tabs" class="project-tab">
                <div class="row">
                    <div class="col-md-12">
                        <nav>
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-matematica-tab" data-toggle="tab" href="#nav-matematica-orden" role="tab" aria-controls="nav-matematica" aria-selected="true">Matemáticas</a>
								<a class="nav-item nav-link" id="nav-lenguaje-tab" data-toggle="tab" href="#nav-lenguaje-orden" role="tab" aria-controls="nav-lenguaje" aria-selected="false">Lenguaje</a>
								<a class="nav-item nav-link" id="nav-tecnologia-tab" data-toggle="tab" href="#nav-tecnologia-orden" role="tab" aria-controls="nav-tecnologia" aria-selected="false">Tecnología</a>
								<a class="nav-item nav-link" id="nav-musica-tab" data-toggle="tab" href="#nav-musica-orden" role="tab" aria-controls="nav-musica" aria-selected="false">Música</a>
								<a class="nav-item nav-link" id="nav-artesvisuales-tab" data-toggle="tab" href="#nav-artesvisuales-orden" role="tab" aria-controls="nav-artesvisuales" aria-selected="false">Artes Visuales</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-matematica-orden" role="tabpanel" aria-labelledby="nav-matematica-tab">
								<div class="buscador">
									<input type="search" class="search form-control" placeholder="Puedes buscar por temática, curso, tipo, pagado y estado"/>
								</div>
                                <table id="tabla-matematica-ordenes" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
											<th class="sort" data-sort="tema">Tema</th>
											<th class="sort" data-sort="curso">Curso</th>
                                            <th class="sort" data-sort="tipo">Tipo</th>
											<th class="sort" data-sort="pagado">Pagado</th>
											<th>Fecha</th>
											<th class="sort" data-sort="estado">Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_matematica_orden)) {
										$pagado_final = number_format($row['ordencompra_pagado'],0, '', '.');	
										?>	

											<tr>
												<td class="tema"><?php echo $row['archivo_nombre']; ?></td>
												<td class="curso"><?php echo $row['archivo_curso']; ?></td>
												<td class="tipo"><?php 
												if($row['archivo_tipo'] == '0')
												{
													echo 'Planificación';
												}
												else
												{
													echo 'Guía';
												}
												
												?></td>
												<td class="pagado">$<?php echo $pagado_final; ?></td>
												<td><?php echo $row['ordencompra_fechacompra']; ?></td>
												<td class="estado"><?php echo $row['ordencompra_estadoorden']; ?></td>
												<td>
												<div class="btn-group" role="group">
													<button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle tabla" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													Opciones
													</button>
													<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
														<a class="dropdown-item" href="/verorden?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">library_books</span> Ver orden</button></a>
														<a class="dropdown-item" href="/verarchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-success tabla"><span class="material-icons">cloud_download</span> Descargar</button></a>
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
                            <div class="tab-pane fade" id="nav-lenguaje-orden" role="tabpanel" aria-labelledby="nav-lenguaje-tab">
								<div class="buscador">
									<input type="search" class="search form-control" placeholder="Puedes buscar por temática, curso, tipo, pagado y estado"/>
								</div>
                                <table id="tabla-lenguaje-ordenes" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
											<th class="sort" data-sort="tema">Tema</th>
											<th class="sort" data-sort="curso">Curso</th>
                                            <th class="sort" data-sort="tipo">Tipo</th>
											<th class="sort" data-sort="pagado">Pagado</th>
											<th>Fecha</th>
											<th class="sort" data-sort="estado">Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_lenguaje_orden)) {
										$pagado_final = number_format($row['ordencompra_pagado'],0, '', '.');		
										?>	

											<tr>
												<td class="tema"><?php echo $row['archivo_nombre']; ?></td>
												<td class="curso"><?php echo $row['archivo_curso']; ?></td>
												<td class="tipo"><?php 
												if($row['archivo_tipo'] == '0')
												{
													echo 'Planificación';
												}
												else
												{
													echo 'Guía';
												}
												
												?></td>
												<td class="pagado">$<?php echo $pagado_final; ?></td>
												<td><?php echo $row['ordencompra_fechacompra']; ?></td>
												<td class="estado"><?php echo $row['ordencompra_estadoorden']; ?></td>
												<td>
												<div class="btn-group" role="group">
													<button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle tabla" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													Opciones
													</button>
													<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
														<a class="dropdown-item" href="/verorden?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">library_books</span> Ver orden</button></a>
														<a class="dropdown-item" href="/verarchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-success tabla"><span class="material-icons">cloud_download</span> Descargar</button></a>
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
							<div class="tab-pane fade" id="nav-tecnologia-orden" role="tabpanel" aria-labelledby="nav-tecnologia-tab">
								<div class="buscador">
									<input type="search" class="search form-control" placeholder="Puedes buscar por temática, curso, tipo, pagado y estado"/>
								</div>
                                <table id="tabla-tecnologia-ordenes" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
											<th class="sort" data-sort="tema">Tema</th>
											<th class="sort" data-sort="curso">Curso</th>
                                            <th class="sort" data-sort="tipo">Tipo</th>
											<th class="sort" data-sort="pagado">Pagado</th>
											<th>Fecha</th>
											<th class="sort" data-sort="estado">Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_tecnologia_orden)) {
										$pagado_final = number_format($row['ordencompra_pagado'],0, '', '.');		
										?>	

											<tr>
												<td class="tema"><?php echo $row['archivo_nombre']; ?></td>
												<td class="curso"><?php echo $row['archivo_curso']; ?></td>
												<td class="tipo"><?php 
												if($row['archivo_tipo'] == '0')
												{
													echo 'Planificación';
												}
												else
												{
													echo 'Guía';
												}
												
												?></td>
												<td class="pagado">$<?php echo $pagado_final; ?></td>
												<td><?php echo $row['ordencompra_fechacompra']; ?></td>
												<td class="estado"><?php echo $row['ordencompra_estadoorden']; ?></td>
												<td>
												<div class="btn-group" role="group">
													<button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle tabla" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													Opciones
													</button>
													<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
														<a class="dropdown-item" href="/verorden?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">library_books</span> Ver orden</button></a>
														<a class="dropdown-item" href="/verarchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-success tabla"><span class="material-icons">cloud_download</span> Descargar</button></a>
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
							<div class="tab-pane fade" id="nav-musica-orden" role="tabpanel" aria-labelledby="nav-musica-tab">
								<div class="buscador">
									<input type="search" class="search form-control" placeholder="Puedes buscar por temática, curso, tipo, pagado y estado"/>
								</div>
                                <table id="tabla-musica-ordenes" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
											<th class="sort" data-sort="tema">Tema</th>
											<th class="sort" data-sort="curso">Curso</th>
                                            <th class="sort" data-sort="tipo">Tipo</th>
											<th class="sort" data-sort="pagado">Pagado</th>
											<th>Fecha</th>
											<th class="sort" data-sort="estado">Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_musica_orden)) {
										$pagado_final = number_format($row['ordencompra_pagado'],0, '', '.');	
										?>	

											<tr>
												<td class="tema"><?php echo $row['archivo_nombre']; ?></td>
												<td class="curso"><?php echo $row['archivo_curso']; ?></td>
												<td class="tipo"><?php 
												if($row['archivo_tipo'] == '0')
												{
													echo 'Planificación';
												}
												else
												{
													echo 'Guía';
												}
												
												?></td>
												<td class="pagado">$<?php echo $pagado_final; ?></td>
												<td><?php echo $row['ordencompra_fechacompra']; ?></td>
												<td class="estado"><?php echo $row['ordencompra_estadoorden']; ?></td>
												<td>
												<div class="btn-group" role="group">
													<button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle tabla" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													Opciones
													</button>
													<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
														<a class="dropdown-item" href="/verorden?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">library_books</span> Ver orden</button></a>
														<a class="dropdown-item" href="/verarchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-success tabla"><span class="material-icons">cloud_download</span> Descargar</button></a>
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
							<div class="tab-pane fade" id="nav-artesvisuales-orden" role="tabpanel" aria-labelledby="nav-artesvisuales-tab">
								<div class="buscador">
									<input type="search" class="search form-control" placeholder="Puedes buscar por temática, curso, tipo, pagado y estado"/>
								</div>
                                <table id="tabla-artesvisuales-ordenes" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
											<th class="sort" data-sort="tema">Tema</th>
											<th class="sort" data-sort="curso">Curso</th>
                                            <th class="sort" data-sort="tipo">Tipo</th>
											<th class="sort" data-sort="pagado">Pagado</th>
											<th>Fecha</th>
											<th class="sort" data-sort="estado">Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_artesvisuales_orden)) {
										$pagado_final = number_format($row['ordencompra_pagado'],0, '', '.');		
										?>	

											<tr>
												<td class="tema"><?php echo $row['archivo_nombre']; ?></td>
												<td class="curso"><?php echo $row['archivo_curso']; ?></td>
												<td class="tipo"><?php 
												if($row['archivo_tipo'] == '0')
												{
													echo 'Planificación';
												}
												else
												{
													echo 'Guía';
												}
												
												?></td>
												<td class="pagado">$<?php echo $pagado_final; ?></td>
												<td><?php echo $row['ordencompra_fechacompra']; ?></td>
												<td class="estado"><?php echo $row['ordencompra_estadoorden']; ?></td>
												<td>
												<div class="btn-group" role="group">
													<button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle tabla" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													Opciones
													</button>
													<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
														<a class="dropdown-item" href="/verorden?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">library_books</span> Ver orden</button></a>
														<a class="dropdown-item" href="/verarchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-success tabla"><span class="material-icons">cloud_download</span> Descargar</button></a>
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
    valueNames: [ 'tema', 'curso', 'tipo', 'pagado', 'estado'],
    page: 10,
    pagination: true
	};

	var tablaMatematicas = new List('nav-matematica-orden', options);
	var tablaLenguaje = new List('nav-lenguaje-orden', options);
	var tablaTecnologia = new List('nav-tecnologia-orden', options);
	var tablaMusica = new List('nav-musica-orden', options);
	var tablaArtesVisuales = new List('nav-artesvisuales-orden', options);
	</script>
</body>
</html>