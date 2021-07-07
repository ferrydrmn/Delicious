<?php 
    session_start();
    include ('include/class/connect.php');
    include ('include/class/product.php');
    include ('include/class/transaction.php');
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

<?php
    if(isset($_GET['id_pembayaran'])){
        $id_pembayaran = $_GET['id_pembayaran'];
        $transaction = new Transaction();
        $transaction->accTransaksi($id_pembayaran);
    }else{
        header('location:management-cashier.php');
    }
?>