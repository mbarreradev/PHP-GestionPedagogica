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

	// Contador planificaciones
	$cnt_planificaciones1 = $rs_result_matematica_planificacion->num_rows;
	$cnt_planificaciones2 = $rs_result_lenguaje_planificacion->num_rows;
	$cnt_planificaciones3 = $rs_result_tecnologia_planificacion->num_rows;
	$cnt_planificaciones4 = $rs_result_musica_planificacion->num_rows;
	$cnt_planificaciones5 = $rs_result_artesvisuales_planificacion->num_rows;
	$cnt_planificaciones_total = ($cnt_planificaciones1 + $cnt_planificaciones2 + $cnt_planificaciones3 + $cnt_planificaciones4 + $cnt_planificaciones5);

	// Contador guias
	$cnt_guias1 = $rs_result_matematica_guia->num_rows;
	$cnt_guias2 = $rs_result_lenguaje_guia->num_rows;
	$cnt_guias3 = $rs_result_tecnologia_guia->num_rows;
	$cnt_guias4 = $rs_result_musica_guia->num_rows;
	$cnt_guias5 = $rs_result_artesvisuales_guia->num_rows;
	$cnt_guias_total = ($cnt_guias1 + $cnt_guias2 + $cnt_guias3 + $cnt_guias4 + $cnt_guias5);

	$cnt_archivos_total = ($cnt_planificaciones_total + $cnt_guias_total);

	// Funcion que elimina el archivo
	if(isset($_POST['eliminararchivo-submit']))
	{
		$archiivo_id = $_POST['archivo_id'];

		// Consulta que borra el archivo
		$sql_delete_archivo= "DELETE FROM archivo WHERE archivo_id = '".$archiivo_id."' "; 
        
		if ($conn->query($sql_delete_archivo) === TRUE) 
		{
			// Refrescamos la página
			header("Refresh:0");
		}
		else
		{
			echo "error sql";
			//echo "Error sql log." . $sql_delete_archivo . "<br>" . $conn->error;
		}
	}

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
							<div class="col-sm">
								<div class="card border-plomo">
									<div class="card-body bg-azul-especial text-white">
										<div class="row">
											<div class="col-3">
												<span class="material-icons stats">sticky_note_2</span>
											</div>
											<div class="col-9 text-right">
												<div class="Count"><?php echo $cnt_planificaciones_total; ?></div>
												<h4>planificaciones</h4>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm">
								<div class="card border-plomo">
									<div class="card-body bg-naranjo-especial text-white">
										<div class="row">
											<div class="col-3">
												<span class="material-icons stats">sticky_note_2</span>
											</div>
											<div class="col-9 text-right">
												<div class="Count"><?php echo $cnt_guias_total; ?></div>
												<h4>guías</h4>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm">
								<div class="card border-plomo">
									<div class="card-body bg-rosado-especial text-white">
										<div class="row">
											<div class="col-3">
												<span class="material-icons stats">source</span>
											</div>
											<div class="col-9 text-right">
												<div class="Count"><?php echo $cnt_archivos_total; ?></div>
												<h4>archivos subidos</h4>
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

		<h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="titulo">Planificaciones</span>

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
								<div class="buscador">
									<input type="search" class="search form-control" placeholder="Puedes buscar por temática, curso, unidad, precio o estado"/>
								</div>
                                <table id="tabla-matematica-planificacion" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
											<th class="sort" data-sort="tema">Tema</th>
											<th class="sort" data-sort="curso">Curso</th>
											<th class="sort" data-sort="unidad">Unidad</th>
                                            <th class="sort" data-sort="precio">Precio</th>
											<th class="sort" data-sort="estado">Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_matematica_planificacion)) { 
										$precio_final = number_format($row['precio'],0, '', '.');
											?>	

											<tr>
												<td class="tema"><?php echo $row['nombre']; ?></td>
												<td class="curso"><?php echo $row['curso']; ?></td>
												<td class="unidad"><?php echo $row['unidad']; ?></td>
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
												<a href="/verarchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">sticky_note_2</span> Ver</button></a>
												<a href="/editararchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-primary tabla"><span class="material-icons">edit</span> Modificar</button></a>
												<form method="post" action="">
												<input type="hidden" name="archivo_id" value="<?php echo $row['archivo_id']; ?>" />
												<button name="eliminararchivo-submit" type="submit" class="btn btn-danger tabla"><span class="material-icons">delete</span> Eliminar</button>
												</form>
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
                            <div class="tab-pane fade" id="nav-lenguaje-planificacion" role="tabpanel" aria-labelledby="nav-lenguaje-tab">
								<div class="buscador">
									<input type="search" class="search form-control" placeholder="Puedes buscar por temática, curso, unidad, precio o estado"/>
								</div>
                                <table id="tabla-lenguaje-planificacion" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
											<th class="sort" data-sort="tema">Tema</th>
											<th class="sort" data-sort="curso">Curso</th>
											<th class="sort" data-sort="unidad">Unidad</th>
                                            <th class="sort" data-sort="precio">Precio</th>
											<th class="sort" data-sort="estado">Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_lenguaje_planificacion)) {
										$precio_final = number_format($row['precio'],0, '', '.');
										?>	

											<tr>
												<td class="tema"><?php echo $row['nombre']; ?></td>
												<td class="curso"><?php echo $row['curso']; ?></td>
												<td class="unidad"><?php echo $row['unidad']; ?></td>
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
												<a href="/archivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">sticky_note_2</span> Ver</button></a>
												<a href="/editararchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-primary tabla"><span class="material-icons">edit</span> Modificar</button></a>
												<a href="/eliminararchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-danger tabla"><span class="material-icons">delete</span> Eliminar</button></a>
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
							<div class="tab-pane fade" id="nav-tecnologia-planificacion" role="tabpanel" aria-labelledby="nav-tecnologia-tab">
								<div class="buscador">
									<input type="search" class="search form-control" placeholder="Puedes buscar por temática, curso, unidad, precio o estado"/>
								</div>
                                <table id="tabla-tecnologia-planificacion" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
											<th class="sort" data-sort="tema">Tema</th>
											<th class="sort" data-sort="curso">Curso</th>
											<th class="sort" data-sort="unidad">Unidad</th>
                                            <th class="sort" data-sort="precio">Precio</th>
											<th class="sort" data-sort="estado">Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_tecnologia_planificacion)) {
										$precio_final = number_format($row['precio'],0, '', '.');	
										?>	

											<tr>
												<td class="tema"><?php echo $row['nombre']; ?></td>
												<td class="curso"><?php echo $row['curso']; ?></td>
												<td class="unidad"><?php echo $row['unidad']; ?></td>
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
												<a href="/archivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">sticky_note_2</span> Ver</button></a>
												<a href="/editararchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-primary tabla"><span class="material-icons">edit</span> Modificar</button></a>
												<a href="/eliminararchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-danger tabla"><span class="material-icons">delete</span> Eliminar</button></a>
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
							<div class="tab-pane fade" id="nav-musica-planificacion" role="tabpanel" aria-labelledby="nav-musica-tab">
								<div class="buscador">
									<input type="search" class="search form-control" placeholder="Puedes buscar por temática, curso, unidad, precio o estado"/>
								</div>
                                <table id="tabla-musica-planificacion" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
											<th class="sort" data-sort="tema">Tema</th>
											<th class="sort" data-sort="curso">Curso</th>
											<th class="sort" data-sort="unidad">Unidad</th>
                                            <th class="sort" data-sort="precio">Precio</th>
											<th class="sort" data-sort="estado">Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_musica_planificacion)) {
										$precio_final = number_format($row['precio'],0, '', '.');	
										?>	

											<tr>
												<td class="tema"><?php echo $row['nombre']; ?></td>
												<td class="curso"><?php echo $row['curso']; ?></td>
												<td class="unidad"><?php echo $row['unidad']; ?></td>
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
												<a href="/verarchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">sticky_note_2</span> Ver</button></a>
												<a href="/editararchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-primary tabla"><span class="material-icons">edit</span> Modificar</button></a>
												<a href="/eliminararchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-danger tabla"><span class="material-icons">delete</span> Eliminar</button></a>
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
							<div class="tab-pane fade" id="nav-artesvisuales-planificacion" role="tabpanel" aria-labelledby="nav-artesvisuales-tab">
								<div class="buscador">
									<input type="search" class="search form-control" placeholder="Puedes buscar por temática, curso, unidad, precio o estado"/>
								</div>
                                <table id="tabla-artesvisuales-planificacion" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
											<th class="sort" data-sort="tema">Tema</th>
											<th class="sort" data-sort="curso">Curso</th>
											<th class="sort" data-sort="unidad">Unidad</th>
                                            <th class="sort" data-sort="precio">Precio</th>
											<th class="sort" data-sort="estado">Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_artesvisuales_planificacion)) {
										$precio_final = number_format($row['precio'],0, '', '.');	
										?>	

											<tr>
												<td class="tema"><?php echo $row['nombre']; ?></td>
												<td class="curso"><?php echo $row['curso']; ?></td>
												<td class="unidad"><?php echo $row['unidad']; ?></td>
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
												<a href="/verarchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">sticky_note_2</span> Ver</button></a>
												<a href="/editararchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-primary tabla"><span class="material-icons">edit</span> Modificar</button></a>
												<a href="/eliminararchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-danger tabla"><span class="material-icons">delete</span> Eliminar</button></a>
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

		<h4 class="d-flex justify-content-between align-items-center mb-3 margin-bottom">
            <span class="titulo">Guías</span>

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
								<div class="buscador">
									<input type="search" class="search form-control" placeholder="Puedes buscar por temática, curso, unidad, precio o estado"/>
								</div>
                                <table id="tabla-matematica-guia" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
											<th class="sort" data-sort="tema">Tema</th>
											<th class="sort" data-sort="curso">Curso</th>
											<th class="sort" data-sort="unidad">Unidad</th>
                                            <th class="sort" data-sort="precio">Precio</th>
											<th class="sort" data-sort="estado">Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_matematica_guia)) {
										$precio_final = number_format($row['precio'],0, '', '.');	
										?>	

											<tr>
												<td class="tema"><?php echo $row['nombre']; ?></td>
												<td class="curso"><?php echo $row['curso']; ?></td>
												<td class="unidad"><?php echo $row['unidad']; ?></td>
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
												<a href="/verarchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">sticky_note_2</span> Ver</button></a>
												<a href="/editararchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-primary tabla"><span class="material-icons">edit</span> Modificar</button></a>
												<a href="/eliminararchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-danger tabla"><span class="material-icons">delete</span> Eliminar</button></a>
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
                            <div class="tab-pane fade" id="nav-lenguaje-guia" role="tabpanel" aria-labelledby="nav-lenguaje-tab">
								<div class="buscador">
									<input type="search" class="search form-control" placeholder="Puedes buscar por temática, curso, unidad, precio o estado"/>
								</div>
                                <table id="tabla-lenguaje-guia" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
											<th class="sort" data-sort="tema">Tema</th>
											<th class="sort" data-sort="curso">Curso</th>
											<th class="sort" data-sort="unidad">Unidad</th>
                                            <th class="sort" data-sort="precio">Precio</th>
											<th class="sort" data-sort="estado">Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_lenguaje_guia)) {
										$precio_final = number_format($row['precio'],0, '', '.');	
										?>	

											<tr>
												<td class="tema"><?php echo $row['nombre']; ?></td>
												<td class="curso"><?php echo $row['curso']; ?></td>
												<td class="unidad"><?php echo $row['unidad']; ?></td>
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
												<a href="/verarchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">sticky_note_2</span> Ver</button></a>
												<a href="/editararchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-primary tabla"><span class="material-icons">edit</span> Modificar</button></a>
												<a href="/eliminararchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-danger tabla"><span class="material-icons">delete</span> Eliminar</button></a>
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
							<div class="tab-pane fade" id="nav-tecnologia-guia" role="tabpanel" aria-labelledby="nav-tecnologia-tab">
								<div class="buscador">
									<input type="search" class="search form-control" placeholder="Puedes buscar por temática, curso, unidad, precio o estado"/>
								</div>
                                <table id="tabla-tecnologia-guia" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
											<th class="sort" data-sort="tema">Tema</th>
											<th class="sort" data-sort="curso">Curso</th>
											<th class="sort" data-sort="unidad">Unidad</th>
                                            <th class="sort" data-sort="precio">Precio</th>
											<th class="sort" data-sort="estado">Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_tecnologia_guia)) {
										$precio_final = number_format($row['precio'],0, '', '.');	
										?>	

											<tr>
												<td class="tema"><?php echo $row['nombre']; ?></td>
												<td class="curso"><?php echo $row['curso']; ?></td>
												<td class="unidad"><?php echo $row['unidad']; ?></td>
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
												<a href="/verarchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">sticky_note_2</span> Ver</button></a>
												<a href="/editararchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-primary tabla"><span class="material-icons">edit</span> Modificar</button></a>
												<a href="/eliminararchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-danger tabla"><span class="material-icons">delete</span> Eliminar</button></a>
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
							<div class="tab-pane fade" id="nav-musica-guia" role="tabpanel" aria-labelledby="nav-musica-tab">
								<div class="buscador">
									<input type="search" class="search form-control" placeholder="Puedes buscar por temática, curso, unidad, precio o estado"/>
								</div>
                                <table id="tabla-musica-guia" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
											<th class="sort" data-sort="tema">Tema</th>
											<th class="sort" data-sort="curso">Curso</th>
											<th class="sort" data-sort="unidad">Unidad</th>
                                            <th class="sort" data-sort="precio">Precio</th>
											<th class="sort" data-sort="estado">Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_musica_guia)) {
										$precio_final = number_format($row['precio'],0, '', '.');	
										?>	

											<tr>
												<td class="tema"><?php echo $row['nombre']; ?></td>
												<td class="curso"><?php echo $row['curso']; ?></td>
												<td class="unidad"><?php echo $row['unidad']; ?></td>
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
												<a href="/verarchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">sticky_note_2</span> Ver</button></a>
												<a href="/editararchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-primary tabla"><span class="material-icons">edit</span> Modificar</button></a>
												<a href="/eliminararchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-danger tabla"><span class="material-icons">delete</span> Eliminar</button></a>
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
							<div class="tab-pane fade" id="nav-artesvisuales-guia" role="tabpanel" aria-labelledby="nav-artesvisuales-tab">
								<div class="buscador">
									<input type="search" class="search form-control" placeholder="Puedes buscar por temática, curso, unidad, precio o estado"/>
								</div>
                                <table id="tabla-artesvisuales-guia" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
											<th class="sort" data-sort="tema">Tema</th>
											<th class="sort" data-sort="curso">Curso</th>
											<th class="sort" data-sort="unidad">Unidad</th>
                                            <th class="sort" data-sort="precio">Precio</th>
											<th class="sort" data-sort="estado">Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_artesvisuales_guia)) {
										$precio_final = number_format($row['precio'],0, '', '.');	
										?>	

											<tr>
												<td class="tema"><?php echo $row['nombre']; ?></td>
												<td class="curso"><?php echo $row['curso']; ?></td>
												<td class="unidad"><?php echo $row['unidad']; ?></td>
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
												<a href="/verarchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">sticky_note_2</span> Ver</button></a>
												<a href="/editararchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-primary tabla"><span class="material-icons">edit</span> Modificar</button></a>
												<a href="/eliminararchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-danger tabla"><span class="material-icons">delete</span> Eliminar</button></a>
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
    valueNames: [ 'tema', 'curso', 'unidad', 'precio', 'estado'],
    page: 10,
    pagination: true
	};

	var tablaMatematicasPlanificaciones = new List('nav-matematica-planificacion', options);
	var tablaLenguajePlanificaciones = new List('nav-lenguaje-planificacion', options);
	var tablaTecnologiaPlanificaciones = new List('nav-tecnologia-planificacion', options);
	var tablaMusicaPlanificaciones = new List('nav-musica-planificacion', options);
	var tablaArtesVisualesPlanificaciones = new List('nav-artesvisuales-planificacion', options);

	var tablaMatematicasGuias = new List('nav-matematica-guia', options);
	var tablaLenguajeGuias = new List('nav-lenguaje-guia', options);
	var tablaTecnologiaGuias = new List('nav-tecnologia-guia', options);
	var tablaMusicaGuias = new List('nav-musica-guia', options);
	var tablaArtesVisualesGuias = new List('nav-artesvisuales-guia', options);

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
    
    <script src="js/bootstrap.bundle.min.js"></script>
	
  </body>
</html>