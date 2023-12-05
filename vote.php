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
        <title>NBA Stat - Vote</title>
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
        .w-5{
            width: 5%;
        }
        .w-10{
            width: 10%;
        }
        .w-15{
            width: 15%;
        }
        .w-20{
            width: 20%;
        }
        .w-30{
            width: 30%;
        }
        .w-35{
            width: 35%;
        }
        .w-80{
            width: 80%;
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
                            <li><a class="dropdown-item" href="#">Vote</a></li>
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
            <?php
                $search = "";
                if(isset($_COOKIE["searchVTitle"])){
                    $search = $_COOKIE["searchVTitle"];
                    echo "document.cookie = 'searchVTitle=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=vote.php;';";
                }
            ?>
            function _searchVote() {
                var searchVTitle = document.getElementById('search').value;
    
                if(searchVTitle){
                    document.cookie = "searchVTitle=" + searchVTitle;
                }
                window.location.reload();
            }
        </script>
        <div class="container mt-4">
            <h3 class="fw-bolder">Vote</h3>
            <hr class="mt-3 mb-3"></hr>
            <div class="container">
                <div class="row">
                    <div class="col-md-3 me-auto">
                        <div class="input-group">
                            <input type="text" class="form-control" id="search" name="search" placeholder="Search" value="<?php echo isset($_COOKIE["searchVTitle"]) ? $_COOKIE["searchVTitle"] : '' ?>">
                            <button class="btn btn-secondary" type="button" id="searchBtn" onclick="_searchVote()">
                            &nbsp;
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                            </svg>
                            &nbsp;
                            </button>
                        </div>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-secondary" type="button" href="#" data-bs-toggle="modal" data-bs-target="#voteModal" <?php echo $_SESSION["username"] == NULL ? 'disabled' : ''; ?>>
                            &nbsp;
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                            </svg>
                            &nbsp;
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            <?php
                if(isset($_COOKIE["delVTitle"])){
                    if(delVote($_COOKIE["delVTitle"])){
                        echo "document.cookie = 'delVTitle=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=vote.php;';";
                        echo "alert('Delete vote successful!');";
                        echo "window.location.reload();";
                    }
                    else{
                        echo "alert('Delete vote failed!');";
                    }
                }
            ?>
            function _delVote(VTitle) {
                if(VTitle){
                    document.cookie = "delVTitle=" + VTitle;
                    window.location.reload();
                }
                else{
                    alert('Delete vote failed! (ERR: Title undefined)');
                }
            }
            <?php
                if(isset($_COOKIE["VTitle"]) && isset($_COOKIE["VSide"])){
                    if(Vote($_COOKIE["VTitle"], $_SESSION['username'],  $_COOKIE["VSide"])){
                        echo "document.cookie = 'VTitle=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=vote.php;';";
                        echo "document.cookie = 'VSide=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=vote.php;';";
                        echo "alert('Vote successful!');";
                        echo "window.location.reload();";
                    }
                    else{
                        echo "document.cookie = 'VTitle=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=vote.php;';";
                        echo "document.cookie = 'VSide=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=vote.php;';";
                        echo "alert('Vote failed!');";
                    }
                }
            ?>
            function _Vote(VTitle, side) {
                if(VTitle){
                    document.cookie = "VTitle=" + VTitle;
                    document.cookie = "VSide=" + side;
                    window.location.reload();
                }
                else{
                    alert('Vote failed! (ERR: Title undefined)');
                }
            }
        </script>
         <div class="container mt-3">
            <?php
                echo "<div class='table-responsive'>";
                echo "<table class='table table-borded'>";
                echo "<thead><tr>";
                echo "<th scope='col' class='w-20 align-middle'>Title</th>";
                echo "<th scope='col' class='w-5 align-middle text-center'>L</th>";
                echo "<th scope='col' class='w-30 align-middle text-center'></th>";
                echo "<th scope='col' class='w-5 align-middle text-center'>R</th>";
                echo "<th scope='col' class='w-15 align-middle'>Author</th>";
                echo "<th scope='col' class='w-20 align-middle'>Time</th>";
                echo "<th scope='col' class='w-5 align-middle'></th>";
                echo "</tr></thead>";
                echo "<tbody>";
                if($search != ""){
                    $voteData = getVoteList($search);
                    $voteCnt = 0;
                    if($voteData != NULL){
                        $voteCnt = count($voteData);
                    }
                    if($voteCnt > 0){
                        for($index = 0; $index < $voteCnt; $index ++){
                            $vote = $voteData[$index]->get_all();
                            echo "<tr>";
                            echo "<td class='align-middle'><a href='#' data-bs-toggle='modal' data-bs-target='#voteModalIdx".$index."'>".$vote[0]."</a></td>";
                            // echo "<td class='align-middle'>".$vote[0]."</td>";
                            echo "<td class='align-middle text-center'>".$vote[1]."</td>";
                            echo "<td class='align-middle'>";
                            echo "<div class='progress'>";
                            if($vote[1] + $vote[2] == 0){
                                echo "<div class='progress-bar' role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'></div>";
                            }
                            else{
                                $tmp = round($vote[1] * 100 / ($vote[1] + $vote[2]));
                                echo "<div class='progress-bar' role='progressbar' style='width: ".$tmp."%' aria-valuenow='".$tmp."' aria-valuemin='0' aria-valuemax='100'></div>";
                                echo "<div class='progress-bar bg-danger' role='progressbar' style='width: ".(100 - $tmp)."%' aria-valuenow='".(100 - $tmp)."' aria-valuemin='0' aria-valuemax='100'></div>";
                            }
                            echo "</div>";
                            echo "</td>";
                            echo "<td class='align-middle text-center'>".$vote[2]."</td>";
                            echo "<td class='align-middle'>".$vote[4]."</td>";
                            echo "<td class='align-middle'>".$vote[3]."</td>";
                            echo "<td class='align-middle'>";
                            if(isset($_SESSION['username'])){
                                $username = $_SESSION['username'];
                                if($username == "admin" || $username = $vote[4]){
                                    echo "<button class='btn btn-danger' type='button' onclick=\"_delVote('".$vote[0]."')\">";
                                    echo "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>";
                                    echo "<path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z'/>";
                                    echo "<path d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z'/>";
                                    echo "</svg>";
                                    echo "</button>";
                                }
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                    }
                    else{
                        echo "<tr><td class='align-middle' colspan='7'><span class='text-danger mb-3'>No result found.</span></td></tr>";
                    }
                    echo "</tbody></table></div></div>";
                }
                else{
                    $voteData = getVoteList("");
                    $voteCnt = 0;
                    if($voteData != NULL){
                        $voteCnt = count($voteData);
                    }
                    if($voteCnt > 0){
                        for($index = 0; $index < $voteCnt; $index ++){
                            $vote = $voteData[$index]->get_all();
                            // echo "<pre>";
                            // print_r($vote);
                            // echo "</pre>";
                            echo "<tr>";
                            echo "<td class='align-middle'><a href='#' data-bs-toggle='modal' data-bs-target='#voteModalIdx".$index."'>".$vote[0]."</a></td>";
                            // echo "<td class='align-middle'>".$vote[0]."</td>";
                            echo "<td class='align-middle text-center'>".$vote[1]."</td>";
                            echo "<td class='align-middle'>";
                            echo "<div class='progress'>";
                            if($vote[1] + $vote[2] == 0){
                                echo "<div class='progress-bar' role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'></div>";
                            }
                            else{
                                $tmp = round($vote[1] * 100 / ($vote[1] + $vote[2]));
                                echo "<div class='progress-bar' role='progressbar' style='width: ".$tmp."%' aria-valuenow='".$tmp."' aria-valuemin='0' aria-valuemax='100'></div>";
                                echo "<div class='progress-bar bg-danger' role='progressbar' style='width: ".(100 - $tmp)."%' aria-valuenow='".(100 - $tmp)."' aria-valuemin='0' aria-valuemax='100'></div>";
                            }
                            echo "</div>";
                            echo "</td>";
                            echo "<td class='align-middle text-center'>".$vote[2]."</td>";
                            echo "<td class='align-middle'>".$vote[4]."</td>";
                            echo "<td class='align-middle'>".$vote[3]."</td>";
                            echo "<td class='align-middle'>";
                            if(isset($_SESSION['username'])){
                                $username = $_SESSION['username'];
                                if($username == "admin" || $username = $vote[4]){
                                    echo "<button class='btn btn-danger' type='button' onclick=\"_delVote('".$vote[0]."')\">";
                                    echo "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>";
                                    echo "<path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z'/>";
                                    echo "<path d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z'/>";
                                    echo "</svg>";
                                    echo "</button>";
                                }
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                    }
                    else{
                        echo "<tr><td class='align-middle' colspan='7'><span class='text-danger mb-3'>No data found.</span></td></tr>";
                    }
                }
                echo "</tbody></table></div></div>";
                if($voteCnt > 0){
                    for($index = 0; $index < $voteCnt; $index ++){
                        $vote = $voteData[$index]->get_all();
                        echo "<div class='modal fade' id='voteModalIdx".$index."' tabindex='-1' data-bs-backdrop='static' data-bs-keyboard='false' aria-labelledby='voteModalLabel' aria-hidden='true'>";
                        echo "<div class='modal-dialog modal-lg'>";
                        echo "<div class='modal-content'>";
                        echo "<div class='modal-header'>";
                        echo "<h5 class='modal-title' id='voteModalIdx".$index."Label'>".$vote[0]."</h5>";
                        echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                        echo "</div>";
                        echo "<div class='modal-body'>";
                        echo "<div class='table-responsive'>";
                        echo "<table class='table table-borded'>";
                        echo "<thead><tr>";
                        echo "<th scope='col' class='w-5 align-middle'></th>";
                        echo "<th scope='col' class='w-5 align-middle text-center'>L</th>";
                        echo "<th scope='col' class='w-80 align-middle text-center'></th>";
                        echo "<th scope='col' class='w-5 align-middle text-center'>R</th>";
                        echo "<th scope='col' class='w-5 align-middle'></th>";
                        echo "</tr></thead>";

                        echo "<tbody>";
                        echo "<tr>";
                        echo "<td class='align-middle'>";
                        echo "<button class='btn btn-primary' type='button' onclick=\"_Vote('".$vote[0]."', 1)\"".($_SESSION["username"] == NULL ? 'disabled' : '').">";
                        echo "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-patch-check' viewBox='0 0 16 16'>";
                        echo "<path fill-rule='evenodd' d='M10.354 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708 0z'/>";
                        echo "<path d='m10.273 2.513-.921-.944.715-.698.622.637.89-.011a2.89 2.89 0 0 1 2.924 2.924l-.01.89.636.622a2.89 2.89 0 0 1 0 4.134l-.637.622.011.89a2.89 2.89 0 0 1-2.924 2.924l-.89-.01-.622.636a2.89 2.89 0 0 1-4.134 0l-.622-.637-.89.011a2.89 2.89 0 0 1-2.924-2.924l.01-.89-.636-.622a2.89 2.89 0 0 1 0-4.134l.637-.622-.011-.89a2.89 2.89 0 0 1 2.924-2.924l.89.01.622-.636a2.89 2.89 0 0 1 4.134 0l-.715.698a1.89 1.89 0 0 0-2.704 0l-.92.944-1.32-.016a1.89 1.89 0 0 0-1.911 1.912l.016 1.318-.944.921a1.89 1.89 0 0 0 0 2.704l.944.92-.016 1.32a1.89 1.89 0 0 0 1.912 1.911l1.318-.016.921.944a1.89 1.89 0 0 0 2.704 0l.92-.944 1.32.016a1.89 1.89 0 0 0 1.911-1.912l-.016-1.318.944-.921a1.89 1.89 0 0 0 0-2.704l-.944-.92.016-1.32a1.89 1.89 0 0 0-1.912-1.911l-1.318.016z'/>";
                        echo "</svg>";
                        echo "</button>";
                        echo "</td>";

                        echo "<td class='align-middle text-center'>".$vote[1]."</td>";

                        echo "<td class='align-middle'>";
                        echo "<div class='progress'>";
                        if($vote[1] + $vote[2] == 0){
                            echo "<div class='progress-bar' role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'></div>";
                        }
                        else{
                            $tmp = round($vote[1]  * 100 / ($vote[1] + $vote[2]));
                            echo "<div class='progress-bar' role='progressbar' style='width: ".$tmp."%' aria-valuenow='".$tmp."' aria-valuemin='0' aria-valuemax='100'></div>";
                            echo "<div class='progress-bar bg-danger' role='progressbar' style='width: ".(100 - $tmp)."%' aria-valuenow='".(100 - $tmp)."' aria-valuemin='0' aria-valuemax='100'></div>";
                        }
                        echo "</div>";
                        echo "</td>";
                        echo "<td class='align-middle text-center'>".$vote[2]."</td>";

                        echo "<td class='align-middle'>";
                        echo "<button class='btn btn-danger' type='button' onclick=\"_Vote('".$vote[0]."', 2)\"".($_SESSION["username"] == NULL ? 'disabled' : '').">";
                        echo "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-patch-check' viewBox='0 0 16 16'>";
                        echo "<path fill-rule='evenodd' d='M10.354 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708 0z'/>";
                        echo "<path d='m10.273 2.513-.921-.944.715-.698.622.637.89-.011a2.89 2.89 0 0 1 2.924 2.924l-.01.89.636.622a2.89 2.89 0 0 1 0 4.134l-.637.622.011.89a2.89 2.89 0 0 1-2.924 2.924l-.89-.01-.622.636a2.89 2.89 0 0 1-4.134 0l-.622-.637-.89.011a2.89 2.89 0 0 1-2.924-2.924l.01-.89-.636-.622a2.89 2.89 0 0 1 0-4.134l.637-.622-.011-.89a2.89 2.89 0 0 1 2.924-2.924l.89.01.622-.636a2.89 2.89 0 0 1 4.134 0l-.715.698a1.89 1.89 0 0 0-2.704 0l-.92.944-1.32-.016a1.89 1.89 0 0 0-1.911 1.912l.016 1.318-.944.921a1.89 1.89 0 0 0 0 2.704l.944.92-.016 1.32a1.89 1.89 0 0 0 1.912 1.911l1.318-.016.921.944a1.89 1.89 0 0 0 2.704 0l.92-.944 1.32.016a1.89 1.89 0 0 0 1.911-1.912l-.016-1.318.944-.921a1.89 1.89 0 0 0 0-2.704l-.944-.92.016-1.32a1.89 1.89 0 0 0-1.912-1.911l-1.318.016z'/>";
                        echo "</svg>";
                        echo "</button>";
                        echo "</td>";

                        echo "</tr>";
                        echo "</tbody></table></div>";

                        // echo "<div class='mb-3' style='word-break:break-all'>".$forum[1]."</div>";
                        echo "</div>";
                        echo "<div class='modal-footer text-secondary'>".$vote[4]."</div>";
                        echo "</div></div></div>";
                    }
                }
            ?>
        </div>
        <script>
            <?php
                if(isset($_COOKIE["addVTitle"])){
                    if(addVote($_COOKIE["addVTitle"], $_SESSION['username'])){
                        echo "document.cookie = 'addVTitle=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=vote.php;';";
                        echo "alert('Add vote successful!');";
                        echo "window.location.reload();";
                    }
                    else{
                        echo "alert('Add vote failed!');";
                    }
                }
            ?>
            function _addVote() {
                var VTitle = document.getElementById('VTitle').value;
    
                if(VTitle){
                    if(VTitle.length > 20){
                        alert('Add vote failed! (ERR: The length of Title is greater than 20.)');
                    }
                    else{
                        document.cookie = "addVTitle=" + VTitle; path="vote.php";
                        window.location.reload();
                    }
                }
                else{
                    alert('Add vote failed! Please fill in all fields.');
                }
            }
        </script>
        <div class="modal fade" id="voteModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="voteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="forumModalLabel">New Vote</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="VTitle" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" id="VTitle">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="submitBtn" onclick="_addVote()">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bootstrap JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>