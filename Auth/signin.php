<?php 
    require '../Connection/connection.php';
    require 'adminCnfg.php';

    session_start();

    if (isset($_SESSION['role'])){
        echo 
            "<script>
            alert('Anda harus logout dahulu!');
            </script>";
        if($_SESSION['role'] === 'user'){
            echo 
                "<script>
                document.location.href = '../User/home.php';
                </script>";
                exit;
        }else{
            echo 
                "<script>
                document.location.href = '../Admin/showReport.php';
                </script>";
        }
    }

    $registrationStatus = null; 

    if(isset($_POST['daftar'])){
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $checkUsr = "SELECT * FROM akun WHERE username_akun = '$username'";
        $checkUsrRslt = mysqli_query($conn, $checkUsr);

        if(mysqli_num_rows($checkUsrRslt)>0 || $username === $adminUsr){
            $registrationStatus = false;
        }else{
            $inputUsr = "INSERT INTO akun (username_akun, password_akun) VALUES ('$username', '$passwordHash')";
            if(mysqli_query($conn, $inputUsr)){
                $registrationStatus = true;
            }else{
                echo "
                <script>
                alert('Registrasi gagal!');
                document.location.href = 'signin.php';
                </script>
                ";
            }
        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/color.css">
    <link rel="stylesheet" href="../styles/signin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <title>Sign In</title>
</head>
<body>
<body>
    <form action="" method="post">
        <h2 class="sign-in">Sign In</h2>
        <input 
        type="text"
        name="username" 
        id="username" 
        placeholder="Username" 
        pattern="[a-z0-9]+"
        title="The text should only contain lowercase letters and numbers"
        maxlength="255"
        autocomplete="off"
        required>
        <input 
        type="password" 
        name="password" 
        id="password" 
        placeholder="Password" 
        minlength="5"
        maxlength="255"
        title="The password must contain at least 5 characters"
        autocomplete="off"
        required>
        <button type="submit" value="Sign In" name="daftar">Sign In</button>
        <p>Have an account? <a href="login.php">Log In</a></p>
    </form>

    <div id="modal" class="modal <?php if ($registrationStatus === true) echo 'success';elseif ($registrationStatus === false) echo 'failed'; ?>">
        <div class="content">
            <?php if ($registrationStatus === true): ?>
                <svg xmlns="http://www.w3.org/2000/svg" height="64px" viewBox="0 -960 960 960" width="64px" fill="#81C784"><path d="M378-246 154-470l43-43 181 181 384-384 43 43-427 427Z"/></svg>
                <div class="text">
                    <h2 class="title">Registration successful</h2>
                    <p class="subtitle">Start exploring and enjoy a new experience with us!</p>
                </div>
                <button class="close" onclick="closeModal(true)">OK</button>
            <?php elseif ($registrationStatus === false): ?>
                <svg xmlns="http://www.w3.org/2000/svg" height="64px" viewBox="0 -960 960 960" width="64px" fill="#D32F2F "><path d="m249-207-42-42 231-231-231-231 42-42 231 231 231-231 42 42-231 231 231 231-42 42-231-231-231 231Z"/></svg>
                <div class="text">
                    <h2 class="title">Registration Failed</h2>
                    <p class="subtitle">Username already taken. Please choose a different username</p>
                </div>
                <button class="close" onclick="closeModal(false)">OK</button>
            <?php endif; ?>
        </div>
    </div>
    <script>

        function closeModal(success){
            if(success){
                document.location.href = 'login.php'
            }
            else{
                document.getElementById('modal').classList.remove('failed');
            }
        }
    </script>
</body>
</html>