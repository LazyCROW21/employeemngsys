<?php require_once '../config/checksession.php'; ?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="/assets/"
  data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Dashboard</title>

  <meta name="description" content="Employee management system" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="/assets/img/favicon/favicon.ico" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet" />

  <!-- Icons. Uncomment required icon fonts -->
  <link rel="stylesheet" href="/assets/vendor/fonts/boxicons.css" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="/assets/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="/assets/css/demo.css" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

  <link rel="stylesheet" href="/assets/vendor/libs/apex-charts/apex-charts.css" />

  <!-- Page CSS -->

  <!-- Helpers -->
  <script src="/assets/vendor/js/helpers.js"></script>

  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="/assets/js/config.js"></script>
</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->
      <?php require_once "../views/sidebar.php" ?>
      <!-- / Menu -->

      <!-- Layout container -->
      <div class="layout-page">
        <?php require_once "../views/navbar.php"; ?>

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->
        <?php 
          require_once "../config/dbconfig.php";
          require_once "../models/clients.php";
          require_once "../models/departments.php";
          require_once "../models/designations.php";
          require_once "../models/leaves.php";
          require_once "../models/payrolls.php";
          require_once "../models/permissions.php";
          require_once "../models/projects.php";
          require_once "../models/users.php";

          $clientModel = new ClientModel($conn);
          $deptModel = new DeptModel($conn);
          $desgModel = new DesgModel($conn);
          $leaveModel = new LeaveModel($conn);
          $projectModel = new ProjectModel($conn);
          $userModel = new UserModel($conn);
        ?>

          <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
              <div class="col-6 my-1">
                <div class="card border border-primary border-2">
                  <div class="card-body">
                    Active Employees <span class="badge bg-primary"><?= $userModel->findAllActive()->num_rows ?></span>
                  </div>
                </div>
              </div>
              <div class="col-6 my-1">
                <div class="card border border-success border-2">
                  <div class="card-body">
                    Active Departments <span class="badge bg-success"><?= $deptModel->findAllActive()->num_rows ?></span>
                  </div>
                </div>
              </div>
              <div class="col-6 my-1">
                <div class="card border border-info border-2">
                  <div class="card-body">
                    Active Designations <span class="badge bg-info"><?= $desgModel->findAllActive()->num_rows ?></span>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="card my-1 border border-warning border-2">
                  <div class="card-body">
                    New Leave Requests <span class="badge bg-warning"><?= $leaveModel->findPendingLeaves()->num_rows ?></span>
                  </div>
                </div>
              </div>
              <div class="col-6 my-1">
                <div class="card border border-dark border-2">
                  <div class="card-body">
                    Active Clients <span class="badge bg-dark"><?= $clientModel->findAllActive()->num_rows ?></span>
                  </div>
                </div>
              </div>
              <?php
                $allProjects = $projectModel->findAll();
                $active = 0;
                $late = 0;
                $currDate = Date('Y-m-d');
                foreach($allProjects as $project) {
                  if($project['Completed']) continue;
                  $active++;
                  if(isset($project['Deadline']) && $project['Deadline'] < $currDate) {
                    $late++;
                  }
                }
              ?>
              <div class="col-6 my-1">
                <div class="card border border-secondary border-2">
                  <div class="card-body">
                    Active Projects <span class="badge bg-secondary"><?= $active ?></span>
                  </div>
                </div>
              </div>
              <div class="col-6 my-1">
                <div class="card border border-danger border-2">
                  <div class="card-body">
                    Late Projects <span class="badge bg-danger"><?= $late ?></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- / Content -->

          <?php require_once "../views/footer.php"; ?>

          <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
  <!-- / Layout wrapper -->

  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->
  <script src="/assets/vendor/libs/jquery/jquery.js"></script>
  <script src="/assets/vendor/libs/popper/popper.js"></script>
  <script src="/assets/vendor/js/bootstrap.js"></script>
  <script src="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

  <script src="/assets/vendor/js/menu.js"></script>
  <!-- endbuild -->

  <!-- Vendors JS -->
  <script src="/assets/vendor/libs/apex-charts/apexcharts.js"></script>

  <!-- Main JS -->
  <script src="/assets/js/main.js"></script>

  <!-- Page JS -->
  <script src="/assets/js/dashboards-analytics.js"></script>

  <!-- Place this tag in your head or just before your close body tag. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>