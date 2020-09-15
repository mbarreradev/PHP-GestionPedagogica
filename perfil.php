<?php
session_start();
require 'inc/conexion.php';

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
	// BOX: Tabla Matematica
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos, luego entramos a usuarios con la condición de que usuario_id sea iguales y luego filtramos todos los datos para que aparescan los que tienen el mismo facebook_id
	$sql_matematica_planificacion = "SELECT ordencompra.ordencompra_id, ordencompra.fecha_compra, archivo.unidad AS archivo_unidad, archivo.asignatura AS archivo_asignatura, archivo.archivo_id AS archivo_id, archivo.nombre AS archivo_nombre, archivo.curso AS archivo_curso
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
		ordencompra.usuario_id = '".$_SESSION['usuario_id']."' AND ordencompra.estado_orden = 'Pagado' AND archivo.asignatura = 'Matemáticas' AND tipo = '0'
	ORDER BY ordencompra.ordencompra_id DESC"; 
	$rs_result_matematica_planificacion = mysqli_query($conn, $sql_matematica_planificacion);
		
	// BOX: Tabla Lenguaje
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos, luego entramos a usuarios con la condición de que usuario_id sea iguales y luego filtramos todos los datos para que aparescan los que tienen el mismo facebook_id
	$sql_lenguaje_planificacion = "SELECT ordencompra.ordencompra_id, ordencompra.fecha_compra, archivo.unidad AS archivo_unidad, archivo.asignatura AS archivo_asignatura, archivo.archivo_id AS archivo_id, archivo.nombre AS archivo_nombre, archivo.curso AS archivo_curso
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
		ordencompra.usuario_id = '".$_SESSION['usuario_id']."' AND ordencompra.estado_orden = 'Pagado' AND archivo.asignatura = 'Lenguaje' AND tipo = '0'
	ORDER BY ordencompra.ordencompra_id DESC"; 
	$rs_result_lenguaje_planificacion = mysqli_query($conn, $sql_lenguaje_planificacion);

	// BOX: Tabla Tecnologia
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos, luego entramos a usuarios con la condición de que usuario_id sea iguales y luego filtramos todos los datos para que aparescan los que tienen el mismo facebook_id
	$sql_tecnologia_planificacion = "SELECT ordencompra.ordencompra_id, ordencompra.fecha_compra, archivo.unidad AS archivo_unidad, archivo.asignatura AS archivo_asignatura, archivo.archivo_id AS archivo_id, archivo.nombre AS archivo_nombre, archivo.curso AS archivo_curso
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
		ordencompra.usuario_id = '".$_SESSION['usuario_id']."' AND ordencompra.estado_orden = 'Pagado' AND archivo.asignatura = 'Tecnología' AND tipo = '0'
	ORDER BY ordencompra.ordencompra_id DESC"; 
	$rs_result_tecnologia_planificacion = mysqli_query($conn, $sql_tecnologia_planificacion);

	// BOX: Tabla Musica
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos, luego entramos a usuarios con la condición de que usuario_id sea iguales y luego filtramos todos los datos para que aparescan los que tienen el mismo facebook_id
	$sql_musica_planificacion = "SELECT ordencompra.ordencompra_id, ordencompra.fecha_compra, archivo.unidad AS archivo_unidad, archivo.asignatura AS archivo_asignatura, archivo.archivo_id AS archivo_id, archivo.nombre AS archivo_nombre, archivo.curso AS archivo_curso
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
		ordencompra.usuario_id = '".$_SESSION['usuario_id']."' AND ordencompra.estado_orden = 'Pagado' AND archivo.asignatura = 'Música' AND tipo = '0'
	ORDER BY ordencompra.ordencompra_id DESC"; 
	$rs_result_musica_planificacion = mysqli_query($conn, $sql_musica_planificacion);

	// BOX: Tabla Artes Visuales
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos, luego entramos a usuarios con la condición de que usuario_id sea iguales y luego filtramos todos los datos para que aparescan los que tienen el mismo facebook_id
	$sql_artesVisuales_planificacion = "SELECT ordencompra.ordencompra_id, ordencompra.fecha_compra, archivo.unidad AS archivo_unidad, archivo.asignatura AS archivo_asignatura, archivo.archivo_id AS archivo_id, archivo.nombre AS archivo_nombre, archivo.curso AS archivo_curso
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
		ordencompra.usuario_id = '".$_SESSION['usuario_id']."' AND ordencompra.estado_orden = 'Pagado' AND archivo.asignatura = 'Artes Visuales' AND tipo = '0'
	ORDER BY ordencompra.ordencompra_id DESC"; 
	$rs_result_artesvisuales_planificacion = mysqli_query($conn, $sql_artesVisuales_planificacion);


	// GUIAS
	// BOX: Tabla Matematica
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos, luego entramos a usuarios con la condición de que usuario_id sea iguales y luego filtramos todos los datos para que aparescan los que tienen el mismo facebook_id
	$sql_matematica_guia = "SELECT ordencompra.ordencompra_id, ordencompra.fecha_compra, archivo.unidad AS archivo_unidad, archivo.asignatura AS archivo_asignatura, archivo.archivo_id AS archivo_id, archivo.nombre AS archivo_nombre, archivo.curso AS archivo_curso
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
		ordencompra.usuario_id = '".$_SESSION['usuario_id']."' AND ordencompra.estado_orden = 'Pagado' AND archivo.asignatura = 'Matemáticas' AND tipo = '1'
	ORDER BY ordencompra.ordencompra_id DESC"; 
	$rs_result_matematica_guia = mysqli_query($conn, $sql_matematica_guia);
		
	// BOX: Tabla Lenguaje
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos, luego entramos a usuarios con la condición de que usuario_id sea iguales y luego filtramos todos los datos para que aparescan los que tienen el mismo facebook_id
	$sql_lenguaje_guia = "SELECT ordencompra.ordencompra_id, ordencompra.fecha_compra, archivo.unidad AS archivo_unidad, archivo.asignatura AS archivo_asignatura, archivo.archivo_id AS archivo_id, archivo.nombre AS archivo_nombre, archivo.curso AS archivo_curso
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
		ordencompra.usuario_id = '".$_SESSION['usuario_id']."' AND ordencompra.estado_orden = 'Pagado' AND archivo.asignatura = 'Lenguaje' AND tipo = '1'
	ORDER BY ordencompra.ordencompra_id DESC"; 
	$rs_result_lenguaje_guia = mysqli_query($conn, $sql_lenguaje_guia);

	// BOX: Tabla Tecnologia
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos, luego entramos a usuarios con la condición de que usuario_id sea iguales y luego filtramos todos los datos para que aparescan los que tienen el mismo facebook_id
	$sql_tecnologia_guia = "SELECT ordencompra.ordencompra_id, ordencompra.fecha_compra, archivo.unidad AS archivo_unidad, archivo.asignatura AS archivo_asignatura, archivo.archivo_id AS archivo_id, archivo.nombre AS archivo_nombre, archivo.curso AS archivo_curso
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
		ordencompra.usuario_id = '".$_SESSION['usuario_id']."' AND ordencompra.estado_orden = 'Pagado' AND archivo.asignatura = 'Tecnología' AND tipo = '1'
	ORDER BY ordencompra.ordencompra_id DESC"; 
	$rs_result_tecnologia_guia = mysqli_query($conn, $sql_tecnologia_guia);

	// BOX: Tabla Musica
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos, luego entramos a usuarios con la condición de que usuario_id sea iguales y luego filtramos todos los datos para que aparescan los que tienen el mismo facebook_id
	$sql_musica_guia = "SELECT ordencompra.ordencompra_id, ordencompra.fecha_compra, archivo.unidad AS archivo_unidad, archivo.asignatura AS archivo_asignatura, archivo.archivo_id AS archivo_id, archivo.nombre AS archivo_nombre, archivo.curso AS archivo_curso
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
		ordencompra.usuario_id = '".$_SESSION['usuario_id']."' AND ordencompra.estado_orden = 'Pagado' AND archivo.asignatura = 'Música' AND tipo = '1'
	ORDER BY ordencompra.ordencompra_id DESC"; 
	$rs_result_musica_guia = mysqli_query($conn, $sql_musica_guia);

	// BOX: Tabla Artes Visuales
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos, luego entramos a usuarios con la condición de que usuario_id sea iguales y luego filtramos todos los datos para que aparescan los que tienen el mismo facebook_id
	$sql_artesVisuales_guia = "SELECT ordencompra.ordencompra_id, ordencompra.fecha_compra, archivo.unidad AS archivo_unidad, archivo.asignatura AS archivo_asignatura, archivo.archivo_id AS archivo_id, archivo.nombre AS archivo_nombre, archivo.curso AS archivo_curso
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
		ordencompra.usuario_id = '".$_SESSION['usuario_id']."' AND ordencompra.estado_orden = 'Pagado' AND archivo.asignatura = 'Artes Visuales' AND tipo = '1'
	ORDER BY ordencompra.ordencompra_id DESC"; 
	$rs_result_artesvisuales_guia = mysqli_query($conn, $sql_artesVisuales_guia);


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

		<title>Gestión Pedagógica</title>

		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
		<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
		<script src="js/moment-with-locales.js"></script>
		<script src="js/list.min.js"></script>
	</head>
