<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (basename($_SERVER['SCRIPT_FILENAME']) == basename(__FILE__)) {
    echo "<script>window.history.back();</script>";
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


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/sidebar.css">
    <link rel="stylesheet" href="../styles/color.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
</head>
<body>
    <nav>
        <div class="top-nav">
            <div class="logo">
                <img src="../img/ei logo.png" alt="" width="40px">
                <h1 class="text">EatsInsight</h1>
            </div>
            <div class="nav-links">
                <a href="../User/home.php"><svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="#e8eaed"><path d="M240-200h120v-240h240v240h120v-360L480-740 240-560v360Zm-80 80v-480l320-240 320 240v480H520v-240h-80v240H160Zm320-350Z"/></svg><span class="text">Home</span></a>
                <a href="../User/search.php"><svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="#e8eaed"><path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/></svg><span class="text">Search</span></</a>
                <a href="../User/create.php"><svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="#e8eaed"><path d="M440-280h80v-160h160v-80H520v-160h-80v160H280v80h160v160ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z"/></svg><span class="text">Create</span></</a>
            </div>
        </div>
        <a class="profile" href="../User/profile.php"><img src="ProfilePicture/<?php echo $akun['foto_akun']?>" alt="" width="35px" height="35px"><span class="text">Profile</span></a>
    </nav>
</body>
</html>