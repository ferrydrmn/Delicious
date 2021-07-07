<?php
    class Product extends Dbh{
        private $id_produk;

        public function getIdProduk(){
            return $this->id_produk;
        }

        public function showAllProduct(){
            $sql = "SELECT * FROM produk ORDER BY id_produk DESC";
            $execute = $this->connect()->query($sql);
            if($execute->num_rows > 0){
                while ($row = $execute->fetch_assoc()){
                    $data[] = $row;
                }
                $execute->close();
                return $data; 
            }else{
                $execute->close();
                return false;
            }
        }

        public function showProduct($jenis){
            $sql = "SELECT * FROM produk WHERE jenis_produk = '$jenis' and status = 'aktif' ORDER BY id_produk DESC";
            $execute = $this->connect()->query($sql);
            if($execute->num_rows > 0){
                while ($row = $execute->fetch_assoc()){
                    $data[] = $row;
                }
                $execute->close();
                return $data; 
            }else{
                $execute->close();
                return false;
            }
        }

        public function showSingleProduct($id_produk){
            $sql = "SELECT * FROM produk WHERE id_produk = $id_produk";
            $execute = $this->connect()->query($sql);
            if($execute->num_rows > 0){
                $result = $execute->fetch_assoc();
                $execute->close();
                return $result; 
            }else{
                $execute->close();
                return false;
            }
        }

        public function statusProduct($id_produk){
            $sql = "SELECT status FROM produk WHERE id_produk = $id_produk";
            $execute = $this->connect()->query($sql);
            $result = $execute->fetch_assoc();
            if($result['status'] == 'aktif'){
                $execute = $this->connect()->query("UPDATE produk SET status = 'nonaktif' WHERE id_produk = $id_produk");
            }else{
                $execute = $this->connect()->query("UPDATE produk SET status = 'aktif' WHERE id_produk = $id_produk");
            }
            echo "<script>
            alert('Status produk berhasil diupdate!');
            window.location.href='management-food.php';
            </script>";
        }

        //Management Food
        public function insertProduct($nama,$jenis,$deskripsi,$harga,$status){
            //Insert Data
            $sql = "INSERT INTO produk (nama_produk,jenis_produk,deskripsi,harga,status) VALUES ('$nama','$jenis','$deskripsi','$harga','$status')";
            $execute = $this->connect()->query($sql);
            //Ambil ID Produk
            $sql = "SELECT id_produk FROM produk WHERE nama_produk = '$nama'";
            $execute = $this->connect()->query($sql);
            $result = $execute->fetch_assoc();
            $id_produk = $result['id_produk'];
            return $id_produk;
        }

        public function updateProductSameName($jenis,$deskripsi,$harga,$id_produk){
            $sql = "UPDATE produk SET jenis_produk = '$jenis', deskripsi = '$deskripsi', harga = '$harga' WHERE id_produk = '$id_produk'";
            $execute = $this->connect()->query($sql);
        }

        public function checkProductName($nama){
            $sql = "SELECT nama_produk FROM produk WHERE nama_produk = '$nama'";
            $execute = $this->connect()->query($sql);
            return $execute;
        }

        public function updateProduct($nama,$jenis,$deskripsi,$harga,$id_produk){
            $execute = $this->checkProductName($nama);
            if($execute->num_rows > 0){
                return false;
            }else{
                $sql = "UPDATE produk SET nama_produk = '$nama', jenis_produk = '$jenis', deskripsi = '$deskripsi', harga = '$harga' WHERE id_produk = '$id_produk'";
                $execute = $this->connect()->query($sql);
                return "";
            }
        }
    }
?>
