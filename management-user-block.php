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
        $account = new ManAccount();
        $account->blockUser($id_pengguna);
    }else{
        header('location:management-user.php');
    }
?>
