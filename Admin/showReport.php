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

    if (isset($_SESSION['message'])) {
        echo "<script>alert('" . $_SESSION['message'] . "');</script>";
        unset($_SESSION['message']); 
    }

    $getReportSql = "SELECT * FROM makanan LEFT JOIN akun ON (makanan.id_akun = akun.id_akun) WHERE status_report = 'Reported'";
    $getReportRslt = mysqli_query($conn, $getReportSql);

    $report = [];
    while ($row = mysqli_fetch_assoc($getReportRslt)) {
        if(empty($row['foto_akun'])){
            $row['foto_akun'] = "null-profile.png";
        }
        $report[] = $row;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/color.css">
    <link rel="stylesheet" href="../styles/admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <title>Document</title>
</head>
<body>
    <nav>
        <div class="logo">
            <img src="../img/ei logo.png" alt="logo" width="28">
            <h1>EatsInsight</h1>
        </div>
            <a onclick="modalOpen()">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z"/></svg>
            </a>
    </nav>
    <h1 class="header">Home Admin</h1>
    <?php foreach($report as $rp): ?>
        <div class="post-container">
            <div class="post-header">
                <div class="header-profile">
                    <img src="../User/ProfilePicture/<?php echo $rp['foto_akun'] ?>" width="35px" height="35px" alt="profil">
                    <p class="username"><?php echo $rp['username_akun']?></p>
                    <p class="date"><?php echo $rp['tanggal_upload']?></p>
                </div>
            </div>
            <img src="../User/MakananUploads/<?php echo $rp['foto_makanan'] ?>" alt="makanan">
            <h1><?php echo $rp['judul_makanan']?></h1>
            <p><?php echo $rp['deskripsi_makanan'] ?></p>
            <div class="action-button">
                <a href="hapusReport.php?id_makanan=<?php echo $rp['id_makanan']?>"><button class="delete-report">Delete Report</button></a>
                <a href="hapusReview.php?id_makanan=<?php echo $rp['id_makanan']?>"><button class="delete-post">Delete Post</button></a>
            </div>
        </div>
    <?php endforeach; ?>
    
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