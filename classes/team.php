<?php
    class team{
        private $TID;
        private $tName;

        function set_TID($TID){
            $this->TID = $TID;
        }
        function set_tName($tName){
            $this->tName = $tName;
        }
        
        function get_TID(){
            return $this->TID;
        }
        function get_tName(){
            return $this->tName;
        }
    }
?>