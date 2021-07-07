<?php
    session_start();
    include ('include/class/connect.php');
    include ('include/class/paymentlog.php')
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
    $payment = new PaymentLog();
    if(isset($_POST['submit'])){
        if($_POST['jenisProduk'] == 'hari'){
            $data = $payment->income("SELECT tanggal, sum(bayar) FROM pembayaran WHERE status = 'terima' group by tanggal");
        }else if($_POST['jenisProduk'] == 'bulan'){
            $data = $payment->income("SELECT YEAR(tanggal), MONTHNAME(tanggal), sum(bayar) FROM pembayaran WHERE status = 'terima' group by YEAR(tanggal), MONTH(tanggal)");
        }else{
            $data = $payment->income("SELECT YEAR(tanggal), sum(bayar) FROM pembayaran WHERE status = 'terima' group by YEAR(tanggal)");
        }
    }else{
        $data = $payment->income("SELECT tanggal, sum(bayar) FROM pembayaran WHERE status = 'terima' group by tanggal");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ('include/head.php') ?>
    <link rel="stylesheet" href="style/management-data.css" type="text/css">
    <title>Delicious - Transaksi Pembayaran</title>
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
            <h1 class="title">Informasi Pemasukan</h1>
            <div class="management-button-main-container" style="background-color: white; border-radius: 10px; padding: 15px; box-shadow: 5px 10px 18px #888888;">
                <form action="" method="POST">
                    <h3>Tampilkan berdasarkan:</h3>
                    <select name="jenisProduk" class="option">
                        <option value='hari'>Hari</option>
                        <option value='bulan'>Bulan</option>
                        <option value="tahun">Tahun</option>
                    </select>
                    <div class="income-submit">
                        <input type="submit" name="submit" value="Tampilkan" class="blue-button" style="border: none; margin: 10px;">
                    </div>
                </form>
            </div>
            <div class="sub-container" style="width: 75%; margin-top: 15px;">
                <h3 class="sub-title">Data Pemasukan</h3>
                <div class="insert-form">
                    <?php if($data == false): ?>
                        <h3>Belum ada data transaksi yang diinput!</h3>
                    <?php else: ?>
                        <?php $nomor = 1 ?>
                        <table class='update-table-food'>
                        <tr>
                            <th>No.</th>
                            <th>Tanggal</th>
                            <th>Jumlah (Rp.)</th>
                        </tr>
                        <?php if(isset($_POST['submit'])): ?>
                            <?php if($_POST['jenisProduk'] == 'hari'): ?>
                                <?php foreach($data as $result): ?>
                                    <tr>
                                        <td><?php echo $nomor ?></td>
                                        <td><?php echo $result['tanggal'] ?></td>
                                        <td><?php echo number_format($result['sum(bayar)'] , 0, ',', '.') ?></td>
                                    </tr>
                                    <?php $nomor++ ?>
                                <?php endforeach ?>
                                </table>
                            <?php elseif($_POST['jenisProduk'] == 'bulan'): ?>
                                <?php foreach($data as $result): ?>
                                    <tr>
                                        <td><?php echo $nomor ?></td>
                                        <td><?php echo $result['MONTHNAME(tanggal)']." ".$result['YEAR(tanggal)'] ?></td>
                                        <td><?php echo number_format($result['sum(bayar)'] , 0, ',', '.') ?></td>
                                    </tr>
                                    <?php $nomor++ ?>
                                <?php endforeach ?>
                                </table>
                            <?php else: ?>
                                <?php foreach($data as $result): ?>
                                    <tr>
                                        <td><?php echo $nomor ?></td>
                                        <td><?php echo $result['YEAR(tanggal)'] ?></td>
                                        <td><?php echo number_format($result['sum(bayar)'] , 0, ',', '.') ?></td>
                                    </tr>
                                    <?php $nomor++ ?>
                                <?php endforeach ?>
                                </table>
                            <?php endif ?>                      
                        <?php else: ?>
                            <?php foreach($data as $result): ?>
                                <tr>
                                    <td><?php echo $nomor ?></td>
                                    <td><?php echo $result['tanggal'] ?></td>
                                    <td><?php echo number_format($result['sum(bayar)'] , 0, ',', '.') ?></td>
                                </tr>
                                <?php $nomor++ ?>
                            <?php endforeach ?>
                            </table>
                        <?php endif ?>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </main>
    <?php include ('include/footer.php')?>
</body>
</html>