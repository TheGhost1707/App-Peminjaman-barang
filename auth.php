<?php
session_start();
include('connection.php'); // Koneksi ke database

// Cek apakah form login sudah dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Mencari pengguna berdasarkan email
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah pengguna ditemukan
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifikasi password (tanpa hash)
        if ($password === $user['password']) { // Ganti ini untuk membandingkan password secara langsung
            // Set session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['profile_img'] = $user['profile_img']; // Menyimpan gambar profil ke session

            // Redirect berdasarkan role
            if ($user['role'] == 'admin') {
                $_SESSION['message'] = "Welcome, Admin!";
                header("Location: admin/dashboard_adm.php?notif=success");
            } elseif ($user['role'] == 'user') {
                $_SESSION['message'] = "Welcome, User!";
                header("Location: users/dashboard_usr.php?notif=success");
            } else {
                $_SESSION['message'] = "Unknown role. Redirecting to home.";
                header("Location: index.php");
            }
            exit(); // Pastikan untuk mengakhiri skrip setelah header
        } else {
            // Jika password salah
            echo "<script>alert('Password is incorrect!'); window.location.href='index.php';</script>";
        }
    } else {
        // Jika email tidak ditemukan
        echo "<script>alert('User not found!'); window.location.href='index.php';</script>";
    }
}
