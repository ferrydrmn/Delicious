<?php
    session_start();
    include ('include/class/connect.php');
    include ('include/class/login.php');
    $verification = "";
?>

<?php
    if(isset($_SESSION['id_pengguna'])){
        header('location:index.php');
    }
?>

<?php 
    if(isset($_POST['submit'])){
        $login = new Login();
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $verification = $login->verification($email,$password);
        if($verification == ""){
            $_SESSION['id_pengguna'] = $login->getIdPengguna($_POST['email']);
            $_SESSION['level'] = $login->getLevel($_POST['email']);
            if($_SESSION['level'] == 'admin' or $_SESSION['level'] == 'owner'){
                header('location:management.php');
            }else{
                header('location:index.php');
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ('include/head.php'); ?>
    <link rel="stylesheet" href="style/login.css" type="text/css">
    <title>Delicious - Login</title>
</head>
<body>
    <?php include ('include/nav.php'); ?>
    <main>
        <div class="main-container">
            <div class="login-banner">
                <img src="pictures/login-banner.png" alt="Login Banner">
            </div>
            <form action="" method="POST" class="login-form">
                <h1>LOG IN</h1>
                <p>Sebagai member Delicious!</p>
                <label for="email">Email</label>
                <input id="email" type="email" name="email" maxlength="40">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" maxlength="12">
                <p style="font-size: 18px; margin: 5px 0; color: red;"><?php echo $verification; ?></p>
                <p style="font-size: 18px; margin: 5px 0;">Belum punya akun? <a href="register.php">Registrasi di sini!</a>
                <div class="login-button">
                    <input type="submit" name="submit" value="Login">
                </div>
            </form>
        </div>
    </main>
    <?php include ('include/footer.php'); ?>
</body>
</html>