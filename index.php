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
$sql_planificaciones = "SELECT * FROM archivo WHERE tipo = '0' ORDER BY RAND() LIMIT 5";  
$rs_result_planificaciones = mysqli_query($conn, $sql_planificaciones);  

// BOX guias
$sql_guias = "SELECT * FROM archivo WHERE tipo = '1' ORDER BY RAND() LIMIT 5";  
$rs_result_guias = mysqli_query($conn, $sql_guias);  

// BOX Recomendados
$sql_recomendados = "SELECT * FROM archivo WHERE recomendado = '1' ORDER BY RAND() LIMIT 3";  
$rs_result_recomendados = mysqli_query($conn, $sql_recomendados);  

// Contador planificaciones
$sql_planificaciones_totales = "SELECT * FROM archivo WHERE tipo ='0' ";  
$rs_result_planificaciones_totales = mysqli_query($conn, $sql_planificaciones_totales);  
$cnt_planificaciones = $rs_result_planificaciones_totales->num_rows;

// Contador guias
$sql_guias_totales = "SELECT * FROM archivo WHERE tipo ='1' ";  
$rs_result_guias_totales = mysqli_query($conn, $sql_guias_totales);  
$cnt_guias = $rs_result_guias_totales->num_rows;

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
		<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
		<link href="css/sidebar.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    	<script src="js/bootstrap.bundle.min.js"></script>
		<script src="js/carousel.js"></script>
        <script src="js/sidebar.js"></script>
		<script data-ad-client="ca-pub-2522486668045838" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	</head>
<body>
<div class="page-wrapper chiller-theme toggled">
  <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
    <i class="fas fa-bars"></i>
  </a>
  
  <?php require 'inc/sidebar.php'; ?>

  <main class="page-content">
    <div class="container-fluid">
      <h1 class="display-4">Bienvenido a Gestión Pedagógica</h1>
			<p class="index-description">En esta página encontrarás más de <?php echo $cnt_planificaciones; ?> planificaciones y <?php echo $cnt_guias; ?> guías para casi todos los cursos de enseñanza básica.</p>
				
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
      <div class="d-flex justify-content-between">
        <h4 class="titulo">Recomendados</h4>
      </div>
      <hr>

      <div class="row">
        
        <?php  
			while ($row = mysqli_fetch_assoc($rs_result_recomendados)) {
		?>
        
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 form-group">
          <div class="card rounded-0 p-0 shadow-sm">
            <div class="card-body text-center">
                <div class="item">
					<div class="pad15">
						<p class="lead"><?php echo $row['asignatura']; ?></p>
						<p class="titulo-negro"><?php echo $row['nombre']; ?></p>
						<p><?php echo $row['curso']; ?></p>
						<?php
                        if($row["estado"] === '1' AND isset($_SESSION["fb_access_token"])) // 1 disponible 0 no disponible
                        {
                            echo '<a href=""><button type="button" data-name="'.$row["nombre"].'" data-price="'.$row["precio"].'" class="add-to-cart btn btn-sm btn-block btn-outline-primary">Agregar al carrito</button></a>';
                        }
                        ?>
					</div>
				</div>
            </div>
          </div>
        </div>
        <?php  
			};  
		?>
      </div>

      <div class="d-flex justify-content-between mt-3">
        <h4 class="titulo">Planificaciones disponibles</h4>
        <div class="btn-group dropup btn-block options">
          <a href="/planificaciones"><button type="button" class="btn btn-primary"><span class="material-icons">select_all</span> Ver todos</button></a>
        </div>
      </div>
      <hr>


      <div class="card-deck text-center justify-content-center">
        <ul class="list">
                                
        <?php  
          while ($row = mysqli_fetch_assoc($rs_result_planificaciones)) {
					  $precio_final = number_format($row['precio'],0, '', '.');
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
            <h1 class="card-title pricing-card-title price">Precio $<?php echo $precio_final; ?></h1>
            <?php
              if($row["estado"] === '1' AND isset($_SESSION["fb_access_token"])) // 1 disponible 0 no disponible
              {
                echo '<a href=""><button type="button" data-name="'.$row["nombre"].'" data-price="'.$row["precio"].'" class="add-to-cart btn btn-xs btn-outline-primary">Agregar al carrito</button></a>';
              }
              ?>
          </div>
        </div>
                                
        <?php  
          };  
        ?>
        </ul>
      </div>

      <div class="d-flex justify-content-between mt-3">
        <h4 class="titulo">Guías disponibles</h4>
        <div class="btn-group dropup btn-block options">
          <a href="/guias"><button type="button" class="btn btn-primary"><span class="material-icons">select_all</span> Ver todos</button></a>
        </div>
      </div>
      <hr>

      <div class="card-deck text-center justify-content-center">
        <ul class="list">
                                
        <?php  
          while ($row = mysqli_fetch_assoc($rs_result_guias)) {
					  $precio_final = number_format($row['precio'],0, '', '.');
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
            <h1 class="card-title pricing-card-title price">Precio $<?php echo $precio_final; ?></h1>
            <?php
              if($row["estado"] === '1' AND isset($_SESSION["fb_access_token"])) // 1 disponible 0 no disponible
              {
                echo '<a href="#"><button type="button" data-name="'.$row["nombre"].'" data-price="'.$row["precio"].'" class="add-to-cart btn btn-xs btn-outline-primary">Agregar al carrito</button></a>';
              }
            ?>
          </div>
        </div>
                                
        <?php  
          };  
        ?>
        </ul>
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
  </main>
  <!-- page-content" -->
</div>
<!-- page-wrapper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    
</body>
</html>