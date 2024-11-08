<?php 
    session_start();
    require '../Connection/connection.php';
    require "../templates/navbar.php";
    require "../templates/post.php";

    if (!isset($_SESSION['username'])){
        echo 
        "<script>
        alert('Tidak bisa mengakses halaman ini!');
        document.location.href = '../Auth/login.php';
        </script>";
        exit;
    }

    $getAkunPost = "SELECT makanan.*, akun.*, 
    (SELECT COUNT(*) FROM komentar WHERE komentar.id_makanan = makanan.id_makanan) AS total_komentar
        FROM makanan
        LEFT JOIN akun ON makanan.id_akun = akun.id_akun ORDER BY makanan.id_makanan DESC;";
    $getAkunPostRslt = mysqli_query($conn, $getAkunPost);

    $akunPost = [];
    while ($row = mysqli_fetch_assoc($getAkunPostRslt)) {
        if(empty($row['foto_akun'])){
            $row['foto_akun'] = "null-profile.png";
        }
        $akunPost[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <h1 class="header">Insights</h1>
    <?php
    foreach($akunPost as $post){
        displayPost($post);
    }
    ?>
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