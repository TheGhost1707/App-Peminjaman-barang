<?php
// Buat koneksi ke database
        $conn = mysqli_connect("localhost", "root", "", "db_kstools");

        // Periksa koneksi
        if (!$conn) {
            die("Connection Failed : " . mysqli_connect_error());
        }
?>