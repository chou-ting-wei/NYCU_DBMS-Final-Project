<?php
    class Vote{
        private $VTitle;
        private $V_1;
        private $V_2;
        private $post_time;
    }
    function set_Vote($row){
        $this->VTitle=$row[0];
        $this->V_1=$row[1];
        $this->V_2=$row[2];
        $this->post_time=$row[3];
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

?>