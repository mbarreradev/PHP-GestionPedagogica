<?php
session_start();
require 'inc/conexion.php';

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
		<script src="https://code.jquery.com/jquery-3.5.0.slim.min.js" integrity="sha256-MlusDLJIP1GRgLrOflUQtshyP0TwT/RHXsI1wWGnQhs=" crossorigin="anonymous"></script>
		<script data-ad-client="ca-pub-2522486668045838" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<script src="js/moment.min.js"></script>
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
		
			<div class="card mb-3 profile border-plomo bg-azul-claro">
			  <div class="row no-gutters">
				<div class="col-md-4">
				  <img src="<?php echo $row_profile_general["avatar_url"]; ?>" class="card-img profile">
                    <h4><?php echo $row_profile_general["nombres"]; ?> <?php echo $row_profile_general["apellidos"]; ?></h4>
                    <span class="tags">Conectado desde Facebook</span>
				</div>
				<div class="col-md-8">
				  <div class="card-body">
				  

            <div class="row">
                <div class="col-sm">
                    

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


                    <form role="form">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Nombre</label>
                            <div class="col-lg-9">
                                <input class="form-control" type="text" value="<?php echo $row_profile_general["nombres"]; ?>" maxlength="50">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Apellido</label>
                            <div class="col-lg-9">
                                <input class="form-control" type="text" value="<?php echo $row_profile_general["apellidos"]; ?>" maxlength="50">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Correo electrónico</label>
                            <div class="col-lg-9">
                                <input class="form-control" type="email" value="<?php echo $row_profile_general["correo"]; ?>" maxlength="30">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">RUT</label>
                            <div class="col-lg-6">
                                <input class="form-control" type="number" value="<?php echo $row_profile_general["rut"]; ?>" placeholder="RUT" maxlength="8">
                            </div>
                            <div class="col-lg-3">
                                <input class="form-control" type="text" value="<?php echo $row_profile_general["dv"]; ?>" placeholder="Digito verificador" maxlength="1">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Número de teléfono</label>
                            <div class="col-lg-9">
                                <input class="form-control" type="number" value="<?php echo $row_profile_general["telefono"]; ?>" placeholder="Número de teléfono" maxlength="12">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Registrado el </label>
                            <div class="col-lg-9">
                                <input class="form-control" type="text" value="<?php echo $row_profile_general["registrado_el"]; ?>" disabled>
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
                            <label class="col-lg-3 col-form-label form-control-label">Último inicio de sesión</label>
                            <div class="col-lg-9">
                                <input class="form-control" type="text" value="<?php echo $row_profile_general["ultimo_iniciosesion"]; ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Última dirección IP</label>
                            <div class="col-lg-9">
                                <input class="form-control" type="text" value="<?php echo $row_profile_general["ultima_ip"]; ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label"></label>
                            <div class="col-lg-9">
                                <input type="reset" class="btn btn-secondary" value="Cancelar">
                                <input type="button" class="btn btn-primary" value="Guardar cambios">
                            </div>
                        </div>
                    </form>



                </div>
            </div>
				  
				  
				  </div>
				</div>
			  </div>
			</div>
			
		<h4 class="d-flex justify-content-between align-items-center mb-3">
			<span class="titulo">Historial del usuario</span>
        </h4>	

		<section id="tabs" class="project-tab">
                <div class="row">
                    <div class="col-md-12">

                            <div id="ordenes-pendientes">
                                <div class="buscador arriba">
									<input type="search" class="search form-control" placeholder="Puedes buscar por ID, usuario, monto pagado o estado"/>
								</div>
                                <table id="tabla-matematica-planificacion" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
											<th class="sort" data-sort="id">Historial ID</th>
                                            <th class="sort" data-sort="fechacreacion">Fecha de creación</th>
                                            <th class="sort" data-sort="accion">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_pendientes_confirmacion)) {?>	

											<tr>
												<td class="id"><?php echo $row['ordencompra_id']; ?></td>
												<td class="fechacreacion"><a href="/verperfil?id="><?php echo $row['nombres']." ".$row['apellidos']; ?></a></td>
												<td class="accion">$<?php echo $row['pagado']; ?></td>
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

	<SCRIPT type="text/javascript">
		var options = {
    valueNames: [ 'tema', 'curso', 'unidad'],
    page: 10,
    pagination: true
	};

	var tablaMatematicasPlanificaciones = new List('nav-matematica-planificacion', options);
	</script>

    <script src="js/bootstrap.bundle.min.js"></script>
	
  </body>
</html>