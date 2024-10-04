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
                            <li class="breadcrumb-item active" aria-current="page">Users Data</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Users Data</h4>
                            <p class="card-description"> Add user : <code><a href="#" data-bs-toggle="modal" data-bs-target="#addUserModal">click here</a></code></p>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th> No </th>
                                        <th> Image Profile </th>
                                        <th> Full Name </th>
                                        <th> Role </th>
                                        <th> Email </th>
                                        <th> Password </th>
                                        <th> Date of Created </th>
                                        <th> Update at </th>
                                        <th> Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include('../connection.php'); // Koneksi ke database

                                    // Query untuk mendapatkan data pengguna
                                    $query = "SELECT * FROM users ORDER BY created_at DESC";
                                    $result = $conn->query($query);

                                    if ($result->num_rows > 0) {
                                        $no = 1; // Untuk nomor urut
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $no++ . "</td>";

                                            // Menampilkan gambar profil
                                            if (!empty($row['profile_img'])) {
                                                echo "<td class='py-1'><img src='" . $row['profile_img'] . "' alt='image' style='width:100px;height:auto;'/></td>";
                                            } else {
                                                echo "<td class='py-1'>No Image</td>";
                                            }

                                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['password']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['updated_at']) . "</td>";
                                            echo "<td>
                                            <button class='btn btn-warning btn-sm' onclick='openEditModal(" . $row['user_id'] . ", \"" . $row['name'] . "\", \"" . $row['role'] . "\", \"" . $row['email'] . "\", \"" . $row['password'] . "\")'>Edit</button> 
                                            <a href='delete_user.php?id=" . $row['user_id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                                            </td>";
                                            echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='8' class='text-center'>No users found</td></tr>";
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
            <!-- Add User Modal -->
            <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="add_user.php" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <select class="form-select" name="role" required>
                                        <option value="" disabled selected>Select role</option>
                                        <option value="Admin">Admin</option>
                                        <option value="User">User</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="profile_img" class="form-label">Profile Picture</label>
                                    <input type="file" class="form-control" name="profile_img" accept="image/*">
                                </div>
                                <button type="submit" class="btn btn-primary">Add User</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Edit User Modal -->
            <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="edit_user.php" method="POST" enctype="multipart/form-data">
                                <!-- Hidden field for user_id -->
                                <input type="hidden" name="user_id" id="editUserId">

                                <div class="mb-3">
                                    <label for="editName" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" name="name" id="editName" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editRole" class="form-label">Role</label>
                                    <select class="form-select" name="role" id="editRole" required>
                                        <option value="" disabled>Select role</option>
                                        <option value="Admin">Admin</option>
                                        <option value="User">User</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="editEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="editEmail" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editPassword" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" id="editPassword" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editProfileImg" class="form-label">Profile Picture</label>
                                    <input type="file" class="form-control" name="profile_img" id="editProfileImg" accept="image/*">
                                </div>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
                        </div>
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
    <script>
    function openEditModal(userId, name, role, email, password) {
        // Mengisi data di modal
        document.getElementById('editUserId').value = userId;
        document.getElementById('editName').value = name;
        document.getElementById('editRole').value = role;
        document.getElementById('editEmail').value = email;
        document.getElementById('editPassword').value = password;
        // Membuka modal edit
        var editUserModal = new bootstrap.Modal(document.getElementById('editUserModal'));
        editUserModal.show();
    }
    </script>
</body>

</html>