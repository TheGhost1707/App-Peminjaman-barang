<?php
// Mulai session
session_start();
include('../connection.php'); // Pastikan file koneksi ke database

// Cek apakah form telah dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $serial_number = trim($_POST['serial_number']);
    $item_name = trim($_POST['item_name']);
    $item_type = trim($_POST['item_type']);
    $available_quantity = intval($_POST['available_quantity']);
    $damaged_quantity = intval($_POST['damaged_quantity']);

    // Proses upload gambar
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // Path di mana gambar akan disimpan
        $target_dir = "../uploads/";
        $image_name = basename($_FILES['image']['name']);
        $target_file = $target_dir . $image_name;
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validasi tipe file gambar
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($image_file_type, $allowed_types)) {
            echo "<script>alert('Only JPG, JPEG, PNG & GIF files are allowed.'); window.location.href='inventory.php';</script>";
            exit();
        }

        // Upload gambar
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // Gambar berhasil diupload
            $image_path = $target_file;
        } else {
            echo "<script>alert('Error uploading the image.'); window.location.href='inventory.php';</script>";
            exit();
        }
    } else {
        // Jika tidak ada gambar yang diupload
        $image_path = null;
    }

    // Query untuk menambahkan data ke table items
    $query = "INSERT INTO items (serial_number, item_name, item_type, available_quantity, damaged_quantity, picture, created_at) 
              VALUES (?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssiis", $serial_number, $item_name, $item_type, $available_quantity, $damaged_quantity, $image_path);

    // Eksekusi query
    if ($stmt->execute()) {
        echo "<script>alert('Item successfully added!'); window.location.href='inventory.php';</script>";
    } else {
        echo "<script>alert('Error adding item.'); window.location.href='inventory.php';</script>";
    }

    // Tutup statement dan koneksi
    $stmt->close();
    $conn->close();
}
?>