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

  // Cek apakah pengguna sudah login dan memiliki role admin
  if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php"); // Jika tidak login atau bukan admin, redirect ke login
    exit();
  }
  // Isi halaman admin dashboard di sini
  echo "Selamat datang, " . $_SESSION['name'];
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
            <div class="nav-profile-image">
              <img src="<?php echo !empty($_SESSION['profile_img']) ? $_SESSION['profile_img'] : '../uploads/'; ?>" alt="profile" <img src="../assets/images/faces/face1.jpg" alt="image" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
              <span class="login-status online"></span>
              <!--change to offline or busy as needed-->
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
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="dashboard_adm.php">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Inventory items</li>
            </ol>
          </nav>
        </div>
        <div class="row">
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Inventory list</h4>
                <p class="card-description">
                  Add item: <a href="#" data-bs-toggle="modal" data-bs-target="#addItemModal">click here</a>
                </p>
                <table class="table">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Image</th>
                      <th>Serial Number</th>
                      <th>Name</th>
                      <th>Type</th>
                      <th>Available Qty</th>
                      <th>Damaged Qty</th>
                      <th>Date Created</th>
                      <th>Updated At</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    include('../connection.php'); // Koneksi ke database
                    $query = "SELECT * FROM items ORDER BY created_at DESC";
                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                      $no = 1; // Untuk nomor urut
                      while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        // Menampilkan gambar jika ada, jika tidak tampilkan teks default
                        if (!empty($row['picture'])) {
                          echo "<td><img src='" . $row['picture'] . "' width='50' height='auto' alt='Image'></td>";
                        } else {
                          echo "<td>No image</td>";
                        }
                        echo "<td>" . htmlspecialchars($row['serial_number']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['item_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['item_type']) . "</td>";
                        echo "<td><center>" . intval($row['available_quantity']) . "</center></td>";
                        echo "<td><center>" . intval($row['damaged_quantity']) . "</center></td>";
                        echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['updated_at']) . "</td>";
                        echo "<td>";
                        echo "<a href='#' class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editItemModal" . $row['item_id'] . "'>Edit</a> ";
                        echo "<a href='delete_item.php?id=" . $row['item_id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";

                        // Modal for edit item
                        echo "
                        <div class='modal fade' id='editItemModal" . $row['item_id'] . "' tabindex='-1' aria-labelledby='editItemModalLabel" . $row['item_id'] . "' aria-hidden='true'>
                        <div class='modal-dialog'>
                        <div class='modal-content'>
                        <div class='modal-header'>
                          <h5 class='modal-title' id='editItemModalLabel" . $row['item_id'] . "'>Edit Item</h5>
                          <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <div class='modal-body'>
                          <form method='POST' action='edit_item.php' enctype='multipart/form-data'>
                          <input type='hidden' name='item_id' value='" . $row['item_id'] . "'>
                        <div class='mb-3'>
                          <label for='serial_number' class='form-label'>Serial Number</label>
                          <input type='text' class='form-control' name='serial_number' value='" . htmlspecialchars($row['serial_number']) . "' required>
                        </div>
                        <div class='mb-3'>
                          <label for='item_name' class='form-label'>Item Name</label>
                          <input type='text' class='form-control' name='item_name' value='" . htmlspecialchars($row['item_name']) . "' required>
                        </div>
                        <div class='mb-3'>
                          <label for='item_type' class='form-label'>Item Type</label>
                            <select class='form-control' name='item_type' required style=height:50px;>
                              <option value=''>Select Type..</option>
                              <option value='inspeksi'>Inspeksi</option>
                              <option value='kalibrasi'>Kalibrasi</option>
                            </select>
                        </div>
                        <div class='mb-3'>
                          <label for='available_quantity' class='form-label'>Available Quantity</label>
                          <input type='number' class='form-control' name='available_quantity' value='" . intval($row['available_quantity']) . "' required>
                        </div>
                        <div class='mb-3'>
                          <label for='damaged_quantity' class='form-label'>Damaged Quantity</label>
                          <input type='number' class='form-control' name='damaged_quantity' value='" . intval($row['damaged_quantity']) . "' required>
                        </div>
                        <div class='mb-3'>
                        <label for='image' class='form-label'>Image</label>
                        <input type='file' class='form-control' name='image'>
                        <input type='hidden' name='old_image' value='" . $row['picture'] . "'>
                        <!-- Tampilkan gambar lama -->
                        <div class='mt-2'>
                          <img src='" . $row['picture'] . "' width='250' height='auto' alt='Current Image'>
                          <p>Current Image</p>
                        </div>
                      </div>
                        <button type='submit' class='btn btn-primary'>Save Changes</button>
                      </form>
                      </div>
                    </div>
                  </div>
                </div>
                ";
                      }
                    } else {
                      echo "<tr><td colspan='10' class='text-center'>No items found</td></tr>";
                    }

                    // Tutup koneksi
                    $conn->close();
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal Bootstrap 5 -->
        <div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="addItemModalLabel">Add New Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form id="addItemForm" action="add_item.php" method="POST" enctype="multipart/form-data">
                  <div class="mb-3">
                    <label for="serial_number" class="form-label">Serial Number</label>
                    <input type="text" class="form-control" id="serial_number" name="serial_number" required>
                  </div>
                  <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="item_name" required>
                  </div>
                  <div class='mb-3'>
                    <label for='item_type' class='form-label'>Item Type</label>
                    <select class='form-control' name='item_type' required style="height:50px;">
                      <option value=''>Select Type..</option>
                      <option value='inspeksi'>Inspeksi</option>
                      <option value='kalibrasi'>Kalibrasi</option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="available_qty" class="form-label">Available Quantity</label>
                    <input type="number" class="form-control" id="available_quantity" name="available_quantity" required>
                  </div>
                  <div class="mb-3">
                    <label for="damaged_qty" class="form-label">Damaged Quantity</label>
                    <input type="number" class="form-control" id="damaged_quantity" name="damaged_quantity" required>
                  </div>
                  <div class="mb-3">
                    <label for="image" class="form-label">Item Image</label>
                    <input type="file" class="form-control" id="image" name="image" required>
                  </div>
                  <button type="submit" class="btn btn-primary">Add Item</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
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
  <script>
    // Menutup modal setelah formulir disubmit
    document.getElementById('addItemForm').addEventListener('submit', function(event) {
      event.preventDefault(); // Mencegah reload halaman
      var form = this;

      // Lakukan request AJAX atau submit form biasa
      // Misalnya:
      form.submit();

      // Setelah sukses, tutup modal
      var modal = bootstrap.Modal.getInstance(document.getElementById('addItemModal'));
      modal.hide();
    });
  </script>
</body>

</html>