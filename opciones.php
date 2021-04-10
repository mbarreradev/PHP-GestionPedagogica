<?php
session_start();
require 'inc/database.php';

if (!isset($_SESSION["fb_access_token"])) // Si no encuentra el access token de la sesión, se enviará a login
{
	header("location: login.php");
}
else // Continuamos a la página
	header( 'Content-Type: text/html; charset=utf-8' );
	
	// Consulta para traer los datos de usuario generales
	$sql_datosusuariosgeneral = "SELECT usuario_id, registrado_el, nombres, apellidos, correo, avatar_url, facebook_id, rango, rut, dv, ultimo_iniciosesion, ultima_ip, telefono
	FROM 
		usuario
	WHERE 
		usuario_id = '".$_SESSION['usuario_id']."' "; 
	$rs_resultdatosgeneral = mysqli_query($conn, $sql_datosusuariosgeneral);
    $row_profile_general = mysqli_fetch_assoc($rs_resultdatosgeneral);
    
    // Función para guardar los cambios
	if(isset($_POST['guardarcambios-submit']))
	{
        $usuario = $_SESSION['usuario_id'];

        // Campos
        $nombres = $_POST['Nombres'];
        $nombres_final = filter_var($nombres , FILTER_SANITIZE_STRING);

        $apellidos = $_POST['Apellidos'];
        $apellidos_final = filter_var($apellidos , FILTER_SANITIZE_STRING);

        $email = $_POST['Email'];
        $email_final = filter_var($email , FILTER_SANITIZE_EMAIL);

        $rut = $_POST['Rut'];
        $rut_final = filter_var($rut , FILTER_SANITIZE_NUMBER_INT);

        $dv = $_POST['Dv'];
        $dv_final = filter_var($dv , FILTER_SANITIZE_STRING);

        $telefono = $_POST['Telefono'];
        $telefono_final = filter_var($telefono , FILTER_SANITIZE_NUMBER_INT);


        $sql_update_guardarcambios = "UPDATE usuario SET nombres = '$nombres_final', apellidos = '$apellidos_final', correo = '$email_final', rut = '$rut_final', dv = '$dv_final', telefono = '$telefono_final' WHERE usuario_id = '$usuario' ";

        if ($conn->query($sql_update_guardarcambios) === TRUE)
		{
            // Refrescamos la página
		    header("Refresh:0");
        }
        else
        {
            echo "Error sql log." . $sql_update_guardarcambios . "<br>" . $conn->error;
            //echo "Error sql log.";
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

		<title>Gestión Pedagógica</title>

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
		<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Hola <?php echo $row_profile_general["nombres"]; ?></button>
		<div class="dropdown-menu" aria-labelledby="dropdownMenu1">
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
			<span class="titulo">Opciones de Mi Perfil</span>

            <div class="btn-group dropup btn-block options">
			<a href="/perfil"><button type="button" class="btn btn-primary"><span class="material-icons">person</span> Volver al perfil</button></a>
			</div>
        </h4>
		
			<div class="card mb-3 profile border-plomo">
			  <div class="row no-gutters">
				<div class="col-md-4 margin-top">
                    <div class="card mb-3">
                        <div class="card-body bg-azul-claro">
				  <img src="<?php echo $row_profile_general["avatar_url"]; ?>" class="card-img profile">
                    <h4 class="titulo"><?php echo $row_profile_general["nombres"]; ?> <?php echo $row_profile_general["apellidos"]; ?></h4>
                    <p class="titulo"><strong>Registrado el:</strong> <?php echo $row_profile_general["registrado_el"]; ?></p>
                    <p class="titulo"><strong>Último inicio de sesión:</strong> <?php echo $row_profile_general["ultimo_iniciosesion"]; ?></p>
                    <p class="titulo"><strong>Última dirección IP:</strong> <?php echo $row_profile_general["ultima_ip"]; ?></p>
                    </div>
                    </div>
				</div>
				<div class="col-md-8">
				  <div class="card-body">
				  

            <div class="row">
                <div class="col-sm">
                <h4 class="titulo">Datos del perfil</h4>

                <div class="modal fade" id="desvincularModal" tabindex="-1" role="dialog" aria-labelledby="desvincularModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header bg-azul">
                            <h5 class="modal-title" id="desvincularModalLabel">Importante</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Actualmente esta función no esta disponible.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                        </div>
                    </div>
                </div>

                    <form method="post" action="">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Nombre</label>
                            <div class="col-lg-9">
                                <input class="form-control" type="text" name="Nombres" value="<?php echo $row_profile_general["nombres"]; ?>" maxlength="50" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Apellido</label>
                            <div class="col-lg-9">
                                <input class="form-control" type="text" name="Apellidos" value="<?php echo $row_profile_general["apellidos"]; ?>" maxlength="50" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Correo electrónico</label>
                            <div class="col-lg-9">
                                <input class="form-control" type="email" name="Email" value="<?php echo $row_profile_general["correo"]; ?>" maxlength="30" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">RUT</label>
                            <div class="col-lg-6">
                                <input class="form-control" type="number" name="Rut" value="<?php echo $row_profile_general["rut"]; ?>" placeholder="RUT" maxlength="8" required>
                            </div>
                            <div class="col-lg-3">
                                <input class="form-control" type="text" name="Dv" value="<?php echo $row_profile_general["dv"]; ?>" placeholder="Digito verificador" maxlength="1" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Número de teléfono</label>
                            <div class="col-lg-9">
                                <input class="form-control" type="number" name="Telefono" value="<?php echo $row_profile_general["telefono"]; ?>" placeholder="Número de teléfono" maxlength="12" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Facebook ID vinculado</label>
                            <div class="col-lg-6">
                                <input class="form-control" type="number" value="<?php echo $row_profile_general["facebook_id"]; ?>" disabled>
                            </div>
                            <div class="col-lg-3">
                            <input type="button" class="btn btn-danger full-width" value="Desvincular Facebook" data-toggle="modal" data-target="#desvincularModal">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label"></label>
                            <div class="col-lg-9">
                                <a href="/perfil"><input type="button" class="btn btn-secondary" value="Volver"></a>
                                <input class="btn btn-primary" type="submit" name="guardarcambios-submit" value="Guardar cambios">
                            </div>
                        </div>
                    </form>



                </div>
            </div>
				  
				  
				  </div>
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