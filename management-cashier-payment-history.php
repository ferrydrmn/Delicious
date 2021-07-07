<?php
    session_start();
    include ('include/class/connect.php');
    include ('include/class/paymentlog.php');
?>

<?php
    if(isset($_SESSION['id_pengguna'])){
        if($_SESSION['level'] != 'cashier'){
            header('location:management.php');
        }else{
            $id_pengguna = $_SESSION['id_pengguna'];
        }
    }else{
        header('location:login.php');
    }
?>

<?php 
    $payment = new PaymentLog();
    $data = $payment->allPayment();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ('include/head.php') ?>
    <link rel="stylesheet" href="style/management-data.css" type="text/css">
    <title>Delicious - Histori Pembayaran</title>
    <style>
        .income-submit{
            display: flex;
            justify-content: center;
            align-items: center;
            border: none;
        }
    </style>
</head>
<body>
    <?php include ('include/nav.php') ?>
    <main>
    <div class="main-container">
            <h1 class="title">Data Histori Pembayaran</h1>
            <div class="management-button-main-container">
            </div>
            <div class="sub-container" style="width: 75%;">
                <h3 class="sub-title">Daftar Transaksi</h3>
                <div class="insert-form">
                    <?php if($results = false): ?>
                        <h3>Belum ada data transaksi yang diinput!</h3>
                    <?php else: ?>
                        <?php $nomor = 1 ?>
                        <table class='update-table-food'>
                        <tr>
                            <th>No.</th>
                            <th>ID Pembayaran</th>
                            <th>Jumlah (Rp.)</th>
                            <th>Status</th>
                        </tr>
                        <?php foreach($data as $result): ?>
                            <tr>
                                <td><?php echo $nomor ?></td>
                                <td><?php echo $result['id_pembayaran'] ?><a href='detail-payment-history.php?id_pembayaran=<?php echo $result['id_pembayaran'] ?>'>(Detail)</a></td>
                                <td><?php echo number_format($result['bayar'] , 0, ',', '.') ?></td>
                                <td><?php echo ucfirst($result['status']) ?></td>
                            </tr>
                            <?php $nomor ++ ?>
                        <?php endforeach ?>
                        </table>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </main>
    <?php include ('include/footer.php')?>
</body>
</html>