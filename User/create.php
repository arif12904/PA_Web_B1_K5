<?php 
    session_start();
    require '../Connection/connection.php';
    require "../templates/navbar.php";

    if (!isset($_SESSION['username'])){
        echo 
        "<script>
        alert('Tidak bisa mengakses halaman ini!');
        document.location.href = '../Auth/login.php';
        </script>";
        exit;
    }

    $username = $_SESSION['username'];
    $getId = "SELECT id_akun FROM akun WHERE username_akun='$username'";
    $getIdRslt = mysqli_query($conn, $getId);
    $akun = mysqli_fetch_assoc($getIdRslt);
    $idAkun = $akun['id_akun'];
    $isImage = null;
    $isSuccess = null;

    if (isset($_POST['create'])) {
        $judul = htmlspecialchars($_POST['judul']);
        $desc = htmlspecialchars($_POST['desc']);
        $rate = $_POST['rate'];
        $tanggal = date('Y-m-d');
        $gambar = $_FILES['foto']['name'];
        $gambarTemp = $_FILES['foto']['tmp_name'];

        $fileEkstensi = pathinfo($gambar, PATHINFO_EXTENSION);
        $gambarFinal = date('YmdHis').'.'.$fileEkstensi;

        $dir =  "MakananUploads/";
        $uploadDir = $dir . $gambarFinal;

        $ekstensiList = ['jpg', 'jpeg', 'png'];

        if(in_array(strtolower($fileEkstensi), $ekstensiList)){
            if(move_uploaded_file($gambarTemp, $uploadDir)){
                $uploadSql = "INSERT INTO makanan (judul_makanan, deskripsi_makanan, foto_makanan, rating_makanan, tanggal_upload, id_akun) VALUES ('$judul', '$desc', '$gambarFinal', '$rate', '$tanggal', '$idAkun')";
                if(mysqli_query($conn, $uploadSql)){
                    $isSuccess = true;
                }else{
                    $isSuccess = false;

                }
            }
        }else{
            $isSuccess = false;
            $isImage = false;
        }

    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/create.css">
    <title>Create</title>
</head>
<body>
    <h1 class="header">Create Insight</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="create-container">
            <label for="judul">Title</label>
            <input type="text" name="judul" id="judul" placeholder="Type something here" maxlength="255" autocomplete="off" required>
            <label for="desc">Description</label>
            <input type="text" style="max-width: 100%;" name="desc" id="desc" placeholder="Type something here" maxlength="2000" autocomplete="off" required>
            <label for="rate">Rate</label>
            <input type="number" name="rate" id="rate" min="1.0" max="5.0" step="0.1" oninput="validity.valid||(value='');" placeholder="Your rate" required>
            <label for="foto">Image</label>
            <input type="file" name="foto" id="foto" required>
            <input type="submit" value="Create" name="create">
        </div>
    </form>

    <div id="modal" class="modal <?php if ($isSuccess === true) echo 'success';elseif ($isSuccess === false) echo 'failed'; ?>">
        <div class="content">
            <?php if ($isSuccess === true): ?>
                <svg xmlns="http://www.w3.org/2000/svg" height="64px" viewBox="0 -960 960 960" width="64px" fill="#81C784"><path d="M378-246 154-470l43-43 181 181 384-384 43 43-427 427Z"/></svg>
                <div class="text">
                    <h2 class="title">Update Post Successful</h2>
                    <p class="subtitle">Your post has been successfully updated </p>
                </div>
                <button class="close" onclick="closeModal(true)">Ok</button>
            <?php elseif ($isSuccess === false): ?>
                <svg xmlns="http://www.w3.org/2000/svg" height="64px" viewBox="0 -960 960 960" width="64px" fill="#D32F2F "><path d="m249-207-42-42 231-231-231-231 42-42 231 231 231-231 42 42-231 231 231 231-42 42-231-231-231 231Z"/></svg>
                <div class="text">
                    <h2 class="title">Update Post Failed</h2>
                    <?php if ($isImage === false): ?>
                        <p class="subtitle">File must be in JPG, JPEG, or PNG format</p>
                    <?php endif; ?>
                </div>
                <button class="close" onclick="closeModal(false)">Ok</button>
            <?php endif; ?>
        </div>
    </div>
    <script>
        function closeModal(success){
            if(success){
                document.location.href = 'home.php'
            }
            else{
                document.getElementById('modal').classList.remove('failed');
            }
        }
    </script>
</body>
</html>