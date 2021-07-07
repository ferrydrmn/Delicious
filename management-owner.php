<?php
    session_start();
?>

<?php
    if(isset($_SESSION['id_pengguna'])){
        if($_SESSION['level'] != 'owner'){
            header('location:management.php');
        }
    }else{
        header('location:login.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ('include/head.php'); ?>
    <link rel="stylesheet" href="style/management.css" type="text/css">
    <title>Delicious - Manajemen Admin</title>
</head>
<body>
    <?php include ('include/nav.php') ?>
    <main>
        <div class="management-container">
            <div class="sub-management-container">
                <a href="management-owner-income.php">
                    <img src="pictures/income.png" alt="Income Information">
                </a>
                <h1>Informasi Pemasukan</h1>
            </div>
            <div class="sub-management-container">
                <a href="management-owner-food.php">
                    <img src="pictures/man-food.png" alt="Product Information">
                </a>
                <h1>Informasi Produk</h1>
            </div>
            <div class="sub-management-container">
                <a href="account.php">
                    <img src="pictures/man-account.png" alt="Account Management">
                </a>
                <h1>Manajemen Akun</h1>
            </div>
        </div>
    </main>
    <?php include ('include/footer.php') ?>
</body>
</html>