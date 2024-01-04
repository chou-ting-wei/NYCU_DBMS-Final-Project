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
        <title>NBA Stat - Team Stat</title>
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
        .w-10{
            width: 10%;
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
                            <li><a class="dropdown-item" href="#">Team Stat</a></li>
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
                                    echo "<a class='nav-link active'>".$username."</a>";
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
        <script>
            function _searchTitle() {
                var searchTTitle = document.getElementById('searchName').value;
                var searchTYear = document.getElementById('searchYear').value;
                var searchTPo = document.getElementById('searchPo').value;
                if(searchTTitle){
                    document.cookie = "searchTTitle=" + searchTTitle;
                }
                else{
                    document.cookie = "searchTTitle=; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
                }
                if(searchTYear){
                    document.cookie = "searchTYear=" + searchTYear;
                }
                else{
                    document.cookie = "searchTYear=; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
                }
                if(searchTPo){
                    document.cookie = "searchTPo=" + searchTPo;
                }
                else{
                    document.cookie = "searchTPo=; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
                }
                window.location.reload();
            }
            function loadInfo(searchTTitle, searchTYear, searchTPo) {
                document.cookie = "searchTTitle=" + searchTTitle + ";path='teamstat_info.php';";
                document.cookie = "searchTYear=" + searchTYear + ";path='teamstat_info.php';";
                document.cookie = "searchTPo=" + searchTPo + ";path='teamstat_info.php';";
                window.location = "teamstat_info.php?mode=1";
            }
        </script>

        <div class="container mt-4">
            <h3 class="fw-bolder">Team Stat</h3>
            <hr class="mt-3 mb-3"></hr>
            <div class="col-md-6 me-auto">
                <div class="input-group">
                    <input type="text" class="form-control w-25" id="searchName" name="searchName" placeholder="Team Name" value="<?php echo isset($_COOKIE["searchTTitle"]) ? $_COOKIE["searchTTitle"] : '' ?>">
                    <input type="text" class="form-control" id="searchYear" name="searchYear" placeholder="Year" value="<?php echo isset($_COOKIE["searchTYear"]) ? $_COOKIE["searchTYear"] : '' ?>">
                    <select class="form-select" id="searchPo">
                        <option <?php echo !isset($_COOKIE["searchTPo"]) ? 'selected' : '' ?> disabled value="">Playoff</option>
                        <option <?php echo (isset($_COOKIE["searchTPo"]) && ($_COOKIE["searchTPo"] == 1)) ? 'selected' : '' ?> value="1">Yes</option>
                        <option <?php echo (isset($_COOKIE["searchTPo"]) && ($_COOKIE["searchTPo"] == 0)) ? 'selected' : '' ?> value="0">No</option>
                        <option <?php echo (isset($_COOKIE["searchTPo"]) && ($_COOKIE["searchTPo"] == 2)) ? 'selected' : '' ?> value="2">Both</option>
                    </select>
                    <button class="btn btn-secondary" type="button" id="searchBtn" onclick="_searchTitle()">
                    &nbsp;
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                    </svg>
                    &nbsp;
                    </button>
                </div>
            </div>
        </div>

        <div class="container mt-4">
            <?php
                echo "<div class='table-responsive'>";
                echo "<table class='table table-borded'>";
                echo "<thead><tr>";
                echo "<th scope='col' class='w-50 align-middle'>Team Name</th>";
                echo "<th scope='col' class='w-25 align-middle text-center'>Year</th>";
                echo "<th scope='col' class='w-25 align-middle'>Playoff</th>";
                echo "</tr></thead>";
                echo "<tbody>";
                $TName = (isset($_COOKIE["searchTTitle"]) ? $_COOKIE["searchTTitle"] : '');
                $year = (isset($_COOKIE["searchTYear"]) ? $_COOKIE["searchTYear"] : '');
                if(isset($_COOKIE["searchTPo"])){
                    if($_COOKIE["searchTPo"] == 1) $playoff = "TRUE";
                    else if($_COOKIE["searchTPo"] == 0) $playoff = "FALSE";
                    else $playoff = "";
                }
                else{
                    $playoff = "";
                }
                echo "TName: ".$TName." year: ".$year." playoff: ".$playoff;
                $teamData = getTeamInfo($TName, $year, 1, $playoff);
                $teamCnt = 0;
                if($teamData != NULL){
                    $teamCnt = count($teamData);
                }
                if($teamCnt > 0){
                    for($index = 0; $index < $teamCnt; $index ++){
                        $team = $teamData[$index]->getTeam_1();
                        // echo "<pre>";
                        // print_r($user);
                        // echo "</pre>";
                        echo "<tr>";
                        echo "<td class='align-middle'><a href='#' onclick='loadInfo(".$team[2].",".$team[0].",".$team[8].")'>".$team[2]."</a></td>";
                        echo "<td class='align-middle'>".$team[0]."</td>";
                        echo "<td class='align-middle'>".$team[8]."</td>";
                        echo "</tr>";
                    }
                }
                else{
                    echo "<tr><td class='align-middle' colspan='3'><span class='text-danger mb-3'>No data found.</span></td></tr>";
                }
                echo "</tbody></table></div></div>";
            ?>
        </div>
       

        <!-- Bootstrap JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>