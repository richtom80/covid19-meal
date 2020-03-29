<?php

require 'vendor/autoload.php';
require 'includes/main.php';
require 'includes/meal-class.php';

use PHPAuth\Config as PHPAuthConfig;
use PHPAuth\Auth as PHPAuth;

$config = new PHPAuthConfig($db);
$auth = new PHPAuth($db, $config);

$user = $auth->getCurrentUser();
$ms = new meal_system($user, $db);

if(!$user){
  header("Location: /login.php");
  die();
}

if($user['level'] == 3){
  header("Location: register.php");
}

if($_GET['logout'] == 1){
  $auth->logout($_COOKIE['phpauth_session_cookie']);
  header("Location: /login.php");
  die();
}
