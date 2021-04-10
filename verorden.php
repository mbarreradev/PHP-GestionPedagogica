<?php
session_start();
require 'inc/database.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION["fb_access_token"])) // Si no encuentra el access token de la sesión, se enviará a login
{
	header("location: login.php");
}
else // Continuamos a la página
	header( 'Content-Type: text/html; charset=utf-8' );
	
	// Consulta que muestra todos los datos del archivo de la orden
	$url_id = trim(mysqli_real_escape_string($conn,$_GET['id'])); 
	$sql1 = "SELECT archivo.archivo_id, archivo.nombre, archivo.descripcion_corta, archivo.descripcion_larga, ordencompra.estado_orden, ordencompra.fecha_compra, ordencompra.fecha_actualizacion, ordencompra.pagado
	FROM ordencompra
	INNER JOIN 
        archivo
    ON
        archivo.archivo_id=ordencompra.archivo_id
	INNER JOIN 
        usuario
    ON
        ordencompra.usuario_id=usuario.usuario_id
	WHERE ordencompra.ordencompra_id = '".$url_id."' "; 
	$rs_result1 = mysqli_query($conn, $sql1);
	$consulta_planificacion = mysqli_fetch_assoc($rs_result1);

	// Se hace comprobación de si el ID en la url existe, si no existe se retorna a 404.php
	if(mysqli_num_rows($rs_result1)==0) 
	{
		header("location: 404.php");
	}
	else
	{
		// Consulta para traer los datos de usuario generales
		$sql_datosusuariosgeneral = "SELECT usuario_id, registrado_el, nombres, apellidos, correo, avatar_url, facebook_id
		FROM 
			usuario
		WHERE 
			usuario_id = '".$_SESSION['usuario_id']."' "; 
		$rs_resultdatosgeneral = mysqli_query($conn, $sql_datosusuariosgeneral);
		$row_profile_general = mysqli_fetch_assoc($rs_resultdatosgeneral);

		$fecha_actualizacion = date("Y-m-d H:i:s");
		$usuario = $row_profile_general['nombres']." ".$row_profile_general['apellidos'];
		
		
		// Función para cambiar estado a "Pendiente de confirmación"
		if(isset($_POST['cambiarestado-submit']))
		{
			// Consulta que actualiza el valor del estado de la orden
			$sql_update_ordencompra = "UPDATE ordencompra SET estado_orden = 'Pendiente de confirmación', fecha_actualizacion = '".$fecha_actualizacion."' WHERE ordencompra_id = '".$url_id."' "; 

			if ($conn->query($sql_update_ordencompra) === TRUE) 
			{
				// Creamos log de orden
				$redirect = NULL;
				$accion = $usuario." modificó la orden a Pendiente de confirmación";
				crearlog_ordencompra($url_id, $accion, $redirect);
			} 
			else 
			{
				//echo "Error updating record: " . $conn->error;
				echo "Error sql update.";
			}

			$conn->close();
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

		<title>Gestión Pedagógica</title>

		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
		<script src="js/moment-with-locales.js"></script>
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
				<a href="/ordenes"><button class="dropdown-item" type="button">Mis ordenes</button></a>
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
			<h1 class="display-4">Proceso de compra</h1>
			<p class="index-description">A continuación se mostrarán los datos para realizar el deposito, luego de comprobar los datos y realizar la transferencia, debes presionar el botón "Notificar orden pagada" para que sea notificada a un administrador.</p>
			
			<div class="row">
                <div class="container">
                <?

                if($consulta_planificacion["estado_orden"] == 'Pagado')
                {
                    echo '<ul class="progressbar">';
                    echo '<li class="active">Creación de orden</li>';
                    echo '<li class="active">Pago</li>';
                    echo '<li class="active"><p class="compraactiva">Confirmación de pago</p></li>';
                    echo '</ul>';
                }
                else
                {
                    echo '<ul class="progressbar">';
                    echo '<li class="active">Creación de orden</li>';
                    echo '<li class="active"><p class="compraactiva">Pago</p></li>';
                    echo '<li>Confirmación de pago</li>';
                    echo '</ul>';
                }

                ?>
                </div>
		    </div>
				
		<div class="row">
			<div class="col-md-4 order-md-2 mb-4">
			<h4 class="d-flex justify-content-between align-items-center mb-3">
				<span>Productos</span>
			</h4>
			<ul class="list-group mb-3">
				<li class="list-group-item d-flex justify-content-between lh-condensed">
				<div>
					<h6 class="my-0"><?php echo $consulta_planificacion["nombre"]; ?></h6>
					<small class="text-muted"><?php echo $consulta_planificacion["descripcion_corta"]; ?></small>
				</div>
				<span class="text-muted">$<?php echo $consulta_planificacion["pagado"]; ?></span>
				</li>
				<li class="list-group-item d-flex justify-content-between bg-azul-claro">
				<span>Total a pagar</span>
				<strong>$<?php echo $consulta_planificacion["pagado"]; ?></strong>
				</li>
			</ul>
			
			<h4 class="d-flex justify-content-between align-items-center mb-3">
				<span>Descripción</span>
			</h4>
			<ul class="list-group mb-3">
				<li class="list-group-item d-flex lh-condensed">
					<h6 class="my-0"><?php echo $consulta_planificacion["descripcion_larga"]; ?></h6>
				</li>
			</ul>
			
			</div>
		
			<?php
			// Comprobamos si esta pendiente de pago para mostrar información de pago
			
			if($consulta_planificacion["estado_orden"] == 'Pendiente de pago')
			{
				echo '<div class="col-md-8 order-md-1 text-left">';
					echo'<h4 class="mb-3">Detalles de la transacción</h4>';
					echo'<ul class="list-group mb-3">';
					echo'<li class="list-group-item d-flex lh-condensed">';
						echo'<div class="col-sm">';
							echo'<div class="alert alert-warning alert-dismissible fade show" role="alert">';
								echo'<strong>Recuerda</strong> verificar los datos antes de realizar la transferencia, para evitar perdidas de dinero';
							echo'</div>';
						echo'<p><b>Banco:</b> Banco Estado</p>';
						echo'<p><b>Rut:</b> Banco Estado</p>';
						echo'<p><b>Tipo de cuenta:</b> Banco Estado</p>';
						echo'<p><b>Nº de cuenta:</b> Banco Estado</p>';
						echo'<p><b>Correo electrónico:</b> &#118;&#101;&#110;&#116;&#097;&#115;&#064;&#103;&#101;&#115;&#116;&#105;&#111;&#110;&#112;&#101;&#100;&#097;&#103;&#111;&#103;&#105;&#099;&#097;&#046;&#099;&#108;</p>';
						echo'<p><b>Comentario:</b> Pago Orden '.$url_id.'</p>';
						echo'</div>';
					echo'</li>';
					echo'</ul>';
				echo'</div>';
				echo'<div class="col order-md-3">';
					echo'<div class="row nomargin-left">';
							echo '<div class="alert alert-info">';
								echo'<span class="material-icons">announcement</span> La verificación de confirmación de pago puede demorar entre 5 a 24 horas';
							echo'</div>';
							echo'<div class="col text-right">';
								echo'<form method="post" action=""><button type="submit" name="cambiarestado-submit" class="btn btn-primary btn-lg">Notificar orden pagada</button></form>';
							echo'</div>';
					echo'</div>';
				echo'</div>';
			}
			elseif($consulta_planificacion["estado_orden"] == 'Pendiente de confirmación')
			{
				// Si no, mostramos ventana que muestra que la orden esta pendiente de aprobación
				
				echo '<div class="col-md-8 order-md-1 text-left">';
					echo'<h4 class="mb-3">Detalles de la orden</h4>';
					echo'<ul class="list-group mb-3">';
					echo'<li class="list-group-item d-flex lh-condensed">';
						echo'<div class="col-sm">';
						echo'<p><b>Orden ID: </b> '.$url_id.'</p>';
						echo'<p><b>Creado el:</b> '.$consulta_planificacion["fecha_compra"].'</p>';
						echo'<p><b>Última actualización:</b> '.$consulta_planificacion["fecha_actualizacion"].'</p>';
						echo'<hr class="message-inner-separator">';
						echo'<strong>Tu pago está en espera de confirmación</strong>';
						echo'<p>La verificación del pago demora entre 5 a 24 horas. Una vez que tu pago sea aprobado, el documento será liberado y estará disponible en tu perfil</p>';
						echo'</div>';
					echo '</li>';
					echo '</ul>';
				echo'</div>';
				echo'<div class="col order-md-3">';
					echo'<div class="row nomargin-left">';
						echo '<div class="alert alert-info">';
							echo '<span class="material-icons">announcement</span> Recibirás un aviso cuando tu pago sea aprobado';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			}
			else
			{
				// Entonces mostramos que el pago esta ok y lo enviamos al perfil para que vea su nuevo archivo comprado
				
				echo '<div class="col-md-8 order-md-1 text-left">';
					echo'<h4 class="mb-3">Detalles de la orden</h4>';
					echo'<ul class="list-group mb-3">';
					echo'<li class="list-group-item d-flex lh-condensed">';
						echo'<div class="col-sm">';
						echo'<p><b>Orden ID: </b> '.$url_id.'</p>';
						echo'<p><b>Creado hace:</b> '.$consulta_planificacion["fecha_compra"].'</p>';
						echo'<p><b>Última actualización:</b> '.$consulta_planificacion["fecha_actualizacion"].'</p>';
						echo'<hr class="message-inner-separator">';
						echo'<strong>Buenas noticias '.$row_profile_general["nombres"].'</strong>';
						echo'<p>Tu orden fue confirmada y el archivo fue agregado a tu cuenta.</p>';
						echo'</div>';
					echo'</li>';
					echo'</ul>';
				echo'</div>';
				echo'<div class="col order-md-3">';
					echo'<div class="row nomargin-left">';
						echo'<div class="alert alert-success">';
							echo'<span class="material-icons">check_circle_outline</span> Ya puedes acceder al archivo '.$consulta_planificacion["nombre"].' ';
						echo'</div>';
						echo'<div class="col text-right">';
							echo'<a href="verarchivo?id='.$consulta_planificacion["archivo_id"].'"><button type="submit" class="btn btn-primary btn-lg">Ver archivo</button></a>';
						echo'</div>';
					echo'</div>';
				echo'</div>';
			}
			?>
      	</div>
	</div>

    </div>

      <footer class="mastfoot margin-top">
        <div class="inner">
          <p class="footer">Copyright © 2020 Gestión Pedagógica</p>
        </div>
      </footer>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
  </body>
</html>