<?php
    class Photo extends Product{
        public function showFirstPhoto($id_produk){
            $sql = "SELECT path FROM foto_produk WHERE id_produk = $id_produk LIMIT 1";
            $execute = $this->connect()->query($sql);
            $result = $execute->fetch_assoc();
            $execute->close();
            return $result['path'];
        }

        public function insertPhoto($id_final,$path_foto){
            $sql = "INSERT INTO foto_produk (id_produk,path) values ('$id_final','$path_foto')";
            $execute = $this->connect()->query($sql);
        }

        public function showAllPhoto($id_produk){
            $sql = "SELECT path FROM foto_produk WHERE id_produk = $id_produk";
            $execute = $this->connect()->query($sql);
            if($execute->num_rows > 0){
                $nomor = 1;
                while($row = $execute->fetch_assoc()){
                    $data[$nomor] = $row['path'];
                    $nomor++;
                }
                return $data;
            }else{
                return false;
            }
        }
    }
?>