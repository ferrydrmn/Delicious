<?php
    session_start();
    include ('include/class/connect.php');
    include ('include/class/account.php');
?>

<?php
    if(isset($_SESSION['id_pengguna'])){
        $id_pengguna = $_SESSION['id_pengguna'];
    }else{
        header('location:login.php');
    }
?>

<?php
    $account = new Account($id_pengguna);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include ('include/head.php'); ?>
    <link rel="stylesheet" href="style/account.css" type="text/css">
    <title>Delicious - Manajemen Akun</title>
</head>
<body>
    <?php include ('include/nav.php') ?>
    <main>
        <div class="main-container">
            <h1>Informasi Akun</h1>
            <div class="profile-picture">
                <img src="<?php echo $account->getFotoProfil() ?>" alt="Profile Picture">
            </div>
            <div class="profile-information">
                <h3>Nama:</h3>
                <p><?php echo $account->getNama() ?></p>
                <h3>Email:</h3>
                <p><?php echo $account->getEmail() ?></p>
                <h3>No HP:</h3>
                <p><?php echo $account->getNoHp() ?></p>
                <h3>Alamat:</h3>
                <p><?php echo nl2br($account->getAlamat()) ?></p>
                <div class="edit-button">
                    <a href="edit-account.php" class="edit-button">Edit Akun</a>
                    <a href="edit-password.php" class="edit-button">Edit Password</a>
                </div>
            </div>
        </div>
    </main>
    <?php include ('include/footer.php') ?>
</body>
</html>