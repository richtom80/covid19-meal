<?php
require 'includes/preload.php';

if(!empty($_POST)){

  $pe = $db->prepare("UPDATE `sites` SET `name`=:name, `surname`=:surname, `street1`=:street1, `street2`=:street2, `town`=:town,
  `county`=:county, `postcode`=:postcode, `phone`=:phone, `std_meal`=:std_meal, `veg_meal`=:veg_meal, `type`=:type,
  `delivery_instructions`=:delivery_instructions, `mon`=:mon, `tue`=:tue, `wed`=:wed, `thu`=:thu, `fri`=:fri, `sat`=:sat, `sun`=:sun
  WHERE `id` = :id");

  $pe->execute(array(
    ':name' => $_POST['name'],
    ':surname' =>  $_POST['surname'],
    ':street1' =>  $_POST['street1'],
    ':street2' =>  $_POST['street2'],
    ':town' =>  $_POST['town'],
    ':county' =>  $_POST['county'],
    ':postcode' =>  $_POST['postcode'],
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
    ':id' => $_POST['id']
  ));

}

$k = $ms->getSite($_GET['id']);

$page_title = "Edit Person";

require 'includes/html-head.php';
?>

      <!-- Main Content -->
      <div id="content">
        <?php include('includes/html-top-bar.php'); ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><?= $page_title; ?></h1>
          </div>


          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Edit - <?= $k['name']." ".$k['surname']; ?></h6>
            </div>
            <div class="card-body">
              <form method="post">
                <input type="hidden" name="id" value="<?= $_GET['id']; ?>">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control" name="name" placeholder="First Name" value="<?= $k['name']; ?>">
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="surname" placeholder="Last Name" value="<?= $k['surname']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="street1" placeholder="Street Address 1" value="<?= $k['street1']; ?>">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="street2" placeholder="Street Address 2" value="<?= $k['street2']; ?>">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="town" placeholder="Town" value="<?= $k['town']; ?>">
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control" name="county" placeholder="County" value="<?= $k['county']; ?>">
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="postcode" placeholder="Postcode" value="<?= $k['postcode']; ?>">
                  </div>
                </div>
                <div class="form-group row meal-row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" name="phone" class="form-control" placeholder="Phone Number" value="<?= $k['phone']; ?>">
                  </div>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <select class="form-control" name="type">
                      <option value="elderly" <?php if($k['type'] == "elderly") echo "selected"; ?>)>Elderly</option>
                      <option value="high-risk" <?php if($k['type'] == "high-risk") echo "selected"; ?>>High Risk</option>
                      <option value="key-line" <?php if($k['type'] == "key-line") echo "selected"; ?>>Key Line Worker</option>
                      <option value="family" <?php if($k['type'] == "family") echo "selected"; ?>>Family</option>
                    </select>
                  </div>

                </div>
                <div class="form-group row meal-row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control" value="Standard Meals" readonly>
                  </div>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="number" name="standard-meal" class="form-control" value="<?= $k['std_meal']; ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control" value="Veggie Meals" readonly>
                  </div>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="number" name="veggie-meal" class="form-control" value="<?= $k['veg_meal']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <textarea rows="2" class="form-control" name="delivery-instructions" placeholder="Delivery Instructions"><?= $k['delivery_instructions']; ?></textarea>
                </div>
                <div class="form-group row">
                  <div class="custom-control custom-checkbox small col-sm-2 mb-3 mb-sm-0">
                    <input type="checkbox" class="custom-control-input" id="mon" name="mon" value="1" <?php if($k['mon'] == 1) echo "checked"; ?>>
                    <label class="custom-control-label" for="mon">Mon</label>
                  </div>
                  <div class="custom-control custom-checkbox small col-sm-2 mb-3 mb-sm-0">
                    <input type="checkbox" class="custom-control-input" id="tue" name="tue" value="1" <?php if($k['tue'] == 1) echo "checked"; ?>>
                    <label class="custom-control-label" for="tue">Tue</label>
                  </div>
                  <div class="custom-control custom-checkbox small col-sm-2 mb-3 mb-sm-0">
                    <input type="checkbox" class="custom-control-input" id="wed" name="wed" value="1" <?php if($k['wed'] == 1) echo "checked"; ?>>
                    <label class="custom-control-label" for="wed">Wed</label>
                  </div>
                  <div class="custom-control custom-checkbox small col-sm-2 mb-3 mb-sm-0">
                    <input type="checkbox" class="custom-control-input" id="thu" name="thu" value="1" <?php if($k['thu'] == 1) echo "checked"; ?>>
                    <label class="custom-control-label" for="thu">Thu</label>
                  </div>
                  <div class="custom-control custom-checkbox small col-sm-2 mb-3 mb-sm-0">
                    <input type="checkbox" class="custom-control-input" id="fri" name="fri" value="1" <?php if($k['fri'] == 1) echo "checked"; ?>>
                    <label class="custom-control-label" for="fri">Fri</label>
                  </div>
                  <div class="custom-control custom-checkbox small col-sm-2 mb-3 mb-sm-0">
                    <input type="checkbox" class="custom-control-input" id="sat" name="sat" value="1" <?php if($k['sat'] == 1) echo "checked"; ?>>
                    <label class="custom-control-label" for="sat">Sat</label>
                  </div>
                  <div class="custom-control custom-checkbox small col-sm-2 mb-3 mb-sm-0">
                    <input type="checkbox" class="custom-control-input" id="sun" name="sun" value="1" <?php if($k['sun'] == 1) echo "checked"; ?>>
                    <label class="custom-control-label" for="sun">Sun</label>
                  </div>
                </div>
                <div class="row">
                  <button type="submit" class="btn btn-success">Update</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; <?= COMPANY; ?></span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <?php include('includes/html-foot.php'); ?>

  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>


</body>

</html>
