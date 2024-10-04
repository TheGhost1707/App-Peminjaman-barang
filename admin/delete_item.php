<?php
session_start();
include('../connection.php'); // Koneksi ke database

// Cek apakah id item ada dalam query string
if (isset($_GET['id'])) {
    $item_id = intval($_GET['id']); // Mengambil id dari query string

    // Query untuk menghapus item
    $query = "DELETE FROM items WHERE item_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $item_id);

    // Eksekusi query
    if ($stmt->execute()) {
        // Jika ada gambar yang terkait, hapus juga dari server
        $select_query = "SELECT picture FROM items WHERE item_id = ?";
        $select_stmt = $conn->prepare($select_query);
        $select_stmt->bind_param("i", $item_id);
        $select_stmt->execute();
        $select_result = $select_stmt->get_result();

        if ($select_result->num_rows > 0) {
            $row = $select_result->fetch_assoc();
            $image_path = $row['picture'];

            // Hapus file gambar dari server jika ada
            if (!empty($image_path) && file_exists($image_path)) {
                unlink($image_path); // Menghapus file gambar
            }
        }

        echo "<script>alert('Item successfully deleted!'); window.location.href='inventory.php';</script>";
    } else {
        echo "<script>alert('Error deleting item.'); window.location.href='inventory.php';</script>";
    }

    // Tutup statement dan koneksi
    $stmt->close();
    $select_stmt->close();
    $conn->close();
} else {
    echo "<script>alert('No item ID provided.'); window.location.href='inventory.php';</script>";
}
?>
