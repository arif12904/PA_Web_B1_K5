<?php 
    session_start();
    require '../Connection/connection.php';
    require '../templates/navbar.php';

    if (!isset($_SESSION['username'])){
        echo 
        "<script>
        alert('Tidak bisa mengakses halaman ini!');
        document.location.href = '../Auth/login.php';
        </script>";
        exit;
    }
    $username= $_SESSION['username'];
    $getAkun = "SELECT * FROM akun WHERE username_akun = '$username'";
    $getAkunResult = mysqli_query($conn, $getAkun);
    $akun = mysqli_fetch_assoc($getAkunResult);
    $idAkun = $akun['id_akun'];
    $gambarLama = $akun['foto_akun'];
    $isImage = null;
    $isSuccess = null;

    if (isset($_POST['edit'])) {
        $username = htmlspecialchars($_POST['username']);

        $checkUsernameSql = "SELECT username_akun FROM akun WHERE username_akun = '$username' AND id_akun <> '$idAkun'";
        $checkUsernameRslt = mysqli_query($conn, $checkUsernameSql);

        if (mysqli_num_rows($checkUsernameRslt)>0) {
            $isSuccess = false;
        }else{
            if ($_FILES['foto']['error'] == UPLOAD_ERR_NO_FILE) {
                $gambarFinal = $gambarLama;
            }else{
                $gambarUp = $_FILES['foto']['name'];
                $gambarUpTmp = $_FILES['foto']['tmp_name'];

                $gambarEkstensi = pathinfo($gambarUp, PATHINFO_EXTENSION);
                $gambarFinal = date('Y-m-d_H-i-s'). ".". $gambarEkstensi;

                $pathGambarLama = "ProfilePicture/". $gambarLama;
                $pathGambarBaru = "ProfilePicture/". $gambarFinal;

                if(file_exists($pathGambarLama) && $gambarLama!== null){
                    unlink($pathGambarLama);
                }

                $ekstensiList = ['jpg', 'jpeg', 'png'];
                if(in_array(strtolower($gambarEkstensi), $ekstensiList)){
                    move_uploaded_file($gambarUpTmp, $pathGambarBaru);
                }else{
                    $isImage=false;
                    $isSuccess = false;
                }
            }   
            if($isSuccess !== false){
                $updateSql = "UPDATE akun SET username_akun = '$username', foto_akun='$gambarFinal' WHERE id_akun = '$idAkun'";
                    if(mysqli_query($conn, $updateSql)){
                        $_SESSION['username'] = $username;
                        $isSuccess = true;
                    }else{
                        echo "<script>
                            alert('Data gagal diubah!');
                            document.location.href = 'editProfile.php';
                        </script>";
                    }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/edit.css">
    <title>Edit Profile</title>
</head>
<body>
    <h1 class="header">Edit Profile</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="create-container">
            <label for="username">Username</label>
            <input 
            type="text" 
            name="username" 
            id="username" 
            placeholder="Type something here" 
            value="<?php echo $akun['username_akun']?>" 
            maxlength="25" 
            autocomplete="off" 
            pattern="[a-z0-9]+" 
            required>
            <input type="file" name="foto" id="foto">
            <input type="submit" value="Edit" name="edit">
        </div>
    </form>

    <div id="modal" class="modal <?php if ($isSuccess === true) echo 'success';elseif ($isSuccess === false) echo 'failed'; ?>">
        <div class="content">
            <?php if ($isSuccess === true): ?>
                <svg xmlns="http://www.w3.org/2000/svg" height="64px" viewBox="0 -960 960 960" width="64px" fill="#81C784"><path d="M378-246 154-470l43-43 181 181 384-384 43 43-427 427Z"/></svg>
                <div class="text">
                    <h2 class="title">Update Profile Successful</h2>
                    <p class="subtitle">You have successfully logged into your account</p>
                </div>
                <button class="close" onclick="closeModal(true)">Ok</button>
            <?php elseif ($isSuccess === false): ?>
                <svg xmlns="http://www.w3.org/2000/svg" height="64px" viewBox="0 -960 960 960" width="64px" fill="#D32F2F "><path d="m249-207-42-42 231-231-231-231 42-42 231 231 231-231 42 42-231 231 231 231-42 42-231-231-231 231Z"/></svg>
                <div class="text">
                    <h2 class="title">Update Profile Failed</h2>
                    <?php if ($isImage === false): ?>
                        <p class="subtitle">File must be in JPG, JPEG, or PNG format</p>
                    <?php else: ?>
                        <p class="subtitle">Username already taken. Please choose a different username</p>
                    <?php endif; ?>
                </div>
                <button class="close" onclick="closeModal(false)">Ok</button>
            <?php endif; ?>
        </div>
    </div>
    <script>
        function closeModal(success){
            if(success){
                document.location.href = 'profile.php'
            }
            else{
                document.getElementById('modal').classList.remove('failed');
            }
        }
    </script>
</body>
</html>