<?php
session_start();
require_once 'inc/database.php';
require_once 'inc/functions.php';

require_once 'inc/PHPMailer/PHPMailer.php';
require_once 'inc/PHPMailer/SMTP.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

// Función para enviar correo electrónico
if(isset($_POST['enviar-submit']))
{
    // Reseteo de variables
    $nombreEstado = $emailEstado = $telefonoEstado = $mensajeEstado = $nombreValido = $emailValido = $telefonoValido = $mensajeValido = $nombreErrors = $emailErrors = $telefonoErrors = $mensajeErrors = NULL;

    //Obtenemos datos para comprobaciones
    $nombreValido = $_POST['nombre'];
    $emailValido = $_POST['email'];
    $telefonoValido = $_POST['telefono'];
    $mensajeValido = $_POST['mensaje'];

    //Regla Nombre
    if (empty($_POST['nombre'])) {
      $nombreErrors = "\n Por favor ingrese su nombre."; 
    } elseif (!filter_var($nombreValido, FILTER_SANITIZE_STRING)) {
      $nombreErrors = "\n Sólo se permiten letras y espacios en blanco."; 
    } else {  //Caso verdadero obtenemos datos.
      $nombreEstado = TRUE;
    }

    //Regla Email
    if (empty($_POST['email'])) {
      $emailErrors = "\n Por favor ingrese su correo electrónico. "; 
    } elseif (!filter_var($emailValido, FILTER_VALIDATE_EMAIL)) {
      $emailErrors = "\n Correo electrónico no válido";
    } else { //Caso verdadero obtenemos datos.
      $emailEstado = TRUE;
    }

    //Regla Telefono
    if (empty($_POST['telefono'])) {
      $telefonoErrors = "\n Por favor ingresar su teléfono. "; 
    } elseif (!filter_var($telefonoValido, FILTER_SANITIZE_NUMBER_INT)) {
      $telefonoErrors = "\n Número no valido";
    } else { //Caso verdadero obtenemos datos.
      $telefonoEstado = TRUE;
    }

    //Regla Mensaje
    if (empty($_POST['mensaje'])) {
      $mensajeErrors = "\n Por favor ingrese su mensaje."; 
    } elseif (!filter_var($mensajeValido, FILTER_SANITIZE_STRING)) {
      $mensajeErrors = "\n Sólo se permiten letras y espacios en blanco."; 
    } else {  //Caso verdadero obtenemos datos.
      $mensajeEstado = TRUE;
    }

    // Si todos los campos son validos, entonces se hace la secuencia SQL
    if ($nombreEstado == TRUE && $emailEstado == TRUE && $telefonoEstado == TRUE && $mensajeEstado == TRUE)
    {
      $asunto = "Mensaje de ".$emailValido;
      $body = "Nuevo mensaje de la página de contacto: <br><br><b>Nombre:</b> ".$nombreValido." <br><b>Correo electrónico:</b> ".$emailValido." <br><b>Teléfono:</b> ".$telefonoValido." <br><b>Mensaje:</b> ".$mensajeValido;
      $email_destino = "contacto@gestionpedagogica.cl";

      // Función para enviar correo
      $return = enviar_correo($asunto, $body, $email_destino);

      if($return == 0)
      {
        $resultMsg = "\n <div class='alert alert-danger' role='alert'>Ocurrió un error al enviar el formulario.</div>";
      }
      else
      {
        $resultMsg = "\n <div class='alert alert-success' role='alert'>Formulario enviado con éxito. Nos pondremos en contacto contigo en los próximos días.</div>";
      }
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
		<title>Contacto - Gestión Pedagógica</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <link href="css/sidebar.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    	<script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/sidebar.js"></script>
	</head>
<body>
<div class="page-wrapper chiller-theme toggled">
  <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
    <i class="fas fa-bars"></i>
  </a>
  
  <?php require 'inc/sidebar.php'; ?>

  <main class="page-content">
    <div class="container-fluid">
        <h1 class="display-4">Formulario de Contacto</h1>
      <p class="index-description">Asegurese que el correo es válido y está bien escrito, para que podamos contactarnos con usted.</p>
      <hr>

      <?php if (!empty($resultMsg)) {  echo "<span class=estiloError>$resultMsg</span>";  }  ?>

        <form method="post">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="nombre" class="form-control" placeholder="Tu nombre" required/>
                                <?php if (!empty($nombreErrors)) {  echo "<div class='alert alert-danger' role='alert'>$nombreErrors</div>";  }  ?>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="Tu correo electrónico" required/>
                                <?php if (!empty($emailErrors)) {  echo "<div class='alert alert-danger' role='alert'>$emailErrors</div>";  }  ?>
                            </div>
                            <div class="form-group">
                                <input type="number" name="telefono" class="form-control" placeholder="Tu número de teléfono" required/>
                                <?php if (!empty($telefonoErrors)) {  echo "<div class='alert alert-danger' role='alert'>$telefonoErrors</div>";  }  ?>
                            </div>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Recuerda</strong> verificar los datos antes de enviar el formulario
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <textarea name="mensaje" class="form-control" placeholder="Tu mensaje" style="width: 100%; height: 150px;" required></textarea>
                                <?php if (!empty($mensajeErrors)) {  echo "<div class='alert alert-danger' role='alert'>$mensajeErrors</div>";  }  ?>
                            </div>
                            <button type="submit" name="enviar-submit" class="btn btn-primary btn-lg float-right">Enviar mensaje</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

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