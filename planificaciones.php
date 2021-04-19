<?php
session_start();
require_once 'inc/database.php';

if (isset($_SESSION["fb_access_token"]))
{
    // Consulta para traer los datos de usuario generales
    $sql_datosusuariosgeneral = "SELECT nombres, apellidos, rango, avatar_url
    FROM 
        usuario
    WHERE 
        usuario_id = '".$_SESSION['usuario_id']."' "; 
    $rs_resultdatosgeneral = mysqli_query($conn, $sql_datosusuariosgeneral);
    $row_profile_general = mysqli_fetch_assoc($rs_resultdatosgeneral);
}

// BOX planificaciones
$sql_planificaciones = "SELECT * FROM archivo WHERE tipo = '0' ORDER BY asignatura ASC";  
$rs_result_planificaciones = mysqli_query($conn, $sql_planificaciones);  

?>
<!doctype html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<link rel="icon" href="favicon.ico">
		<title>Planificaciones - Gestión Pedagógica</title>
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
    <div id="tabla-lista-planificaciones">
      <div class="d-flex justify-content-between">
        <h4 class="titulo">Planificaciones disponibles</h4>
        <div class="btn-group dropup btn-block options">
            <a href="https://repositorio.gestionpedagogica.cl/"><button type="button" class="btn btn-primary"><i class="fa fa-home"></i> Volver al menú principal</button></a>
        </div>
      </div>
      <hr>

    <div class="container-separado">
		  <input type="search" class="search form-control" placeholder="Puedes buscar por temática, curso, asignatura o unidad"/>
	  </div>

    <div class="card-deck mb-3 text-center justify-content-center">
						<ul class="list">
						
						<?php  
							while ($row = mysqli_fetch_assoc($rs_result_planificaciones)) {
						?>

						<div class="card mb-4 box-shadow">
							<div class="card-header bg-azul">
								<h4 class="my-0 font-weight-normal nombre"><?php echo $row['asignatura']; ?></h4>
							</div>
							<div class="card-body">
								<h1 class="card-title pricing-card-title asignatura"><?php echo $row['nombre']; ?></h1>
								<hr class="bg-azul"/>
								<ul class="list-unstyled mt-3 mb-4">
									<li class="unidad"><?php echo $row['curso']; ?></li>
									<li class="unidad"><?php echo $row['unidad']; ?></li>
								</ul>
								<h1 class="card-title pricing-card-title price">Precio $<?php echo $row['precio']; ?></h1>
								<?php
									if($row["estado"] === '1' AND isset($_SESSION["fb_access_token"])) // 1 disponible 0 no disponible
									{
										echo '<a href="/comprar?id='.$row["archivo_id"].'"><button type="button" class="btn btn-xs btn-outline-primary">Ver documento</button></a>';
									}
									else
									{
										echo '<button type="button" class="btn btn-xs btn-outline-secondary" disabled>No disponible</button>';
									}
								?>
							</div>
						</div>
						
						<?php  
							};  
                        ?>

                        </ul>
                        <div class="container">
                            <div class="row text-center justify-content-center">
                                <ul class="pagination"></ul>
                            </div>
                        </div>
					</div>

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
    </div>
  </main>
  <!-- page-content" -->
</div>
<!-- page-wrapper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script type="text/javascript">
	var options = {
    valueNames: [ 'nombre', 'asignatura', 'unidad', 'curso' ],
    page: 12,
    pagination: true
    };

    var tablaPlanificaciones = new List('tabla-lista-planificaciones', options);
	</script> 
</body>
</html>