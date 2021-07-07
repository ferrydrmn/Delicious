<?php
    session_start();
    include ('include/class/connect.php');
    include ('include/class/product.php');
    include ('include/class/rating.php');
    include ('include/class/photo.php');
?>

<?php
    if(isset($_SESSION['id_pengguna'])){
        if(isset($_SESSION['level'])){
            if($_SESSION['level'] == 'admin' or $_SESSION['level'] == 'owner'){
                header('location:management.php');
            }
        }
    }
?>

<?php
    $makanan = new Product();
    $dataMakanan = $makanan->showProduct('makanan');
    $minuman = new Product();
    $dataMinuman = $minuman->showProduct('minuman');
    $integerOnly = "validity.valid||(value='')";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ('include/head.php'); ?>
    <link rel="stylesheet" href="style/home.css" type="text/css">
    <title>Delicious - Home</title>
    <style>
        .jenis-produk{
            font-size: 24px;
            background-color: white;
            padding: 5px 10px;
            border-radius: 10px;
            box-shadow: 5px 10px 18px #888888;
            margin: 15px 0;
        }
        .nama-produk a{
            color: black;
        }
        .block-rating{
            display: inline-flex;
        }
    </style>
</head>
<body>
    <?php include ('include/nav.php'); ?>
    <main>
        <form action="transaction.php" method="POST" class="list-menu-main-container">
            <h1 class="jenis-produk">Makanan</h1>
            <div class="list-menu">
                <?php if($dataMakanan == false): ?>
                        <h3 style='font-size: 24px;'>Belum ada produk makanan yang ditambahkan.</h3>
                <?php else: ?>
                    <?php foreach($dataMakanan as $data): ?>
                        <?php
                            #Ambil Foto
                            $foto = new Photo();
                            $pathFoto = $foto->showFirstPhoto($data['id_produk']);
                            #Ambil Rating
                            $rating = new Rating();
                            $avgRating = $rating->avgRating($data['id_produk']);
                        ?>
                        <div class='card'>
                            <div class='product-image'>
                                <img src='<?php echo $pathFoto ?>' alt='Produk'>
                            </div>
                            <h3 class='nama-produk'><a href='detail.php?id_produk=<?php echo $data['id_produk'] ?>'><?php echo $data['nama_produk'] ?></a></h3>
                            <?php if($avgRating == false): ?>
                                <p>Belum memiliki rating dan review.</p>
                            <?php else: ?>
                                <div class='block-rating'>
                                    <?php for($i=1; $i<=$avgRating; $i++): ?>
                                        <img src='pictures/star.png' width='32px'>
                                    <?php endfor ?>
                                </div>
                            <?php endif ?>
                            <p><b>Rp. <?php echo number_format($data['harga'] , 0, ',', '.');  ?></b></p>
                            <label>Jumlah</label>
                            <input type='number' name='<?php echo $data['id_produk'] ?>' min='0' oninput='$integerOnly' value=0 step='1' multiple>
                        </div>
                    <?php endforeach ?>
                <?php endif ?>
            </div>
            <h1 class="jenis-produk">Minuman</h1>
            <div class="list-menu">
                <?php if($dataMinuman == false): ?>
                        <h3 style='font-size: 24px;'>Belum ada produk makanan yang ditambahkan.</h3>
                <?php else: ?>
                    <?php foreach($dataMinuman as $data): ?>
                        <?php
                            #Ambil Foto
                            $foto = new Photo();
                            $pathFoto = $foto->showFirstPhoto($data['id_produk']);
                            #Ambil Rating
                            $rating = new Rating();
                            $avgRating = $rating->avgRating($data['id_produk']);
                        ?>
                        <div class='card'>
                            <div class='product-image'>
                                <img src='<?php echo $pathFoto ?>' alt='Produk'>
                            </div>
                            <h3 class='nama-produk'><a href='detail.php?id_produk=<?php echo $data['id_produk'] ?>'><?php echo $data['nama_produk'] ?></a></h3>
                            <?php if($avgRating == false): ?>
                                <p>Belum memiliki rating dan review.</p>
                            <?php else: ?>
                                <div class='block-rating'>
                                    <?php for($i=1; $i<=$avgRating; $i++): ?>
                                        <img src='pictures/star.png' width='32px'>
                                    <?php endfor ?>
                                </div>
                            <?php endif ?>
                            <p><b>Rp. <?php echo number_format($data['harga'] , 0, ',', '.');  ?></b></p>
                            <label>Jumlah</label>
                            <input type='number' name='<?php echo $data['id_produk'] ?>' min='0' oninput='$integerOnly' value=0 step='1' multiple>
                        </div>
                    <?php endforeach ?>
                <?php endif ?>
            </div>
            <div class="submit-button">
                <?php if($dataMakanan != false || $dataMinuman != false): ?>
                    <input type='submit' name='submit' value='Bayar'>
                <?php endif ?>
            </div>
        </form>
    </main>
    <?php include ('include/footer.php') ?>
</body>
</html>