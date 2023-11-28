<?php
    class Player{
        private $PID;
        private $PName;
        private $PMoney;

        function set_PID($PID){
            $this->PID = $PID;
        }
        function set_PName($PName){
            $this->PName = $PName;
        }

        function get_PID(){
            return $this->PID;
        }
        function get_PName(){
            return $this->PName;
        }
    }
?>