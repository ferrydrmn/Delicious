<?php
    session_start();
?>

<?php
    if(isset($_SESSION['id_pengguna'])){
        if($_SESSION['level'] != 'cashier'){
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
    <title>Delicious - Manajemen Akun</title>
</head>
<body>
    <?php include ('include/nav.php') ?>
    <main>
        <div class="management-container">
            <div class="sub-management-container">
                <a href="management-cashier-payment.php">
                    <img src="pictures/man-payment.png" alt="Payment Mangement">
                </a>
                <h1>Manajemen Pembayaran</h1>
            </div>
            <div class="sub-management-container">
                <a href="management-cashier-payment-history.php">
                    <img src="pictures/payment-history.png" alt="Payment History">
                </a>
                <h1>Histori Pembayaran</h1>
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