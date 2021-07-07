<?php
    class Login extends Dbh{
        public function verification($email,$password){
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                return "Format email tidak valid!";
            }else{
                $sql = "SELECT id_pengguna,email,password,level,status FROM pengguna WHERE email = '$email'";
                $execute = $this->connect()->query($sql);
                if($execute->num_rows > 0){
                    $check = $execute->fetch_assoc();
                    if($check['status'] == 'blokir'){
                        return "Anda telah diblokir oleh admin!";
                    }else{
                        if($email == $check['email'] and $password == $check['password']){
                            return "";
                        }else{
                            return "Email atau password salah!";
                        }
                    }
                }else{
                    return "Email atau password salah!";
                }
            }
        }

        public function getIdPengguna($email){
            $sql = "SELECT id_pengguna FROM pengguna WHERE email = '$email'";
            $execute = $this->connect()->query($sql);
            $id_pengguna = $execute->fetch_assoc();
            return $id_pengguna['id_pengguna'];
        }

        public function getLevel($email){
            $sql = "SELECT level FROM pengguna WHERE email = '$email'";
            $execute = $this->connect()->query($sql);
            $level = $execute->fetch_assoc();
            return $level['level'];
        }

        public function checkEmail($email){
            $sql = "SELECT email FROM pengguna WHERE email = '$email'";
            $execute = $this->connect()->query($sql);
            if($execute->num_rows > 0){
                return 1;
            }else{
                return 0;
            }
        }

        public function regsitrasi($getEmail, $getNama, $getNoHP, $getPassword, $getAlamat, $getLevel, $getStatus, $getFotoProfil){
            $sql = "INSERT INTO pengguna (email,nama,no_hp,password,level,alamat,foto_profil,status) VALUES ('$getEmail','$getNama','$getNoHP','$getPassword','$getLevel','$getAlamat','$getFotoProfil','$getStatus')";
            $execute = $this->connect()->query($sql);
        }
    }
?>