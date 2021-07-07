<?php
    session_start();
    include ('include/class/connect.php');
    include ('include/class/account.php');
    include ('include/class/management-account.php');
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
    $account = new ManAccount();
    $results = $account->allUser();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ('include/head.php') ?>
    <link rel="stylesheet" href="style/management-data.css" type="text/css">
    <title>Delicious - Manajemen Pengguna</title>
</head>
<body>
    <?php include ('include/nav.php') ?>
    <main>
        <div class="main-container">
            <h1 class="title">Manajemen Pengguna</h1>
            <div class="sub-container" style="width: 95%; margin: 25px 0;">
                <h3 class="sub-title">Informasi Pengguna</h3>
                <div class="insert-form">
                    <?php if($results == false): ?>
                       <h3>Belum ada data pengguna yang diinput!</h3>
                    <?php else: ?>
                        <?php $nomor = 1 ?>
                            <table class='update-table-food' style='width: 100%;'>
                            <tr>
                                <th>No.</th>
                                <th>ID User</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No. HP (+62)</th>
                                <th>Level</th>
                                <th>Alamat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            <?php foreach($results as $result): ?>
                                <tr>
                                    <td><?php echo $nomor ?></td>
                                    <td><?php echo $result['id_pengguna'] ?></td>
                                    <td><?php echo $result['nama'] ?></td>
                                    <td><?php echo $result['email'] ?></td>
                                    <td><?php echo $result['no_hp'] ?></td>
                                    <td><?php echo ucfirst($result['level']) ?></td>
                                    <td><?php echo $result['alamat'] ?></td>
                                    <td><?php echo ucfirst($result['status']) ?></td>
                                    <?php if($result['level'] == 'customer' or $result['level'] == 'cashier'): ?>
                                        <?php if($result['status'] == 'aktif'): ?>
                                            <td style='width: 25%;'><a class ='red-button edit' href='management-user-block.php?id_pengguna=<?php echo $result['id_pengguna'] ?>'>Blokir</a>
                                        <?php else: ?>
                                            <td style='width: 25%;'><a class='green-button edit' href='management-user-block.php?id_pengguna=<?php echo $result['id_pengguna'] ?>'>Unblokir</a>
                                        <?php endif ?>
                                        <a class='blue-button edit' href='management-user-edit-password.php?id_pengguna=<?php echo $result['id_pengguna'] ?>'>Edit Password</a></td></tr>
                                    <?php else: ?>
                                        <?php if($result['level'] != 'guest'): ?>
                                            <td style='width: 25%;'><a class='blue-button edit' href='management-user-edit-password.php?id_pengguna=<?php echo $result['id_pengguna'] ?>'>Edit Password</a></td>
                                        <?php else: ?>
                                            <td></td>
                                        <?php endif ?>
                                    <?php endif ?>
                                </tr>
                                <?php $nomor++ ?>
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