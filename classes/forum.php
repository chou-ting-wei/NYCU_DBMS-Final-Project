<?php
    class Forum{
        private $FTitle;
        private $FText;
        private $username;
        private $post_time;
        
        // function set_Forum($title,$text,$usname,$time){
        //     $this->FTitle=$title;
        //     $this->FText=$text;
        //     $this->username=$usname;
        //     $this->post_time=$time;
        // }

        function set_Forum($row){
            $this->FTitle=$row["title"];
            $this->FText=$row["content"];
            $this->username=$row["post_username"];
            $this->post_time=$row["post_time"];
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