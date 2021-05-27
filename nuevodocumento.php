<?php
session_start();
require_once 'inc/database.php';
require_once 'inc/functions.php';

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
	$sql_datosusuariosgeneral = "SELECT nombres
	FROM 
		usuario
	WHERE 
		usuario_id = '".$_SESSION['usuario_id']."' "; 
	$rs_resultdatosgeneral = mysqli_query($conn, $sql_datosusuariosgeneral);
    $row_profile_general = mysqli_fetch_assoc($rs_resultdatosgeneral);
    
    // Funcion que crea la orden
	if(isset($_POST['crear-submit']))
	{
        $nombre = $_POST['txtNombre'];
        $precio = $_POST['txtPrecio'];
        $estado = $_POST['selectEstado'];
        $descripcion_larga = $_POST['txtDescripcionLarga'];
        $descripcion_corta = $_POST['txtDescripcionCorta'];
        $asignatura = $_POST['selectAsignatura'];
        $unidad = $_POST['txtUnidad'];
        $curso = $_POST['selectCurso'];
		$fecha_subida = date("Y-m-d H:i:s");
        $fecha_actualizacion = date("Y-m-d H:i:s");
        $tipo = $_POST['selectTipo'];

        if(!empty($_POST['recomendado'])) 
        {
            $recomendado_valorfinal = "1"; // activado
        }
        else
        {
            $recomendado_valorfinal = "0"; // desactivado
        }


        // Reemplazamos espacios por -
        $nombre_archivo = basename($_FILES["fileArchivo"]["name"]);
        $nombreFinal = str_replace(' ', '-', $nombre_archivo);

        $target_dir = "files/";
        $target_file = $target_dir . $nombreFinal;
        $uploadOk = 0;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
        // Comprobar tamaño
        if ($_FILES["fileArchivo"]["size"] > 2000000) { // Limite 20 MB
            $uploadOk = 0;
            $link_archivo = "error de tamaño";
        }
        
        // Comprobar extensiones
        if(($imageFileType == "pdf") or ($imageFileType == "xlsx") or ($imageFileType == "xls") or ($imageFileType == "docx")) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
            $link_archivo = "error de extensión";
        }
        
        // Comprobamos que $uploadOk es 0 para ver si tiene algun error
        if ($uploadOk == 0) {
            echo "</br>Ahora mismo el documento no puede ser subido.";
        // si uploadOk sigue en 1, subimos el archivo
        } else {
            if (move_uploaded_file($_FILES["fileArchivo"]["tmp_name"], $target_file)) 
            {
                $link_archivo = $nombreFinal;
            } else {
                echo "Hubo un error subiendo el archivo.";
                $link_archivo = "error desconocido";
            }
        }
					
		$sql1 = "INSERT INTO archivo (archivo_id, nombre, precio, estado, descripcion_larga, descripcion_corta, asignatura, unidad, curso, link_archivo, fecha_subida, fecha_actualizacion, recomendado, tipo) VALUES (DEFAULT, '$nombre', '$precio', '$estado', '$descripcion_larga', '$descripcion_corta', '$asignatura', '$unidad', '$curso', '$link_archivo', '$fecha_subida', '$fecha_actualizacion', '$recomendado_valorfinal', '$tipo')";

		if ($conn->query($sql1) === TRUE) 
		{
			// Enviamos al usuario a la siguiente pantalla
			header("Location: https://repositorio.gestionpedagogica.cl/administracion");
		}
		else
		{
			echo "Error sql log.";
			//echo "Error sql log." . $sql1 . "<br>" . $conn->error;
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
      <div class="d-flex justify-content-between">
        <h4 class="titulo">Subir nuevo documento</h4>
        <div class="btn-group dropup btn-block options">
            <a href="/administracion"><button type="button" class="btn btn-primary"><i class="fa fa-tachometer-alt"></i> Volver a la administración</button></a>
        </div>
      </div>
      <hr>

        <div class="card mb-3">
			    <div class="row no-gutters">
				    <div class="col">
				        <div class="card-body">
                            <form method="post" action="" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" id="txtNombre" name="txtNombre" class="form-control" placeholder="Nombre del documento" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="asignatura">Asignatura</label>
                                        <select class="custom-select d-block w-100" name="selectAsignatura" id="selectAsignatura" required>
                                            <option selected>Escoge una opción</option>
                                            <option value="Matemáticas">Matemáticas</option>
                                            <option value="Lenguaje">Lenguaje</option>
                                            <option value="Tecnología">Tecnología</option>
                                            <option value="Música">Música</option>
                                            <option value="Artes Visuales">Artes Visuales</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="curso">Curso</label>
                                        <select class="custom-select d-block w-100" name="selectCurso" id="selectCurso" required>
                                            <option selected>Escoge una opción</option>
                                            <option value="Primero Básico">Primero Básico</option>
                                            <option value="Segundo Básico">Segundo Básico</option>
                                            <option value="Tercero Básico">Tercero Básico</option>
                                            <option value="Cuarto Básico">Cuarto Básico</option>
                                            <option value="Quinto Básico">Quinto Básico</option>
                                            <option value="Sexto Básico">Sexto Básico</option>
                                            <option value="Séptimo Básico">Séptimo Básico</option>
                                            <option value="Octavo Básico">Octavo Básico</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="unidad">Unidad</label>
                                        <input type="text" id="txtUnidad" name="txtUnidad" class="form-control" placeholder="Unidad del archivo" required>
                                    </div>
                                        
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="tipo">Tipo de archivo</label>
                                            <select class="custom-select d-block w-100" name="selectTipo" id="tipo" required>
                                                <option selected>Escoge una opción</option>
                                                <option value="0">Planificación</option>
                                                <option value="1">Guía</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="estado">Estado</label>
                                            <select class="custom-select d-block w-100" name="selectEstado" id="estado" required>
                                                <option selected>Escoge una opción</option>
                                                <option value="0">Disponible</option>
                                                <option value="1">No disponible</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="precio">Precio</label>
                                            <input type="number" class="form-control" name="txtPrecio" id="txtPrecio" placeholder="Precio" required>
                                        </div>
                                        
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="recomendado" id="recomendado">
                                        <label class="custom-control-label" for="recomendado">Recomendar este documento en la página principal de Gestión Pedagógica *</label>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="descripcionCorta">Descripción corta</label>
                                        <input type="text" name="txtDescripcionCorta" id="txtDescripcionCorta" class="form-control" placeholder="Descripción corta" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="descripcionLarga">Descripción larga</label>
                                        <textarea name="txtDescripcionLarga" id="txtDescripcionLarga" class="form-control" placeholder="Descripción larga" style="width: 100%; height: 150px;" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="descripcionLarga">Este documento contiene *</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="graficos" id="graficos">
                                            <label class="custom-control-label" for="graficos">Gráficos</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="ejemplos" id="ejemplos">
                                            <label class="custom-control-label" for="ejemplos">Ejemplos</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="ejercicios" id="ejercicios">
                                            <label class="custom-control-label" for="ejercicios">Ejercicios</label>
                                        </div>
                                    </div>
                                    <hr class="mb-4">
                                    <div class="form-group">
                                        <input type="file" id="fileArchivo" name="fileArchivo" class="form-control" required>
                                    </div>

                                    <button type="submit" name="crear-submit" class="btn btn-primary btn-lg float-center">Subir nuevo documento</button>
                                </div>
                                </div>
				            </div>
                            </form>
				        </div>
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