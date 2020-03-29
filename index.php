<?php
require 'includes/preload.php';

require 'includes/html-head.php';
?>

      <!-- Main Content -->
      <div id="content">
        <?php include('includes/html-top-bar.php'); ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
          </div>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">New Registers</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Phone</th>
                      <th>Type</th>
                      <th>Postcode</th>
                      <th># Std</th>
                      <th># Veg</th>
                      <th>DOW</th>
                      <th>Date</th>
                      <th>Edit</th>
                      <?php if($user['level'] == 1){ echo "<th>Added by</th>"; } ?>
                    </tr>
                  </thead>

                  <tbody>
                    <?php foreach($ms->listSites() as $site){ ?>
                    <tr>
                      <td><?= $site['name']." ".$site['surname']; ?></td>
                      <td><?= $site['phone']; ?></td>
                      <td><?= ucwords($site['type']); ?></td>
                      <td><?= $site['postcode']; ?></td>
                      <td><?= $site['std_meal']; ?></td>
                      <td><?= $site['veg_meal']; ?></td>
                      <td><?= $ms->dowOut($site); ?></td>
                      <td><?= $site['date_added']; ?></td>
                      <td><a href="person-edit.php?id=<?= $site['id']; ?>" class="btn btn-sm btn-warning">Edit</a></td>
                      <?php if($user['level'] == 1){ echo "<td>".$ms->lookupUser($site['added_by'])."</td>"; } ?>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Register Per Day - Coming Soon&hellip;</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Meals</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart"></canvas>
                  </div>
                  <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle text-primary"></i> Standard [<?= $ms->mealTotal()['std_meal_count']; ?>]
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-success"></i> Veg [<?= $ms->mealTotal()['veg_meal_count']; ?>]
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Map</h6>
                </div>
                <div class="card-body">
                  <div id="map" style="height: 500px;">Map Loading&hellip;</div>
                </div>
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

  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/chart-area-demo.js"></script>
  <script>
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';

    // Pie Chart
    var ctx = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ["Standard", "Veg"],
        datasets: [{
          data: [<?= $ms->mealTotal()['std_meal_count']; ?>, <?= $ms->mealTotal()['veg_meal_count']; ?>],
          backgroundColor: ['#4e73df', '#1cc88a'],
          hoverBackgroundColor: ['#2e59d9', '#17a673'],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          caretPadding: 10,
        },
        legend: {
          display: false
        },
        cutoutPercentage: 80,
      },
    });
  </script>
  <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>

  <script>
    var map;
    var markers = [];
    function initMap() {
      geocoder = new google.maps.Geocoder();
      var latlng = new google.maps.LatLng(51.455540,0.524910);

      map = new google.maps.Map(document.getElementById('map'), {
        center: latlng,
        zoom: 11
      });
      <?php
      foreach($ms->listSites() as $s){
        $colour = 'ffdddd';
        if(!empty($s['hexcode'])) $colour = $s['hexcode'];
        echo "addMarker('{$s['id']}', '{$s['lat']}','{$s['lng']}', '{$colour}', '".str_replace("'", "", $s['name']." ".$s['surname'])." [{$s['postcode']}]');\n";
      }
       ?>
       var markerCluster = new MarkerClusterer(map, [],
         {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
      markerCluster.addMarkers(markers, true);
    }
    function addMarker(id, glat, glng, colour, info = "Unlabelled"){
      var marker = new google.maps.Marker({
        position: new google.maps.LatLng(glat,glng),
        title: info,
        icon: '//chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|'+colour,
        map: map
      });

      markers.push(marker);
    }
  </script>
  <script src="https://maps.googleapis.com/maps/api/js?key=<?= GOOGLE_API_JS; ?>&callback=initMap" async defer></script>


</body>

</html>
