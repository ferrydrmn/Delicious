<?php
    class ManAccount extends Dbh{
        public function allUser(){
            $sql = "SELECT * FROM pengguna";
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

        public function editPassword($password,$id_pengguna){
            $sql = "UPDATE pengguna SET password = '$password' WHERE id_pengguna = $id_pengguna";
            $execute = $this->connect()->query($sql);
            if($execute){
                echo "<script>
                    alert('Password berhasil diganti!');
                    window.location.href='management-user.php';
                </script>";
            }
        }

        public function blockUser($id_pengguna){
            //Cek Level
            $sql = "SELECT level,status FROM pengguna WHERE id_pengguna = $id_pengguna";
            $execute = $this->connect()->query($sql);
            $result = $execute->fetch_assoc();
            if($result['level'] == 'admin' or $result['level'] =='owner'){
                header('location:management-user.php');
            }else if($result['status'] == 'aktif'){
                $sql = "UPDATE pengguna SET status = 'blokir' WHERE id_pengguna = $id_pengguna";
                $execute = $this->connect()->query($sql);
            }else{
                $sql = "UPDATE pengguna SET status = 'aktif' WHERE id_pengguna = $id_pengguna";
                $execute = $this->connect()->query($sql);
            }
            echo "<script>
            alert('Status pengguna telah diedit!');
            window.location.href='management-user.php';
            </script>";
        }
    }
?>