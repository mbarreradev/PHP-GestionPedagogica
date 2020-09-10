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

	// BOX: Ordenes pendientes de confirmación
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos
	$sql_pendientes_confirmacion = "SELECT ordencompra.ordencompra_id, ordencompra.fecha_actualizacion, ordencompra.estado_orden, ordencompra.pagado, usuario.nombres, usuario.apellidos
	FROM 
		ordencompra
    INNER JOIN 
		usuario
	ON
		ordencompra.usuario_id=usuario.usuario_id
	WHERE 
    ordencompra.estado_orden = 'Pendiente de confirmación'
	ORDER BY ordencompra_id DESC"; 
    $rs_result_pendientes_confirmacion = mysqli_query($conn, $sql_pendientes_confirmacion);

    // Contador de ordenes pendientes de confirmación
	$cnt_ordenes_pendientes_confirmacion = $rs_result_pendientes_confirmacion->num_rows;
    

    // ORDENES
	// BOX: Tabla Matematica
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos
	$sql_matematicas_orden = "SELECT ordencompra.ordencompra_id, ordencompra.usuario_id, ordencompra.fecha_actualizacion, ordencompra.estado_orden, ordencompra.pagado, usuario.nombres, usuario.apellidos
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
		archivo.asignatura = 'Matemáticas' AND != ordencompra.estado_orden = 'Pendiente de confirmación'
	ORDER BY ordencompra.ordencompra_id DESC"; 
	$rs_result_matematica_orden = mysqli_query($conn, $sql_matematicas_orden);
		
	// BOX: Tabla Lenguaje
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos
	$sql_lenguaje_orden = "SELECT ordencompra.ordencompra_id, ordencompra.usuario_id, ordencompra.fecha_actualizacion, ordencompra.estado_orden, ordencompra.pagado, usuario.nombres, usuario.apellidos
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
		archivo.asignatura = 'Lenguaje' AND != ordencompra.estado_orden = 'Pendiente de confirmación'
	ORDER BY ordencompra.ordencompra_id DESC"; 
	$rs_result_lenguaje_orden = mysqli_query($conn, $sql_lenguaje_orden);

	// BOX: Tabla Tecnología
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos
	$sql_tecnologia_orden = "SELECT ordencompra.ordencompra_id, ordencompra.usuario_id, ordencompra.fecha_actualizacion, ordencompra.estado_orden, ordencompra.pagado, usuario.nombres, usuario.apellidos
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
		archivo.asignatura = 'Tecnología' AND != ordencompra.estado_orden = 'Pendiente de confirmación'
	ORDER BY ordencompra.ordencompra_id DESC";  
	$rs_result_tecnologia_orden = mysqli_query($conn, $sql_tecnologia_orden);

	// BOX: Tabla Música
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos
	$sql_musica_orden = "SELECT ordencompra.ordencompra_id, ordencompra.usuario_id, ordencompra.fecha_actualizacion, ordencompra.estado_orden, ordencompra.pagado, usuario.nombres, usuario.apellidos
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
		archivo.asignatura = 'Música' AND != ordencompra.estado_orden = 'Pendiente de confirmación'
	ORDER BY ordencompra.ordencompra_id DESC"; 
	$rs_result_musica_orden = mysqli_query($conn, $sql_musica_orden);

	// BOX: Tabla Artes Visuales
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos
	$sql_artesvisuales_orden = "SELECT ordencompra.ordencompra_id, ordencompra.usuario_id, ordencompra.fecha_actualizacion, ordencompra.estado_orden, ordencompra.pagado, usuario.nombres, usuario.apellidos
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
		archivo.asignatura = 'Artes Visuales' AND != ordencompra.estado_orden = 'Pendiente de confirmación'
	ORDER BY ordencompra.ordencompra_id DESC"; 
	$rs_result_artesvisuales_orden = mysqli_query($conn, $sql_artesvisuales_orden);

    // Contador ordenes creadas
    $sql_ordenes_creadas = "SELECT * FROM ordencompra";  
	$rs_result_ordenes_creadas = mysqli_query($conn, $sql_ordenes_creadas);  
    $cnt_ordenes_creadas = $rs_result_ordenes_creadas->num_rows;
    
    // Contador odenes pagadas
    $sql_ordenes_pagadas = "SELECT * FROM ordencompra WHERE estado_orden = 'Pagado'";  
	$rs_result_ordenes_pagadas = mysqli_query($conn, $sql_ordenes_pagadas);  
	$cnt_ordenes_pagadas = $rs_result_ordenes_pagadas->num_rows;

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
		<script src="https://code.jquery.com/jquery-3.5.0.slim.min.js" integrity="sha256-MlusDLJIP1GRgLrOflUQtshyP0TwT/RHXsI1wWGnQhs=" crossorigin="anonymous"></script>
		<script src="js/list.min.js"></script>
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
			<a href="/administracion"><button type="button" class="btn btn-primary"><span class="material-icons">build</span> Volver a la administración</button></a>
			</div>
				
        </h4>
		
			<div class="card mb-3">
			  <div class="row no-gutters">

				<div class="col">
				  <div class="card-body bg-azul-claro">


            <div class="row">
				<div class="col-sm text-center">
					<div class="row counter-profile">
						<div class="col-sm">
							<h2><strong><?php echo $cnt_ordenes_pendientes_confirmacion; ?></strong></h2>                    
							<p><small>ordenes pendientes de confirmación</small></p>
							<hr class="mb-4">
						</div>
						<div class="col-sm">
							<h2><strong><?php echo $cnt_ordenes_creadas; ?></strong></h2>                    
							<p><small>ordenes creadas</small></p>
							<hr class="mb-4">
						</div>
						<div class="col-sm">
							<h2><strong><?php echo $cnt_ordenes_pagadas; ?></strong></h2>                    
							<p><small>ordenes pagadas</small></p>
							<hr class="mb-4">
						</div>
					</div>
                </div>            
            </div>
				  
				  
				  </div>
				</div>
			  </div>
			</div>

		<h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="titulo">Ordenes pendientes de confirmación</span>
        </h4>	

		<section id="tabs" class="project-tab">
                <div class="row">
                    <div class="col-md-12">

                            <div id="ordenes-pendientes">
                                <div class="buscador arriba">
									<input type="text" class="search form-control" placeholder="Puedes buscar por temática, curso, unidad, precio o estado"/>
								</div>
                                <table id="tabla-matematica-planificacion" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
											<th class="sort" data-sort="id">Orden ID</th>
                                            <th class="sort" data-sort="creado">Creado por</th>
                                            <th class="sort" data-sort="pagado">Pagado</th>
											<th class="sort" data-sort="estado">Estado</th>
                                            <th>Última actualización</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_pendientes_confirmacion)) {?>	

											<tr>
												<td class="id"><?php echo $row['ordencompra_id']; ?></td>
												<td class="creado"><a href="/verperfil?id="><?php echo $row['nombres']." ".$row['apellidos']; ?></a></td>
												<td class="pagado">$<?php echo $row['pagado']; ?></td>
												<td class="estado"><?php echo $row['estado_orden']; ?></td>
                                                <td><?php echo $row['fecha_actualizacion']; ?></td>
												<td>
												<a href="/verorden?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">zoom_in</span> Ver</button></a>
												<a href="/editarorder?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-primary tabla"><span class="material-icons">edit</span> Modificar</button></a>
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
        </section>

		<h4 class="d-flex justify-content-between align-items-center mb-3 margin-bottom">
            <span class="titulo">Otras ordenes</span>
        </h4>	

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
									<input type="text" class="search form-control" placeholder="Puedes buscar por temática, curso, unidad, precio o estado"/>
								</div>
                                <table id="tabla-matematica-orden" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
                                            <th class="sort" data-sort="id">Orden ID</th>
                                            <th class="sort" data-sort="creado">Creado por</th>
                                            <th class="sort" data-sort="pagado">Precio</th>
											<th class="sort" data-sort="estado">Estado</th>
                                            <th>Última actualización</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_matematica_orden)) {?>	

											<tr>
                                                <td class="id"><?php echo $row['ordencompra_id']; ?></td>
												<td class="creado"><a href="/verperfil?id="><?php echo $row['nombres']." ".$row['apellidos']; ?></a></td>
												<td class="pagado">$<?php echo $row['pagado']; ?></td>
												<td class="estado"><?php echo $row['estado_orden']; ?></td>
                                                <td><?php echo $row['fecha_actualizacion']; ?></td>
												<td>
												<a href="/verorden?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">zoom_in</span> Ver</button></a>
												<a href="/editarorden?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-primary tabla"><span class="material-icons">edit</span> Modificar</button></a>
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
									<input type="text" class="search form-control" placeholder="Puedes buscar por temática, curso, unidad, precio o estado"/>
								</div>
                                <table id="tabla-lenguaje-orden" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
                                            <th class="sort" data-sort="id">Orden ID</th>
                                            <th class="sort" data-sort="creado">Creado por</th>
                                            <th class="sort" data-sort="pagado">Precio</th>
											<th class="sort" data-sort="estado">Estado</th>
                                            <th>Última actualización</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_lenguaje_orden)) {?>	

											<tr>
                                                <td class="id"><?php echo $row['ordencompra_id']; ?></td>
												<td class="creado"><a href="/verperfil?id="><?php echo $row['nombres']." ".$row['apellidos']; ?></a></td>
												<td class="pagado">$<?php echo $row['pagado']; ?></td>
												<td class="estado"><?php echo $row['estado_orden']; ?></td>
                                                <td><?php echo $row['fecha_actualizacion']; ?></td>
												<td>
												<a href="/verorden?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">zoom_in</span> Ver</button></a>
												<a href="/editarorden?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-primary tabla"><span class="material-icons">edit</span> Modificar</button></a>
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
									<input type="text" class="search form-control" placeholder="Puedes buscar por temática, curso, unidad, precio o estado"/>
								</div>
                                <table id="tabla-tecnologia-orden" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
                                            <th class="sort" data-sort="id">Orden ID</th>
                                            <th class="sort" data-sort="creado">Creado por</th>
                                            <th class="sort" data-sort="pagado">Precio</th>
											<th class="sort" data-sort="estado">Estado</th>
                                            <th>Última actualización</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_tecnologia_orden)) {?>	

											<tr>
                                                <td class="id"><?php echo $row['ordencompra_id']; ?></td>
												<td class="creado"><a href="/verperfil?id="><?php echo $row['nombres']." ".$row['apellidos']; ?></a></td>
												<td class="pagado">$<?php echo $row['pagado']; ?></td>
												<td class="estado"><?php echo $row['estado_orden']; ?></td>
                                                <td><?php echo $row['fecha_actualizacion']; ?></td>
												<td>
												<a href="/verorden?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">zoom_in</span> Ver</button></a>
												<a href="/editarorden?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-primary tabla"><span class="material-icons">edit</span> Modificar</button></a>
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
									<input type="text" class="search form-control" placeholder="Puedes buscar por temática, curso, unidad, precio o estado"/>
								</div>
                                <table id="tabla-musica-orden" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
                                            <th class="sort" data-sort="id">Orden ID</th>
                                            <th class="sort" data-sort="creado">Creado por</th>
                                            <th class="sort" data-sort="pagado">Precio</th>
											<th class="sort" data-sort="estado">Estado</th>
                                            <th>Última actualización</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_musica_orden)) {?>	

											<tr>
                                                <td class="id"><?php echo $row['ordencompra_id']; ?></td>
												<td class="creado"><a href="/verperfil?id="><?php echo $row['nombres']." ".$row['apellidos']; ?></a></td>
												<td class="pagado">$<?php echo $row['pagado']; ?></td>
												<td class="estado"><?php echo $row['estado_orden']; ?></td>
                                                <td><?php echo $row['fecha_actualizacion']; ?></td>
												<td>
												<a href="/verorden?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">zoom_in</span> Ver</button></a>
												<a href="/editareditar?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-primary tabla"><span class="material-icons">edit</span> Modificar</button></a>
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
									<input type="text" class="search form-control" placeholder="Puedes buscar por temática, curso, unidad, precio o estado"/>
								</div>
                                <table id="tabla-artesvisuales-orden" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
                                            <th class="sort" data-sort="id">Orden ID</th>
                                            <th class="sort" data-sort="creado">Creado por</th>
                                            <th class="sort" data-sort="pagado">Precio</th>
											<th class="sort" data-sort="estado">Estado</th>
                                            <th>Última actualización</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_artesvisuales_orden)) {?>	

											<tr>
                                                <td class="id"><?php echo $row['ordencompra_id']; ?></td>
												<td class="creado"><a href="/verperfil?id="><?php echo $row['nombres']." ".$row['apellidos']; ?></a></td>
												<td class="pagado">$<?php echo $row['pagado']; ?></td>
												<td class="estado"><?php echo $row['estado_orden']; ?></td>
                                                <td><?php echo $row['fecha_actualizacion']; ?></td>
												<td>
												<a href="/verorden?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">zoom_in</span> Ver</button></a>
												<a href="/editarorden?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-primary tabla"><span class="material-icons">edit</span> Modificar</button></a>
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


	</div>
    </div>

      <footer class="mastfoot margin-top">
        <div class="inner">
          <p class="footer">Copyright © 2020 Gestión Pedagógica</p>
        </div>
      </footer>
    </div>

	<SCRIPT type="text/javascript">
		var options = {
    valueNames: [ 'tema', 'curso', 'unidad', 'pagado', 'estado'],
    page: 10,
    pagination: true
	};

	var tablaOrdenesPendientes = new List('ordenes-pendientes', options);

	var tablaMatematicasOrden = new List('nav-matematica-orden', options);
	var tablaLenguajeOrden = new List('nav-lenguaje-orden', options);
	var tablaTecnologiaOrden = new List('nav-tecnologia-orden', options);
	var tablaMusicaOrden = new List('nav-musica-orden', options);
	var tablaArtesVisualesOrden = new List('nav-artesvisuales-orden', options);
	</script>
    
    <script src="js/bootstrap.bundle.min.js"></script>
	
  </body>
</html>