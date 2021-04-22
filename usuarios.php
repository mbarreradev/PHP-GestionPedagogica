<?php
session_start();
require_once 'inc/database.php';

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
    $sql_datosusuariosgeneral = "SELECT nombres, apellidos, rango, avatar_url
    FROM 
        usuario
    WHERE 
        usuario_id = '".$_SESSION['usuario_id']."' "; 
    $rs_resultdatosgeneral = mysqli_query($conn, $sql_datosusuariosgeneral);
    $row_profile_general = mysqli_fetch_assoc($rs_resultdatosgeneral);

    // BOX: Tabla usuarios
	$sql_usuarios = "SELECT usuario_id, registrado_el, nombres, apellidos, correo, facebook_id, rut, dv, rango, ultimo_iniciosesion, ultima_ip, telefono, estado, avatar_url
    FROM 
		usuario
	ORDER BY usuario_id DESC"; 
    $rs_result_usuarios = mysqli_query($conn, $sql_usuarios);

    // Contador de usuarios totales
	$cnt_usuarios_totales = $rs_result_usuarios->num_rows;
    
    // Contador usuarios activos
    $sql_usuarios_activos = "SELECT * FROM usuario Where estado = '1'";  
	$rs_result_usuarios_activos = mysqli_query($conn, $sql_usuarios_activos);  
    $cnt_usuarios_activos = $rs_result_usuarios_activos->num_rows;
    
    // Contador usuarios bloqueados
    $sql_usuarios_bloqueados = "SELECT * FROM usuario WHERE estado = '0'";  
	$rs_result_usuarios_bloqueados = mysqli_query($conn, $sql_usuarios_bloqueados);  
	$cnt_usuarios_bloqueados = $rs_result_usuarios_bloqueados->num_rows;

?>
<!doctype html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<link rel="icon" href="favicon.ico">
		<title>Usuarios - Gestión Pedagógica</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" rel="stylesheet">
        <link href="css/sidebar.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    	<script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/sidebar.js"></script>
        <script src="js/list.min.js"></script>
        <script src="js/moment-with-locales.js"></script>
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
            <h4 class="titulo">Estadísticas</h4>
            <div class="btn-group dropup btn-block options">
                <a href="/administracion"><button type="button" class="btn btn-primary"><i class="fa fa-tachometer-alt"></i> Volver a la administración</button></a>
            </div>
        </div>
        <hr>

		<div class="container mb-4">
			<div class="row">
				<div class="col-sm-4 nopadding-left">
                    <div class="card border-plomo">
						<div class="card-body bg-rosado-especial text-white">
							<div class="row">
								<div class="col-3">
                                    <i class="fas fa-user-check fa-5x"></i>
								</div>
								<div class="col-9 text-right">
									<div class="Count"><?php echo $cnt_usuarios_activos; ?></div>
									<h4>usuarios activados</h4>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="card border-plomo">
						<div class="card-body bg-naranjo-especial text-white">
							<div class="row">
								<div class="col-3">
                                    <i class="fas fa-user-times fa-5x"></i>
								</div>
								<div class="col-9 text-right">
									<div class="Count"><?php echo $cnt_usuarios_bloqueados; ?></div>
									<h4>usuarios bloqueados</h4>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-4 nopadding-right">
                    <div class="card border-plomo">
						<div class="card-body bg-azul-especial text-white">
							<div class="row">
								<div class="col-3">
                                    <i class="fas fa-users fa-5x"></i>
								</div>
								<div class="col-9 text-right">
									<div class="Count"><?php echo $cnt_usuarios_totales; ?></div>
									<h4>usuarios registrados</h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

        <div class="d-flex justify-content-between mb-3">
        <h4 class="titulo">Usuarios</h4>
		</div>

        <section id="tabs" class="project-tab">
                <div class="row">
                    <div class="col-md-12">

                            <div id="ordenes-pendientes">
                                <div class="buscador arriba">
									<input type="search" class="search form-control" placeholder="Puedes buscar por ID, nombre, apellido, rango o email"/>
								</div>
                                <table id="tabla-matematica-planificacion" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
                                            <th class="sort" data-sort="usuario">Usuario</th>
                                            <th>Rango</th>
                                            <th class="sort" data-sort="correo">Correo</th>
                                            <th>Registrado el</th>
                                            <th>Último inicio de sesión</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_usuarios)) {?>	
											
											<tr>
												<td class="usuario"><?php echo $row['nombres']." ".$row['apellidos']; ?></td>
                                                <td class="usuario">

                                                <?php

                                                if($row['rango'] === '2')
                                                {
                                                    echo 'Administrador';
                                                }
                                                else
                                                {
                                                    echo 'Usuario';
                                                }

                                                ?>

                                                </td>
                                                <td class="correo"><?php echo $row['correo']; ?></td>
												<td><?php echo $row['registrado_el']; ?></td>
                                                <td><?php echo $row['ultimo_iniciosesion']; ?></td>
												<td>
                                                    <a href="/verperfil?id=<?php echo $row['usuario_id']; ?>"><button class="btn btn-info tabla"><i class="fas fa-user"></i> Ver perfil</button></a>
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
    valueNames: [ 'id', 'usuario', 'correo', 'rango'],
    page: 10,
    pagination: true
	};

	var tablaOrdenesPendientes = new List('ordenes-pendientes', options);

	var tablaMatematicasOrden = new List('nav-matematica-orden', options);
	var tablaLenguajeOrden = new List('nav-lenguaje-orden', options);
	var tablaTecnologiaOrden = new List('nav-tecnologia-orden', options);
	var tablaMusicaOrden = new List('nav-musica-orden', options);
	var tablaArtesVisualesOrden = new List('nav-artesvisuales-orden', options);

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
</body>
</html>