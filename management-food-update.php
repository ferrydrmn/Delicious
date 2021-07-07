<?php
    session_start();
    include ('include/class/connect.php');
    include ('include/class/product.php');
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
    //Inisiasi Objek
    $product = new Product();
?>

<?php
    if(isset($_GET['id_produk'])){
        $id_produk = $_GET['id_produk'];
        $result = $product->showSingleProduct($id_produk);
    }else{
        header("location:management-food.php");
    }
?>

<?php
    if(isset($_POST['submit'])){
        //Ambil Data
        $getNama = $_POST['namaProduk'];
        $getJenis = $_POST['jenisProduk'];
        $getDeskripsi = $_POST['deskripsi'];
        $getHarga = $_POST['harga'];

        //Cek Foto Produk
        $statusFoto1 = false;
        $statusFoto2 = false;
        $statusFoto3 = false;

        $cekFoto = true;

        if($_FILES['fotoProduk1']['name'] != ''){
            $type = $_FILES['fotoProduk1']['type'];
            $statusFoto1 = true;
            if($type == 'image/jpg' or $type == 'image/jpeg' or $type == 'image/png'){
                $cekFoto *= true;
            }else{
                $cekFoto *= false;
            }
        }

        if($_FILES['fotoProduk2']['name'] != ''){
            $type = $_FILES['fotoProduk2']['type'];
            $statusFoto2 = true;
            if($type == 'image/jpg' or $type == 'image/jpeg' or $type == 'image/png'){
                $cekFoto *= true;
            }else{
                $cekFoto *= false;
            }
        }

        if($_FILES['fotoProduk3']['name'] != ''){
            $type = $_FILES['fotoProduk3']['type'];
            $statusFoto3 = true;
            if($type == 'image/jpg' or $type == 'image/jpeg' or $type == 'image/png'){
                $cekFoto *= true;
            }else{
                $cekFoto *= false;
            }
        }  

        if(isset($cekFoto)){
            if($cekFoto == false){
                $verification = 'Ekstensi foto produk harus PNG, JPG, atau PNG!';
            }else{
                //Cek Nama
                $cekNama = $product->showSingleProduct($id_produk);
                if($cekNama['nama_produk'] == $getNama){
                    $product->updateProductSameName($getJenis,$getDeskripsi,$getHarga,$id_produk);
                    include('update-product-picture.php');
                }else{
                    $verification = $product->updateProduct($getNama,$getJenis,$getDeskripsi,$getHarga,$id_produk);
                    if($verification == false){
                        $verification = "Nama produk telah digunakan!";
                    }else{
                        include('update-product-picture.php');
                    }
                }
            }
        }       
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ('include/head.php'); ?>
    <link rel="stylesheet" href="style/management-data.css" type="text/css">
    <title>Delicious - Manajemen Makanan</title>
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
            <div class="sub-container">
                <h3 class="sub-title">Update Data Produk</h3>
                <div class="insert-form">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <label for="namaProduk">Nama Produk:</h3>
                        <input type="text" id="namaProduk" name="namaProduk" maxlength="40" value='<?php echo $result['nama_produk'] ?>' required>
                        <label for="jenisProduk" required>Jenis Produk:</label>
                        <select name="jenisProduk" class="option">
                            <option value='makanan'>Makanan</option>
                            <option value='minuman'>Minuman</option>
                        </select>
                        <label for="deskripsi">Deskripsi:</label>
                        <textarea name ="deskripsi" class="textArea" placeholder="Deskripsi makanan..." rows="8" required><?php echo $result['deskripsi'] ?></textarea>
                        <label for="harga">Harga:</h3>
                        <input type="number" id="harga" name="harga" value='<?php echo $result['harga'] ?>' required>
                        <label for="fotoProduk1">Foto Produk 1:</label>
                        <input id="fotoProduk1" name="fotoProduk1" type="file">
                        <label for="fotoProduk2">Foto Produk 2:</label>
                        <input id="fotoProduk2" name="fotoProduk2" type="file">
                        <label for="fotoProduk3">Foto Produk 3:</label>
                        <input id="fotoProduk3" name="fotoProduk3" type="file">
                        <p style="font-size: 18px; color: red;"><?php echo $verification ?></p>
                        <div class="submit-button">
                            <input type="submit" value="Submit" name="submit" class="submit-button">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <?php include ('include/footer.php') ?>
</body>
</html>