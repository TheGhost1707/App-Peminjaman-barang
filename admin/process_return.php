<?php
include('../connection.php'); // Koneksi ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $loan_id = intval($_POST['loan_id']);
    $item_id = intval($_POST['item_id']);
    $quantity = intval($_POST['quantity']);
    $good_qty = intval($_POST['available_quantity']); // Sesuaikan dengan form input untuk barang bagus
    $damaged_qty = intval($_POST['damaged_quantity']); // Sesuaikan dengan form input untuk barang rusak

    // Validasi agar total barang yang dikembalikan tidak melebihi jumlah yang dipinjam
    if ($good_qty + $damaged_qty > $quantity) {
        echo "Error: Total good and damaged items exceeds the borrowed quantity.";
        exit;
    }

    // Mulai transaksi
    $conn->begin_transaction();

    try {
        // Update jumlah barang bagus ke available_quantity di table items
        if ($good_qty > 0) {
            $update_good = "UPDATE items SET available_quantity = available_quantity + ? WHERE item_id = ?";
            $stmt_good = $conn->prepare($update_good);
            $stmt_good->bind_param('ii', $good_qty, $item_id);
            $stmt_good->execute();
        }

        // Update jumlah barang rusak ke damaged_available di table items
        if ($damaged_qty > 0) {
            $update_damaged = "UPDATE items SET damaged_quantity = damaged_quantity + ? WHERE item_id = ?";
            $stmt_damaged = $conn->prepare($update_damaged);
            $stmt_damaged->bind_param('ii', $damaged_qty, $item_id);
            $stmt_damaged->execute();
        }

        // Update return date dan status di table loans
        $update_loan = "UPDATE loans SET return_date = NOW(), status = 'returned' WHERE loan_id = ?";
        $stmt_loan = $conn->prepare($update_loan);
        $stmt_loan->bind_param('i', $loan_id);
        $stmt_loan->execute();

        // Commit transaksi jika semuanya berhasil
        $conn->commit();
        header("Location: requestment.php?return=success");
        exit;
    } catch (Exception $e) {
        // Rollback jika terjadi kesalahan
        $conn->rollback();
        header("Location: requestment.php?return=error&message=" . urlencode($e->getMessage()));
        exit;
    }
} else {
    echo "Invalid request.";
}

$conn->close();
