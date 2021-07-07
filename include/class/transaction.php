<?php
    class Transaction extends Product{
        private $totalSemua;
        private $cekMakananOrder = 0;
        private $cekMinumanOrder = 0;
        public $arrayMakanan = array();
        public $arrayMinuman = array();

        public function setCekMakananOrder($value){
            $this->cekMakananOrder = $value;
        }

        public function setCekMinumanOrder($value){
            $this->cekMinumanOrder = $value;
        }

        public function getCekMakananOrder(){
            return $this->cekMakananOrder;
        }

        public function getCekMinumanOrder(){
            return $this->cekMinumanOrder;
        }

        public function tambahTotalSemua($value){
            $this->totalSemua += $value;
        }

        public function getTotalSemua(){
            return $this->totalSemua;
        }

        public function getArrayMakanan(){
            return $this->arrayMakanan;
        }

        public function getArrayMinuman(){
            return $this->arrayMinuman;
        }

        public function cekOrder(){
            $makanan = $this->getCekMakananOrder();
            $minuman = $this->getCekMinumanOrder();
            if($minuman == 0 and $makanan == 0){
                echo "<script>
                    alert('Order minimal 1 produk!');
                    window.location.href='index.php';
                </script>
                ";
            }
        }

        public function cekTransaksi($getData){
            $dataProduk = $this->showAllProduct();
            foreach($dataProduk as $data){
                $index = $data['id_produk'];
                $cekProduk = $getData[$index];
                if($cekProduk > 0){
                    if($data['jenis_produk'] == 'makanan'){
                        $this->setCekMakananOrder(1);
                        $this->arrayMakanan[$index] = $cekProduk;
                    }else{
                        $this->setCekMinumanOrder(1);
                        $this->arrayMinuman[$index] = $cekProduk;
                    }
                }
            }
            $this->cekOrder();
        }

        public function hitungTransaksi(){
            $nomor = 1;
            $this->cekOrder();
            if($this->getCekMakananOrder() == true){
                foreach($this->arrayMakanan as $key => $value){
                    $sql = "SELECT nama_produk, harga FROM produk WHERE id_produk = $key";
                    $execute = $this->connect()->query($sql);
                    $result = $execute->fetch_assoc();
                    $total = $value * $result['harga'];
                    echo "
                    <tr>
                        <td>$nomor</td>
                        <td>$result[nama_produk]</td>
                        <td>$result[harga]</td>
                        <td>$value</td>
                        <td>$total</td>
                    </tr>
                    ";
                    $this->tambahTotalSemua($total);
                    $nomor ++;
                }
            }
            if($this->getCekMinumanOrder() == true){
                foreach($this->arrayMinuman as $key=>$value){
                    $sql = "SELECT nama_produk, harga FROM produk WHERE id_produk = $key";
                    $execute = $this->connect()->query($sql);
                    $result = $execute->fetch_assoc();
                    $total = $value * $result['harga'];
                    echo "
                    <tr>
                        <td>$nomor</td>
                        <td>$result[nama_produk]</td>
                        <td>$result[harga]</td>
                        <td>$value</td>
                        <td>$total</td>
                    </tr>
                    ";
                    $this->tambahTotalSemua($total);
                    $nomor ++;
                }
            }
        }

        public function insertTransaksi($id_pengguna, $jenis_pembayaran, $totalSemua){
            $sql = "INSERT INTO pembayaran (id_pengguna,jenis_pembayaran,bayar,status,tanggal) VALUES ($id_pengguna,'$jenis_pembayaran',$totalSemua,'menunggu',curdate())";
            $execute = $this->connect()->query($sql);
            if(!$execute){
                echo $execute->error;
            }
        }

        public function insertDaftarOrder($cekMakananOrder,$cekMinumanOrder,$arrayMakanan,$arrayMinuman,$jenis_pembayaran){
            $sql = "SELECT id_pembayaran FROM pembayaran ORDER BY id_pembayaran DESC LIMIT 1";
            $execute = $this->connect()->query($sql);
            $result = $execute->fetch_assoc();
            $id_pembayaran = $result['id_pembayaran'];

            if($cekMakananOrder == '1'){
                foreach($arrayMakanan as $key => $value){
                    $sql = "SELECT harga FROM produk WHERE id_produk = $key";
                    $execute = $this->connect()->query($sql);
                    $result = $execute->fetch_assoc();
                    $harga = $result['harga'];
                    $execute = $this->connect()->query("INSERT INTO daftar_order (id_pembayaran,id_produk,harga,jumlah) VALUES ($id_pembayaran,$key,$harga,$value)");
                }
            }
            if($cekMinumanOrder == '1'){
                foreach($arrayMinuman as $key => $value){
                    $sql = "SELECT harga FROM produk WHERE id_produk = $key";
                    $execute = $this->connect()->query($sql);
                    $result = $execute->fetch_assoc();
                    $harga = $result['harga'];
                    $execute = $this->connect()->query("INSERT INTO daftar_order (id_pembayaran,id_produk,harga,jumlah) VALUES ($id_pembayaran,$key,$harga,$value)");
                }
            }
    
            if($jenis_pembayaran == 'offline'){
                echo "<script>
                alert('Lakukan pembayaran di kasir dengan ID pembayaran: ".$id_pembayaran."!');
                window.location.href='index.php';
                </script>";
            }else{
                echo "<script>
                alert('Lakukan pembayaran dengan mengirim bukti transfer ke Delicious, ID pembayaran: ".$id_pembayaran."!');
                window.location.href='index.php';
                </script>";
            }
        }

        public function accTransaksi($id_pembayaran){
            $sql = "UPDATE pembayaran SET status = 'terima'  WHERE id_pembayaran = $id_pembayaran";
            $execute = $this->connect()->query($sql);
            header('location:management-cashier-payment.php');
        }

        public function delTransaksi($id_pembayaran){
            $sql = "UPDATE pembayaran SET status = 'tolak'  WHERE id_pembayaran = $id_pembayaran";
            $execute = $this->connect()->query($sql);
            header('location:management-cashier-payment.php');
        }
    }
?> 
