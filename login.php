<?php
require 'vendor/autoload.php';
require 'includes/main.php';

use PHPAuth\Config as PHPAuthConfig;
use PHPAuth\Auth as PHPAuth;

$config = new PHPAuthConfig($db);
$auth = new PHPAuth($db, $config);

if(!empty($_POST['email']) && !empty($_POST['password'])){
  $login = $auth->login($_POST['email'], $_POST['password'], $_POST['remember-me']);
  if(empty($login['error'])){
    header("Location: /");
  }
}

?><!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="<?= COMPANY; ?> Waste Management System by IT Desk">
  <meta name="author" content="ITDesk.io">

  <title>Log in · <?= SITE_NAME; ?></title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link rel="shortcut icon" type="image/png" href="<?= DOMAIN; ?>favicon-32x32.png">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4"><?= SITE_NAME; ?></h1>
                    <p>Welcome to the <?= COMPANY; ?> protal, by logging into the system you agree to our <a href="terms.php">usage terms and conditions</a>.</p>
                    <?php if(!empty($_GET['msg']) || !empty($login['message'])){ ?>
                      <div class="alert <?= (!empty($_GET['error'] || $login['error'] == 1) ? 'alert-danger' : 'alert-success'); ?>">
                        <?php
                        if(!empty($login['message'])){ echo "<strong>Error</strong> {$login['message']}"; }
                        if($_GET['msg'] == 'activated'){ echo "<strong>Activated</strong> your account. You can now login in."; }
                        if($_GET['msg'] == 'pw-reset'){ echo "<strong>Reset</strong> your password. You can now login in."; }
                        ?>
                      </div>
                    <?php } ?>
                  </div>
                  <form class="user" method="post" action="<?= DOMAIN; ?>/login.php">
                    <div class="form-group">
                      <input type="email" class="form-control form-control-user" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="remember-me" name="remember-me" value="1">
                        <label class="custom-control-label" for="remember-me">Remember Me</label>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Login
                    </button>
                  </form>
                  <hr>
                  <div class="text-center">
                    &copy; <?= COMPANY." ".date('Y'); ?><br>
                    System by <a href="https://itdesk.io" target="_blank">IT Desk</a>
                  </div>
                </div>
              </div>
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

</body>

</html>
