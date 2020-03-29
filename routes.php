<?php
require 'includes/preload.php';

$page_title = "Routes";

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
              <h6 class="m-0 font-weight-bold text-primary">Add Route</h6>
            </div>
            <div class="card-body">
              <?php if(!empty($reg)){
                if($reg['error']){
                  echo "<div class='alert alert-danger'>{$reg['message']}</div>";
                } else {
                  echo "<div class='alert alert-success'>{$reg['message']}</div>";
                }
              } ?>
              <form method="post" class="form-inline">
                <input type="hidden" name="new_user" value="1">
                <label class="sr-only" for="name">Name</label>
                <input type="text" class="form-control mb-2 mr-sm-2" name="name" placeholder="Name" required>
                <label class="sr-only" for="phone">Kitchen</label>
                <select class="form-control mb-2 mr-sm-2" name="kitchen">
                  <?php foreach($ms->listKitchens() as $k){ ?>
                    <option value="<?= $k['id']; ?>"><?= $k['name']; ?></option>
                  <?php } ?>
                </select>
                <div class="custom-control custom-checkbox small">
                  <input type="checkbox" id="mon" name="mon" value="1" checked>
                  <label for="mon">Mon</label>
                </div>
                <div class="custom-control custom-checkbox small">
                  <input type="checkbox" id="tue" name="tue" value="1" checked>
                  <label for="tue">Tue</label>
                </div>
                <div class="custom-control custom-checkbox small">
                  <input type="checkbox" id="wed" name="wed" value="1" checked>
                  <label for="wed">Wed</label>
                </div>
                <div class="custom-control custom-checkbox small">
                  <input type="checkbox" id="thu" name="thu" value="1" checked>
                  <label for="thu">Thu</label>
                </div>
                <div class="custom-control custom-checkbox small">
                  <input type="checkbox" id="fri" name="fri" value="1" checked>
                  <label for="fri">Fri</label>
                </div>
                <div class="custom-control custom-checkbox small">
                  <input type="checkbox" id="sat" name="sat" value="1" checked>
                  <label for="sat">Sat</label>
                </div>
                <div class="custom-control custom-checkbox small">
                  <input type="checkbox" id="sun" name="sun" value="1" checked>
                  <label for="sun">Sun</label>
                </div>
                <button type="submit" class="btn btn-primary" style="margin-left: 20px">Add Route</button>
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
