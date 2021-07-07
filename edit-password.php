<?php
    session_start();
    include ('include/class/connect.php');
    include ('include/class/account.php');
    $verification = '';
?>

<?php
    if(isset($_SESSION['id_pengguna'])){
        $id_pengguna = $_SESSION['id_pengguna'];
    }else{
        header('location:login.php');
    }
?>

<?php
    if(isset($_POST['submit'])){ //Ganti sesuai tombol ya
        $account = new Account($id_pengguna);
        $password_baru = md5($_POST['password_baru']);
        $password_konfirm = md5($_POST['password_konfirm']);
        $password_lama = $account->getPassword();
        if(md5($_POST['password_lama']) == $password_lama){
            if($password_baru == $password_konfirm){
                $account->updateData('password',$password_baru); 
                echo "<script>
                    alert('Password berhasil diganti!');
                    window.location.href='account.php';
                </script>";
            }else{
                $verification = "Password baru dengan konfirmasi password baru tidak sama!";
            }
        }else{
            $verification = "Password lama salah!";
        }
    }   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ('include/head.php') ?>
    <link rel="stylesheet" href="style/account.css" type="text/css">
    <title>EPBSS - Ganti Password</title>
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
            <h1>Ganti Password</h1>
            <div class="profile-picture">
                <img src="pictures/password.png" alt="Password">
            </div>
            <div class="profile-information">
                <form action="" method="POST" enctype="multipart/form-data" class="edit-password">
                    <h3>Password Lama:</h3>
                    <input type="password" name="password_lama" maxlength="14" class="input-information-account" required>
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

        