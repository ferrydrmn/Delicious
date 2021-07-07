<?php
    class PaymentLog extends Dbh{
        public function paymentHistoryCustomer($id_pengguna){
            $sql = "SELECT * FROM pembayaran WHERE id_pengguna = $id_pengguna";
            $execute = $this->connect()->query($sql);
            if($execute->num_rows > 0){
               while($row = $execute->fetch_assoc()){
                   $data[] = $row;
               }
               $execute->close();
               return $data;
            }else{
                return false;
            }
        }

        public function checkPayment($id_pengguna,$id_pembayaran){
            $sql = "SELECT * FROM pembayaran WHERE id_pengguna = $id_pengguna AND id_pembayaran = $id_pembayaran";
            $execute = $this->connect()->query($sql);
            if($execute->num_rows < 1){
                return false;
            }else{
                return true;
            }
        }

        public function paymentDetail($id_pembayaran){
            $data = array();
            $sql = "SELECT * FROM daftar_order WHERE id_pembayaran = $id_pembayaran";
            $execute = $this->connect()->query($sql);
            while($row = $execute->fetch_assoc()){
                $data[] = $row;
            }
            return $data;
        }

        public function totalPayment($id_pembayaran){
            $sql = "SELECT * FROM pembayaran WHERE id_pembayaran = $id_pembayaran";
            $execute = $this->connect()->query($sql);
            $result = $execute->fetch_assoc();
            return $result['bayar'];
        }

        public function allPayment(){
            $sql = "SELECT * FROM pembayaran";
            $execute = $this->connect()->query($sql);
            if($execute->num_rows > 0){
                while($row = $execute->fetch_assoc()){
                    $data[] = $row;
                }
                return $data;
            }else{
                return false;
            }
        }

        public function allPaymentWaiting(){
            $sql = "SELECT * FROM pembayaran WHERE status = 'menunggu'";
            $execute = $this->connect()->query($sql);
            if($execute->num_rows > 0){
                while($row = $execute->fetch_assoc()){
                    $data[] = $row;
                }
                return $data;
            }else{
                return false;
            }
        }

        public function getUserDataPayment($id_pengguna){
            $sql = "SELECT nama, alamat FROM pengguna WHERE id_pengguna = $id_pengguna";
            $execute = $this->connect()->query($sql);
            $result = $execute->fetch_assoc();
            return $result;
        }

        public function income($sql){
            $execute = $this->connect()->query($sql);
            if($execute->num_rows > 0){
                while($row = $execute->fetch_assoc()){
                    $data[] = $row;
                }
                return $data;
            }else{
                return false;
            }
        }

        public function productProfit($id_produk){
            $sql = "SELECT sum(daftar_order.jumlah * daftar_order.harga) FROM daftar_order JOIN produk ON daftar_order.id_produk = produk.id_produk JOIN pembayaran on daftar_order.id_pembayaran = pembayaran.id_pembayaran WHERE pembayaran.status = 'terima' GROUP BY produk.id_produk HAVING produk.id_produk = $id_produk";
            $execute = $this->connect()->query($sql);
            $result = $execute->fetch_assoc();
            if($result['sum(daftar_order.jumlah * daftar_order.harga)'] > 0){
                return $result['sum(daftar_order.jumlah * daftar_order.harga)'];
            }else{
                return 0;
            }
            
        }
    }
?>