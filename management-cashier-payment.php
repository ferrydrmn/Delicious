<?php
    session_start();
    include ('include/class/connect.php');
    include ('include/class/paymentlog.php');
    include ('include/class/account.php');
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
    $payment = new PaymentLog();
    $data = $payment->allPaymentWaiting();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ('include/head.php') ?>
    <link rel="stylesheet" href="style/management-data.css" type="text/css">
    <title>Delicious - Transaksi Pembayaran</title>
    <style>
        .cashier-button{
            border: none;
            margin: 10px;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <?php include ('include/nav.php') ?>
    <main>
    <div class="main-container">
            <h1 class="title">Transaksi Pembayaran</h1>
            <div class="management-button-main-container">
            </div>
            <div class="sub-container" style="width: 75%;">
                <h3 class="sub-title">Daftar Transaksi</h3>
                <div class="insert-form">
                    <?php if($data == false): ?>
                        <h3>Belum ada data transaksi yang diinput!</h3>
                    <?php else: ?>
                        <?php $nomor = 1 ?>
                        <table class='update-table-food'>
                        <tr>
                            <th>No.</th>
                            <th>ID Pembayaran</th>
                            <th>Nama Customer</th>
                            <th>Alamat</th>
                            <th>Jumlah (Rp.)</th>
                            <th>Jenis</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                        <?php foreach($data as $result): ?>
                            <?php 
                                $customer = $payment->getUserDataPayment($result['id_pengguna']); 
                            ?>
                            <tr>
                                <td><?php echo $nomor ?></td>
                                <td><?php echo $result['id_pembayaran'] ?><a href='detail-payment-history.php?id_pembayaran=<?php echo $result['id_pembayaran'] ?>'>(Detail)</a></td>
                                <td><?php echo $customer['nama'] ?></td>
                                <td><?php echo nl2br($customer['alamat']) ?></td>
                                <td><?php echo number_format($result['bayar'] , 0, ',', '.') ?></td>
                                <td><?php echo ucfirst($result['jenis_pembayaran']) ?></td>
                                <td><?php echo ucfirst($result['status']) ?></td>
                                <td><button class='green-button cashier-button' onclick=accconfirm(<?php echo $result['id_pembayaran'] ?>)>Terima</button>
                                <button class='red-button cashier-button' onclick=delconfirm(<?php echo $result['id_pembayaran'] ?>)>Tolak</button></td>
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
    <script>
        function accconfirm(id_pembayaran){
            if(confirm("Apakah Anda yakin ingin menerima order tersebut?")){
                window.location.href='accept-order.php?id_pembayaran=' + id_pembayaran + '';
            }
        }
        function delconfirm(id_pembayaran){
            if(confirm("Apakah Anda yakin ingin menolak order tersebut?")){
                window.location.href='delete-order.php?id_pembayaran=' + id_pembayaran + '';
            }
        }
    </script>
</body>
</html>