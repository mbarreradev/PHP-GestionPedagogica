<?php
session_start();
require 'inc/conexion.php';

if (!isset($_SESSION["fb_access_token"])) // Si no encuentra el access token de la sesión, se enviará a login
{
	header("location: login.php");
}
else //Continue to current page
	header( 'Content-Type: text/html; charset=utf-8' );
	
	// Consulta para traer los datos de usuario generales
	$sql_datosusuariosgeneral = "SELECT usuario_id, registrado_el, nombres, apellidos, correo, avatar_url, facebook_id
	FROM 
		usuario
	WHERE 
		usuario_id = '".$_SESSION['usuario_id']."' "; 
	$rs_resultdatosgeneral = mysqli_query($conn, $sql_datosusuariosgeneral);
	$row_profile_general = mysqli_fetch_assoc($rs_resultdatosgeneral);
	
	// PENDIENTE: Falta filtrar por Matematicas y Lenguaje
		
		// BOX: Tabla Matematica
		// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos, luego entramos a usuarios con la condición de que usuario_id sea iguales y luego filtramos todos los datos para que aparescan los que tienen el mismo facebook_id
		$sql1 = "SELECT ordencompra.ordencompra_id, ordencompra.fecha_compra, archivo.unidad AS archivo_unidad, archivo.asignatura AS archivo_asignatura, archivo.archivo_id AS archivo_id, archivo.nombre AS archivo_nombre, archivo.curso AS archivo_curso
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
			ordencompra.usuario_id = '".$_SESSION['usuario_id']."' AND archivo.asignatura = 'Matemáticas'
		ORDER BY ordencompra.ordencompra_id DESC LIMIT 0, 5"; 
		$rs_result1 = mysqli_query($conn, $sql1);
		
		// BOX: Tabla Lenguaje
		// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos, luego entramos a usuarios con la condición de que usuario_id sea iguales y luego filtramos todos los datos para que aparescan los que tienen el mismo facebook_id
		$sql2 = "SELECT ordencompra.ordencompra_id, ordencompra.fecha_compra, archivo.unidad AS archivo_unidad, archivo.asignatura AS archivo_asignatura, archivo.archivo_id AS archivo_id, archivo.nombre AS archivo_nombre, archivo.curso AS archivo_curso
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
			ordencompra.usuario_id = '".$_SESSION['usuario_id']."' AND archivo.asignatura = 'Lenguaje'
		ORDER BY ordencompra.ordencompra_id DESC LIMIT 0, 5"; 
		$rs_result2 = mysqli_query($conn, $sql2);

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
		<script data-ad-client="ca-pub-2522486668045838" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<script src="js/moment.min.js"></script>
	</head>
<body class="text-center">

<?php
// values
$registradotime = $row_profile_general["registrado_el"];
?>

<script>

$(document).ready(function() {
	$('#tabla-matematica').DataTable( {
	"lengthChange": false,
	"pageLength": 10,
	"order": [ 0, 'desc' ]
	} );
	
	$('#tabla-lenguaje').DataTable( {
	"lengthChange": false,
	"pageLength": 10,
	"order": [ 0, 'desc' ]
	} );
} );

$(function(){
  setInterval(function(){
	  
	var dateFormat = 'YYYY-DD-MM HH:mm:ss';
	var registrado_utctime = moment.utc('<?php echo $registradotime; ?>');
	var registrado_localdate = registrado_utctime.local();
	
	var modificardivregistrado = document.getElementById('registrado');
	modificardivregistrado.innerHTML =  moment(registrado_localdate, "YYYY-MM-DD hh:mm:ss").fromNow();
	
  },1000);
});

