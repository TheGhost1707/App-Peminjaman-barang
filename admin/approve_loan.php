<?php
session_start();
include('../connection.php'); // Koneksi ke database

if (isset($_GET['loan_id'])) {
    $loan_id = $_GET['loan_id'];

    // Ambil detail peminjaman dan barang terkait
    $query = "SELECT l.quantity, l.item_id, i.available_quantity FROM loans l JOIN items i ON l.item_id = i.item_id WHERE l.loan_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $loan_id);
    $stmt->execute();
    $stmt->bind_result($loan_quantity, $item_id, $available_quantity);
    $stmt->fetch();
    $stmt->close();

    // Pastikan stok cukup untuk approve peminjaman
    if ($available_quantity >= $loan_quantity) {
        // Kurangi jumlah barang yang tersedia
        $new_quantity = $available_quantity - $loan_quantity;
        $update_item_query = "UPDATE items SET available_quantity = ? WHERE item_id = ?";
        $update_stmt = $conn->prepare($update_item_query);
        $update_stmt->bind_param("ii", $new_quantity, $item_id);
        $update_stmt->execute();
        $update_stmt->close();

        // Update status peminjaman menjadi 'approved'
        $update_loan_query = "UPDATE loans SET status = 'borrowed', updated_at = NOW() WHERE loan_id = ?";
        $update_stmt = $conn->prepare($update_loan_query);
        $update_stmt->bind_param("i", $loan_id);
        $update_stmt->execute();
        $update_stmt->close();

        // Redirect ke halaman sebelumnya dengan notifikasi sukses
        header("Location: requestment.php?approve_success=true");
        exit();
    } else {
        // Jika stok tidak cukup, beri pesan error
        header("Location: requestment.php?approve_error=insufficient_stock");
        exit();
    }
} else {
    // Jika tidak ada loan_id di URL, redirect ke halaman sebelumnya
    header("Location: requestment.php");
    exit();
}
?>