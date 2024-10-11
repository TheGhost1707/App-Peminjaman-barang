<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>KS TOOLS Admin</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <!-- endinject -->
  <!-- Layout styles -->
  <link rel="stylesheet" href="../assets/css/style.css">
  <!-- End layout styles -->
  <link rel="shortcut icon" href="../assets/images/favicon.ico" />
</head>

<body>
  <?php
  session_start();

  // Menampilkan notifikasi jika ada
  if (isset($_GET['notif']) && $_GET['notif'] == 'success') {
    echo '<script>alert("' . addslashes(htmlspecialchars($_SESSION['message'])) . '");</script>';
    unset($_SESSION['message']); // Hapus message setelah ditampilkan
  }

  // Konten dashboard user
  echo "Selamat datang, " . htmlspecialchars($_SESSION['name']);

  // Cek apakah pengguna sudah login dan memiliki role admin
  if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php"); // Jika tidak login atau bukan admin, redirect ke login
    exit();
  }
  // Isi halaman admin dashboard di sini
  echo "Selamat datang, " . $_SESSION['name'];
  ?>
  <?php
  // Check if user is logged in
  if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to the login page
    header("Location: ../index.php");
    exit();
  }

  // Prevent caching
  header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
  header("Pragma: no-cache"); // HTTP 1.0
  header("Expires: 0"); // Proxies
  ?>
  <!-- partial:partials/_navbar.html -->
  <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
      <a class="navbar-brand brand-logo" href="dashboard_adm.php"><img src="../assets/images/logo.png" alt="logo" /></a>
      <a class="navbar-brand brand-logo-mini" href="dashboard_adm.php"><img src="../assets/images/logo-mini.svg" alt="logo" /></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-stretch">
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
        <span class="mdi mdi-menu"></span>
      </button>
      <ul class="navbar-nav navbar-nav-right">
        <li class="nav-item nav-profile dropdown">
          <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="nav-profile-text">
              <!-- Menampilkan nama sesuai dengan sesi user login -->
              <p class="mb-1 text-black">
                Hello,
                <?php
                if (isset($_SESSION['name'])) {
                  echo $_SESSION['name']; // Memanggil nama dari session
                } else {
                  echo 'Guest'; // Jika tidak ada sesi, tampilkan "Guest"
                }
                ?>
              </p>
            </div>
          </a>
          <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="../logout.php">
              <i class="mdi mdi-logout me-2 text-primary"></i> Logout </a>
          </div>
        </li>
      </ul>
      <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
        <span class="mdi mdi-menu"></span>
      </button>
    </div>
  </nav>
  <!-- partial -->
  <div class="container-fluid page-body-wrapper">
    <!-- partial:partials/_sidebar.html -->
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
      <ul class="nav">
        <li class="nav-item nav-profile">
          <a href="#" class="nav-link">
            <div class="nav-profile-img">
              <img src="<?php echo !empty($_SESSION['profile_img']) ? $_SESSION['profile_img'] : '../uploads/'; ?>" alt="profile" <img src="../assets/images/faces/face1.jpg" alt="image" style="width: 65px; height: 65px; border-radius: 50%; object-fit: cover;">
              <span class="availability-status online"></span>
            </div>
            <div class="nav-profile-text d-flex flex-column">
              <!-- Menampilkan nama dari session -->
              <span class="font-weight-bold mb-2">
                <?php
                if (isset($_SESSION['name'])) {
                  echo $_SESSION['name']; // Memanggil nama dari session
                } else {
                  echo 'Guest'; // Jika tidak ada sesi, tampilkan "Guest"
                }
                ?>
              </span>
              <!-- Menampilkan role dari session -->
              <span class="text-secondary text-small">
                <?php
                if (isset($_SESSION['role'])) {
                  echo $_SESSION['role']; // Memanggil role dari session
                } else {
                  echo 'No Role'; // Jika tidak ada role, tampilkan "No Role"
                }
                ?>
              </span>
            </div>
          </a>
        </li>
        <li class="nav-item sidebar-actions">
          <span class="nav-link">
            <div class="mt-2">
              <div class="border-bottom">
                <p class="text-secondary">Pages menu</p>
              </div>
            </div>
          </span>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="dashboard_adm.php">
            <span class="menu-title">Dashboard</span>
            <i class="mdi mdi-home menu-icon"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="inventory.php">
            <span class="menu-title">Inventory Items</span>
            <i class="mdi mdi-package-variant-closed menu-icon"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="requestment.php">
            <span class="menu-title">Requestment</span>
            <i class="mdi mdi-format-list-bulleted menu-icon"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="users.php">
            <span class="menu-title">Users Data</span>
            <i class="mdi mdi-account-check mdi-20px float-right menu-icon"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="page-header">
          <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
              <i class="mdi mdi-home"></i>
            </span> Dashboard
          </h3>
          <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page">
                <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
              </li>
            </ul>
          </nav>
        </div>
        <div class="row">
          <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-danger card-img-holder text-white">
              <div class="card-body">
                <img src="../assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">Inventori Items <i class="mdi mdi-briefcase-check mdi-24px float-right"></i></h4>
                <?php
                // Koneksi ke database
                include('../connection.php');

                // Mendapatkan data barang masuk
                $periods = ['today', 'week', 'month', 'year'];
                $total_items = []; // Array untuk menyimpan total item

                // Loop untuk mendapatkan data berdasarkan periode
                foreach ($periods as $period) {
                  // Ambil semua data barang masuk tanpa batasan waktu
                  $query_in = "SELECT COUNT(*) AS total FROM items";
                  $result_in = $conn->query($query_in);
                  $total_items[$period] = $result_in->fetch_assoc()['total']; // Simpan total item
                }
                ?>
                <h2 class="mb-5">Total Items : <?php echo $total_items['today']; ?></h2> <!-- Tampilkan total item hari ini -->
              </div>
            </div>
          </div>

          <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-info card-img-holder text-white">
              <div class="card-body">
                <img src="../assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">Requestment <i class="mdi mdi-account-check mdi-24px float-right"></i></h4>
                <?php
                // Koneksi ke database
                include('../connection.php');

                // Mendapatkan data barang dipinjam dan alat paling sering dipinjam
                $total_loans = [];  // Array untuk menyimpan total pinjaman per periode
                $item_names = [];   // Array untuk menyimpan nama alat yang paling sering dipinjam per periode

                // Loop untuk mendapatkan data berdasarkan periode
                foreach ($periods as $period) {
                  if ($period == 'today') {
                    $date_condition = "DATE(loan_date) = CURDATE()";
                  } elseif ($period == 'week') {
                    $date_condition = "loan_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
                  } elseif ($period == 'month') {
                    $date_condition = "loan_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
                  } else {
                    $date_condition = "loan_date >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)";
                  }

                  // Ambil nama alat yang paling sering dipinjam dan jumlah pinjamannya per periode
                  $query_loans = "
        SELECT i.item_name, COUNT(l.loan_id) AS total_loans 
        FROM loans l 
        JOIN items i ON l.item_id = i.item_id 
        WHERE $date_condition
        GROUP BY i.item_name 
        ORDER BY total_loans DESC 
        LIMIT 1"; // Ambil alat yang paling banyak dipinjam

                  $result_loans = $conn->query($query_loans);
                  $row = $result_loans->fetch_assoc();

                  // Simpan total pinjaman dan nama alat ke dalam array
                  $total_loans[$period] = $row ? $row['total_loans'] : 0; // Jika tidak ada pinjaman, set 0
                  $item_names[$period] = $row ? $row['item_name'] : 'No Data'; // Jika tidak ada alat, set 'No Data'
                }

                // Ambil total semua data pinjaman tanpa batasan periode
                $query_total_all_loans = "SELECT COUNT(*) AS total_all_loans FROM loans";
                $result_total_all_loans = $conn->query($query_total_all_loans);
                $total_all_loans = $result_total_all_loans->fetch_assoc()['total_all_loans'];

                // Tutup koneksi
                $conn->close();
                ?>

                <h2 class="mb-5">Total Requestments : <?php echo $total_all_loans; ?></h2> <!-- Semua pinjaman dari database -->
                <!-- Tampilkan total pinjaman hari ini -->
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <h3 class="text-center">Data Overview</h3>
            <canvas id="myChart" width="200" height="50"></canvas>
          </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
          const ctx = document.getElementById('myChart').getContext('2d');
          const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: ['Today', 'This Week', 'This Month', 'This Year'], // Label untuk setiap periode
              datasets: [{
                  label: 'Items In',
                  data: [
                    <?php echo $total_items['today']; ?>,
                    <?php echo $total_items['week']; ?>,
                    <?php echo $total_items['month']; ?>,
                    <?php echo $total_items['year']; ?>
                  ],
                  backgroundColor: 'rgba(255, 99, 132, 0.2)',
                  borderColor: 'rgba(255, 99, 132, 1)',
                  borderWidth: 1
                },
                {
                  label: 'Requestment',
                  data: [
                    <?php echo $total_loans['today']; ?>,
                    <?php echo $total_loans['week']; ?>,
                    <?php echo $total_loans['month']; ?>,
                    <?php echo $total_loans['year']; ?>
                  ],
                  backgroundColor: 'rgba(54, 162, 235, 0.2)',
                  borderColor: 'rgba(54, 162, 235, 1)',
                  borderWidth: 1
                }
              ]
            },
            options: {
              scales: {
                y: {
                  beginAtZero: true // Mulai grafik dari angka 0
                }
              },
              responsive: true, // Membuat grafik responsif
              plugins: {
                legend: {
                  position: 'top', // Posisi legend
                },
                tooltip: {
                  callbacks: {
                    // Menampilkan nama alat di tooltip
                    afterLabel: function(context) {
                      const itemNames = [
                        '<?php echo $item_names['today']; ?>',
                        '<?php echo $item_names['week']; ?>',
                        '<?php echo $item_names['month']; ?>',
                        '<?php echo $item_names['year']; ?>'
                      ];
                      return 'Item: ' + itemNames[context.dataIndex];
                    }
                  }
                }
              }
            }
          });
        </script>

        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="container-fluid d-flex justify-content-between">
            <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">Copyright © Project Delima Sari Dewi 2023</span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="../assets/vendors/chart.js/Chart.min.js"></script>
  <script src="../assets/js/jquery.cookie.js" type="text/javascript"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="../assets/js/off-canvas.js"></script>
  <script src="../assets/js/hoverable-collapse.js"></script>
  <script src="../assets/js/misc.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page -->
  <script src="../assets/js/dashboard.js"></script>
  <script src="../assets/js/todolist.js"></script>
  <!-- End custom js for this page -->
</body>

</html>