<body class="text-center">

<?php
// values
$registradotime = $row_profile_general["registrado_el"];
?>

<script>
$(function(){
  setInterval(function(){
	  
	var dateFormat = 'YYYY-DD-MM HH:mm:ss';
	var registrado_utctime = moment.utc('<?php echo $registradotime; ?>');
	var registrado_localdate = registrado_utctime.local();
	var registrado_localdate2 = registrado_localdate.locale('es')
	
	var modificardivregistrado = document.getElementById('registrado');
	modificardivregistrado.innerHTML =  moment(registrado_localdate, "YYYY-MM-DD hh:mm:ss").fromNow();
	
  },1000);
});

</script>

    <div class="container d-flex p-3 mx-auto flex-column">

	<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-color border-azul-claro">
		<img class="logo" src="/images/Logo.png" width="32" height="32"><h5 class="my-0 mr-md-auto font-weight-normal">Gestión Pedagógica</h5>
      	<nav class="my-2 my-md-0 mr-md-3">
		<a href="http://repositorio.gestionpedagogica.cl"><button class="btn btn-secondary" type="button">Inicio</button></a>
		<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Hola <?php echo $row_profile_general["nombres"]; ?></button>
		<div class="dropdown-menu" aria-labelledby="dropdownMenu1">
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
			<span class="titulo">Mi perfil</span>
            <?php 
			if (!isset($_SESSION["rango"]) == '2')
			{ 
				echo '<div class="btn-group dropup btn-block options">';
				echo '<a href="/misordenes"><button type="button" class="btn btn-primary margin"><span class="material-icons">library_books</span> Mis ordenes</button></a>';
				echo '<a href="/opciones"><button type="button" class="btn btn-primary"><span class="material-icons">settings</span> Opciones</button></a>';
				echo '</div>';
			}
			else
			{
				echo '<div class="btn-group dropup btn-block options">';
				echo '<a href="/administracion"><button type="button" class="btn btn-primary margin"><span class="material-icons">build</span> Administración</button></a>';
				echo '<a href="/misordenes"><button type="button" class="btn btn-primary margin"><span class="material-icons">library_books</span> Mis ordenes</button></a>';
				echo '<a href="/opciones"><button type="button" class="btn btn-primary"><span class="material-icons">settings</span> Opciones</button></a>';
				echo '</div>';
			}
			?>
				
        </h4>
		
			<div class="card mb-3 profile border-plomo bg-azul-claro">
			  <div class="row no-gutters">
				<div class="col-md-4">
				  <img src="<?php echo $row_profile_general["avatar_url"]; ?>" class="card-img profile">
				</div>
				<div class="col-md-8">
				  	<div class="card-body">
						<div class="row">
							<div class="col-sm">
								<h4 class="titulo"><?php echo $row_profile_general["nombres"]; ?> <?php echo $row_profile_general["apellidos"]; ?></h4>
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
			
		<h4 class="d-flex justify-content-between align-items-center mb-3">
			<span class="titulo">Mis planificaciones</span>
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
									<input type="search" class="search form-control" placeholder="Puedes buscar por temática, curso o unidad"/>
								</div>
                                <table id="tabla-matematica-planificacion" class="table" cellspacing="0">
                                    <thead>
                                        <tr class="bg-azul">
                                            <th class="sort" data-sort="tema">Tema</th>
											<th class="sort" data-sort="curso">Curso</th>
											<th class="sort" data-sort="unidad">Unidad</th>
                                            <th>Fecha de compra</th>
											<th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_matematica_planificacion)) {?>	

											<tr>
												<td class="tema"><?php echo $row['archivo_nombre']; ?></td>
												<td class="curso"><?php echo $row['archivo_curso']; ?></td>
												<td class="unidad"><?php echo $row['archivo_unidad']; ?></td>
												<td><?php echo $row['fecha_compra']; ?></td>
												<td>
												<a href="/verorden?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">library_books</span> Ver orden</button></a>
												<a href="/verarchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-success tabla"><span class="material-icons">cloud_download</span> Descargar archivo</button></a>
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
									<input type="search" class="search form-control" placeholder="Puedes buscar por temática, curso o unidad"/>
								</div>
                                <table id="tabla-lenguaje-planificacion" class="table" cellspacing="0">
                                    <thead>
                                        <tr class="bg-azul">
                                            <th class="sort" data-sort="tema">Tema</th>
											<th class="sort" data-sort="curso">Curso</th>
											<th class="sort" data-sort="unidad">Unidad</th>
                                            <th>Fecha de compra</th>
											<th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_lenguaje_planificacion)) {?>	

											<tr>
												<td class="tema"><?php echo $row['archivo_nombre']; ?></td>
												<td class="curso"><?php echo $row['archivo_curso']; ?></td>
												<td class="unidad"><?php echo $row['archivo_unidad']; ?></td>
												<td><?php echo $row['fecha_compra']; ?></td>
												<td>
												<a href="/verorden?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">library_books</span> Ver orden</button></a>
												<a href="/verarchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-success tabla"><span class="material-icons">cloud_download</span> Descargar archivo</button></a>
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
									<input type="search" class="search form-control" placeholder="Puedes buscar por temática, curso o unidad"/>
								</div>
                                <table id="tabla-tecnologia-planificacion" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
                                            <th class="sort" data-sort="tema">Tema</th>
											<th class="sort" data-sort="curso">Curso</th>
											<th class="sort" data-sort="unidad">Unidad</th>
                                            <th>Fecha de compra</th>
											<th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_tecnologia_planificacion)) {?>	

											<tr>
												<td class="tema"><?php echo $row['archivo_nombre']; ?></td>
												<td class="curso"><?php echo $row['archivo_curso']; ?></td>
												<td class="unidad"><?php echo $row['archivo_unidad']; ?></td>
												<td><?php echo $row['fecha_compra']; ?></td>
												<td>
												<a href="/verorden?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">library_books</span> Ver orden</button></a>
												<a href="/verarchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-success tabla"><span class="material-icons">cloud_download</span> Descargar archivo</button></a>
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
									<input type="search" class="search form-control" placeholder="Puedes buscar por temática, curso o unidad"/>
								</div>
                                <table id="tabla-musica-planificacion" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
                                            <th class="sort" data-sort="tema">Tema</th>
											<th class="sort" data-sort="curso">Curso</th>
											<th class="sort" data-sort="unidad">Unidad</th>
                                            <th>Fecha de compra</th>
											<th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_musica_planificacion)) {?>	

											<tr>
												<td class="tema"><?php echo $row['archivo_nombre']; ?></td>
												<td class="curso"><?php echo $row['archivo_curso']; ?></td>
												<td class="unidad"><?php echo $row['archivo_unidad']; ?></td>
												<td><?php echo $row['fecha_compra']; ?></td>
												<td>
												<a href="/verorden?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">library_books</span> Ver orden</button></a>
												<a href="/verarchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-success tabla"><span class="material-icons">cloud_download</span> Descargar archivo</button></a>
												</td>
											</tr>

										<?php };  ?>
                                    </tbody>
                                </table>
							</div>
							<div class="tab-pane fade" id="nav-artesvisuales-planificacion" role="tabpanel" aria-labelledby="nav-artesvisuales-tab">
								<div class="buscador">
									<input type="search" class="search form-control" placeholder="Puedes buscar por temática, curso o unidad"/>
								</div>
                                <table id="tabla-artesvisuales-planificacion" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
                                            <th class="sort" data-sort="tema">Tema</th>
											<th class="sort" data-sort="curso">Curso</th>
											<th class="sort" data-sort="unidad">Unidad</th>
                                            <th>Fecha de compra</th>
											<th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_artesvisuales_planificacion)) {?>	

											<tr>
												<td class="tema"><?php echo $row['archivo_nombre']; ?></td>
												<td class="curso"><?php echo $row['archivo_curso']; ?></td>
												<td class="unidad"><?php echo $row['archivo_unidad']; ?></td>
												<td><?php echo $row['fecha_compra']; ?></td>
												<td>
												<a href="/verorden?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">library_books</span> Ver orden</button></a>
												<a href="/verarchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-success tabla"><span class="material-icons">cloud_download</span> Descargar archivo</button></a>
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

		<h4 class="d-flex justify-content-between align-items-center mb-3 margin-top">
			<span class="titulo">Mis guías</span>
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
									<input type="text" class="search form-control" placeholder="Puedes buscar por temática, curso o unidad"/>
								</div>
                                <table id="tabla-matematica-guia" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
                                            <th class="sort" data-sort="tema">Tema</th>
											<th class="sort" data-sort="curso">Curso</th>
											<th class="sort" data-sort="unidad">Unidad</th>
                                            <th>Fecha de compra</th>
											<th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_matematica_guia)) {?>	

											<tr>
												<td class="tema"><?php echo $row['archivo_nombre']; ?></td>
												<td class="curso"><?php echo $row['archivo_curso']; ?></td>
												<td class="unidad"><?php echo $row['archivo_unidad']; ?></td>
												<td><?php echo $row['fecha_compra']; ?></td>
												<td>
												<a href="/verorden?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">library_books</span> Ver orden</button></a>
												<a href="/verarchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-success tabla"><span class="material-icons">cloud_download</span> Descargar archivo</button></a>
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
									<input type="text" class="search form-control" placeholder="Puedes buscar por temática, curso o unidad"/>
								</div>
                                <table id="tabla-lenguaje-guia" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
                                            <th class="sort" data-sort="tema">Tema</th>
											<th class="sort" data-sort="curso">Curso</th>
											<th class="sort" data-sort="unidad">Unidad</th>
                                            <th>Fecha de compra</th>
											<th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_lenguaje_guia)) {?>	

											<tr>
												<td class="tema"><?php echo $row['archivo_nombre']; ?></td>
												<td class="curso"><?php echo $row['archivo_curso']; ?></td>
												<td class="unidad"><?php echo $row['archivo_unidad']; ?></td>
												<td><?php echo $row['fecha_compra']; ?></td>
												<td>
												<a href="/verorden?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">library_books</span> Ver orden</button></a>
												<a href="/verarchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-success tabla"><span class="material-icons">cloud_download</span> Descargar archivo</button></a>
												</td>
											</tr>

										<?php };  ?>
                                    </tbody>
                                </table>
							</div>
							<div class="tab-pane fade" id="nav-tecnologia-guia" role="tabpanel" aria-labelledby="nav-tecnologia-tab">
								<div class="buscador">
									<input type="text" class="search form-control" placeholder="Puedes buscar por temática, curso o unidad"/>
								</div>
                                <table id="tabla-tecnologia-guia" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
                                            <th class="sort" data-sort="tema">Tema</th>
											<th class="sort" data-sort="curso">Curso</th>
											<th class="sort" data-sort="unidad">Unidad</th>
                                            <th>Fecha de compra</th>
											<th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_tecnologia_guia)) {?>	

											<tr>
												<td class="tema"><?php echo $row['archivo_nombre']; ?></td>
												<td class="curso"><?php echo $row['archivo_curso']; ?></td>
												<td class="unidad"><?php echo $row['archivo_unidad']; ?></td>
												<td><?php echo $row['fecha_compra']; ?></td>
												<td>
												<a href="/verorden?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">library_books</span> Ver orden</button></a>
												<a href="/verarchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-success tabla"><span class="material-icons">cloud_download</span> Descargar archivo</button></a>
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
									<input type="text" class="search form-control" placeholder="Puedes buscar por temática, curso o unidad"/>
								</div>
                                <table id="tabla-musica-guia" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
                                            <th class="sort" data-sort="tema">Tema</th>
											<th class="sort" data-sort="curso">Curso</th>
											<th class="sort" data-sort="unidad">Unidad</th>
                                            <th>Fecha de compra</th>
											<th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_musica_guia)) {?>	

											<tr>
												<td class="tema"><?php echo $row['archivo_nombre']; ?></td>
												<td class="curso"><?php echo $row['archivo_curso']; ?></td>
												<td class="unidad"><?php echo $row['archivo_unidad']; ?></td>
												<td><?php echo $row['fecha_compra']; ?></td>
												<td>
												<a href="/verorden?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">library_books</span> Ver orden</button></a>
												<a href="/verarchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-success tabla"><span class="material-icons">cloud_download</span> Descargar archivo</button></a>
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
									<input type="text" class="search form-control" placeholder="Puedes buscar por temática, curso o unidad"/>
								</div>
                                <table id="tabla-artesvisuales-guia" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
                                            <th class="sort" data-sort="tema">Tema</th>
											<th class="sort" data-sort="curso">Curso</th>
											<th class="sort" data-sort="unidad">Unidad</th>
                                            <th>Fecha de compra</th>
											<th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_artesvisuales_guia)) {?>	

											<tr>
												<td class="tema"><?php echo $row['archivo_nombre']; ?></td>
												<td class="curso"><?php echo $row['archivo_curso']; ?></td>
												<td class="unidad"><?php echo $row['archivo_unidad']; ?></td>
												<td><?php echo $row['fecha_compra']; ?></td>
												<td>
												<a href="/verorden?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">library_books</span> Ver orden</button></a>
												<a href="/verarchivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-success tabla"><span class="material-icons">cloud_download</span> Descargar archivo</button></a>
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

	<script type="text/javascript">
		var options = {
    valueNames: [ 'tema', 'curso', 'unidad'],
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