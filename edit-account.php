<?php
    session_start();
    include ('include/class/connect.php');
    include ('include/class/account.php');
    $verification = '';
?>

<?php
    if(isset($_SESSION['id_pengguna'])){
        $id_pengguna = $_SESSION['id_pengguna'];
    }else{
        header('location:login.php');
    }
?>

<?php
    $account = new Account($id_pengguna);
    if(isset($_POST['submit'])){
        $nama = $_POST['nama'];
        $no_hp = $_POST['no_hp'];
        $alamat = $_POST['alamat'];
        foreach($_POST as $key => $value){
            if($key != 'submit'){
                $account->updateData($key,$value);
            }
        }
        if(!empty($_FILES['foto-profil']['tmp_name'])){
            $typeFile = $_FILES['foto-profil']['type'];
            if($typeFile == 'image/png' or $typeFile == 'image/jpg' or $typeFile =='image/jpeg'){
                $namaFoto = $id_pengguna.'.png';
                $tname = $_FILES['foto-profil']['tmp_name'];
                $uploads_dir = 'profile';
                move_uploaded_file($tname, $uploads_dir.'/'.$namaFoto);
                $image_path = $uploads_dir.'/'.$namaFoto;
                $account->updateData('foto_profil',$image_path);
                echo "<script>
                    alert('Data berhasil diupdate!');
                    window.location.href='account.php';
                </script>";
            }else{
                $verification = 'Esktensi foto harus PNG/JPG/JPEG!';
            }
        }else{
            echo 
            "<script>
                alert('Data berhasil diupdate!');
                window.location.href='account.php';
            </script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ('include/head.php'); ?>
    <link rel="stylesheet" href="style/account.css" type="text/css">
    <title>Delicious - Edit Informasi Akun</title>
    <style>
        h3{
            font-size: 20px;
        }
    </style>
</head>
<body>
    <?php include ('include/nav.php'); ?>
    <main>
        <div class="main-container">
            <h1>Informasi Akun</h1>
            <div class="profile-picture">
                <img src="<?php echo $account->getFotoProfil() ?>" alt="Profile Picture">
            </div>
            <div class="profile-information">
                <form action="" method="POST" enctype="multipart/form-data">
                    <h3>Nama:</h3>
                    <input type="text" value="<?php echo $account->getNama() ?>" name="nama" maxlength="40" class="input-information-account" required>
                    <h3>No HP (+62):</h3>
                    <input type="number" value="<?php echo $account->getNoHp() ?>" name="no_hp" maxlength="13" class="input-information-account" required>
                    <h3>Alamat:</h3>
                    <textarea name ="alamat" class="input-information-account" placeholder="Alamat rumah" rows="5" required><?php echo $account->getAlamat() ?></textarea>
                    <h3>Foto Profil:</h3>
                    <input id="foto-profil" name="foto-profil" type="file">
                    <p style="color: red"><?php echo $verification ?></p>
                    <input type="submit" value="Submit" name="submit" class="edit-button-child" class="input-information-account">
                </form>
            </div>
        </div>
    </main>
    <?php include ('include/footer.php'); ?>
</body>
</html>