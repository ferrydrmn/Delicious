<?php
    session_start();
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
                <a href="management-food.php">
                    <img src="pictures/man-food.png" alt="Food Management">
                </a>
                <h1>Manajemen Produk</h1>
            </div>
            <div class="sub-management-container">
                <a href="management-user.php">
                    <img src="pictures/man-user.png" alt="User Management">
                </a>
                <h1>Manajemen Pengguna</h1>
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