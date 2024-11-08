<?php 
    session_start();
    require '../Connection/connection.php';
    require "../templates/navbar.php";
    require "../templates/post.php";

    if (!isset($_SESSION['username']) || $_SESSION['role']=='admin'){
        if($_SESSION['role'] == 'admin'){
            echo 
            "<script>
            alert('Tidak bisa mengakses halaman ini!');
            document.location.href = '../Admin/showReport.php';
            </script>";
            exit;
        }else{
            echo 
            "<script>
            alert('Tidak bisa mengakses halaman ini!');
            document.location.href = '../Auth/login.php';
            </script>";
            exit;
        }
    }
    $akunPost = [];

if (isset($_GET['cari'])) {
    $cari = htmlspecialchars($_GET['cari']);
    
    $cariSql = "SELECT makanan.*, akun.*, 
               (SELECT COUNT(*) FROM komentar WHERE komentar.id_makanan = makanan.id_makanan) AS total_komentar
               FROM makanan
               LEFT JOIN akun ON makanan.id_akun = akun.id_akun
               WHERE makanan.judul_makanan LIKE '%$cari%' ORDER BY makanan.id_makanan DESC";
    
    $cariRslt = mysqli_query($conn, $cariSql);
    
    while ($row = mysqli_fetch_assoc($cariRslt)) {
        if (empty($row['foto_akun'])) {
            $row['foto_akun'] = "null-profile.png";
        }
        $akunPost[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/search.css">
    <title>Search</title>
</head>
<body>
    <h1 class="header">Search</h1>
    <form action="" method="get">
    <input type="text" name="cari" id="cari" placeholder="Search" autocomplete="off" required>
    </form>
    <?php if (isset($_GET['cari'])): ?>
        <?php if (!empty($akunPost)): ?>
            <?php
                foreach($akunPost as $post){
                    displayPost($post, true);
                }
            ?>
        <?php else: ?>
            <p class="no-result">Sorry, we couldn’t find any reviews. Please try again with different keywords.</p>
        <?php endif; ?>
    <?php endif; ?>

    <script>
         function openModal(id) {
        document.getElementById('modalReport-' + id).classList.add('active');
        }
        function closeModal(id) {
            document.getElementById('modalReport-' + id).classList.remove('active');
        }
    </script>
</body>
</html>