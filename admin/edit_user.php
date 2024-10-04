<?php
session_start();
include('../connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id']; // Ambil ID pengguna
    $full_name = trim($_POST['full_name']);
    $role = trim($_POST['role']);
    $email = trim($_POST['email']);

    // Proses upload gambar
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $target_dir = "../uploads/";
        $image_name = basename($_FILES['profile_picture']['name']);
        $target_file = $target_dir . $image_name;
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validasi tipe file gambar
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($image_file_type, $allowed_types)) {
            echo "<script>alert('Only JPG, JPEG, PNG & GIF files are allowed.'); window.location.href='users_data.php';</script>";
            exit();
        }

        // Upload gambar
        if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
            echo "<script>alert('Error uploading the image.'); window.location.href='users_data.php';</script>";
            exit();
        }
    } else {
        // Jika gambar tidak diubah, ambil gambar saat ini
        $query = "SELECT profile_picture FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $target_file = $row['profile_picture'];
        $stmt->close();
    }

    // Query untuk mengupdate data pengguna
    $query = "UPDATE users SET full_name = ?, role = ?, email = ?, profile_picture = ? WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $full_name, $role, $email, $target_file, $user_id);

    // Eksekusi query
    if ($stmt->execute()) {
        echo "<script>alert('User successfully updated!'); window.location.href='users_data.php';</script>";
    } else {
        echo "<script>alert('Error updating user.'); window.location.href='users_data.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
