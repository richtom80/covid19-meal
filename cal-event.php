<?php
require 'includes/preload.php';

$date = new DateTime($_GET['date']);

$page_title = "Calendar Event - ".$date->format('d M Y');

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
              <h6 class="m-0 font-weight-bold text-primary">Deliveries - <span id="std-meals"></span> <span id="veg-meals"></span></h6>
            </div>
            <div class="card-body">
              <?php $std_meals = 0; $veg_meals = 0;
              foreach($ms->listSites("WHERE `route` = {$_GET['rid']}") as $s){
                $std_meals += $s['std_meal']; $veg_meals += $s['veg_meal']; ?>
                <div class="row">
                  <div class="col-md-12">
                    <h4><?= $s['name']." ".$s['surname']." [".ucwords($s['type'])."]"; ?></h4>
                  </div>
                  <div class="col-md-3">
                    <address><?= $ms->formatAddress(array($s['street1'], $s['street2'], $s['town'], $s['county'], $s['postcode']), "html_block"); ?></address>
                    <a href="tel:<?= $s['phone']; ?>"><?= $s['phone']; ?></a>
                  </div>
                  <div class="col-md-3">
                    <h5>Meals</h5>
                    <ul>
                      <li><strong>Std:</strong> <?= $s['std_meal']; ?></li>
                      <li><strong>Veg:</strong> <?= $s['veg_meal']; ?></li>
                    </ul>
                  </div>
                  <div class="col-md-3">
                    <h5>Notes</h5>
                    <p><?= nl2br($s['delivery_instructions']); ?></p>
                  </div>
                </div>
                <hr>
              <?php } ?>
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
  <script>
  $(function() {
    $('#std-meals').html("Std Meals: <?= $std_meals; ?>");
    $('#veg-meals').html(" - Veg Meals: <?= $veg_meals; ?>");
  });
  </script>

</body>

</html>
