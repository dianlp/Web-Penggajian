<!DOCTYPE html>
<html>
<head>
  <?php $this->load->view("templates/head.php") ?>
</head>
<body>
  <body>
    <div class="wrapper">
      <?php $this->load->view("templates/sidebar.php") ?>
      <div class="main-panel">
        <!-- Navbar -->
        <?php $this->load->view("templates/navbar.php") ?>
        <!-- End Navbar -->
        <div class="content">
          <div class="container-fluid">
            <div class="row">

              <!-- Earnings (Monthly) Card Example -->
              <div class="col-xl-4 col-md-3 mb-5">
                <div class="card border-left-primary shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Pegawai</div>
                        <div class="h3 font-weight-bold"><?= $pegawai ?></div>
                      </div>
                      <div class="col">
                        <h1><i class="nc-icon nc-single-02"></i></h1>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-xl-4 col-md-3 mb-5">
                <div class="card border-left-warning shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col ">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Jumlah Absen</div>
                        <div class="h3 font-weight-bold"><?= $absen ?></div>
                      </div>
                      <div class="col ">
                        <h1><i class="nc-icon nc-badge"></i></h1>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

              <!-- <div class="row"> -->

                <!-- Area Chart -->
                <!-- <div class="col-xl-12 col-lg-7"> -->
                  <!-- <div class="card shadow mb-4"> -->
                    <!-- Card Header - Dropdown -->
                    <!-- <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                      <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                          <div class="dropdown-header">Dropdown Header:</div>
                          <a class="dropdown-item" href="#">Action</a>
                          <a class="dropdown-item" href="#">Another action</a>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                      </div>
                    </div> -->
                    <!-- Card Body -->
                    <!-- <div class="card-body">
                      <div class="chart-area">
                        <canvas id="myAreaChart"></canvas>
                      </div>
                    </div> -->
                  <!-- </div> -->
                </div>
              </div>
            </div>
            <?php $this->load->view("templates/footer.php") ?>
          </div>
        </div>
      </body>
      <?php $this->load->view("templates/js.php") ?>

      </html>