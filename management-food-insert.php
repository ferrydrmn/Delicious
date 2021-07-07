<?php
    session_start();
    include ('include/class/connect.php');
    include ('include/class/product.php');
    include ('include/class/photo.php');
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
    if(isset($_POST['submit'])){
        //Inisiasi Objek
        $product = new Product();
        //Ambil Data
        $getNama = $_POST['namaProduk'];
        $getJenis = $_POST['jenisProduk'];
        $getDeskripsi = $_POST['deskripsi'];
        $getHarga = $_POST['harga'];
        $getStatus = 'aktif';
        //Ambil Ekstensi File
        $esktensiFile1 = $_FILES['fotoProduk1']['type'];
        $esktensiFile2 = $_FILES['fotoProduk2']['type'];
        $esktensiFile3 = $_FILES['fotoProduk3']['type'];
        if(($esktensiFile1 == 'image/jpg' or $esktensiFile1 == 'image/jpeg' or $esktensiFile1 == 'image/png') and ($esktensiFile2 == 'image/jpg' or $esktensiFile2 == 'image/jpeg' or $esktensiFile2 == 'image/png') and ($esktensiFile3 == 'image/jpg' or $esktensiFile3 == 'image/jpeg' or $esktensiFile3 == 'image/png')){
            $cekNama = $product->checkProductName($getNama);
            if($cekNama->num_rows > 0){
                $verification = "Nama produk telah digunakan!";
            }else{
                //Query
                $id_final = $product->insertProduct($getNama,$getJenis,$getDeskripsi,$getHarga,$getStatus);
                //Query Foto
                $photo = new Photo();

                $namaFoto1 = 'P'.$id_final.'1.png';
                $namaFoto2 = 'P'.$id_final.'2.png';
                $namaFoto3 = 'P'.$id_final.'3.png';
                $tmp1 = $_FILES['fotoProduk1']['tmp_name'];
                $tmp2 = $_FILES['fotoProduk2']['tmp_name'];
                $tmp3 = $_FILES['fotoProduk3']['tmp_name'];
                $path = 'food';

                move_uploaded_file($tmp1,$path."/".$namaFoto1);
                move_uploaded_file($tmp2,$path."/".$namaFoto2);
                move_uploaded_file($tmp3,$path."/".$namaFoto3);
            
                $path_foto = $path."/".$namaFoto1;
                $photo->insertPhoto($id_final,$path_foto);
                
                $path_foto = $path."/".$namaFoto2;
                $photo->insertPhoto($id_final,$path_foto);
                
                $path_foto = $path."/".$namaFoto3;
                $photo->insertPhoto($id_final,$path_foto);

                echo"
                <script>
                alert('Data produk berhasil diinput!');
                window.location.href='management-food-update.php';
                </script>
                ";
            }
        }else{
            $verification = 'Ekstensi foto produk harus PNG, JPG, atau PNG!';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ('include/head.php'); ?>
    <link rel="stylesheet" href="style/management-data.css" type="text/css">
    <title>Delicious - Insert Data Produk</title>
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
                <h3 class="sub-title">Insert Data Produk</h3>
                <div class="insert-form">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <label for="namaProduk">Nama Produk:</h3>
                        <input type="text" id="namaProduk" name="namaProduk" maxlength="40" required>
                        <label for="jenisProduk" required>Jenis Produk:</label>
                        <select name="jenisProduk" class="option">
                            <option value='makanan'>Makanan</option>
                            <option value='minuman'>Minuman</option>
                        </select>
                        <label for="deskripsi">Deskripsi:</label>
                        <textarea name ="deskripsi" class="textArea" placeholder="Deskripsi makanan..." rows="8" required></textarea>
                        <label for="harga">Harga:</h3>
                        <input type="number" id="harga" name="harga"required>
                        <label for="fotoProduk1">Foto Produk 1:</label>
                        <input id="fotoProduk1" name="fotoProduk1" type="file" required>
                        <label for="fotoProduk2">Foto Produk 2:</label>
                        <input id="fotoProduk2" name="fotoProduk2" type="file" required>
                        <label for="fotoProduk3">Foto Produk 3:</label>
                        <input id="fotoProduk3" name="fotoProduk3" type="file" required>
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