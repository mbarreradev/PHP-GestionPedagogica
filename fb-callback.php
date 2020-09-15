<?php
session_start();

require 'inc/conexion.php';
require_once "inc/Facebook/autoload.php";

$fb = new Facebook\Facebook([
  'app_id' => '686939815406136',
  'app_secret' => '9d7865e642ef945605669e8398bc2097',
  'default_graph_version' => 'v3.2',
  ]);

$helper = $fb->getRedirectLoginHelper();

try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (! isset($accessToken)) {
  if ($helper->getError()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
  } else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad request';
  }
  exit;
}

$oAuth2Client = $fb->getOAuth2Client();
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
$tokenMetadata->validateAppId('686939815406136');
$tokenMetadata->validateExpiration();

if (! $accessToken->isLongLived()) {
  try {
    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
  } catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
    exit;
  }
}

$_SESSION['fb_access_token'] = (string) $accessToken;

// Obtenemos los datos de facebook para usar $userNode

$fb->setDefaultAccessToken($_SESSION['fb_access_token']);

try 
{
$response = $fb->get('/me?fields=id,name,email,picture.width(300).height(300),first_name,last_name');
$userNode = $response->getGraphUser();
		
} catch(Facebook\Exceptions\FacebookResponseException $e) 
{
	echo 'Graph returned an error: ' . $e->getMessage();
	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) 
{
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
	exit;
}

// obtenemos el facebook id y lo guardamos en la sesión
$facebook_id = $userNode->getId();
$_SESSION['facebook_id'] = $userNode->getId();

// Verificamos si existe una cuenta
$sql_checkifexists_usuario = "SELECT facebook_id from usuario WHERE facebook_id = '$facebook_id' ";
$rs_check = mysqli_query($conn, $sql_checkifexists_usuario) or die ("(2) Problemas al seleccionar ".mysqli_error($conn));

// Si $sql_checkifexists_usuario retorna más de 0 columnas es que encontro el usuario, si no, se creará en la db el usuario
if(mysqli_num_rows($rs_check) > 0)
{
	// Guardamos el usuario_id en la sesión
	$sql_selectusuarioid1 = "SELECT usuario_id from usuario WHERE facebook_id = '$facebook_id' ";
		
  $rs_usuario_id = mysqli_query($conn, $sql_selectusuarioid1) or die ("(1) Problemas al seleccionar ".mysqli_error($conn));

  // Se guarda en un variable el usuario_id
  $row = mysqli_fetch_assoc($rs_usuario_id);
  // Guardamos el usuario_id del usuario en una variable
  $usuario_id = $row['usuario_id'];
    
  // Guardamos usuario_id y rango en la sesión
  $_SESSION['usuario_id'] = $usuario_id;
  $_SESSION['rango'] = '0';
  $ultimo_iniciosesion1 = date("Y-m-d H:i:s");

  // ACTUALIZAMOS ULTIMA IP E INICIO DE SESION
  if (getenv('HTTP_X_FORWARDED_FOR')) { 
    $pipaddress = getenv('HTTP_X_FORWARDED_FOR');
    $ipaddress = getenv('REMOTE_ADDR'); 
    $ultima_ip1 = $ipaddress;
  } 
  else 
  { 
    $ipaddress = getenv('REMOTE_ADDR'); 
    $ultima_ip1 = $ipaddress; 
  }

  // Consulta que actualiza el valor del estado de la orden
  $sql_update_lastiniciosesionyip = "UPDATE usuario SET ultimo_iniciosesion = '".$ultimo_iniciosesion1."', ultima_ip = '".$ultima_ip1."' WHERE usuario_id = '".$usuario_id."' "; 

  if ($conn->query($sql_update_lastiniciosesionyip) === TRUE) 
  {
    // Enviamos al usuario devuelta a la página de usuario
	header('Location: https://repositorio.gestionpedagogica.cl/perfil');
  }
	
	
}
else // si no encuentra el usuario, entonces creamos cuenta nueva
{
	// Valores
	$registrado_el = date("Y-m-d H:i:s");
	$nombres = $userNode->getFirstname();
	$apellidos = $userNode->getLastname();
	$correo = $userNode->getEmail();
	$usuario_imagen = $userNode->getPicture();
    $avatar_url = $usuario_imagen['url'];
    $rango = '0';
    $ultimo_iniciosesion2 = date("Y-m-d H:i:s");


  if (getenv('HTTP_X_FORWARDED_FOR')) { 
    $pipaddress = getenv('HTTP_X_FORWARDED_FOR');
    $ipaddress = getenv('REMOTE_ADDR'); 
    $ultima_ip2 = $ipaddress;
  } 
  else 
  { 
    $ipaddress = getenv('REMOTE_ADDR'); 
    $ultima_ip2 = $ipaddress; 
  }
				
	$sql1 = "INSERT INTO usuario (usuario_id, registrado_el, nombres, apellidos, correo, avatar_url, facebook_id, rango, ultimo_iniciosesion, ultima_ip) VALUES (DEFAULT, '$registrado_el', '$nombres', '$apellidos', '$correo', '$avatar_url', '$facebook_id', '$rango', '$ultimo_iniciosesion2', '$ultima_ip2')";

	if ($conn->query($sql1) === TRUE) 
	{
		// Seleccionamos el usuario_id
		$sql_selectusuarioid2 = "SELECT usuario_id from usuario WHERE facebook_id = '$facebook_id' ";
		
    $rs_usuario_id = mysqli_query($conn, $sql_selectusuarioid2) or die ("(1) Problemas al seleccionar ".mysqli_error($conn));

    // Se guarda en un variable el usuario_id
    $row = mysqli_fetch_assoc($rs_usuario_id);
    // Guardamos el usuario_id del usuario en una variable
    $usuario_id = $row['usuario_id'];
		// Guardamos usuario_id y rango en la sesión
    $_SESSION['usuario_id'] = $usuario_id;
    $_SESSION['rango'] = '0';
		
		// Enviamos al usuario devuelta a la página de usuario
		header('Location: https://repositorio.gestionpedagogica.cl/perfil');
	}
	else
	{
		echo "Error sql log.";
		//echo "Error sql log." . $sql1 . "<br>" . $conn->error;
	}
}

mysqli_close($conn);
?>