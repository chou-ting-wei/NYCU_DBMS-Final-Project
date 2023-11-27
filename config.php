<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'A12345678');
define('DB_NAME', 'nbastat');
 
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
// 輸入中文也OK的編碼
mysqli_query($link, 'SET NAMES utf8');

if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
else{
    return $link;
}
?>