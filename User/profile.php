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

    $username = $_SESSION['username'];
    $getAkun = "SELECT * FROM akun WHERE username_akun='$username'";
    $getIdRslt = mysqli_query($conn, $getAkun);
    $akun = mysqli_fetch_assoc($getIdRslt);
    $idAkun = $akun['id_akun'];

    if(empty($akun['foto_akun'])){
        $akun['foto_akun'] = "null-profile.png";
    }

    $getAkunPost = "SELECT makanan.*, akun.*, (SELECT COUNT(*) FROM komentar WHERE komentar.id_makanan = makanan.id_makanan) AS total_komentar  FROM makanan LEFT JOIN akun ON (makanan.id_akun = akun.id_akun) WHERE makanan.id_akun = '$idAkun' ORDER BY makanan.id_makanan DESC";
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
    <link rel="stylesheet" href="../styles/profile.css">
    <title>profile</title>
</head>
<body>
    <h1 class="header">Profile</h1>
    <div class="profile-container">
        <img src="ProfilePicture/<?php echo $akun['foto_akun']?>" width=100px height="100px" alt="">
        <p><?php echo $akun['username_akun'] ?></p>
        <div>
            <a href="editProfile.php">
                <button class="edit">Edit</button>
            </a>
            <a onclick="modalOpen()">
                <button class="logout">Logout</button>
            </a>  
        </div>
    </div>
    <?php
    foreach($akunPost as $post){
        displayPost($post);
    }
    ?>

    <div id="modal" class="modal">
        <div class="content">
            <div class="text">
                <h2 class="title">Log Out</h2>
                <p class="subtitle"> Are you sure you want to log out? Your session will end, and you will need to log in again to access your account</p>
            </div>
            <div class="action">
                <button class="cancel" onclick="modalClose()">Cancel</button>
                <a href="../Auth/logout.php">
                    <button class="logout" >Log Out</button>
                </a>
            </div>
        </div>
    </div>
    
    <script>
        function modalOpen(){
            document.getElementById('modal').classList.add('active')
        }
        function modalClose(){
            document.getElementById('modal').classList.remove('active')
        }

        function openModal(id) {
        document.getElementById('modalReport-' + id).classList.add('active');
        }
        function closeModal(id) {
            document.getElementById('modalReport-' + id).classList.remove('active');
        }
    </script>
</body>
</html>