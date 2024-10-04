<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>KS TOOLS Users</title>
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
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
        header("Location: ../index.php"); // Jika tidak login atau bukan user, redirect ke login
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
                    <a class="nav-link" href="dashboard_usr.php">
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
                                <h4 class="font-weight-normal mb-3">Inventori Items <i class="mdi mdi-briefcase-check mdi-24px float-right"></i>
                                </h4>
                                <?php
                                // Koneksi ke database
                                include('../connection.php');

                                // Query untuk menghitung total item
                                $query = "SELECT COUNT(*) AS total FROM items";
                                $result = $conn->query($query);
                                $total_items = 0; // Inisialisasi total item

                                if ($result) {
                                    $row = $result->fetch_assoc();
                                    $total_items = $row['total']; // Ambil total item dari hasil query
                                }

                                // Tutup koneksi
                                $conn->close();
                                ?>
                                <h2 class="mb-5"><?php echo $total_items; ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 stretch-card grid-margin">
                        <div class="card bg-gradient-info card-img-holder text-white">
                            <div class="card-body">
                                <img src="../assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3"> Your Request <i class="mdi mdi-account-check mdi-24px float-right"></i>
                                </h4>
                                <?php
                                // Koneksi ke database
                                include('../connection.php');

                                // Fungsi untuk menghitung total pinjaman berdasarkan nama peminjam
                                function getTotalLoansByUser($conn, $borrower_name)
                                {
                                    // Menyiapkan query untuk menghitung total pinjaman
                                    $query = "SELECT COUNT(*) AS total 
              FROM loans 
              WHERE borrower_name = ?";

                                    // Menyiapkan statement
                                    $stmt = $conn->prepare($query);
                                    if ($stmt === false) {
                                        // Jika ada kesalahan saat menyiapkan statement
                                        echo "Error preparing statement: " . $conn->error;
                                        return 0; // Kembalikan 0 jika ada kesalahan
                                    }

                                    // Mengikat parameter
                                    $stmt->bind_param("s", $borrower_name); // Mengikat nama peminjam

                                    // Menjalankan statement
                                    $stmt->execute();

                                    // Mendapatkan hasil
                                    $result = $stmt->get_result();

                                    // Menutup statement
                                    $stmt->close();

                                    // Mengambil total dari hasil query
                                    $total_loans = 0; // Inisialisasi total pinjaman
                                    if ($result) {
                                        $row = $result->fetch_assoc();
                                        $total_loans = $row['total']; // Ambil total pinjaman dari hasil query
                                    }

                                    return $total_loans; // Mengembalikan total pinjaman
                                }

                                // Pastikan user_id ada di session
                                if (!isset($_SESSION['user_id']) || !isset($_SESSION['name'])) {
                                    echo "<h2 class='mb-5'>User not logged in</h2>";
                                    exit();
                                }

                                // Ambil nama peminjam dari sesi
                                $borrower_name = $_SESSION['name'];

                                // Memanggil fungsi untuk menghitung total pinjaman
                                $total_loans = getTotalLoansByUser($conn, $borrower_name);

                                // Tutup koneksi
                                $conn->close();
                                ?>

                                <h2 class="mb-5"><?php echo $total_loans; ?></h2>

                            </div>
                        </div>
                    </div>
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