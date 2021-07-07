<?php
    session_start();
?>

<?php
    if(isset($_SESSION['id_pengguna'])){
        if($_SESSION['level'] == 'customer'){
            header('location:management-customer.php');
        }else if($_SESSION['level'] == 'admin'){
            header('location:management-admin.php');
        }else if($_SESSION['level'] == 'cashier'){
            header('location:management-cashier.php');
        }else{
            header('location:management-owner.php');
        }
    }else{
        header('location:login.php');
    }
?>