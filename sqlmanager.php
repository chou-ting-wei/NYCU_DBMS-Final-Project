<?php
    error_reporting(E_ERROR | E_WARNING);
    date_default_timezone_set("Asia/Taipei");
    
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

    function chkLogin($username, $password){
        $ret = false;

        $connection = initDB();
        $query = "SELECT * FROM students WHERE password='".$password."' AND username='".$username."'";
        $result = mysqli_query($connection, $query);
        if(mysqli_num_rows($result) > 0){
            $ret = true;
        }

        closeDB($connection);
        return $ret;
    }

    function addRegister($username, $password){
        $ret = false;

        $connection = initDB();
        // 確認是否存在 username
        $query = "SELECT * FROM User WHERE username='".$username."'";
        $result = mysqli_query($connection, $query);
        if(mysqli_num_rows($result) > 0){
            return $ret;
        }

        // 加入此 username password
        $query2 = "INSERT INTO User Values(".$username.",".$password.")";
        $result2 = mysqli_query($connection, $query2);

        closeDB($connection);
        return $result2;
    }

    function getUserList(){
        $connection = initDB();

        $query = "SELECT * FROM User ORDER BY username";
        $result = mysqli_query($connection, $query);

        $userData = NULL;
        $userID = 0;

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){            
            $user = new User();
            if ($userID>0){
                $user->set_User($row);
            }
            $userData[$userID] = $user;
            $userID = $userID + 1;
        }

        closeDB($connection);
        return $userData;
    }

    function delUser($username){
        $connection = initDB();
        $query="DELETE FROM User WHERE username='".$username."'";
        $b=mysqli_query($connection, $query);
        closeDB($connection);
        return $b;
    }

    function getPlayerList($PTitle){

    }

    function getPlayerInfo($PName){
        $connection = initDB();
    
        $query = "SELECT * FROM Players WHERE PName='".$PName."'";
        $result = mysqli_query($connection, $query);

        $playerData = NULL;
        $playerID = 0;
        
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){   
            $PID = $row['PID'];
            $PName = $row['PName'];

            // 這些是原本書裡給的
            // $SourceSID = $row['SourceSID'];
            // $DestSID = $row['DestSID'];

            // // 取得出發地點的航點資訊
            // $query2 = "SELECT * FROM Sectors WHERE SID='".$SourceSID."'";
            // $result2 = mysqli_query($connection,$query2);         
            // $row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC);
            // $source = $row2['Sector'];

            // // 取得目的地點的航點資訊 
            // $query3 = "SELECT * FROM Sectors WHERE SID='".$DestSID."'";
            // $result3 = mysqli_query($connection, $query3);             
            // $row3 = mysqli_fetch_array($result3,MYSQLI_ASSOC);
            // $dest= $row3['Sector'];

            $player = new Player();        
            $player->set_PID($PID);
            $player->set_PName($PName);

            $playerData[$playerID] = $player;
            $playerID = $playerID + 1;              
        }

        closeDB($connection);
        return $playerData;
    }

    function getTeamList($TName){

    }

    function getTeamInfo($TName){

    }

    function getForumList($FTitle){
        $connection = initDB();

        $query = "SELECT * FROM Forum ORDER BY post_time DESC";
        $result = mysqli_query($connection, $query);

        $forumData = NULL;
        $forumID = 0;

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){            
            $forum = new Forum();
            if ($forumID>0){
                $forum->set_Forum($row);
            }
            $forumData[$forumID] = $forum;
            $forumID = $forumID + 1;
        }

        closeDB($connection);
        return $forumData;
    }

    function addForum($FTitle, $FText, $username){
        $connection = initDB();
        $time=date("Y/m/d h:i:s");
        $query="INSERT INTO Forum Values(".$FTitle.",".$FText.",".$username.",".$time.")";
        $b=mysqli_query($connection, $query);
        closeDB($connection);
        return $b;
    }

    function delForum($FTitle){
        $connection = initDB();
        $query="DELETE FROM Forum WHERE title='".$FTitle."'";
        $b=mysqli_query($connection, $query);
        closeDB($connection);
        return $b;
    }

    function getVoteList($VTitle){
        $connection = initDB();

        $query = "SELECT * FROM Vote ORDER BY post_time DESC";
        $result = mysqli_query($connection, $query);

        $voteData = NULL;
        $voteID = 0;

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){ 
            
            $vote = new Vote();
            if ($voteID>0){
                $vote->set_Vote($row);
            }
            $voteData[$voteID] = $vote;
            $voteID = $voteID + 1;
        }

        closeDB($connection);
        return $voteData;
    }
    
    function addVote($VTitle){
        $connection = initDB();
        $time=date("Y/m/d h:i:s");
        $query="INSERT INTO Vote Values(".$VTitle.", 0, 0, ".$time.")";
        $b=mysqli_query($connection, $query);
        closeDB($connection);
        return $b;
    }

    function Vote($VTitle, $side){
        $connection = initDB();
        $query="";
        if ($side==1){
            $query="UPDATE Vote SET vote_1=vote_1+1 WHERE title='".$VTitle."'";
        }
        else{
            $query="UPDATE Vote SET vote_2=vote_2+1 WHERE title='".$VTitle."'";
        }
        $b=mysqli_query($connection, $query);
        closeDB($connection);
        return $b;
    }

    function delVote($VTitle){
        $connection = initDB();
        $query="DELETE FROM Vote WHERE title='".$VTitle."'";    
        $b=mysqli_query($connection, $query);
        closeDB($connection);
        return $b;
    }
?>