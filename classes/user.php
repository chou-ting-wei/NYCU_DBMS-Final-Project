<?php
    class User{
        private $username;
        private $password;
        function set_User($row){
            $this->username=$row[0];
            $this->password=$row[1];
        }
        function get_username(){
            return $this->username;
        }
        function get_password(){
            return $this->password;
        }
    }
?>