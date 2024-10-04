<?php
session_start();
include('../connection.php');

// Cek apakah form telah dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_id = $_POST['item_id'];
    $serial_number = trim($_POST['serial_number']);
    $item_name = trim($_POST['item_name']);
    $item_type = trim($_POST['item_type']);
    $available_qty = intval($_POST['available_quantity']);
    $damaged_qty = intval($_POST['damaged_quantity']);
    $old_image = $_POST['old_image'];

    // Proses upload gambar baru jika ada
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../uploads/";
        $image_name = basename($_FILES['image']['name']);
        $target_file = $target_dir . $image_name;
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($image_file_type, $allowed_types)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $image_path = $target_file;
            } else {
                echo "<script>alert('Error uploading the image.'); window.location.href='inventory.php';</script>";
                exit();
            }
        } else {
            echo "<script>alert('Only JPG, JPEG, PNG & GIF files are allowed.'); window.location.href='inventory.php';</script>";
            exit();
        }
    } else {
        // Jika tidak ada gambar baru, gunakan gambar lama
        $image_path = $old_image;
    }

    // Query untuk update data
    $query = "UPDATE items SET serial_number = ?, item_name = ?, item_type = ?, available_quantity = ?, damaged_quantity = ?, picture = ?, updated_at = NOW() WHERE item_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssiisi", $serial_number, $item_name, $item_type, $available_qty, $damaged_qty, $image_path, $item_id);

    // Eksekusi query
    if ($stmt->execute()) {
        echo "<script>alert('Item successfully updated!'); window.location.href='inventory.php';</script>";
    } else {
        echo "<script>alert('Error updating item.'); window.location.href='inventory.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
