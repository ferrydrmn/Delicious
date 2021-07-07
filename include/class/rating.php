<?php
    class Rating extends Product{

        public function checkRowRating($id_produk){
            $sql = "SELECT * FROM komentar WHERE id_produk = $id_produk";
            $execute = $this->connect()->query($sql);
            if($execute->num_rows > 0){
                $execute->close();
                return true;
            }else{
                $execute->close();
                return false;
            }
        }

        public function avgRating($id_produk){
            $checkRow = $this->checkRowRating($id_produk);
            if($checkRow){
                $sql = "SELECT avg(rating) FROM komentar WHERE id_produk = $id_produk";
                $execute = $this->connect()->query($sql);
                $result = $execute->fetch_assoc();
                return $result['avg(rating)'];
            }else{
                return false;
            }
        }

        public function review($id_produk){
            $checkRow = $this->checkRowRating($id_produk);
            if($checkRow){
                $sql = "SELECT * FROM komentar WHERE id_produk = $id_produk";
                $execute = $this->connect()->query($sql);
                if($execute){
                    while($row = $execute->fetch_assoc()){
                        $data[] = $row;
                    }
                    return $data;
                }
            }else{
                return false;
            }
        }

        public function getUserInformationComment($id_pengguna){
            $sql = "SELECT nama,foto_profil FROM pengguna WHERE id_pengguna = $id_pengguna";
            $execute = $this->connect()->query($sql);
            $result = $execute->fetch_assoc();
            return $result;
        }

        public function insertReview($id_produk,$id_pengguna,$rating,$komentar){
            $sql = "INSERT INTO komentar (id_produk, id_pengguna, rating, komentar, tanggal) VALUES ($id_produk,$id_pengguna,'$rating','$komentar',curdate())";
            $execute = $this->connect()->query($sql);
        }
    }
?>
