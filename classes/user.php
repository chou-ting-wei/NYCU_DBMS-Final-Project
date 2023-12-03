<?php
    class User{
        private $username;
        private $password;
        function set_User($row){
            $this->username=$row["username"];
            $this->password=$row["password"];
        }
        function get_username(){
            return $this->username;
        }
        function get_password(){
            return $this->password;
        }
    }
?>