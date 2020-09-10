<?php
session_start();
require 'inc/conexion.php';

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
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
        // Comprobar tamaño
        if ($_FILES["fileArchivo"]["size"] > 2000000) { // Limite 20 MB
            $uploadOk = 0;
            $link_archivo = "error de tamaño";
        }
        
        // Comprobar extensiones
        if($imageFileType != "pdf" && $imageFileType != "xlsx" && $imageFileType != "docx") {
            $uploadOk = 0;
            $link_archivo = "error de extensión";
        }
        
        // Comprobamos que $uploadOk es 0 para ver si tiene algun error
        if ($uploadOk == 0) {
            //echo "</br>Ahora mismo el archivo no puede ser subido.";
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
			echo "Error sql log." . $sql1 . "<br>" . $conn->error;
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

		<title>Administración - Gestión Pedagógica</title>

		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
		<script src="https://code.jquery.com/jquery-3.5.0.slim.min.js" integrity="sha256-MlusDLJIP1GRgLrOflUQtshyP0TwT/RHXsI1wWGnQhs=" crossorigin="anonymous"></script>
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
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span>Crear nuevo archivo</span>
                <div class="btn-group dropup btn-block options">
                <a href="/administracion"><button type="button" class="btn btn-primary"><span class="material-icons">build</span> Volver a la administración</button></a>
                </div>  
            </h4>
			<div class="card mb-3">
			    <div class="row no-gutters">
				    <div class="col">
				        <div class="card-body">
                            <form method="post" action="" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" id="txtNombre" name="txtNombre" class="form-control" placeholder="Nombre del archivo" required>
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
                                                <option value="1">Activado</option>
                                                <option value="0">Desactivado</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="precio">Precio</label>
                                            <input type="number" class="form-control" name="txtPrecio" id="txtPrecio" placeholder="Precio" required>
                                        </div>
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
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="recomendado" id="recomendado">
                                        <label class="custom-control-label" for="recomendado">Recomendar archivo en la página principal de Gestión Pedagógica</label>
                                    </div>
                                    <hr class="mb-4">

                                    <div class="form-group">
                                        <input type="file" id="fileArchivo" name="fileArchivo" class="form-control" required>
                                    </div>

                                    <button type="submit" name="crear-submit" class="btn btn-primary btn-lg float-center">Crear nuevo archivo</button>
                                </div>
                                </div>
				            </div>
                            </form>
				        </div>
			        </div>
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