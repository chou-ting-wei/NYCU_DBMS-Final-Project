<?php
    error_reporting(E_ERROR | E_WARNING);
    
    include("classes/player.php");
    include("classes/team.php");
    include("classes/forum.php");
    include("classes/vote.php");

    $databaseURL;
    $databaseUName;
    $databasePWord;
    $databaseName; 

    function initDB(){
        if(!isset($_SESSION["databaseURL"])){
            include("conf/conf.php");
            $dbConf = new Conf();
            $databaseURL = $dbConf->get_databaseURL();
            $databaseUName = $dbConf->get_databaseUName();
            $databasePWord = $dbConf->get_databasePWord();
            $databaseName = $dbConf->get_databaseName();

            $_SESSION['databaseURL'] = $databaseURL; 
            $_SESSION['databaseUName'] = $databaseUName; 
            $_SESSION['databasePWord'] = $databasePWord; 
            $_SESSION['databaseName'] = $databaseName;        
                
            $connection = mysqli_connect($databaseURL,$databaseUName, $databasePWord,$databaseName) or die ("Error: MySQL connection failed!");
        
            mysqli_close($connection);
        }

        $databaseURL = $_SESSION['databaseURL'];
        $databaseUName = $_SESSION['databaseUName'];
        $databasePWord = $_SESSION['databasePWord'];
        $databaseName = $_SESSION['databaseName']; 

        $connection = mysqli_connect($databaseURL,$databaseUName, $databasePWord,$databaseName) or die ("Error: MySQL connection failed!");
        
        mysqli_query($connection,'SET CHARACTER SET utf8');
        mysqli_query($connection,"SET collation_connection = 'utf8_general_ci'");

        return $connection;
    }
    
    function closeDB($connection){
        mysqli_close($connection);
    }

    
?>