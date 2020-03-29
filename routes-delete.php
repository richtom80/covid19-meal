<?php
require 'includes/preload.php';

if(!empty($_GET['id'])){
  $db->query("DELETE FROM `routes` WHERE `id` = {$_GET['id']};");
}
header("Location: routes.php");
