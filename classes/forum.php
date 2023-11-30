<?php
    class Forum{
        private $FTitle;
        private $FText;
        private $username;
        private $post_time;
        
        function set_Forum($row){
            $this->FTitle=$row[0];
            $this->FText=$row[1];
            $this->username=$row[2];
            $this->post_time=$row[3];
        }
    
        function get_all(){
            $row=array($this->FTitle, $this->FText,$this->username,$this->post_time);
            return $row;
        }
        
        function get_FTitle(){
            return $this->FTitle;
        }
    
        function get_FText(){
            return $this->FText;
        }
    
        function get_username(){
            return $this->username;
        }
    
        function get_post_time(){
            return $this->post_time;
        }
    }
?>