<?php
session_start();
require 'inc/conexion.php';

// BOX Archivos
$sql1 = "SELECT * FROM archivo ORDER BY archivo_id ASC";  
$rs_result1 = mysqli_query($conn, $sql1);  

// BOX Recomendados
$sql2 = "SELECT * FROM archivo ORDER BY archivo_id WHERE recomendado = '1' ASC LIMIT 4";  
$rs_result2 = mysqli_query($conn, $sql2);  

// BOX Contador
$row_cnt = $rs_result1->num_rows;

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
		<script src="js/list.min.js"></script>
		<script data-ad-client="ca-pub-2522486668045838" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	</head>
<body class="text-center">

    <div class="container d-flex p-3 mx-auto flex-column">
		<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-color border-bottom box-shadow">
			<h5 class="my-0 mr-md-auto font-weight-normal">Gestión Pedagógica</h5>
			<nav class="my-2 my-md-0 mr-md-3">
				<a href="http://repositorio.gestionpedagogica.cl"><button class="btn btn-secondary" type="button">Inicio</button></a>
				<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Panel Usuarios</button>
				<div class="dropdown-menu" aria-labelledby="dropdownMenu2">
					<?php
					if (!isset($_SESSION["fb_access_token"]))
					{
						echo '<a href="/login"><button class="dropdown-item" type="button">Ingresar con Facebook</button></a>';
					}
					else
					{
						echo '<a href="/perfil"><button class="dropdown-item" type="button">Perfil</button></a>';
						echo '<a href="/logout"><button class="dropdown-item" type="button">Desconectar</button></a>';
					}
					?> 
				</div>
				<a href="/contacto"><button class="btn btn-secondary" type="button">Contacto</button></a>
			</nav>
			<a class="btn btn-outline-success" href="https://api.whatsapp.com/send?phone=56912345678">Contactar por WhatsApp</a>
		</div>

    	<div class="jumbotron">
        	<div class="container">
          	<h1 class="display-4">Bienvenido a Gestión Pedagógica</h1>
          	<p class="index-description">En esta página encontrarás más de <?php echo $row_cnt; ?> planificaciones para casi todos los cursos de enseñanza básica.</p>

			<!-- GestionPedagogica Index -->
			<ins class="adsbygoogle"
				style="display:block"
				data-ad-client="ca-pub-2522486668045838"
				data-ad-slot="5055589516"
				data-ad-format="auto"
				data-full-width-responsive="true"></ins>
			<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
			</script>

		<div id="tabla-archivos-2">
		<h4 class="d-flex justify-content-between align-items-center mb-3">
            <span>Recomendados</span>
        </h4>
		</div>
		
		<div id="tabla-archivos">
		
		<h4 class="d-flex justify-content-between align-items-center mb-3">
            <span>Busqueda de planificaciones</span>
        </h4>
		
			<div class="container-separado">
				<input type="text" class="search form-control" placeholder="Puedes buscar por Curso, Asignatura, Unidad o Nombre"/>
			</div>
			
		<h4 class="d-flex justify-content-between align-items-center mb-3">
            <span>Lista de planificaciones</span>
        </h4>	
		<div class="card-deck mb-3 text-center">
			<ul class="list">
			
			<?php  
				while ($row = mysqli_fetch_assoc($rs_result1)) {
			?>

			<div class="card mb-4 box-shadow">
				<div class="card-header">
					<h4 class="my-0 font-weight-normal nombre"><?php echo $row['nombre']; ?></h4>
				</div>
				<div class="card-body">
					<h1 class="card-title pricing-card-title asignatura"><?php echo $row['asignatura']; ?></h1>
					<ul class="list-unstyled mt-3 mb-4">
						<li class="unidad"><?php echo $row['curso']; ?></li>
						<li class="unidad"><?php echo $row['unidad']; ?></li>
					</ul>
					<h1 class="card-title pricing-card-title price">Precio $<?php echo $row['precio']; ?></h1>
					<?php
					// PENDIENTE: Tiene que estar conectada para poder comprar
						if($row["estado"] === '0') // 0 disponible 1 no disponible
						{
							echo '<a href="/comprar?id='.$row["archivo_id"].'"><button type="button" class="btn btn-lg btn-block btn-outline-primary">Seleccionar</button></a>';
						}
						else
						{
							echo '<button type="button" class="btn btn-lg btn-block btn-outline-secondary" disabled>No disponible</button>';
						}
					?>
				</div>
			</div>
			
			<?php  
				};  
			?>
			</ul>
      </div>

	  	<h4 class="d-flex justify-content-between align-items-center mb-3">
            <span>Lista de guías</span>
        </h4>	

	  </div>
	</div>
    </div>

      <footer class="mastfoot mt-auto">
        <div class="inner">
          <p class="footer">Copyright © 2020 Gestión Pedagógica</p>
        </div>
      </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.0.slim.min.js" integrity="sha256-MlusDLJIP1GRgLrOflUQtshyP0TwT/RHXsI1wWGnQhs=" crossorigin="anonymous"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
	
	<SCRIPT type="text/javascript">
		var options = {
  valueNames: [ 'nombre', 'asignatura', 'unidad' ]
};

var tablaArchivos = new List('tabla-archivos', options);
	</script>
  </body>
</html>