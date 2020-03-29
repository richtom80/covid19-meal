<?php
require 'includes/preload.php';

$page_title = "Search";

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
              <h6 class="m-0 font-weight-bold text-primary">Results for &quot;<?= $_GET['search']; ?>&quot;</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Address</th>
                      <th>Phone</th>
                      <th>Meals</th>
                      <th>DOW</th>
                      <th>Delivery</th>
                      <th>Edit</th>
                      <?php if($user['level'] == 1){ echo "<th>Added by</th>"; } ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sites = $ms->searchSites($_GET['search']);
                    if(!empty($sites)){
                      foreach($sites as $s){ ?>
                      <tr>
                        <td><?= $s['name']." ".$s['surname']; ?></td>
                        <td><?= $ms->formatAddress(array($s['street1'],$s['street2'],$s['town'],$s['county'],$s['postcode'])); ?></td>
                        <td><?= $s['phone']; ?></td>
                        <td>S:<?= $s['std_meal']; ?> | V:<?= $s['veg_meal']; ?></td>
                        <td><?= $ms->dowOut($s); ?></td>
                        <td><?= nl2br($s['delivery_instructions']); ?></td>
                        <td><a href="person-edit.php?id=<?= $s['id']; ?>" class="btn btn-sm btn-warning">Edit</a></td>
                        <?php if($user['level'] == 1){ echo "<td>".$ms->lookupUser($s['added_by'])."</td>"; } ?>
                      </tr>
                      <?php }
                    } ?>
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

  <?php include('includes/html-foot.php'); ?>

  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>


</body>

</html>
