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

    $deleteKomenSql = "DELETE FROM komentar WHERE id_makanan = '$idMakanan'";
    $deleteKomen = mysqli_query($conn, $deleteKomenSql);

    $getFotoMakananSql = "SELECT foto_makanan FROM makanan WHERE id_makanan = '$idMakanan'";
    $getFotoMakanan = mysqli_query($conn, $getFotoMakananSql);
    $fotoMakanan = mysqli_fetch_assoc($getFotoMakanan);
    $foto = $fotoMakanan['foto_makanan'];

    $pathFoto = '../User/MakananUploads/'. $foto;

    if(file_exists($pathFoto)){
        unlink($pathFoto);
    }

    $deleteMakananSql = "DELETE FROM makanan WHERE id_makanan = '$idMakanan'";
    $deleteMakanan = mysqli_query($conn, $deleteMakananSql);

    if($deleteMakanan){
        echo "<script>
        alert('Berhasil menghapus review!');
        document.location.href = 'showReport.php';
        </script>";
        exit;
    }else{
        echo "<script>
        alert('Berhasil menghapus review!');
        document.location.href = 'showReport.php';
        </script>";
        exit;

    }
    
?>