<?php
    class player{
        private $PID;
        private $pName;

        function set_PID($PID){
            $this->PID = $PID;
        }
        function set_pName($pName){
            $this->pName = $pName;
        }
        
        function get_PID(){
            return $this->PID;
        }
        function get_pName(){
            return $this->pName;
        }
    }
?>