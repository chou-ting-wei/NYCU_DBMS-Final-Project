<!DOCTYPE html>
<?php
    error_reporting(E_ERROR | E_WARNING);
    session_start();
    if(!isset($_SESSION["login_session"])){
        $_SESSION["login_session"] = false;
        $_SESSION["username"] = NULL;
    }
    include("sqlmanager.php");

    if(!$_SESSION["login_session"]){
        echo "<script>location.href='login.php'</script>";
    }
?>
<html>
    <head>
        <meta charset="UTF=8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>NBA Stat - Admin</title>
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
        .w-40{
            width: 40%;
        }
        .w-55{
            width: 55%;
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
                                    echo "<a class='nav-link active' href='#'>".$username."</a>";
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
            <h3 class="fw-bolder">Admin</h3>
            <hr class="mt-3 mb-3"></hr>

            <div class="container mt-3">
                <div class="table-responsive">
                    <table class="table table-borded table-hover">
                        <thead>
                            <tr>
                                <th scope="col" class="w-40 align-middle">Username</th>
                                <th scope="col" class="w-55 align-middle">Password</th>
                                <th scope="col" class="w-5 align-middle">
                                <button class="btn btn-secondary" type="button" href="#" data-bs-toggle="modal" data-bs-target="#adminModal" <?php echo $_SESSION["username"] == NULL ? 'disabled' : ''; ?>>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>
                                </button>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $userData = getUserList("");
                                $userCnt = 0;
                                if($userData != NULL){
                                    $userCnt = count($userData);
                                }
                                if($userCnt > 0){
                                    for($index = 0; $index < $userCnt; $index ++){
                                        $user = $userData[$index];
                                        // echo "<pre>";
                                        // print_r($user);
                                        // echo "</pre>";
                                        echo "<tr>";
                                        echo "<td class='align-middle'>".$user->get_username()."</td>";
                                        echo "<td class='align-middle'>".$user->get_password()."</td>";
                                        echo "<td class='align-middle'>";
                                        if($user->get_username() != "admin"){
                                            echo "<button class='btn btn-danger' type='button' onclick=\"_delUser('".$user->get_username()."')\">";
                                            echo "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>";
                                            echo "<path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z'/>";
                                            echo "<path d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z'/>";
                                            echo "</svg>";
                                            echo "</button>";
                                        }
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                }
                                else{
                                    echo "<tr><td class='align-middle' colspan='3'><span class='text-danger mb-3'>No data found.</span></td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script>
            <?php
                if(isset($_COOKIE["delUsername"])){
                    if(delUser($_COOKIE["delUsername"])){
                        echo "document.cookie = 'delUsername=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=admin.php;';";
                        echo "alert('Delete user successful!');";
                        echo "window.location.reload();";
                    }
                    else{
                        echo "alert('Delete user failed!');";
                    }
                }
            ?>
            function _delUser(username) {
                if(username){
                    document.cookie = "delUsername=" + username;
                    window.location.reload();
                }
                else{
                    alert('Delete user failed! (ERR: username undefined)');
                }
            }

            <?php
                if(isset($_COOKIE["editUsername"]) && isset($_COOKIE["editPassword"])){
                    if(editPassword($_COOKIE["editUsername"], $_COOKIE["editPassword"])){
                        echo "document.cookie = 'editUsername=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=admin.php;';";
                        echo "document.cookie = 'editPassword=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=admin.php;';";
                        echo "alert('Edit user successful!');";
                        echo "window.location.reload();";
                    }
                    else{
                        if(addRegister($_COOKIE["editUsername"], $_COOKIE["editPassword"])){
                            echo "document.cookie = 'editUsername=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=admin.php;';";
                            echo "document.cookie = 'editPassword=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=admin.php;';";
                            echo "alert('Add user successful!');";
                            echo "window.location.reload();";
                        }
                        else{
                            echo "alert('Add/Edit user failed!');";
                        }
                    }
                }
            ?>
            function _editPassword() {
                var eUser = document.getElementById('editUsername').value;
                var ePw = document.getElementById('editPassword').value;
    
                if(eUser && ePw){
                    if(ePw.length < 8){
                        alert('Edit user failed! (ERR: The length of Password is lesser than 8.)');
                    }
                    else if(ePw.length > 20){
                        alert('Edit user failed! (ERR: The length of Password is greater than 20.)');
                    }
                    else{
                        document.cookie = "editUsername=" + eUser; path="admin.php";
                        document.cookie = "editPassword=" + ePw; path="admin.php";
                        window.location.reload();
                    }
                }
                else{
                    alert('Edit user failed! Please fill in all fields.');
                }
            }
        </script>
        <div class="modal fade" id="adminModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="forumModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="adminModalLabel">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editUsername" class="form-label">Username</label>
                            <input type="text" name="user" class="form-control" id="editUsername">
                        </div>
                        <div class="mb-3">
                            <label for="editPassword" class="form-label">Password</label>
                            <input type="password" name="pw" class="form-control" id="editPassword">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="submitBtn" onclick="_editPassword()">Submit</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>