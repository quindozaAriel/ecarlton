<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url('src/template/admin/') ?>assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="<?php echo base_url('src/template/admin/') ?>assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    E-Carlton Residence
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link href="<?php echo base_url('src/template/admin/') ?>assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('src/plugins/izitoast/dist/css/iziToast.css') ?>">
  <?php $this->view($css) ?>
  <style type="text/css">
    label.error {
      color: #E14242;
      font-size: 11px;
    }

    .table {
      color: #4a4f54;
    }

    table.dataTable thead th,
    table.dataTable thead td {
      padding: 10px 18px;
      border-bottom: 0px solid #4a4f54;
    }

    table.dataTable.no-footer {
      border-bottom: 0px solid #989595;
    }

    table.dataTable thead th,
    table.dataTable tfoot th {
      font-weight: normal;
    }
  </style>
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="blue">
      <div class="logo">
        <a href="<?php echo base_url('dashboard') ?>" class="simple-text logo-mini">
          <i class="now-ui-icons business_bank"></i>
        </a>
        <a href="<?php echo base_url('dashboard') ?>" class="simple-text logo-normal">
          CARLTON RESIDENCE
        </a>
      </div>

      <!-- SIDEBAR -->
      <div class="sidebar-wrapper" id="sidebar-wrapper">
        <ul class="nav">
          <!--           <li class="<?php echo ($module == 'dashboard') ? 'active' : ''; ?>">
            <a href="<?php echo base_url('dashboard') ?>">
              <i class="now-ui-icons design_app"></i>
              <p>Dashboard</p>
            </a>
          </li> -->
          <li class="<?php echo ($module == 'resident') ? 'active' : ''; ?>">
            <a href="<?php echo base_url('resident') ?>">
              <i class="now-ui-icons business_badge"></i>
              <p>Resident Module</p>
            </a>
          </li>
          <li class="<?php echo ($module == 'reservation') ? 'active' : ''; ?>">
            <a href="<?php echo base_url('reservation') ?>">
              <i class="now-ui-icons location_map-big"></i>
              <p>Reservation Module</p>
            </a>
          </li>
          <li class="<?php echo ($module == 'monthly_due') ? 'active' : ''; ?>">
            <a href="<?php echo base_url('monthly-due') ?>">
              <i class="now-ui-icons business_money-coins"></i>
              <p>Monthly Due Module</p>
            </a>
          </li>
          <li class="<?php echo ($module == 'resident_bills') ? 'active' : ''; ?>">
            <a href="<?php echo base_url('resident-bills') ?>">
              <i class="now-ui-icons business_money-coins"></i>
              <p>Resident Bill Module</p>
            </a>
          </li>
          <li class="<?php echo ($module == 'notification') ? 'active' : ''; ?>">
            <a href="<?php echo base_url('notification') ?>">
              <i class="now-ui-icons users_single-02"></i>
              <p>Notification Module</p>
            </a>
          </li>
          <li class="<?php echo ($module == 'admin') ? 'active' : ''; ?>">
            <a href="<?php echo base_url('admin') ?>">
              <i class="now-ui-icons users_circle-08"></i>
              <p>Admin Module</p>
            </a>
          </li>
          <!--           <li class="<?php echo ($module == 'dashboard') ? 'active' : ''; ?>">
            <a href="<?php echo base_url('dashboard') ?>">
              <i class="fa fa-eye"></i>
              <p>Dashboard</p>
            </a>
          </li> -->
        </ul>
      </div>
      <!-- SIDEBAR -->

    </div>

    <div class="main-panel" id="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <!--      <a class="navbar-brand" href="#">Dashboard</a> -->
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>

          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="#pablo">
                  <i class="now-ui-icons media-2_sound-wave"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Reload Data</span>
                  </p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="now-ui-icons users_single-02"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Account</span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <!-- <a class="dropdown-item" href="#">Profile</a> -->
                  <a class="dropdown-item" href="<?php echo base_url('logout') ?>">Logout</a>
                </div>
              </li>

            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->

      <!-- CONTENT -->
      <?php $this->view($body) ?>
      <!-- CONTENT -->

      <footer class="footer">
        <div class=" container-fluid ">
          <nav>
            <ul>
              <li>
                <a href="<?php echo base_url() ?>">
                  E-Carlton Residence
                </a>
              </li>
              <li>
                <a href="<?php echo base_url() ?>">
                  About Us
                </a>
              </li>
            </ul>
          </nav>
          <div class="copyright" id="copyright">
            &copy; 2020
          </div>
        </div>
      </footer>
    </div>
  </div>

  <!--   Core JS Files   -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="<?php echo base_url('src/template/admin/') ?>assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <script src="<?php echo base_url('src/template/admin/') ?>assets/js/plugins/chartjs.min.js"></script>
  <script src="<?php echo base_url('src/template/admin/') ?>assets/js/plugins/bootstrap-notify.js"></script>
  <script src="<?php echo base_url('src/template/admin/') ?>assets/js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url('src/plugins/izitoast/dist/js/iziToast.js'); ?>"></script>
  <script type="text/javascript">
    const base_url = '<?php echo base_url() ?>'
  </script>
  <?php $this->view($js) ?>
</body>

</html>