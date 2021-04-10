<?php
session_start();
require 'inc/database.php';

if (!isset($_SESSION["fb_access_token"])) // Si no encuentra el access token de la sesión, se enviará a login
{
	header("location: login.php");
}
else // Continuamos a la página
    header( 'Content-Type: text/html; charset=utf-8' );

    // Consulta que muestra todos los datos del archivo
	$url_id = trim(mysqli_real_escape_string($conn,$_GET['id'])); 
	$sql_archivo_id = "SELECT link_archivo 
    FROM 
        archivo 
    WHERE 
        archivo_id = '".$url_id."' "; 
    $rs_link_archivo = mysqli_query($conn, $sql_archivo_id) or die ("(1) Problemas al seleccionar ".mysqli_error($conn));
    // Se guarda en un variable el usuario_id
    $row = mysqli_fetch_assoc($rs_link_archivo);
    // Guardamos el ordencompra_id del usuario en una variable
    $archivo_id = $row['link_archivo'];
    //echo $archivo_id;
    //echo "</br>";
    $file_path = "files/".$archivo_id;
    //echo $file_path;

    header("Location: https://repositorio.gestionpedagogica.cl/$file_path");

    // Hacer filtro si tiene acceso al archivo y lo tiene comprado
    
?>