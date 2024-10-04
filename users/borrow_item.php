<?php
session_start();
include('../connection.php'); // Koneksi ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_id = $_POST['item_id'];
    $borrower_name = $_POST['borrower_name']; // Nama peminjam
    $division = $_POST['division'];
    $project_location = $_POST['location'];
    $loan_date = $_POST['loan_date']; // Tanggal Peminjaman
    $quantity = $_POST['quantity'];

    // Pastikan loan_date tidak kosong dan dalam format yang benar
    if (!empty($loan_date)) {
        // Ambil data item yang ada
        $query = "SELECT available_quantity FROM items WHERE item_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $item_id);
        $stmt->execute();
        $stmt->bind_result($available_quantity);
        $stmt->fetch();
        $stmt->close();

        if ($available_quantity >= $quantity) {
            // Simpan transaksi peminjaman ke dalam tabel loans tanpa mengurangi available_quantity
            $status = 'pending'; // Status awal 'pending'
            $insert_query = "INSERT INTO loans (borrower_name, division, location, loan_date, item_id, quantity, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
            $insert_stmt = $conn->prepare($insert_query);
            $insert_stmt->bind_param("ssssiss", $borrower_name, $division, $project_location, $loan_date, $item_id, $quantity, $status);
            $insert_stmt->execute();
            $insert_stmt->close();

            // Redirect ke halaman sukses atau lainnya
            header("Location: requestment.php");
            exit();
        } else {
            echo "Error: Jumlah alat yang tersedia tidak mencukupi.";
        }
    } else {
        echo "Error: Tanggal peminjaman tidak valid.";
    }
} else {
    header("Location: dashboard_usr.php");
    exit();
}
?>