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
            <a class="btn btn-outline-success" href="#">Contactar por Whatsapp</a>
        </div>

        <div class="jumbotron">
            <div class="container">
            <h1 class="display-4">Formulario de Contacto</h1>
            <p class="index-description">Texto</p>

            <form method="post">
               <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="txtName" class="form-control" placeholder="Tu nombre" value="" />
                        </div>
                        <div class="form-group">
                            <input type="text" name="txtEmail" class="form-control" placeholder="Tu correo electrónico" value="" />
                        </div>
                        <div class="form-group">
                            <input type="text" name="txtPhone" class="form-control" placeholder="Tu número de teléfono" value="" />
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-lg btn-block btn-outline-primary">Enviar mensaje</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <textarea name="txtMsg" class="form-control" placeholder="Tu mensaje" style="width: 100%; height: 150px;"></textarea>
                        </div>
                    </div>
                </div>
            </form>
		
	    </div>
    </div>

      <footer class="mastfoot mt-auto">
        <div class="inner">
          <p class="footer">Copyright © 2020 Gestión Pedagógica</p>
        </div>
      </footer>
    </div>
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