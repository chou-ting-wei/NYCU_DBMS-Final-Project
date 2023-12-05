<?php
    class Vote{
        private $VTitle;
        private $V_1;
        private $V_2;
        private $post_time;
        private $post_username;

        function set_Vote($row){
            $this->VTitle=$row["title"];
            $this->V_1=$row["vote_1"];
            $this->V_2=$row["vote_2"];
            $this->post_time=$row["post_time"];
            $this->post_username=$row["post_username"];
        }
    
        function get_all(){
            $row=array($this->VTitle, $this->V_1,$this->V_2,$this->post_time);
            return $row;
        }
        
        function get_VTitle(){
            return $this->VTitle;
        }
    
        function get_V_1(){
            return $this->V_1;
        }
    
        function get_V_2(){
            return $this->V_2;
        }
    
        function get_post_time(){
            return $this->post_time;
        }

        function get_post_username(){
            return $this->post_username;
        }
    }
?>