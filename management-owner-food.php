<?php
    session_start();
    include ('include/class/connect.php');
    include ('include/class/product.php');
    include ('include/class/paymentlog.php');
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

<?php
    $product = new Product();
    $data = $product->showAllProduct();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ('include/head.php') ?>
    <link rel="stylesheet" href="style/management-data.css" type="text/css">
    <title>Delicious - Manajemen Produk</title>
</head>
<body>
    <?php include ('include/nav.php') ?>
    <main>
        <div class="main-container">
            <h1 class="title">Informasi Produk</h1>
            <div class="management-button-main-container">
            </div>
            <div class="sub-container" style="width: 75%;">
                <h3 class="sub-title">Daftar Data Produk</h3>
                <div class="insert-form">
                    <?php if($data == false): ?>
                       <h3>Belum ada data produk yang diinput!</h3>
                    <?php else: ?>
                        <?php 
                            $payment = new PaymentLog();
                            $nomor = 1; 
                        ?>
                        <table class='update-table-food'>
                            <tr>
                                <th>No.</th>
                                <th>ID Produk</th>
                                <th>Nama Produk</th>
                                <th>Jenis Produk</th>
                                <th>Deskripsi</th>
                                <th>Harga (Rp.)</th>
                                <th>Status</th>
                                <th>Profit</th>
                            </tr>
                            <?php foreach($data as $result): ?>
                                <?php
                                    $profit = $payment->productProfit($result['id_produk']) 
                                ?>
                                <tr>
                                    <td><?php echo $nomor ?></td>
                                    <td><?php echo $result['id_produk'] ?></td>
                                    <td><a href='detail.php?id_produk=<?php echo $result['id_produk'] ?>'><?php echo $result['nama_produk'] ?></a></td>
                                    <td><?php echo ucfirst($result['jenis_produk']) ?></td>
                                    <td><?php echo $result['deskripsi'] ?></td>
                                    <td><?php echo number_format($result['harga'] , 0, ',', '.') ?></td>
                                    <td><?php echo ucfirst($result['status']) ?></td>
                                    <td><?php echo number_format($profit, 0, ',', '.') ?></td>
                                </tr>
                                <?php $nomor ++ ?>
                            <?php endforeach ?>
                            </table>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </main>
    <?php include ('include/footer.php') ?>
</body>
</html>