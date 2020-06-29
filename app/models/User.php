<?php
    class User {
        private $db;
        public function __construct(){
            $this->db = new Database;
        }
        // Register user
        public function register($data){
            $this->db->query('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
            // Binds Values
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':password', $data['password']);

            // Execute
            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }

        public function login($email, $password){
            $this->db->query('SELECT * FROM users WHERE email = :email');
            $this->db->bind(':email', $email);

            $row = $this->db->single();
            $hashed_password = $row->password;
            if(password_verify($password, $hashed_password)){
                return $row;
            }else{
                return false;
            }
        }

        // Find User by Email
        public function findUserByEmail($email){
            $this->db->query('SELECT * FROM users WHERE email = :email');
            // Binds Value
            $this->db->bind(':email', $email);

            $row = $this->db->single();

            // Check Row
            if($this->db->rowCount() >0){
                return true;
            }else{
                return false;
            }
        }

         // Get User By Id
         public function getUserById($id){
            $this->db->query('SELECT * FROM users WHERE id = :id');
            // Binds Value
            $this->db->bind(':id', $id);

            $row = $this->db->single();

            return $row;
        }
    }
?>