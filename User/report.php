<?php
    require '../Connection/connection.php';
    session_start();

    if (!isset($_SESSION['username']) || $_SESSION['role']=='admin') {
        $_SESSION['message'] = "Anda harus login untuk melakukan report!";
        header("Location: ../Auth/login.php");
        exit;
    }

    if (isset($_GET['id_makanan'])) {
        $idMakanan = $_GET['id_makanan'];
        $status = 'Reported';

        $reportSql = "UPDATE makanan SET status_report = '$status' WHERE id_makanan = '$idMakanan'";
        $reportRslt = mysqli_query($conn, $reportSql);

        if ($reportRslt) {
            $_SESSION['message'] = "Berhasil melakukan report!";
        } else {
            $_SESSION['message'] = "Gagal melakukan report!";
        }
    } else {
        $_SESSION['message'] = "ID makanan tidak ditemukan!";
    }

    $previous_page = $_SERVER['HTTP_REFERER'];
    header("Location: $previous_page");
    exit();
?>
