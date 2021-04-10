<?php
session_start();
require 'inc/database.php';

// Consulta para traer los datos de usuario generales
$sql_datosusuariosgeneral = "SELECT nombres
FROM 
	usuario
WHERE 
	usuario_id = '".$_SESSION['usuario_id']."' "; 
$rs_resultdatosgeneral = mysqli_query($conn, $sql_datosusuariosgeneral);
$row_profile_general = mysqli_fetch_assoc($rs_resultdatosgeneral);

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
	</head>
<body class="text-center">

    <div class="container d-flex p-3 mx-auto flex-column">
        <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-color border-azul-claro">
            <img class="logo" src="/images/Logo.png" width="32" height="32"><h5 class="my-0 mr-md-auto font-weight-normal">Gestión Pedagógica</h5>
            <nav class="my-2 my-md-0 mr-md-3">
            <a href="http://repositorio.gestionpedagogica.cl"><button class="btn btn-secondary" type="button">Inicio</button></a>
            <?php
				if (!isset($_SESSION["fb_access_token"]))
				{
					echo '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Panel de usuario</button>';
					echo '<div class="dropdown-menu" aria-labelledby="dropdownMenu2">';
					echo '<a href="/login"><button class="dropdown-item" type="button">Ingresar con Facebook</button></a>';
					echo '</div>';
				}
				else
				{
					echo '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Hola '.$row_profile_general["nombres"].'</button>';
					echo '<div class="dropdown-menu" aria-labelledby="dropdownMenu2">';
					echo '<a href="/perfil"><button class="dropdown-item" type="button">Perfil</button></a>';
					echo '<a href="/misordenes"><button class="dropdown-item" type="button">Mis ordenes</button></a>';
					echo '<a href="/logout"><button class="dropdown-item" type="button">Desconectar</button></a>';
					echo '</div>';
				}
			?>
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
            <h1 class="display-4">Formulario de Contacto</h1>
            <p class="index-description">Asegurese que el correo es válido y está bien escrito, para que podamos contactarnos con usted.</p>

            <form method="post">
            <div class="card mb-3">
            <div class="card-body">
               <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="txtName" class="form-control" placeholder="Tu nombre" required/>
                        </div>
                        <div class="form-group">
                            <input type="email" name="txtEmail" class="form-control" placeholder="Tu correo electrónico" required/>
                        </div>
                        <div class="form-group">
                            <input type="number" name="txtPhone" class="form-control" placeholder="Tu número de teléfono" required/>
                        </div>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
							<strong>Recuerda</strong> verificar los datos antes de enviar el formulario
						</div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <textarea name="txtMsg" class="form-control" placeholder="Tu mensaje" style="width: 100%; height: 150px;" required></textarea>
                        </div>
                        <button type="submit" name="enviar-submit" class="btn btn-primary btn-lg float-center">Enviar mensaje</button>
                    </div>
                </div>
            </div>
            </div>
            </form>
		
	    </div>
    </div>

      <footer class="mastfoot margin-top">
        <div class="inner">
          <p class="footer">Copyright © 2020 Gestión Pedagógica</p>
        </div>
      </footer>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
  </body>
</html>