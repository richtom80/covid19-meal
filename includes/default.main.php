<?php

// setup database link
try {
    $db = new PDO('mysql:host=localhost;dbname=dbname', 'dbuser', 'dbpass');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

define('SITE_NAME', "COVID-19 Meal Delivery");
define('COMPANY', "Your Company");  
define('DOMAIN', "https://your.domain.name");
define('GOOGLE_API', "google-api-key-for-geocode");
define('GOOGLE_API_JS', "google-api-key-for-js-map");
