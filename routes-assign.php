<?php
require 'includes/preload.php';

$r = $ms->getRoute($_GET['id']);

$page_title = "Route Assign ".$r['name'];

if(!empty($_POST)){

  $ri = $db->prepare("INSERT INTO `routes`(`name`, `kitchen`, `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `sun`)
  VALUES (:name,:kitchen,:mon,:tue,:wed,:thu,:fri,:sat,:sun);");

  $ri->execute(array(
    ":name" => $_POST['name'],
    ":kitchen" => $_POST['kitchen'],
    ":mon" => $_POST['mon'],
    ":tue" => $_POST['tue'],
    ":wed" => $_POST['wed'],
    ":thu" => $_POST['thu'],
    ":fri" => $_POST['fri'],
    ":sat" => $_POST['sat'],
    ":sun" => $_POST['sun']
  ));

}

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
              <h6 class="m-0 font-weight-bold text-primary">Map</h6>
            </div>
            <div class="card-body">
              <div id="map" style="height: 700px;">Map Loading&hellip;</div>
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
  <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>

  <script>
    var map;
    var markers = [];
    function initMap() {
      geocoder = new google.maps.Geocoder();
      var latlng = new google.maps.LatLng(51.455540,0.524910);

      map = new google.maps.Map(document.getElementById('map'), {
        center: latlng,
        zoom: 12
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
