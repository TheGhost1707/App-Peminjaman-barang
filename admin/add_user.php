<?php
session_start();
include('../connection.php'); // Pastikan file koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $name = trim($_POST['name']);
    $role = trim($_POST['role']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Proses upload gambar
    if (isset($_FILES['profile_img']) && $_FILES['profile_img']['error'] == 0) {
        $target_dir = "../uploads/";
        $image_name = basename($_FILES['profile_img']['name']);
        $target_file = $target_dir . $image_name;

        // Upload file gambar
        move_uploaded_file($_FILES['profile_img']['tmp_name'], $target_file);
    } else {
        $target_file = null; // Atau gambar default jika tidak ada
    }

    // Query untuk menambahkan data ke tabel users
    $query = "INSERT INTO users (name, role, email, password, profile_img, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $name, $role, $email, $password, $target_file);

    // Eksekusi query
    if ($stmt->execute()) {
        echo "<script>alert('User successfully added!'); window.location.href='users.php';</script>";
    } else {
        echo "<script>alert('Error adding user.'); window.location.href='add_user.php';</script>";
    }

    // Tutup statement dan koneksi
    $stmt->close();
    $conn->close();
}
