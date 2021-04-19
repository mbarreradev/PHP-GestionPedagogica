<?php
session_start();
require_once 'inc/database.php';

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

    // Contador documentos disponibles
	$sql_documentos_disponibles = "SELECT * FROM ordencompra INNER JOIN usuario ON ordencompra.usuario_id=usuario.usuario_id WHERE ordencompra.usuario_id = '".$_SESSION['usuario_id']."' AND estado_orden = 'Pagado' ";  
	$rs_result_documentos_disponibles = mysqli_query($conn, $sql_documentos_disponibles);  
	$cnt_documentos_disponible_total = $rs_result_documentos_disponibles->num_rows;

	// Contador compras realizadas
	$sql_compras_realizadas = "SELECT * FROM ordencompra INNER JOIN usuario ON ordencompra.usuario_id=usuario.usuario_id WHERE ordencompra.usuario_id = '".$_SESSION['usuario_id']."' AND estado_orden = 'Pagado' ";  
	$rs_result_compras_realizadas = mysqli_query($conn, $sql_compras_realizadas);  
	$cnt_compras_realizadas = $rs_result_compras_realizadas->num_rows;

	// Contador ordenes pendientes
	$sql_ordenes_pendientes = "SELECT * FROM ordencompra INNER JOIN usuario ON ordencompra.usuario_id=usuario.usuario_id WHERE ordencompra.usuario_id = '".$_SESSION['usuario_id']."' AND estado_orden = 'Pendiente de confirmación' ";  
	$rs_result_ordenes_pendientes = mysqli_query($conn, $sql_ordenes_pendientes);  
	$cnt_ordenes_pendientes = $rs_result_ordenes_pendientes->num_rows;
    
    // Función para guardar los cambios
	if(isset($_POST['guardarcambios-submit']))
	{
        $usuario = $_SESSION['usuario_id'];

        // Reseteo de variables
        $nombresEstado = $apellidosEstado = $emailEstado = $rutEstado = $dvEstado = $telefonoEstado = $nombresValido = $apellidosValido = $emailValido = $rutValido = $dvValido = $telefonoValido = $nombresErrors = $apellidosErrors = $emailErrors = $rutErrors = $dvErrors = $telefonoErrors = $exitoMsg = NULL;

        //Obtenemos datos para comprobaciones
        $nombresValido = $_POST['Nombres'];
        $apellidosValido = $_POST['Apellidos'];
        $emailValido = $_POST['Email'];
        $rutValido = $_POST['Rut'];
        $dvValido = $_POST['Dv'];
        $telefonoValido = $_POST['Telefono'];

        //Regla Nombres
        if (empty($_POST['Nombres'])) {
            $nombresErrors = "\n Por favor ingrese su nombre."; 
        } elseif (!filter_var($nombresValido, FILTER_SANITIZE_STRING)) {
            $nombresErrors = "\n Sólo se permiten letras y espacios en blanco."; 
        } else {  //Caso verdadero obtenemos datos.
            $nombresEstado = TRUE;
        }

        //Regla Apellidos
        if (empty($_POST['Apellidos'])) {
            $apellidosErrors = "\n Por favor ingrese su apellido."; 
        } elseif (!filter_var($apellidosValido, FILTER_SANITIZE_STRING)) {
            $apellidosErrors = "\n Sólo se permiten letras y espacios en blanco."; 
        } else {  //Caso verdadero obtenemos datos.
            $apellidosEstado = TRUE;
        }

        //Regla email
        if (empty($_POST['Email'])) {
            $emailErrors = "\n Por favor ingrese su correo electrónico. "; 
        } elseif (!filter_var($emailValido, FILTER_VALIDATE_EMAIL)) {
            $emailErrors = "\n Correo electrónico no válido";
        } else { //Caso verdadero obtenemos datos.
            $emailEstado = TRUE;
        }

        //Regla Rut
        if (empty($_POST['Rut'])) {
            $rutErrors = "\n Por favor ingresar su RUT. "; 
        } elseif (!filter_var($rutValido, FILTER_SANITIZE_NUMBER_INT)) {
            $rutErrors = "\n Número no valido";
        } else { //Caso verdadero obtenemos datos.
            $rutEstado = TRUE;
        }

        //Regla Dv
        if (empty($_POST['Dv'])) {
            $dvErrors = "\n !"; 
        } elseif (!filter_var($dvValido, FILTER_SANITIZE_STRING)) {
            $dvErrors = "\n !"; 
        } else {  //Caso verdadero obtenemos datos.
            $dvEstado = TRUE;
        }

        //Regla telefono
        if (empty($_POST['Telefono'])) {
            $telefonoErrors = "\n Por favor ingresar su número de teléfono. "; 
        } elseif (!filter_var($telefonoValido, FILTER_SANITIZE_NUMBER_INT)) {
            $telefonoErrors = "\n Número de teléfono no válido";
        } else { //Caso verdadero obtenemos datos.  
            $telefonoEstado = TRUE;
        }

        // Si todos los campos son validos, entonces se hace la secuencia SQL
        if ($nombresEstado == TRUE && $apellidosEstado == TRUE && $emailEstado == TRUE && $rutEstado == TRUE && $dvEstado == TRUE && $telefonoEstado == TRUE)
        {
            $sql_update_guardarcambios = "UPDATE usuario SET nombres = '$nombresValido', apellidos = '$apellidosValido', correo = '$emailValido', rut = '$rutValido', dv = '$dvValido', telefono = '$telefonoValido' WHERE usuario_id = '$usuario' ";

            if ($conn->query($sql_update_guardarcambios) === TRUE)
            {
                header("Refresh:0");
                // Mensaje de exito
                $resultMsg = "\n <div class='alert alert-success' role='alert'>Formulario enviado con éxito.</div>"; 
            }
            else
            {
                // Mensaje de error
                $resultMsg = "\n <div class='alert alert-danger' role='alert'>Ocurrió un error al enviar el formulario.</div>"; 
            }
            
            $conn->close();
        }
        else
        {
            echo "Error";
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
		<title>Opciones - Gestión Pedagógica</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <link href="css/sidebar.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    	<script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/sidebar.js"></script>
        <script src="js/moment-with-locales.js"></script>
	</head>
<body>
<script>
window.addEventListener("load", pageFullyLoaded, false);

function pageFullyLoaded(e) {
    var dateFormat = 'YYYY-DD-MM HH:mm:ss';
	var registrado_utctime = moment.utc('<?php echo $row_profile_general["registrado_el"]; ?>');
	var registrado_localdate = registrado_utctime.local();
	var registrado_localdate2 = registrado_localdate.locale('es')
	
	var modificardivregistrado = document.getElementById('registrado');
	modificardivregistrado.innerHTML =  moment(registrado_localdate2, "YYYY-MM-DD hh:mm:ss").fromNow();
}
</script>
<div class="page-wrapper chiller-theme toggled">
  <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
    <i class="fas fa-bars"></i>
  </a>
  
  <?php require 'inc/sidebar.php'; ?>

  <main class="page-content">
    <div class="container-fluid">

     	
        
		<div class="d-flex justify-content-between">
        <h4 class="titulo">Mi perfil</h4>
		</div>
		<hr>

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
                            Actualmente esta función no está disponible.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                        </div>
                    </div>
        </div>

		<div class="card profile border-plomo bg-azul-claro">
			<div class="row no-gutters">
				<div class="col-md">
				  	<div class="card-body">
						<div class="row">
							<div class="col-sm">
								<h4><?php echo $row_profile_general["nombres"]; ?> <?php echo $row_profile_general["apellidos"]; ?></h4>
                                Registrado: <span id="registrado"><?php echo $row_profile_general["registrado_el"]; ?></span></br>
								Correo electrónico: <span><?php echo $row_profile_general["correo"]; ?></span></br>
                                <hr class="bg-azul"/>
								Último inicio de sesión: <span id="registrado"><?php echo $row_profile_general["ultimo_iniciosesion"]; ?></span></br>
								Última dirección IP: <span><?php echo $row_profile_general["ultima_ip"]; ?></span>
							</div>             
							<div class="col-sm text-center">
								<div class="row counter-profile">
									<div class="col-sm">
										<div class="Count"><?php echo $cnt_documentos_disponible_total; ?></div>                    
											<p>documentos disponibles</p>
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

        <div class="d-flex justify-content-between mt-3">
			<h4 class="titulo">Opciones</h4>
		</div>
		<hr>

        <?php if (!empty($resultMsg)) {  echo "<span class=estiloError>$resultMsg</span>";  }  ?>

        <form method="post" action="">
        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                <div class="list-group list-group-flush account-settings-links">
                    <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general">General</a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-notifications">Notificaciones</a>
                </div>
                </div>
                <div class="col-md-9">
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="account-general">

                    <div class="card-body media align-items-center">
                        <img class="settings-pic" src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="" class="d-block ui-w-80">
                        <div class="media-body ml-4">
                        Actualmente no está disponible cambiar fotos de perfiles
                        <div class="small mt-1">Extensiones permitidas: JPG, GIF o PNG. Tamaño maximo: 1MB</div>
                        </div>
                    </div>
                    <hr class="border-dark m-0">

                    <div class="card-body">
                        <div class="form-group">
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label class="form-label">Nombres *</label>
                                    <input type="text" name="Nombres" class="form-control mb-1" value="<?php echo $row_profile_general["nombres"]; ?>" maxlength="50">
                                    <?php if (!empty($nombresErrors)) {  echo "<div class='alert alert-danger' role='alert'>$nombresErrors</div>";  }  ?>
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label">Apellidos *</label>
                                    <input type="text" name="Apellidos" class="form-control" value="<?php echo $row_profile_general["apellidos"]; ?>" maxlength="50">
                                    <?php if (!empty($apellidosErrors)) {  echo "<div class='alert alert-danger' role='alert'>$apellidosErrors</div>";  }  ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Correo electrónico *</label>
                            <input type="email" name="Email" class="form-control" value="<?php echo $row_profile_general["correo"]; ?>" maxlength="30">
                            <?php if (!empty($emailErrors)) {  echo "<div class='alert alert-danger' role='alert'>$emailErrors</div>";  }  ?>
                        </div>
                        <div class="form-group">
                            <label class="form-label">RUT *</label>
                            <div class="form-group row">
                                <div class="col-lg-3">
                                    <input type="number" name="Rut" class="form-control" value="<?php echo $row_profile_general["rut"]; ?>" placeholder="RUT" maxlength="8">
                                    <?php if (!empty($rutErrors)) {  echo "<div class='alert alert-danger' role='alert'>$rutErrors</div>";  }  ?>
                                </div>
                                <p class="settings-guion">-</p>
                                <div class="col-lg-1">
                                    <input type="number" name="Dv" class="form-control" value="<?php echo $row_profile_general["dv"]; ?>" placeholder="Dígito verificador" maxlength="1">
                                    <?php if (!empty($dvErrors)) {  echo "<div class='alert alert-danger' role='alert'>$dvErrors</div>";  }  ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Número de teléfono *</label>
                            <input type="number" name="Telefono" class="form-control" value="<?php echo $row_profile_general["telefono"]; ?>" placeholder="Número de teléfono" maxlength="12">
                            <?php if (!empty($telefonoErrors)) {  echo "<div class='alert alert-danger' role='alert'>$telefonoErrors</div>";  }  ?>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Facebook ID vinculado</label>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <input type="number" class="form-control" value="<?php echo $row_profile_general["facebook_id"]; ?>" disabled>
                                </div>
                                <div class="col-lg-3">
                                    <input type="button" class="btn btn-danger full-width" value="Desvincular Facebook" data-toggle="modal" data-target="#desvincularModal">
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="tab-pane fade" id="account-notifications">
                    <div class="card-body pb-2">

                        <h6 class="mb-4">Recursos</h6>

                        <div class="form-group">
                        <label class="switcher">
                            <input type="checkbox" class="switcher-input" checked="">
                            <span class="switcher-indicator">
                            <span class="switcher-yes"></span>
                            <span class="switcher-no"></span>
                            </span>
                            <span class="switcher-label">Notificar cuando una compra sea realizada</span>
                        </label>
                        </div>
                        <div class="form-group">
                        <label class="switcher">
                            <input type="checkbox" class="switcher-input" checked="">
                            <span class="switcher-indicator">
                            <span class="switcher-yes"></span>
                            <span class="switcher-no"></span>
                            </span>
                            <span class="switcher-label">Notificar cuando un recurso sea actualizado</span>
                        </label>
                        </div>
                    </div>
                    <hr class="border-light m-0">
                    <div class="card-body pb-2">

                        <h6 class="mb-4">Gestión Pedagógica</h6>

                        <div class="form-group">
                        <label class="switcher">
                            <input type="checkbox" class="switcher-input" checked="">
                            <span class="switcher-indicator">
                            <span class="switcher-yes"></span>
                            <span class="switcher-no"></span>
                            </span>
                            <span class="switcher-label">Anuncios y novedades</span>
                        </label>
                        </div>
                        <div class="form-group">
                        <label class="switcher">
                            <input type="checkbox" class="switcher-input">
                            <span class="switcher-indicator">
                            <span class="switcher-yes"></span>
                            <span class="switcher-no"></span>
                            </span>
                            <span class="switcher-label">Promociones</span>
                        </label>
                        </div>

                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>

        <div class="text-right mt-3">
            <a href="/perfil"><input type="button" class="btn btn-secondary" value="Volver"></a>
            <input class="btn btn-primary" type="submit" name="guardarcambios-submit" value="Guardar cambios">
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
    <script type="text/javascript">
		var options = {
    valueNames: [ 'tema', 'curso', 'unidad'],
    page: 10,
    pagination: true
	};

	var tablaMatematicasPlanificaciones = new List('nav-matematica-planificacion', options);
	var tablaLenguajePlanificaciones = new List('nav-lenguaje-planificacion', options);
	var tablaTecnologiaPlanificaciones = new List('nav-tecnologia-planificacion', options);
	var tablaMusicaPlanificaciones = new List('nav-musica-planificacion', options);
	var tablaArtesVisualesPlanificaciones = new List('nav-artesvisuales-planificacion', options);

	var tablaMatematicasGuias = new List('nav-matematica-guia', options);
	var tablaLenguajeGuias = new List('nav-lenguaje-guia', options);
	var tablaTecnologiaGuias = new List('nav-tecnologia-guia', options);
	var tablaMusicaGuias = new List('nav-musica-guia', options);
	var tablaArtesVisualesGuias = new List('nav-artesvisuales-guia', options);

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