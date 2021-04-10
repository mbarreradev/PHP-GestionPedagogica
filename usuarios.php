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
	$sql_datosusuariosgeneral = "SELECT nombres, apellidos
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

	// Funcion que aprueba la orden
	// FALTA: VER COMO OBTENER NUMERO DE ORDEN PARA ACTUALIZAR
	if(isset($_POST['aprobarorden-submit']))
	{
		$usuario = $row_profile_general['nombres']." ".$row_profile_general['apellidos'];
		$fecha_actualizacion = date("Y-m-d H:i:s");
		$ordencompraid = '0';

		// Consulta que actualiza el valor del estado de la orden
		$sql_update_ordencompra = "UPDATE ordencompra SET estado_orden = 'Pagado', fecha_actualizacion = '".$fecha_actualizacion."' WHERE ordencompra_id = '".$ordencompraid."' "; 

		if ($conn->query($sql_update_ordencompra) === TRUE) 
		{
			// Consulta que crea el historial de la orden
			$sql_create_ordencompra_historial= "INSERT INTO ordencompra_historial (historial_id, ordencompra_id, fecha_creacion, accion) VALUES (DEFAULT, '$archivo_id', '$fecha_actualizacion', '".$usuario." modificó la orden a Pagado')"; 
			
			if ($conn->query($sql_create_ordencompra_historial) === TRUE) 
			{
				// Refrescamos la página
				header("Refresh:0");
			}
			else
			{
				//echo "Error updating record: " . $conn->error;
				echo "Error sql update.";
			}
		} 
		else 
		{
			//echo "Error updating record: " . $conn->error;
			echo "Error sql update.";
		}

		$conn->close();
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
												<span class="material-icons stats">how_to_reg</span>
											</div>
											<div class="col-9 text-right">
												<div class="Count"><?php echo $cnt_usuarios_activos; ?></div>
												<h4>usuarios activados</h4>
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
												<span class="material-icons stats">block</span>
											</div>
											<div class="col-9 text-right">
												<div class="Count"><?php echo $cnt_usuarios_bloqueados; ?></div>
												<h4>usuarios bloqueados</h4>
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
												<span class="material-icons stats">people</span>
											</div>
											<div class="col-9 text-right">
												<div class="Count"><?php echo $cnt_usuarios_totales; ?></div>
												<h4>usuarios totales</h4>
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
            <span class="titulo">Usuarios</span>
        </h4>	

		<section id="tabs" class="project-tab">
                <div class="row">
                    <div class="col-md-12">

                            <div id="ordenes-pendientes">
                                <div class="buscador arriba">
									<input type="search" class="search form-control" placeholder="Puedes buscar por ID, nombre, apellido, rango o correo electrónico"/>
								</div>
                                <table id="tabla-matematica-planificacion" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
											<th class="sort" data-sort="id">ID</th>
                                            <th class="sort" data-sort="usuario">Usuario</th>
                                            <th>Rango</th>
                                            <th class="sort" data-sort="correo">Correo</th>
                                            <th>Registrado el</th>
                                            <th>Última inicio de sesión</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_usuarios)) {?>	
											<tr>
												<td class="id"><?php echo $row['usuario_id']; ?></td>
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
												<button class="btn btn-info tabla"><span class="material-icons">person</span> Ver ficha de perfil</button>
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
    
    <script src="js/bootstrap.bundle.min.js"></script>
	
  </body>
</html>