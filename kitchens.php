<?php
require 'includes/preload.php';

if(!empty($_POST['name']) && $user['level'] == 1){

  $addr = $ms->formatAddress(array($_POST['street1'], $_POST['street2'], $_POST['town'], $_POST['county'], $_POST['postcode']));
  $url ="https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($addr)."&sensor=false&components=country:UK&key=".GOOGLE_API;
  $result = json_decode(file_get_contents($url));
  $geocode = $result->results[0]->geometry->location;

  $ka = $db->prepare("INSERT INTO `kitchen`(`name`, `street1`, `street2`, `town`, `county`, `postcode`, `lat`, `lng`, `capacity`, `phone`)
  VALUES (:name, :street1, :street2, :town, :county, :postcode, :lat, :lng, :capacity, :phone)");

  $ka->execute(array(
    ':name' => $_POST['name'],
    ':street1' => $_POST['street1'],
    ':street2' => $_POST['street2'],
    ':town' => $_POST['town'],
    ':county' => $_POST['county'],
    ':postcode' => $_POST['postcode'],
    ':lat' => $geocode->lat,
    ':lng' => $geocode->lng,
    ':capacity' => $_POST['capacity'],
    ':phone' => $_POST['phone']
  ));

}

$page_title = "Kitchens";

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
            <?php if($user['level'] == 1){ ?>
            <a href="#" class="btn btn-sm btn-success btn-icon-split pull-right" data-toggle="modal" data-target="#addKitchenModal">
              <span class="icon text-white-50">
                <i class="fas fa-check"></i>
              </span>
              <span class="text">Add Kitchen</span>
            </a>
            <?php } ?>
          </div>


          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Kitchens</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Address</th>
                      <th>Capacity</th>
                      <th>Active</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($ms->listKitchens() as $k){ ?>
                    <tr>
                      <td><?= $k['name']; ?></td>
                      <td><?= $ms->formatAddress(array($k['street1'], $k['street2'], $k['town'], $k['county'], $k['postcode'])); ?></td>
                      <td><?= $k['capacity']; ?></td>
                      <td><?= ($k['active'] == 1) ? "Yes" : "No"; ?></td>
                      <td><a href="kitchen-edit.php?id=<?= $k['id']; ?>" class="btn btn-sm btn-warning">Edit</a></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
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
  <?php if($user['level'] == 1){ ?>
  <!-- Add Kitchen Modal-->
  <div class="modal fade" id="addKitchenModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <form method="post">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Kitchen</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group row">
              <label for="name" class="col-sm-2 col-form-label">Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" placeholder="Kitchen Name" required>
              </div>
            </div>
            <div class="form-group">
              <label for="street1">Address</label>
              <input type="text" class="form-control" id="street1" name="street1" placeholder="Street 1">
            </div>
            <div class="form-group">
              <input type="text" class="form-control" id="street2" name="street2" placeholder="Street 2">
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <input type="text" class="form-control" id="town" name="town" placeholder="Town">
              </div>
              <div class="form-group col-md-4">
                <input type="text" class="form-control" id="county" name="county" placeholder="County">
              </div>
              <div class="form-group col-md-2">
                <input type="text" class="form-control" id="postcode" name="postcode" placeholder="Postcode" required>
              </div>
              <div class="form-group col-md-6">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone">
              </div>
              <div class="form-group col-md-6">
                <label for="capacity">Capacity</label>
                <input type="text" class="form-control" id="capacity" name="capacity" placeholder="Daily Meal Capacity" required>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-success" type="submit">Add Kitchen</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php } ?>
  <?php include('includes/html-foot.php'); ?>

  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>


</body>

</html>
