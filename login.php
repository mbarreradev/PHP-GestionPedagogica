<?php
session_start();

// https://evilnapsis.com/2016/02/07/fb-access-login-simple-con-el-facebook-sdk-y-php/
// https://josecunat.com/error-no-se-puede-cargar-la-url-el-dominio-de-esta-url-no-esta-incluido-en-los-dominios-de-la-aplicacion/

require_once "inc/Facebook/autoload.php";

$fb = new Facebook\Facebook([
  'app_id' => '686939815406136', // Replace {app-id} with your app id
  'app_secret' => '9d7865e642ef945605669e8398bc2097',
  'default_graph_version' => 'v3.2',
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email'];

$callbackUrl = htmlspecialchars('https://repositorio.gestionpedagogica.cl/fb-callback.php');
$loginUrl = $helper->getLoginUrl($callbackUrl, $permissions);

header('Location: ' . $loginUrl . ' ');
?>