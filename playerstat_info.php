<!DOCTYPE html>
<?php
    error_reporting(E_ERROR | E_WARNING);
    session_start();
    if(!isset($_SESSION["login_session"])){
        $_SESSION["login_session"] = false;
        $_SESSION["username"] = NULL;
    }
    include("sqlmanager.php")
?>
<html>
    <head>
        <meta charset="UTF=8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>NBA Stat - Player Stat</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>
    <style>
        body{
            background-color: #e9eded;
        }
        .unselectable {
            -webkit-user-select: none;
            -webkit-touch-callout: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        .w-40{
            width: 40%;
        }
        .w-60{
            width: 60%;
        }
    </style>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand unselectable">NBA Stat</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-lg-end" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Menu</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="playerstat.php">Player Stat</a></li>
                            <li><a class="dropdown-item" href="teamstat.php">Team Stat</a></li>
                            <li><a class="dropdown-item" href="forum.php">Forum</a></li>
                            <li><a class="dropdown-item" href="vote.php">Vote</a></li>
                        </ul>   
                    </li>
                    <?php
                        if(!$_SESSION["login_session"]){
                            echo "<li class='nav-item'>";
                            echo "<a class='nav-link active' href='login.php'>Login</a>";
                            echo "</li>";
                        }
                        else{
                            if(isset($_SESSION['username'])){
                                $username = $_SESSION['username'];
                                if($username == "admin"){
                                    echo "<li class='nav-item'>";
                                    echo "<a class='nav-link active' href='admin.php'>".$username."</a>";
                                    echo "</li>";
                                }
                                else{
                                    echo "<li class='nav-item'>";
                                    echo "<a class='nav-link active' href='editpw.php'>".$username."</a>";
                                    echo "</li>";
                                }
                            }
                            echo "<li class='nav-item'>";
                            echo "<a class='nav-link active' href='logout.php'>Logout</a>";
                            echo "</li>";
                        }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
    <body>
        <div class="container mt-4">
            <h3 class="fw-bolder">Player Stat</h3>
            <hr class="mt-3 mb-3"></hr>
            <div class="table-responsive">
                <table>
                    <thead><tr>
                        <th scope='col' class='align-middle'><a href="playerstat_info.php?mode=1" class="link-dark">Player Summary</a></th>
                        <th scope='col' class='align-middle'>&nbsp;|&nbsp;</th>
                        <th scope='col' class='align-middle'><a href="playerstat_info.php?mode=2" class="link-dark">Player Basic Stats</a></th>
                        <th scope='col' class='align-middle'>&nbsp;|&nbsp;</th>
                        <th scope='col' class='align-middle'><a href="playerstat_info.php?mode=3" class="link-dark">Player Shooting Stats</a></th>
                    </tr></thead>
                </table>
            </div>
        </div>

        <div class="container mt-4">
            <?php
                $mode = (isset($_GET['mode']) ? $_GET['mode'] : '0');
                echo "<div class='table-responsive'>";
                echo "<table class='table table-borded table-hover'>";
                echo "<thead><tr>";
                $colcnt = 2;
                echo "<th scope='col' class='w-40 align-middle'>Category</th>";
                echo "<th scope='col' class='w-60 align-middle'>Data</th>";
                echo "</tr></thead>";
                echo "<tbody>";
                if($mode != 1 && $mode != 2 && $mode != 3){
                    echo "<tr><td class='align-middle' colspan='".$colcnt."'><span class='text-danger mb-3'>Error: Undefined mode.</span></td></tr>";
                }
                else{
                    $PName = (isset($_COOKIE["searchPNameInfo"]) ? $_COOKIE["searchPNameInfo"] : '');
                    $PTeam = (isset($_COOKIE["searchPTeamInfo"]) ? $_COOKIE["searchPTeamInfo"] : '');
                    $year = (isset($_COOKIE["searchPYearInfo"]) ? $_COOKIE["searchPYearInfo"] : '');
                    $playerData = getPlayerInfo($PName, $PTeam, $year, $mode);
                    $playerCnt = 0;
                    if($playerData != NULL){
                        $playerCnt = count($playerData);
                    }
                    if($playerCnt > 0){
                        if($mode == 1){
                            //["year","league","team","name","pos","age","exp"]
                            $player = $playerData[0]->getPlayer_1();
                            $categ = array("Player Name", "Team Name", "Team Abbreviation", "Year", "League", "Position", "Age", "Experience");
                            $categCnt = count($categ);
                            $ordPlayer = array($player[3], $player[2], nameToAbbrev($player[2]), $player[0], $player[1], $player[4], $player[5], $player[6]);
                            for($index = 0; $index < $categCnt; $index ++){
                                echo "<tr>";
                                echo "<td class='align-middle'>".$categ[$index]."</td>";
                                echo "<td class='align-middle'>".$ordPlayer[$index]."</td>";
                                echo "</tr>";
                            }
                        }
                        else if($mode == 2){
                            //["year","team","name","offensive_rebound","defensive_rebound","total_rebound","assist","steal","block","turnover","personal_foul","points"]
                            $player = $playerData[0]->getPlayer_2();
                            $categ = array("Player Name", "Team Name", "Team Abbreviation", "Year", "Offensive Rebound", "Defensive Rebound", "Assist", "Steal", "Block", "Turnover", "Personal Foul", "Points");
                            $categCnt = count($categ);
                            $ordPlayer = array($player[2], $player[1], nameToAbbrev($player[1]), $player[0], $player[3], $player[4], $player[5], $player[6], $player[7], $player[8], $player[9], $player[10], $player[11]);
                            for($index = 0; $index < $categCnt; $index ++){
                                echo "<tr>";
                                echo "<td class='align-middle'>".$categ[$index]."</td>";
                                echo "<td class='align-middle'>".$ordPlayer[$index]."</td>";
                                echo "</tr>";
                            }
                        }
                        else{
                            //["year","team","name","true_shooting_percent","field_goal","field_goal_attempt","field_goal_percent","3_point","3_point_attempt","3_point_percent","2_point","2_point_attempt","2_point_percent","free_throw","free_throw_attempt","free_throw_percent"]
                            $player = $playerData[0]->getPlayer_3();
                            $categ = array("Player Name", "Team Name", "Team Abbreviation", "Year", "True Shooting Percentage", "Free Throw", "Free Throw Attempt", "Free Throw Percentage", "Field Goal", "Field Goal Attempt", "Field Goal Percentage", "2 Point", "2 Point Attempt", "2 Point Percentage", "3 Point", "3 Point Attempt", "3 Point Percentage");
                            $categCnt = count($categ);
                            $ordPlayer = array($player[2], $player[1], nameToAbbrev($player[1]), $player[0], $player[3], $player[13], $player[14], $player[15], $player[4], $player[5], $player[6], $player[10], $player[11], $player[12], $player[7], $player[8], $player[9]);
                            for($index = 0; $index < $categCnt; $index ++){
                                echo "<tr>";
                                echo "<td class='align-middle'>".$categ[$index]."</td>";
                                echo "<td class='align-middle'>".$ordPlayer[$index]."</td>";
                                echo "</tr>";
                            }
                        }
                    }
                    else{
                        echo "<tr><td class='align-middle' colspan='".$colcnt."'><span class='text-danger mb-3'>No data found.</span></td></tr>";
                    }
                    echo "</tbody></table></div></div>";
                }
            ?>
        </div>
        <!-- Bootstrap JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>