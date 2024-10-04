<?php
session_start();
include('../connection.php');

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Query untuk menghapus pengguna
    $query = "DELETE FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);

    // Eksekusi query
    if ($stmt->execute()) {
        echo "<script>alert('User successfully deleted!'); window.location.href='users.php';</script>";
    } else {
        echo "<script>alert('Error deleting user.'); window.location.href='users.php';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Invalid request.'); window.location.href='users_data.php';</script>";
}
?>
