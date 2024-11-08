<?php
    $server = "localhost"; 
    $user = "root"; 
    $password = ""; 
    $db_name = "eatsinsightdb"; // nama database yang digunakan

    // Melakukan koneksi ke dalam database
    $conn = mysqli_connect($server, $user, $password, $db_name);

    // Cek apakah koneksi berhasil?
    if (!$conn) {
        die("Gagal terhubung ke database: " . mysqli_connect_error());
    }
?>