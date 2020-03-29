<?php
require 'includes/preload.php';

if(!empty($_POST['name'])){

  $va = $db->prepare("INSERT INTO `volunteers`(`name`, `street1`, `street2`, `town`, `county`, `postcode`,`phone`)
  VALUES (:name, :street1, :street2, :town, :county, :postcode, :phone)");

  $va->execute(array(
    ':name' => $_POST['name'],
    ':street1' => $_POST['street1'],
    ':street2' => $_POST['street2'],
    ':town' => $_POST['town'],
    ':county' => $_POST['county'],
    ':postcode' => $_POST['postcode'],
    ':phone' => $_POST['phone']
  ));

}

$page_title = "Volunteers";

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
            <a href="#" class="btn btn-sm btn-success btn-icon-split pull-right" data-toggle="modal" data-target="#addVolunteersModal">
              <span class="icon text-white-50">
                <i class="fas fa-check"></i>
              </span>
              <span class="text">Add Volunteer</span>
            </a>
          </div>


          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Volunteers</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Phone</th>
                      <th>Address</th>
                      <th>Active</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($ms->listVolunteers() as $v){ ?>
                    <tr>
                      <td><?= $v['name']; ?></td>
                      <td><?= $v['phone']; ?></td>
                      <td><?= $ms->formatAddress(array($v['street1'], $v['street2'], $v['town'], $v['county'], $v['postcode'])); ?></td>
                      <td><?= ($v['active'] == 1) ? "Yes" : "No"; ?></td>
                      <td><a href="volunteer-edit.php?id=<?= $v['id']; ?>" class="btn btn-sm btn-warning">Edit</a></td>
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
  <div class="modal fade" id="addVolunteersModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <form method="post">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Volunteer</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group row">
              <label for="name" class="col-sm-2 col-form-label">Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" placeholder="Volunteer Name" required>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" required>
              </div>
              <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email">
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
                <input type="text" class="form-control" id="postcode" name="postcode" placeholder="Postcode">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-success" type="submit">Add Volunteer</button>
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
