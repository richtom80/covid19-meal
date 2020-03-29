<?php
require 'includes/preload.php';

if($user['level'] != 1){
  header("Location: /");
  die();
}

$page_title = "Users";

if(!empty($_POST['new_user'])){
  $reg = $auth->register(
    $_POST['email'],
    $_POST['password'],
    $_POST['password'],
    array(
      'name' => $_POST['name'],
      'level' => $_POST['level'],
      'phone' => $_POST['phone']
    ), NULL, 0);
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
              <h6 class="m-0 font-weight-bold text-primary">Add Users</h6>
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
                <label class="sr-only" for="email">Email</label>
                <input type="email" class="form-control mb-2 mr-sm-2" name="email" placeholder="Email" required>
                <label class="sr-only" for="password">Password</label>
                <input type="password" class="form-control mb-2 mr-sm-2" name="password" placeholder="Password" required>
                <label class="sr-only" for="level">Level</label>
                <select name="level" class="form-control mb-2 mr-sm-2">
                  <option value="3">Register</option>
                  <option value="2">Dashboard</option>
                  <option value="1">Admin</option>
                </select>
                <label class="sr-only" for="phone">Phone</label>
                <input type="text" class="form-control mb-2 mr-sm-2" name="phone" placeholder="Phone">
                <button type="submit" class="btn btn-primary">Add User</button>
              </form>
            </div>
          </div>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Users</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Level</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($ms->listUsers() as $user){ ?>
                    <tr>
                      <td><?= $user['name']; ?></td>
                      <td><?= $user['email']; ?></td>
                      <td><?= $ms->formatUserLevel($user['level']); ?></td>
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

  <?php include('includes/html-foot.php'); ?>

  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>


</body>

</html>
