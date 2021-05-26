<?php
session_start();
require_once 'inc/database.php';
require_once 'inc/functions.php';

// Consulta que muestra todos los datos del archivo
$url_id = trim(mysqli_real_escape_string($conn,$_GET['id'])); 
$sql1 = "SELECT * FROM archivo where archivo_id = '".$url_id."' "; 
$rs_result1 = mysqli_query($conn, $sql1);
$consulta_archivo = mysqli_fetch_assoc($rs_result1);

$archivo_id = $url_id;
$archivo_fecha_subida = date("d-m-Y", strtotime($consulta_archivo["fecha_subida"]));
$archivo_fecha_actualizacion = date("d-m-Y", strtotime($consulta_archivo["fecha_actualizacion"]));

// Variable para mostrar si es planificación o guía
if ($consulta_archivo["tipo"] == 0){
    $archivo_tipo = 'Planificación';
    $tipo_url = '/planificaciones/';
}
else {
    $archivo_tipo = 'Guía';
    $tipo_url = '/guias/';
}

// Se hace comprobación de si el ID en la url existe, si no existe se retorna a 404.php
if(mysqli_num_rows($rs_result1)==0) 
{
    header("location: 404.php");
}
else
{
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

        // Comprobamos si es dueño del archivo
        $valor_dueno_archivo = comprobar_dueno_archivo($_SESSION['usuario_id'],$archivo_id);
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
		<title><?php echo $archivo_tipo; ?> - Gestión Pedagógica</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <link href="css/sidebar.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    	<script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/sidebar.js"></script>
        <script src="js/moment-with-locales.js"></script>
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
    <div class="mb-1"><a href="<?php echo $tipo_url; ?>"> <?php echo $archivo_tipo; ?></a> > <a href="/"><?php echo $consulta_archivo["curso"]; ?></a> > <a href="/planificaciones"><?php echo $consulta_archivo["asignatura"]; ?></a></div>
      <div class="d-flex justify-content-between">
        <h4 class="titulo"><?php echo $consulta_archivo["nombre"]; ?></h4>
        <div class="btn-group dropup btn-block options">
            <a href="/administracion"><button type="button" class="btn btn-primary"><i class="fa fa-tachometer-alt"></i> Volver a la administración</button></a>
        </div>
      </div>
      <hr>

        <div class="card profile border-plomo bg-azul-claro mb-4">
			<div class="row no-gutters">
				<div class="col-md">
				  	<div class="card-body">
						<div class="row">
							<div class="col-sm">
                                <?php echo $consulta_archivo["descripcion_corta"]; ?></br>
								<strong>Valoración:</strong> <span><?php echo $consulta_archivo["valoracion"]; ?> <i class="fa fa-star" data-rating="2" style="font-size:15px;color:#ff9f00;"></i></span></br>
								<strong>Fecha de subida:</strong> <span><?php echo $archivo_fecha_subida; ?></span> <strong>Última actualización:</strong> <span><?php echo $archivo_fecha_actualizacion; ?></span></br>
								<hr class="bg-azul"/>
								<a href="/planificaciones"><button type="button" class="btn btn-primary"><i class="fa fa-heart"></i> Agregar a favoritos</button></a>
                                <a href="/descargar?id=<?php echo $row['archivo_id']; ?>"><button class="btn btn-success"><i class="fas fa-cloud-download-alt"></i> Descargar</button></a>
                                <?php
                                    if($row["estado"] === '1' AND isset($_SESSION["fb_access_token"])) // 1 disponible 0 no disponible
                                    {
                                        echo '<a href="#"><button type="button" data-name="'.$row["nombre"].'" data-price="'.$row["precio"].'" class="add-to-cart btn btn-xs btn-outline-primary">Agregar al carrito</button></a>';
                                    }
                                    else
                                    {
                                        echo 'asd';
                                    }
                                ?>

                                <div class="btn-group" role="group">
									<button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    Administración
									</button>
									<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                        <a class="dropdown-item" href="/editardocumento?id=<?php echo $archivo_id; ?>"><button class="btn btn-primary tabla"><i class="fas fa-pencil-alt"></i> Modificar</button></a>
										<a class="dropdown-item" href="/estadisticas?id=<?php echo $archivo_id; ?>"><button class="btn btn-info tabla"><i class="fas fa-chart-line"></i> Estadísticas</button></a>
									</div>
								</div>

							</div>             
							<div class="col-sm text-center">
								<div class="row counter-profile">
									<div class="col-sm">
										<div class="Count"><?php echo $cnt_documentos_disponible_total; ?></div>                    
										<p>visitas</p>
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

        <div class="container pl-0">
					<div class="row">
						<div class="col">
							<h4 class="titulo">Descripción</h4>
							<?php echo $consulta_archivo["descripcion_larga"]; ?>
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
  </main>
  <!-- page-content" -->
</div>
<!-- page-wrapper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
</body>
</html>