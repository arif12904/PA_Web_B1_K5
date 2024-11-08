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

if (isset($_SESSION['message'])) {
    echo "<script>alert('" . $_SESSION['message'] . "');</script>";
    unset($_SESSION['message']); 
}

$loginStatus = null;
$redirectUrl = ''; 

if(isset($_POST['masuk'])){
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    if ($username === $adminUsr) {
        if($password === $adminPass){
            $_SESSION['role'] = 'admin';
            $_SESSION['name'] = $username;
            $loginStatus = true;
            $redirectUrl = '../Admin/showReport.php';
        }else{
            $loginStatus = false;
        }
    }else{
        $findUsr = "SELECT * FROM akun WHERE username_akun = '$username'";
        $findUsrRslt = mysqli_query($conn, $findUsr);

        if(mysqli_num_rows($findUsrRslt) === 1){
            $akun = mysqli_fetch_assoc($findUsrRslt);
            if (password_verify($password, $akun['password_akun'])){
                $_SESSION['role'] = 'user';
                $_SESSION['username'] = $username;
                $loginStatus = true;
                $redirectUrl = '../User/home.php';
            }else {
                 $loginStatus = false;
            }
        } else{
            $loginStatus = false;
        }
    }
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="../styles/color.css">
    <link rel="stylesheet" href="../styles/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <title>Login</title>
</head>
<body>
<body>
    <form action="" method="post">
        <h2 class="login">Log In</h2>
        <input 
        type="text"
        name="username" 
        id="username" 
        placeholder="Username" 
        title="The text should only contain lowercase letters and numbers"
        maxlength="255"
        autocomplete="off"
        required>
        <input 
        type="password" 
        name="password" 
        id="password" 
        placeholder="Password" 
        maxlength="255"
        title="The password must contain at least 8 characters"
        autocomplete="off"
        required>
        <button value="Log In" name="masuk">Log in</button>
        <p>Don't have an account?<a href="signin.php"> Sign In</a></p>
    </form>
    
    <div id="modal" class="modal <?php if ($loginStatus === true) echo 'success';elseif ($loginStatus === false) echo 'failed'; ?>">
        <div class="content">
            <?php if ($loginStatus === true): ?>
                <svg xmlns="http://www.w3.org/2000/svg" height="64px" viewBox="0 -960 960 960" width="64px" fill="#81C784"><path d="M378-246 154-470l43-43 181 181 384-384 43 43-427 427Z"/></svg>
                <div class="text">
                    <h2 class="title">Login Successful</h2>
                    <p class="subtitle">You have successfully logged into your account</p>
                </div>
                <button class="close" onclick="closeModal(true)">OK</button>
            <?php elseif ($loginStatus === false): ?>
                <svg xmlns="http://www.w3.org/2000/svg" height="64px" viewBox="0 -960 960 960" width="64px" fill="#D32F2F "><path d="m249-207-42-42 231-231-231-231 42-42 231 231 231-231 42 42-231 231 231 231-42 42-231-231-231 231Z"/></svg>
                <div class="text">
                    <h2 class="title">Login Failed</h2>
                    <p class="subtitle">Please check your username and password</p>
                </div>
                <button class="close" onclick="closeModal(false)">OK</button>
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