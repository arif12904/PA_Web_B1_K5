<?php 
    require '../Connection/connection.php';

    session_start();

    if (!isset($_SESSION['username']) || $_SESSION['role']=='admin'){
        if($_SESSION['role'] == 'admin'){
            echo 
            "<script>
            alert('Tidak bisa mengakses halaman ini!');
            document.location.href = '../../Admin/showReport.php';
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
    
    if (!isset($_GET['id_makanan'])){
        echo "<script>
        alert('Pilih postingan dahulu!');
        document.location.href = 'home.php';
        </script>";
        exit;
    }

    $idMakanan = $_GET['id_makanan'];


    $getPost = "SELECT * FROM makanan LEFT JOIN akun ON (makanan.id_akun = akun.id_akun) WHERE id_makanan = '$idMakanan' ORDER BY makanan.id_makanan DESC";
    $getPostRlst = mysqli_query($conn, $getPost);
    $post = mysqli_fetch_assoc($getPostRlst);
    if(empty($post['foto_akun'])){
        $post['foto_akun'] = "null-profile.png";
    }

    $getKomenSql = "SELECT * FROM komentar WHERE id_makanan = '$idMakanan'";
    $getKomenRslt = mysqli_query($conn, $getKomenSql);
    $komen = [];

    while ($row = mysqli_fetch_assoc($getKomenRslt)){
        $komen[] = $row;
    }

    $isSuccess = null;

    if(isset($_POST['up_komentar'])){
        $komentar = htmlspecialchars($_POST['isi_komentar']);
        $tanggal = date('Y-m-d');

        $upKomen = "INSERT INTO komentar (id_makanan, isi_komentar, tanggal_komentar) VALUES ('$idMakanan', '$komentar', '$tanggal')";

        
        if(mysqli_query($conn, $upKomen)){
           $isSuccess = true;
        }else{
            $isSuccess = false;

        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/color.css">
    <link rel="stylesheet" href="../styles/comment.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <title>komentar</title>
</head>
<body>
    <div class="navigation">
        <a href="home.php">
        <svg xmlns="http://www.w3.org/2000/svg" height="36px" viewBox="0 -960 960 960" width="36px" fill="#e8eaed"><path d="m313-440 224 224-57 56-320-320 320-320 57 56-224 224h487v80H313Z"/></svg>
        </a>
        <h1 class="header">Comments</h1>
    </div>
    <div class="container">
        <div class="post-container">
            <div class="post-header">
                <div class="header-profile">
                    <img src="ProfilePicture/<?php echo $post['foto_akun'] ?>" width=100 alt="profil">
                    <p class="username"><?php echo $post['username_akun']?></p>
                    <p class="date"><?php echo $post['tanggal_upload']?></p>     
                </div>
                <a href="report.php?id_makanan=<?php echo $post['id_makanan']; ?>"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-280q17 0 28.5-11.5T520-320q0-17-11.5-28.5T480-360q-17 0-28.5 11.5T440-320q0 17 11.5 28.5T480-280Zm-40-160h80v-240h-80v240ZM330-120 120-330v-300l210-210h300l210 210v300L630-120H330Zm34-80h232l164-164v-232L596-760H364L200-596v232l164 164Zm116-280Z"/></svg></a>
            </div>
            <img src="MakananUploads/<?php echo $post['foto_makanan'] ?>" alt="makanan">
            <h1><?php echo $post['judul_makanan']?></h1>
            <p class="deskripsi"><?php echo $post['deskripsi_makanan'] ?></p>
            <div class="rate">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m305-704 112-145q12-16 28.5-23.5T480-880q18 0 34.5 7.5T543-849l112 145 170 57q26 8 41 29.5t15 47.5q0 12-3.5 24T866-523L756-367l4 164q1 35-23 59t-56 24q-2 0-22-3l-179-50-179 50q-5 2-11 2.5t-11 .5q-32 0-56-24t-23-59l4-165L95-523q-8-11-11.5-23T80-570q0-25 14.5-46.5T135-647l170-57Z"/></svg>
                <p><?php echo $post['rating_makanan'] ?>/5.0</p>
            </div>
        </div>
        <form action="" method="post">
            <div class="comment-input">
                <input type="text" name="isi_komentar" id="isi_komentar" placeholder="Komentar" maxlength="255" autocomplete="off" required>
                <button id="komen" value="komen" name="up_komentar"><svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="#e8eaed"><path d="M120-160v-640l760 320-760 320Zm80-120 474-200-474-200v140l240 60-240 60v140Zm0 0v-400 400Z"/></svg></button>
            </div>
        </form>
        <div class="all-comment">
            <?php if(!empty($komen)): ?>
                <?php foreach ($komen as $km): ?>
                <div class="comment-container">
                    <img src="ProfilePicture/null-profile.png" alt="Foto anonim" width="35px" height="35px">
                    <div class="comment-content">
                        <h1>Anonim</h1>
                        <p class="date"><?php echo $km['tanggal_komentar']?></p>
                        <p><?php echo $km['isi_komentar']?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No comment</p>
            <?php endif; ?>
        </div>
    </div>

    <div id="modal" class="modal <?php if ($isSuccess === true) echo 'success';elseif ($isSuccess === false) echo 'failed'; ?>">
        <div class="content">
            <?php if ($isSuccess === true): ?>
                <svg xmlns="http://www.w3.org/2000/svg" height="64px" viewBox="0 -960 960 960" width="64px" fill="#81C784"><path d="M378-246 154-470l43-43 181 181 384-384 43 43-427 427Z"/></svg>
                <div class="text">
                    <h2 class="title">Comment Successful</h2>
                    <p class="subtitle">Your comment has been posted</p>
                </div>
                <button class="close" onclick="closeModal(true)">Ok</button>
            <?php elseif ($isSuccess === false): ?>
                <svg xmlns="http://www.w3.org/2000/svg" height="64px" viewBox="0 -960 960 960" width="64px" fill="#D32F2F "><path d="m249-207-42-42 231-231-231-231 42-42 231 231 231-231 42 42-231 231 231 231-42 42-231-231-231 231Z"/></svg>
                <div class="text">
                    <h2 class="title">Failed to post comment</h2>
                    <p class="subtitle">We couldn't save your comment.</p>
                </div>
                <button class="close" onclick="closeModal(false)">Ok</button>
            <?php endif; ?>
        </div>
    </div>
    <script>

        function closeModal(success){
            if(success){
                document.location.href = '<?php echo isset($redirectUrl) ? $redirectUrl : ''; ?>';
            }
            else{
                document.getElementById('modal').classList.remove('failed');
            }
        }
    </script>
</body>
</html>