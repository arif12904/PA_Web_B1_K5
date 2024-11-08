<?php 
    require '../Connection/connection.php';
    session_start();
    if($_SESSION['role']!== 'admin'){
        echo 
            "<script>
            alert('Tidak bisa mengakses halaman ini!');
            document.location.href = '../User/home.php';
            </script>";
            exit;
    }

    if(!isset($_SESSION['role'])){
        echo 
            "<script>
            alert('Tidak bisa mengakses halaman ini!');
            document.location.href = '../Auth/login.php';
            </script>";
            exit;
    }
    if (!isset($_GET['id_makanan'])){
        echo "<script>
        alert('Pilih postingan dahulu!');
        document.location.href = 'showReport.php';
        </script>";
        exit;
    }
    $idMakanan = $_GET['id_makanan'];

    $setStatusReport = "UPDATE makanan SET status_report = NULL WHERE id_makanan = '$idMakanan'";
    $setStatusReportRslt = mysqli_query($conn, $setStatusReport);
    if($setStatusReportRslt){
        echo 
        "<script>
            alert('Perubahan berhasil!');
            document.location.href = 'showReport.php';
        </script>";
        exit;
    }else{
        echo 
        "<script>
            alert('Perubahan gagal!');
            document.location.href = 'showReport.php';
        </script>";
        exit;

    }
?>