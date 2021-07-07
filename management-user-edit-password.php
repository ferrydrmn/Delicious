<?php 
    session_start();
    include ('include/class/connect.php');
    include ('include/class/management-account.php');
    $verification = '';
?>

<?php
    if(isset($_SESSION['id_pengguna'])){
        if($_SESSION['level'] != 'admin'){
            header('location:management.php');
        }
    }else{
        header('location:login.php');
    }  
?>

<?php
    if(isset($_GET['id_pengguna'])){
        $id_pengguna = $_GET['id_pengguna'];
    }else{
        header('location:management-user.php');
    }
?>

<?php
    if(isset($_POST['submit'])){
        $account = new ManAccount();
        $password_baru = md5($_POST['password_baru']);
        $password_konfirm = md5($_POST['password_konfirm']);
        if($password_baru == $password_konfirm){
            $account->editPassword($password_baru,$id_pengguna);
        }else{
            $verification = "Password baru dengan konfirmasi<br>password baru tidak sama!";
        }
    }   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ('include/head.php') ?>
    <link rel="stylesheet" href="style/account.css" type="text/css">
    <title>Delicious - Edit Password</title>
    <style>
        .edit-password{
            width: 100%;
        }
    </style>
</head>
<body>
    <?php include ('include/nav.php') ?>
    <main>
        <div class="main-container">
            <h1>Edit Password</h1>
            <div class="profile-picture">
                <img src="pictures/password.png" alt="Password">
            </div>
            <div class="profile-information">
                <form action="" method="POST" class="edit-password">
                    <h3>Password Baru:</h3>
                    <input type="password" name="password_baru" maxlength="14" class="input-information-account" required>
                    <h3>Konfirmasi Password Baru: </h3>
                    <input type="password" name="password_konfirm" maxlength="14" class="input-information-account" required>
                    <p style="color: red; font-size: 18px; text-align: center;"><?php echo $verification ?></p>
                    <input type="submit" value="Submit" name="submit" class="edit-button-child" class="input-information-account">
                </form>
            </div>
        </div>
    </main>
    <?php include ('include/footer.php') ?>
</body>
</html>

        