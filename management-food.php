<?php
    session_start();
    include ('include/class/connect.php');
    include ('include/class/product.php');
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
    $product = new Product();
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
            <h1 class="title">Manajemen Produk</h1>
            <div class="management-button-main-container">
                <a href="management-food-insert.php" class="blue-button">Insert Data</a>
                <a href="management-food.php" class="blue-button">Update Data</a>
            </div>
            <div class="sub-container" style="width: 75%;">
                <h3 class="sub-title">Update Produk</h3>
                <div class="insert-form">
                    <?php if($product->showAllProduct() == false): ?>
                        <h3>Belum ada data produk yang diinput!</h3>
                    <?php else: ?>
                        <?php $nomor = 1 ?>
                        <table class='update-table-food'>
                        <tr>
                            <th>No.</th>
                            <th>ID Produk</th>
                            <th>Nama Produk</th>
                            <th>Jenis Produk</th>
                            <th>Deskripsi</th>
                            <th>Harga (Rp.)</th>
                            <th>Status</th>
                            <th style="width: 20%;">Aksi</th>
                        </tr>
                        <?php foreach($product->showAllProduct() as $result): ?>
                            <tr>
                                <td><?php echo $nomor ?></td>
                                <td><?php echo $result['id_produk'] ?></td>
                                <td><a href='detail.php?id_produk=<?php echo $result['id_produk'] ?>'><?php echo $result['nama_produk'] ?></a></td>
                                <td><?php echo ucfirst($result['jenis_produk']) ?></td>
                                <td><?php echo nl2br($result['deskripsi']) ?></td>
                                <td><?php echo number_format($result['harga'], 0, ',', '.') ?></td>
                                <td><?php echo ucfirst($result['status']) ?>
                                <?php if ($result['status'] == 'aktif'): ?>
                                    <td><a class ='red-button edit' href='status-food.php?id_produk=<?php echo $result['id_produk'] ?>'>Nonaktifkan</a>
                                <?php else: ?>
                                    <td><a class='green-button edit' href='status-food.php?id_produk=<?php echo $result['id_produk'] ?>'>Aktifkan</a>
                                <?php endif ?>
                                <a class='blue-button edit' href='management-food-update.php?id_produk=<?php echo $result['id_produk'] ?>'>Edit</a></td>
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