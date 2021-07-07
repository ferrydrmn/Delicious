<?php
    class Account extends Dbh{
        private $id_pengguna;
        private $email;
        private $nama;
        private $no_hp;
        private $password;
        private $level;
        private $alamat;
        private $foto_profil;
        private $status;

        public function __construct($id_pengguna){
            $sql = "SELECT * FROM pengguna WHERE id_pengguna = $id_pengguna";
            $execute = $this->connect()->query($sql);
            $result = $execute->fetch_array();
            $this->id_pengguna = $id_pengguna;
            $this->email = $result['email'];
            $this->nama = $result['nama'];
            $this->password = $result['password'];
            $this->foto_profil = $result['foto_profil'];
            $this->alamat = $result['alamat'];
            $this->no_hp = $result['no_hp'];
        }

        public function getIdPengguna(){
            return $this->id_pengguna;
        }

        public function getEmail(){
            return $this->email;
        }

        public function getNama(){
            return $this->nama;
        }

        public function getNoHp(){
            return $this->no_hp;
        }

        public function getPassword(){
            return $this->password;
        }

        public function getLevel(){
            return $this->level;
        }

        public function getAlamat(){
            return $this->alamat;
        }

        public function getFotoProfil(){
            return $this->foto_profil;
        }

        public function getStatus(){
            return $this->status;
        }

        public function updateData($kolom,$data){
            $id_pengguna = $this->getIdPengguna();
            $sql = "UPDATE pengguna SET ".$kolom." = '".$data."' WHERE id_pengguna = $id_pengguna";
            $execute = $this->connect()->query($sql);
            if(!$execute){
                echo "Tidak sukses!";
            }
        }
    }