</script>

    <div class="container d-flex p-3 mx-auto flex-column">

	<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-color border-bottom box-shadow">
      <h5 class="my-0 mr-md-auto font-weight-normal">Gestión Pedagógica</h5>
      <nav class="my-2 my-md-0 mr-md-3">
		<a href="http://repositorio.gestionpedagogica.cl"><button class="btn btn-secondary" type="button">Inicio</button></a>
		<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Hola <?php echo $row_profile_general["nombres"]; ?></button>
		<div class="dropdown-menu" aria-labelledby="dropdownMenu2">
			<a href="/perfil"><button class="dropdown-item" type="button">Perfil</button></a>
			<a href="/logout"><button class="dropdown-item" type="button">Desconectar</button></a>
		</div>
        <a href="/contacto"><button class="btn btn-secondary" type="button">Contacto</button></a>
      </nav>
      <a class="btn btn-outline-success" href="#">Contactar por Whatsapp</a>
    </div>

      <div class="jumbotron">
        <div class="container">
		
		
		<h4 class="d-flex justify-content-between align-items-center mb-3">
            <span>Tu perfil</span>
            <?php 
			if($_SESSION['facebook_id'] === '10222464871078931' or $_SESSION['facebook_id'] === '3564167063610457') // perfil papa - perfil mio
			{ 
				echo '<div class="btn-group dropup btn-block options">';
				echo '<a href="/administracion"><button type="button" class="btn btn-primary margin"><span class="material-icons">build</span> Administración</button></a>';
				echo '<a href="/opciones"><button type="button" class="btn btn-primary"><span class="material-icons">settings</span> Opciones</button></a>';
				echo '</div>';
			}
			else
			{
				echo '<div class="btn-group dropup btn-block options">';
				echo '<a href="/opciones"><button type="button" class="btn btn-primary"><span class="material-icons">settings</span> Opciones</button></a>';
				echo '</div>';
			}
			?>
				
        </h4>
		
			<div class="card mb-3 profile">
			  <div class="row no-gutters">
				<div class="col-md-4">
				  <img src="<?php echo $row_profile_general["avatar_url"]; ?>" class="card-img profile">
				</div>
				<div class="col-md-8">
				  <div class="card-body">
				  
				  
				  
				  


            <div class="row">
                <div class="col-sm">
                    <h4><?php echo $row_profile_general["nombres"]; ?> <?php echo $row_profile_general["apellidos"]; ?></h4>
					Registrado: <small id="registrado" class="text-muted">Registrado el: <?php echo $row_profile_general["registrado_el"]; ?></small></br>
                    Correo electronico: <small class="text-muted"><?php echo $row_profile_general["correo"]; ?></small>
					<hr class="mb-4">
                    <p><strong>Asignaturas: </strong>
                        <span class="tags">x1</span>
                    </p>
                </div>             
                <div class="col-sm text-center">
				<div class="row counter-profile">
				<div class="col-sm">
                    <h2><strong>0</strong></h2>                    
                    <p><small>documentos disponibles</small></p>
                </div>
                <div class="col-sm">
                    <h2><strong>0</strong></h2>                    
                    <p><small>compras realizadas</small></p>
                </div>
                <div class="col-sm">
                    <h2><strong>0</strong></h2>                    
                    <p><small>ordenes pendientes</small></p>
                </div>

				</div>
                </div>
            </div>
				  
				  
				  </div>
				</div>
			  </div>
			</div>
			
		<h4 class="d-flex justify-content-between align-items-center mb-3">
            <span>Tus planificaciones</span>
        </h4>	

		<section id="tabs" class="project-tab">
                <div class="row">
                    <div class="col-md-12">
                        <nav>
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-matematica-tab" data-toggle="tab" href="#nav-matematica" role="tab" aria-controls="nav-matematica" aria-selected="true">Planificaciones de Matemáticas</a>
                                <a class="nav-item nav-link" id="nav-lenguaje-tab" data-toggle="tab" href="#nav-lenguaje" role="tab" aria-controls="nav-lenguaje" aria-selected="false">Planificaciones de Lenguaje</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-matematica" role="tabpanel" aria-labelledby="nav-matematica-tab">
                                <table id="tabla-matematica" class="table" cellspacing="0">
                                    <thead>
                                        <tr>
											<th>Orden ID</th>
                                            <th>Tema</th>
											<th>Curso</th>
											<th>Unidad</th>
                                            <th>Fecha de compra</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($rs_result1)) {?>	

											<tr>
												<td><?php echo $row['ordencompra_id']; ?></td>
												<td><?php echo $row['archivo_nombre']; ?></td>
												<td><?php echo $row['archivo_curso']; ?></td>
												<td><?php echo $row['archivo_unidad']; ?></td>
												<td><?php echo $row['fecha_compra']; ?></td>
												<td>
												<a href="/orden?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">zoom_in</span> Ver orden</button></a>
												<a href="/archivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-primary tabla"><span class="material-icons">folder_open</span> Ver documento</button></a>
												<a href="/descarga?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-success tabla"><span class="material-icons">cloud_download</span> Descargar documento</button></a>
												</td>
											</tr>

										<?php };  ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="nav-lenguaje" role="tabpanel" aria-labelledby="nav-lenguaje-tab">
                                <table id="tabla-lenguaje" class="table" cellspacing="0">
                                    <thead>
                                        <tr>
											<th>Orden ID</th>
                                            <th>Tema</th>
											<th>Curso</th>
											<th>Unidad</th>
                                            <th>Fecha de compra</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($rs_result2)) {?>	

											<tr>
												<td><?php echo $row['ordencompra_id']; ?></td>
												<td><?php echo $row['archivo_nombre']; ?></td>
												<td><?php echo $row['archivo_curso']; ?></td>
												<td><?php echo $row['archivo_unidad']; ?></td>
												<td><?php echo $row['fecha_compra']; ?></td>
												<td>
												<a href="/orden?id=<?php echo $row['ordencompra_id']; ?>"><button class="btn btn-info tabla"><span class="material-icons">zoom_in</span> Ver orden</button></a>
												<a href="/archivo?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-primary tabla"><span class="material-icons">folder_open</span> Ver archivo</button></a>
												<a href="/descarga?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-success tabla"><span class="material-icons">cloud_download</span> Descargar archivo</button></a>
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

		<h4 class="d-flex justify-content-between align-items-center mb-3">
            <span>Tus guías</span>
        </h4>	

	</div>
    </div>

      <footer class="mastfoot mt-auto">
        <div class="inner">
          <p class="footer">Copyright © 2020 Gestión Pedagógica</p>
        </div>
      </footer>
    </div>

    
    <script src="js/bootstrap.bundle.min.js"></script>
	
  </body>
</html>