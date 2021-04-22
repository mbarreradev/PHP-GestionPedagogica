<?php
session_start();
require_once 'inc/database.php';

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
    $sql_datosusuariosgeneral = "SELECT nombres, apellidos, rango, avatar_url
    FROM 
        usuario
    WHERE 
        usuario_id = '".$_SESSION['usuario_id']."' "; 
    $rs_resultdatosgeneral = mysqli_query($conn, $sql_datosusuariosgeneral);
    $row_profile_general = mysqli_fetch_assoc($rs_resultdatosgeneral);

    // BOX: Ordenes pendientes de confirmación
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos
	$sql_pendientes_confirmacion = "SELECT ordencompra.ordencompra_id, ordencompra.usuario_id, ordencompra.fecha_compra, ordencompra.fecha_actualizacion, ordencompra.estado_orden, ordencompra.pagado, usuario.nombres, usuario.apellidos, usuario.rut, usuario.dv, archivo.nombre, archivo.asignatura, archivo.curso, archivo.unidad, archivo.tipo, archivo.precio
	FROM 
		ordencompra
    INNER JOIN 
		usuario
	ON
		ordencompra.usuario_id=usuario.usuario_id
	INNER JOIN 
		archivo
	ON
		ordencompra.archivo_id=archivo.archivo_id
	WHERE 
        ordencompra.estado_orden = 'Pendiente de confirmación'
	ORDER BY ordencompra_id ASC"; 
    $rs_result_pendientes_confirmacion = mysqli_query($conn, $sql_pendientes_confirmacion);

    // Contador de ordenes pendientes de confirmación
	$cnt_ordenes_pendientes_confirmacion = $rs_result_pendientes_confirmacion->num_rows;
    

    // ORDENES
	// Primero entramos a la tabla ordencompra y luego archivo para sacar los datos requeridos
	$sql_otras_ordenes = "SELECT ordencompra.ordencompra_id, ordencompra.usuario_id, ordencompra.fecha_actualizacion, ordencompra.estado_orden, ordencompra.pagado, usuario.nombres, usuario.apellidos
	FROM 
        ordencompra
    INNER JOIN 
		archivo
	ON
		ordencompra.archivo_id=archivo.archivo_id
    INNER JOIN 
		usuario
	ON
		ordencompra.usuario_id=usuario.usuario_id
	WHERE 
		ordencompra.estado_orden != 'Pendiente de confirmación'
	ORDER BY ordencompra.ordencompra_id DESC"; 
	$rs_result_otras_ordenes = mysqli_query($conn, $sql_otras_ordenes);

    // Contador ordenes creadas
    $sql_ordenes_creadas = "SELECT * FROM ordencompra";  
	$rs_result_ordenes_creadas = mysqli_query($conn, $sql_ordenes_creadas);  
    $cnt_ordenes_creadas = $rs_result_ordenes_creadas->num_rows;
    
    // Contador odenes pagadas
    $sql_ordenes_pagadas = "SELECT * FROM ordencompra WHERE estado_orden = 'Pagado'";  
	$rs_result_ordenes_pagadas = mysqli_query($conn, $sql_ordenes_pagadas);  
	$cnt_ordenes_pagadas = $rs_result_ordenes_pagadas->num_rows;

    // Funcion que aprueba la orden
	if(isset($_POST['aprobarorden-submit']))
	{
		$usuario = $row_profile_general['nombres']." ".$row_profile_general['apellidos'];
		$fecha_actualizacion = date("Y-m-d H:i:s");
		$ordencompraid =  $_POST["ordenvalue"];

		// Consulta que actualiza el valor del estado de la orden
		$sql_update_ordencompra = "UPDATE ordencompra SET estado_orden = 'Pagado', fecha_actualizacion = '".$fecha_actualizacion."' WHERE ordencompra_id = '".$ordencompraid."' "; 

		if ($conn->query($sql_update_ordencompra) === TRUE) 
		{
			// Consulta que crea el historial de la orden
			$sql_create_ordencompra_historial= "INSERT INTO ordencompra_historial (historial_id, ordencompra_id, fecha_creacion, accion) VALUES (DEFAULT, '$ordencompraid', '$fecha_actualizacion', '".$usuario." modificó la orden a Pagado')"; 
			
			if ($conn->query($sql_create_ordencompra_historial) === TRUE) 
			{
				// Refrescamos la página
				header("Refresh:0");
			}
			else
			{
				//echo "Error updating record: " . $conn->error;
				echo "Error sql update 2.";
			}
		} 
		else 
		{
			//echo "Error updating record: " . $conn->error;
			echo "Error sql update 1.";
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
		<title>Ordenes - Gestión Pedagógica</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" rel="stylesheet">
        <link href="css/sidebar.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    	<script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/sidebar.js"></script>
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
            <h4 class="titulo">Estadísticas</h4>
            <div class="btn-group dropup btn-block options">
                <a href="/administracion"><button type="button" class="btn btn-primary"><i class="fa fa-tachometer-alt"></i> Volver a la administración</button></a>
            </div>
        </div>
        <hr>

		<div class="container mb-4">
			<div class="row">
				<div class="col-sm-4 nopadding-left">
                    <div class="card border-plomo">
						<div class="card-body bg-rosado-especial text-white">
							<div class="row">
								<div class="col-3">
									<span class="material-icons stats">queue</span>
								</div>
								<div class="col-9 text-right">
									<div class="Count"><?php echo $cnt_ordenes_pendientes_confirmacion; ?></div>
									<h4>ordenes pendientes</h4>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="card border-plomo">
						<div class="card-body bg-naranjo-especial text-white">
							<div class="row">
								<div class="col-3">
									<span class="material-icons stats">library_books</span>
								</div>
								<div class="col-9 text-right">
									<div class="Count"><?php echo $cnt_ordenes_creadas; ?></div>
									<h4>ordenes creadas</h4>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-4 nopadding-right">
                    <div class="card border-plomo">
						<div class="card-body bg-azul-especial text-white">
							<div class="row">
								<div class="col-3">
									<span class="material-icons stats">library_add_check</span>
								</div>
								<div class="col-9 text-right">
									<div class="Count"><?php echo $cnt_ordenes_pagadas; ?></div>
									<h4>ordenes pagadas</h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

        <div class="d-flex justify-content-between mb-3">
        <h4 class="titulo">Ordenes pendientes de confirmación</h4>
		</div>

        <section id="tabs" class="project-tab">
                <div class="row">
                    <div class="col-md-12" id="nav-ordenes-pendientes">
                                <div class="buscador arriba">
									<input type="search" class="search form-control" placeholder="Puedes buscar por ID, usuario, monto pagado o estado"/>
								</div>
                                <table id="tabla-ordenes-pendientes" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
											<th class="sort" data-sort="id">Orden ID</th>
                                            <th class="sort" data-sort="creado">Creado por</th>
                                            <th class="sort" data-sort="pagado">Monto</th>
											<th class="sort" data-sort="estado">Estado</th>
                                            <th>Última actualización</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_pendientes_confirmacion)) {
										$precio_archivo = number_format($row['precio'],0, '', '.');
										$valor_pagado = number_format($row['pagado'],0, '', '.');
										?>	


											<!-- Modal orden <?php echo $row['ordencompra_id']; ?> -->
											<div class="modal fade" id="verorden<?php echo $row['ordencompra_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="verorden<?php echo $row['ordencompra_id']; ?>Label" aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header bg-azul">
															<h5 class="modal-title" id="verorden<?php echo $row['ordencompra_id']; ?>Label">Viendo orden <?php echo $row['ordencompra_id']; ?></h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
															<p><strong>Creado por:</strong> <?php echo $row['nombres']." ".$row['apellidos']; ?> - <a href="/verperfil?id=<?php echo $row['usuario_id']; ?>">Ver perfil</a></p>
															<p><strong>Fecha de creación de compra:</strong> <?php echo $row['fecha_compra']; ?></p>
															<p><strong>Archivo:</strong> <?php echo $row['nombre']; ?></p>
															<p><strong>Asignatura:</strong> <?php echo $row['asignatura']." ".$row['curso']; ?></p>
															<p><strong>Valor del archivo:</strong> $<?php echo $precio_archivo; ?></p>
															<hr class="bg-azul"/>
															<p><strong>DETALLES DE LA TRANSFERENCIA</strong></p>
															<p><strong>Rut:</strong> <?php echo $row['rut']."-".$row['dv']; ?></p>
															<p><strong>Pagado:</strong> $<?php echo $valor_pagado; ?></p>
															<p><strong>Comentario de la transferencia:</strong> Pago Orden <?php echo $row['ordencompra_id']; ?></p>
															<hr class="bg-azul"/>
															<p><strong>Última actualización:</strong> <?php echo $row['fecha_actualizacion']; ?></p>
															<p><strong>Estado de la orden:</strong> <?php echo $row['estado_orden']; ?></p>
															
															<?php

															if($row['estado_orden'] === 'Pendiente de confirmación')
															{
																echo '<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Recuerda</strong> verificar el RUT y el número de orden en el comentario de la transferencia antes de aprobar una orden.</div>';
															}
															else
															{
																echo 'Aprobado';
															}

															?>
														
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
															<form method="post">
															<input type="hidden" name="ordenvalue" value="<?php echo $row['ordencompra_id']; ?>" />
															<button class="btn btn-primary" name="aprobarorden-submit" type="submit">Aprobar orden</button>
															</form>
														</div>
													</div>
												</div>
											</div>



											<tr>
												<td class="id"><?php echo $row['ordencompra_id']; ?></td>
												<td class="creado"><a href="/verperfil?id=<?php echo $row['usuario_id']; ?>"><?php echo $row['nombres']." ".$row['apellidos']; ?></a></td>
												<td class="pagado">$<?php echo $valor_pagado; ?></td>
												<td class="estado"><?php echo $row['estado_orden']; ?></td>
                                                <td><?php echo $row['fecha_actualizacion']; ?></td>
												<td>
												<button class="btn btn-info tabla" data-toggle="modal" data-target="#verorden<?php echo $row['ordencompra_id']; ?>"><i class="fas fa-folder"></i> Ver orden</button>
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
        </section>

        <div class="d-flex justify-content-between mt-3 mb-3">
			<h4 class="titulo">Otras ordenes</h4>
		</div>

        <section id="tabs" class="project-tab">
                <div class="row">
                    <div class="col-md-12" id="nav-otras-ordenes">
								<div class="buscador">
									<input type="search" class="search form-control" placeholder="Puedes buscar por ID, usuario, monto pagado o estado"/>
								</div>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-light" id="filter-none-otras-ordenes">Ver todos</button>
                                    <button type="button" class="btn btn-light" id="filter-pendiente-pago-otras-ordenes">Pendiente de Pago</button>
                                    <button type="button" class="btn btn-light" id="filter-pagado-otras-ordenes">Pagado</button>
                                </div>
                                <table id="tabla-otras-ordenes" class="table" cellspacing="0">
                                    <thead>
										<tr class="bg-azul">
                                            <th class="sort" data-sort="id">Orden ID</th>
                                            <th class="sort" data-sort="creado">Creado por</th>
                                            <th class="sort" data-sort="pagado">Monto</th>
											<th class="sort" data-sort="estado">Estado</th>
                                            <th>Última actualización</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="list limpio">
                                        <?php while ($row = mysqli_fetch_assoc($rs_result_otras_ordenes)) {
										$pagado_final = number_format($row['pagado'],0, '', '.');	
										?>	

											<tr>
                                                <td class="id"><?php echo $row['ordencompra_id']; ?></td>
												<td class="creado"><a href="/verperfil?id=<?php echo $row['usuario_id']; ?>"><?php echo $row['nombres']." ".$row['apellidos']; ?></a></td>
												<td class="pagado">$<?php echo $pagado_final; ?></td>
												<td class="estado"><?php echo $row['estado_orden']; ?></td>
                                                <td><?php echo $row['fecha_actualizacion']; ?></td>
												<td>
												<button class="btn btn-info tabla" data-toggle="modal" data-target="#verorden<?php echo $row['ordencompra_id']; ?>"><i class="fas fa-folder"></i> Ver orden</button>
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
        </section>

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
    valueNames: [ 'id', 'usuario', 'correo', 'rango', 'estado'],
    page: 10,
    pagination: true
	};

	var tablaOrdenesPendientes = new List('nav-ordenes-pendientes', options);
	var tablaOtrasOrdenes = new List('nav-otras-ordenes', options);

    $('#filter-pendiente-pago-otras-ordenes').click(function() {
    tablaOtrasOrdenes.filter(function(item) {
        if (item.values().estado == "Pendiente de pago") {
        return true;
        } else {
        return false;
        }
    });
    return false;
    });

    $('#filter-pagado-otras-ordenes').click(function() {
    tablaOtrasOrdenes.filter(function(item) {
        if (item.values().estado == "Pagado") {
        return true;
        } else {
        return false;
        }
    });
    return false;
    });

    $('#filter-none-otras-ordenes').click(function() {
    tablaOtrasOrdenes.filter();
    return false;
    });

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