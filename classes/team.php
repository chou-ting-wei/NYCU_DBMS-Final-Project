<?php
    class Team{
        private $TID;
        private $TName;

        function set_TID($TID){
            $this->TID = $TID;
        }
        function set_TName($TName){
            $this->TName = $TName;
        }
        
        function get_TID(){
            return $this->TID;
        }
        function get_TName(){
            return $this->TName;
        }
    }
?>