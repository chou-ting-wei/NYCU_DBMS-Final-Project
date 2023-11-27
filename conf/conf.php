<?php
class Conf{
    private $databaseURL = "localhost";
    private $databaseUName = "root";
    private $databasePWord = "A12345678"; 
    private $databaseName = "NBAStat";

    function get_databaseURL(){
        return $this->databaseURL;
    }
    function get_databaseUName(){
        return $this->databaseUName;
    }
    function get_databasePWord(){
        return $this->databasePWord;
    } 
    function get_databaseName(){
        return $this->databaseName;
    } 
}
?>