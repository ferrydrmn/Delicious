<?php
    session_start();
    include ('include/class/connect.php');
    include ('include/class/product.php');
    include ('include/class/paymentlog.php');
?>

<?php
    if(isset($_SESSION['id_pengguna'])){
        if($_SESSION['level'] != 'customer' and $_SESSION['level'] != 'cashier'){
            header('location:management.php');
        }else{
            $id_pengguna = $_SESSION['id_pengguna'];
        }
    }else{
        header('location:login.php');
    }
?>

<?php
    if(isset($_GET['id_pembayaran'])){
        $id_pembayaran = $_GET['id_pembayaran'];
        $produk = new Product();
        $payment = new PaymentLog();
        if($_SESSION['level'] != 'cashier'){
            $cek = $payment->checkPayment($id_pengguna,$id_pembayaran);
            if($cek == false){
                header('location:management.php');
            }
        }
        $data = $payment->paymentDetail($id_pembayaran);
        $total = $payment->totalPayment($id_pembayaran);
    }else{
        header('location:management.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include ('include/head.php') ?>
    <link rel="stylesheet" href="style/home.css" type="text/css">
    <link rel="stylesheet" href="style/management-data.css" type="text/css">
    <title>EPBSS - Transaksi</title>
    <style>
        .jenis-pembayaran{
            display: flex;
            align-items: center;
            width: 20%;
        }
        .jenis-pembayaran input{
            width: 50%;
        }
        .konfirmasi-pembayaran input{
            border: none;
            color: white;
            background-color: #00a8ff;
            transition: 0.5s;
            border-radius: 10px;
            font-size: 16px;
            width: 25%;
            padding: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php include ('include/nav.php') ?>
    <main>
    <div class="main-container">
            <h1 class="title">Detail Histori Pembayaran</h1>
            <div class="management-button-main-container">
            </div>
            <div class="sub-container" style="width: 50%;">
                <h3>ID Pembayaran: <?php echo $id_pembayaran ?></h3>
                <div class="insert-form">
                    <table class='update-table-food'>
                        <tr>
                            <th>No.</th>
                            <th>Nama Produk</th>
                            <th>Harga/sajian</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                        </tr>
                    <?php $nomor = 1 ?>
                    <?php foreach($data as $result): ?>
                        <?php $informasiProduk = $produk->showSingleProduct($result['id_produk']) ?>
                            <tr>
                                <td><?php echo $nomor ?></td>
                                <td><?php echo $informasiProduk['nama_produk'] ?></td>
                                <td><?php echo number_format($result['harga'], 0, ',', '.')?></td>
                                <td><?php echo $result['jumlah']?></td>
                                <td><?php echo number_format($result['harga'] * $result['jumlah'], 0, ',', '.')?></td> 
                            </tr>
                            <?php $nomor++ ?>
                    <?php endforeach ?>
                    </table>
                    <h3 style="margin-top: 10px; font-weight: bold; font-size: 24px;">Total harga: Rp. <?php echo number_format($total, 0, ',', '.'); ?></h3>
                </div>
            </div>
        </div>
    </main>
    <?php include ('include/footer.php') ?>
</body>
</html>