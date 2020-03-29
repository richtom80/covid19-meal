<?php
require 'includes/preload.php';

if(!empty($_POST)){

  $ke = $db->prepare("UPDATE `kitchen` SET `active` = :active, `street1` = :street1, `street2` = :street2, `town` = :town, `county` = :county, `postcode` = :postcode, `capacity` = :capacity, `phone` = :phone
  WHERE `id` = :id");

  $ke->execute(array(
    ':active' => $_POST['active'],
    ':street1' => $_POST['street1'],
    ':street2' => $_POST['street2'],
    ':town' => $_POST['town'],
    ':county' => $_POST['county'],
    ':postcode' => $_POST['postcode'],
    ':capacity' => $_POST['capacity'],
    ':phone' => $_POST['phone'],
    ':id' => $_POST['id']
  ));

  header("Location: kitchens.php");

}

$k = $ms->getKitchen($_GET['id']);

$page_title = "Edit Kitchen";

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
              <h6 class="m-0 font-weight-bold text-primary">Edit - <?= $k['name']; ?></h6>
            </div>
            <div class="card-body">
              <form method="post">
                <input type="hidden" name="id" value="<?= $_GET['id']; ?>">
                <div class="form-group row">
                  <label for="name" class="col-sm-2 col-form-label">Name</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Kitchen Name" readonly value="<?= $k['name']; ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="name" class="col-sm-2 col-form-label">Active</label>
                  <div class="col-sm-10">
                    <select name="active" class="form-control">
                      <option value="1" <?php if($k['active'] == 1) echo "selected"; ?>>Yes</option>
                      <option value="0" <?php if($k['active'] == 0) echo "selected"; ?>>No</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="street1">Address</label>
                  <input type="text" class="form-control" id="street1" name="street1" placeholder="Street 1" value="<?= $k['street1']; ?>">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" id="street2" name="street2" placeholder="Street 2" value="<?= $k['street2']; ?>">
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="town" name="town" placeholder="Town" value="<?= $k['town']; ?>">
                  </div>
                  <div class="form-group col-md-4">
                    <input type="text" class="form-control" id="county" name="county" placeholder="County" value="<?= $k['county']; ?>">
                  </div>
                  <div class="form-group col-md-2">
                    <input type="text" class="form-control" id="postcode" name="postcode" placeholder="Postcode" required  value="<?= $k['postcode']; ?>">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone"  value="<?= $k['phone']; ?>">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="capacity">Capacity</label>
                    <input type="text" class="form-control" id="capacity" name="capacity" placeholder="Daily Meal Capacity" required  value="<?= $k['capacity']; ?>">
                  </div>
                </div>
                <button type="submit" class="btn btn-success">Update</button>
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
