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
                            <li><a class="dropdown-item" href="#">Player Stat</a></li>
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
        <script>
            function _searchTitle() {
                var searchPName = document.getElementById('searchPName').value;
                var searchPTeam = document.getElementById('searchPTeam').value;
                var searchPYear = document.getElementById('searchPYear').value;
                if(searchPName){
                    document.cookie = "searchPName=" + searchPName;
                }
                else{
                    document.cookie = "searchPName=; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
                }
                if(searchPTeam){
                    document.cookie = "searchPTeam=" + searchPTeam;
                }
                else{
                    document.cookie = "searchPTeam=; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
                }
                if(searchPYear){
                    document.cookie = "searchPYear=" + searchPYear;
                }
                else{
                    document.cookie = "searchPYear=; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
                }
                window.location = "playerstat.php";
            }
            function loadInfo(searchPName, searchPTeam, searchPYear) {
                document.cookie = "searchPNameInfo=" + searchPName;
                document.cookie = "searchPTeamInfo=" + searchPTeam;
                document.cookie = "searchPYearInfo=" + searchPYear;
                window.location = "playerstat_info.php?mode=1";
            }
        </script>

        <div class="container mt-4">
            <h3 class="fw-bolder">Player Stat</h3>
            <hr class="mt-3 mb-3"></hr>
            <div class="col-md-6 me-auto">
                <div class="input-group">
                    <input type="text" class="form-control w-25" id="searchPName" name="searchPName" placeholder="Player Name" value="<?php echo isset($_COOKIE["searchPName"]) ? $_COOKIE["searchPName"] : '' ?>">
                    <input type="text" oninput="this.value = this.value.toUpperCase()" class="form-control w-25" id="searchPTeam" name="searchPTeam" placeholder="Team Abbreviation" value="<?php echo isset($_COOKIE["searchPTeam"]) ? $_COOKIE["searchPTeam"] : '' ?>">
                    <input type="text" class="form-control" id="searchPYear" name="searchPYear" placeholder="Year" value="<?php echo isset($_COOKIE["searchPYear"]) ? $_COOKIE["searchPYear"] : '' ?>">
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

        <div class="container mt-3">
            <?php
                $t_page = (isset($_GET['t_page']) ? $_GET['t_page'] : 1);
                echo "<div class='table-responsive'>";
                echo "<table class='table table-borded table-hover'>";
                echo "<thead><tr>";
                echo "<th scope='col' class='w-25 align-middle'>Player Name</th>";
                echo "<th scope='col' class='w-25 align-middle'>Team Name</th>";
                echo "<th scope='col' class='w-25 align-middle'>Team Abbreviation</th>";
                echo "<th scope='col' class='w-25 align-middle'>Year</th>";
                echo "</tr></thead>";
                echo "<tbody>";
                $PName = (isset($_COOKIE["searchPName"]) ? $_COOKIE["searchPName"] : '');
                $PTeam = (isset($_COOKIE["searchPTeam"]) ? $_COOKIE["searchPTeam"] : '');
                $year = (isset($_COOKIE["searchPYear"]) ? $_COOKIE["searchPYear"] : '');
                $playerData = getPlayerInfo($PName, $PTeam, $year, 1);
                $playerCnt = 0;
                if($playerData != NULL){
                    $playerCnt = count($playerData);
                }
                if($playerCnt > 0){
                    for($index = 10 * ($t_page - 1); $index < min($playerCnt, 10 * $t_page); $index ++){
                        $player = $playerData[$index]->getPlayer_1();
                        // echo "<pre>";
                        // print_r($user);
                        // echo "</pre>";
                        echo "<tr>";
                        echo "<td class='align-middle'><a href='#' onclick=\"loadInfo('".$player[3]."','".nameToAbbrev($player[2])."','".$player[0]."')\">".$player[3]."</a></td>";
                        echo "<td class='align-middle'>".$player[2]."</td>";
                        echo "<td class='align-middle'>".nameToAbbrev($player[2])."</td>";
                        echo "<td class='align-middle'>".$player[0]."</td>";
                        echo "</tr>";
                    }
                }
                else{
                    echo "<tr><td class='align-middle' colspan='4'><span class='text-danger mb-3'>No data found.</span></td></tr>";
                }
                echo "</tbody></table></div></div>";
            ?>
        </div>

        <div class="container mt-4">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-end">
                    <?php
                        $all_t_page = ceil($playerCnt / 10);
                        if($all_t_page != 0){
                            if($t_page > 1){
                                echo "<li class='page-item'>";
                                echo "<a class='page-link text-dark' href='playerstat.php?t_page=".($t_page - 1)."' aria-label='Previous'>";
                                echo "<span aria-hidden='true'>&laquo;</span>";
                                echo "</a></li>";
                                echo "<li class='page-item'><a class='page-link text-dark' href='playerstat.php?t_page=1'>1</a></li>";
                            }
                            if($t_page - 2 > 1){
                                echo "<li class='page-item disabled'><a class='page-link text-dark'>...</a></li>";
                            }
                            if($t_page - 1 > 1){
                                echo "<li class='page-item'><a class='page-link text-dark' href='playerstat.php?t_page=".($t_page - 1)."'>".($t_page - 1)."</a></li>";
                            }
                            echo "<li class='page-item'><a class='page-link text-dark active' href='playerstat.php?t_page=".($t_page)."'>".($t_page)."</a></li>";
                            if($t_page + 1 < $all_t_page){
                                echo "<li class='page-item'><a class='page-link text-dark' href='playerstat.php?t_page=".($t_page + 1)."'>".($t_page + 1)."</a></li>";
                            }
                            if($t_page + 2 < $all_t_page){
                                echo "<li class='page-item disabled'><a class='page-link text-dark'>...</a></li>";
                            }
                            if($t_page < $all_t_page){
                                echo "<li class='page-item'><a class='page-link text-dark' href='playerstat.php?t_page=".$all_t_page."'>".$all_t_page."</a></li>";
                                echo "<li class='page-item'>";
                                echo "<a class='page-link text-dark' href='playerstat.php?t_page=".($t_page + 1)."' aria-label='Next'>";
                                echo "<span aria-hidden='true'>&raquo;</span>";
                                echo "</a></li>";
                            }
                        }
                    ?>
                </ul>
            </nav>
        </div>

        <!-- Bootstrap JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>