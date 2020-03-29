<?php
require 'vendor/autoload.php';
require 'includes/main.php';

use PHPAuth\Config as PHPAuthConfig;
use PHPAuth\Auth as PHPAuth;

$config = new PHPAuthConfig($db);
$auth = new PHPAuth($db, $config);

$user = $auth->getCurrentUser();
if(!$user){
  header("Location: /login.php");
  die();
}

if(!empty($_POST)){

  $address = "";
  if(!empty($_POST['street1'])){ $addr[] = $_POST['street1']; }
  if(!empty($_POST['street2'])){ $addr[] = $_POST['street2']; }
  if(!empty($_POST['town'])){ $addr[] = $_POST['town']; }
  if(!empty($_POST['county'])){ $addr[] = $_POST['county']; }
  if(!empty($_POST['postcode'])){ $addr[] = $_POST['postcode']; }
  foreach($addr as $r){
    $address .= $r.", ";
  }
  $address = substr($address, 0, -2);

  $url ="https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($address)."&sensor=false&components=country:UK&key=".GOOGLE_API;
  $result = json_decode(file_get_contents($url));
  $geocode = $result->results[0]->geometry->location;

  $r = $db->prepare("INSERT INTO `sites`(`name`, `surname`, `street1`, `street2`, `town`, `county`, `postcode`,
    `lat`, `lng`, `phone`, `std_meal`, `veg_meal`, `delivery_instructions`,
     `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `sun`, `date_added`, `type`, `added_by`)
  VALUES (:name, :surname, :street1, :street2, :town, :county, :postcode,
    :lat, :lng, :phone, :std_meal, :veg_meal, :delivery_instructions,
    :mon, :tue, :wed, :thu, :fri, :sat, :sun, NOW(), :type, :added_by);");
  $r->execute(array(
    ':name' => $_POST['name'],
    ':surname' =>  $_POST['surname'],
    ':street1' =>  $_POST['street1'],
    ':street2' =>  $_POST['street2'],
    ':town' =>  $_POST['town'],
    ':county' =>  $_POST['county'],
    ':postcode' =>  $_POST['postcode'],
    ':lat' => $geocode->lat,
    ':lng' => $geocode->lng,
    ':phone' =>  $_POST['phone'],
    ':std_meal' =>  $_POST['standard-meal'],
    ':veg_meal' =>  $_POST['veggie-meal'],
    ':delivery_instructions' =>  $_POST['delivery-instructions'],
    ':mon' => $_POST['mon'],
    ':tue' => $_POST['tue'],
    ':wed' => $_POST['wed'],
    ':thu' => $_POST['thu'],
    ':fri' => $_POST['fri'],
    ':sat' => $_POST['sat'],
    ':sun' => $_POST['sun'],
    ':type' => $_POST['type'],
    ':added_by' => $user['id']
  ));

  if($r){
    $message = "<strong>Added</strong> {$_POST['name']} {$_POST['surname']}";
  }
}
?><!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?= SITE_NAME; ?> - Register</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link rel="shortcut icon" type="image/png" href="<?= DOMAIN; ?>favicon-32x32.png">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Register</h1>
                <p>Helping our vulnerable members of the community with assistance during the COVID-19 pandemic.</p>
                <?php if(!empty($message)){ echo "<div class='alert alert-success'>$message</div>"; } ?>
              </div>
              <form class="user" method="post">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control" name="name" placeholder="First Name">
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="surname" placeholder="Last Name">
                  </div>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="street1" placeholder="Street Address 1">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="street2" placeholder="Street Address 2">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="town" placeholder="Town">
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control" name="county" placeholder="County" value="Kent">
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="postcode" placeholder="Postcode">
                  </div>
                </div>
                <div class="form-group row meal-row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" name="phone" class="form-control" placeholder="Phone Number">
                  </div>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <select class="form-control" name="type">
                      <option value="elderly">Elderly</option>
                      <option value="high-risk">High Risk</option>
                      <option value="key-line">Key Line Worker</option>
                      <option value="family">Family</option>
                    </select>
                  </div>

                </div>
                <div class="form-group row meal-row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control" value="Standard Meals" readonly>
                  </div>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="number" name="standard-meal" class="form-control">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control" value="Veggie Meals" readonly>
                  </div>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="number" name="veggie-meal" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <textarea rows="2" class="form-control" name="delivery-instructions" placeholder="Delivery Instructions"></textarea>
                </div>
                <div class="form-group row">
                  <div class="custom-control custom-checkbox small col-sm-2 mb-3 mb-sm-0">
                    <input type="checkbox" class="custom-control-input" id="mon" name="mon" value="1" checked>
                    <label class="custom-control-label" for="mon">Mon</label>
                  </div>
                  <div class="custom-control custom-checkbox small col-sm-2 mb-3 mb-sm-0">
                    <input type="checkbox" class="custom-control-input" id="tue" name="tue" value="1" checked>
                    <label class="custom-control-label" for="tue">Tue</label>
                  </div>
                  <div class="custom-control custom-checkbox small col-sm-2 mb-3 mb-sm-0">
                    <input type="checkbox" class="custom-control-input" id="wed" name="wed" value="1" checked>
                    <label class="custom-control-label" for="wed">Wed</label>
                  </div>
                  <div class="custom-control custom-checkbox small col-sm-2 mb-3 mb-sm-0">
                    <input type="checkbox" class="custom-control-input" id="thu" name="thu" value="1" checked>
                    <label class="custom-control-label" for="thu">Thu</label>
                  </div>
                  <div class="custom-control custom-checkbox small col-sm-2 mb-3 mb-sm-0">
                    <input type="checkbox" class="custom-control-input" id="fri" name="fri" value="1" checked>
                    <label class="custom-control-label" for="fri">Fri</label>
                  </div>
                  <div class="custom-control custom-checkbox small col-sm-2 mb-3 mb-sm-0">
                    <input type="checkbox" class="custom-control-input" id="sat" name="sat" value="1" checked>
                    <label class="custom-control-label" for="sat">Sat</label>
                  </div>
                  <div class="custom-control custom-checkbox small col-sm-2 mb-3 mb-sm-0">
                    <input type="checkbox" class="custom-control-input" id="sun" name="sun" value="1" checked>
                    <label class="custom-control-label" for="sun">Sun</label>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block">
                  Register Vulnerable Person
                </button>
              </form>
              <hr>
              <div class="text-center"><a href="/">Home</a></div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <script>
  $(function() {

  });
  </script>

</body>

</html>
