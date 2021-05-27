<?php
session_start();
require_once 'inc/database.php';
require_once 'inc/functions.php';

if (!isset($_SESSION["fb_access_token"])) // Si no encuentra el access token de la sesión, se enviará a login
{
	header("location: login.php");
}
else // Continuamos a la página
    header( 'Content-Type: text/html; charset=utf-8' );

    // Consulta que muestra todos los datos del archivo
	$url_id = trim(mysqli_real_escape_string($conn,$_GET['id'])); 
    $sql_archivo_id = "SELECT * FROM archivo WHERE archivo_id = '".$url_id."' "; 
    $rs_link_archivo = mysqli_query($conn, $sql_archivo_id) or die ("(1) Problemas al seleccionar ".mysqli_error($conn));
    $row = mysqli_fetch_assoc($rs_link_archivo);
    $archivo_id = $row['link_archivo'];
    $file_path = "files/".$archivo_id;

    $archivo_id_int = $url_id;
    $usuario_id = $_SESSION['usuario_id'];

    $valor_dueno_archivo = comprobar_dueno_archivo($usuario_id,$archivo_id_int);

    // Comprobación si es dueño del archivo y lo tiene pagado
    if($valor_dueno_archivo == 0) {
        // Lo devolvemos a un error 404
        header("Location: https://repositorio.gestionpedagogica.cl/404");
    } else {
        // Enviamos a la ubicación del archivo
        header("Location: https://repositorio.gestionpedagogica.cl/$file_path");
    }
?>