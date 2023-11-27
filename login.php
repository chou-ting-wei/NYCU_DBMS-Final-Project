<!DOCTYPE html>
<?php
    error_reporting(E_ERROR | E_WARNING);
    session_start();
?>
<html>
    <head>
        <meta charset="UTF=8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>NBA Stat - Login</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>
    <style>
        body{
            background-color: #e9eded;
        }
    </style>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand">NBA Stat</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Home</a>
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
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <body>
        <?php
            $username = ""; $password = "";
            $msg = "";
            if(isset($_POST["username"]))
                $username = $_POST["username"];  
            if(isset($_POST["password"]))
                $password = $_POST["password"];
            if($username != "" && $password != ""){
                // $link = require_once("config.php");
                // $sql = "SELECT * FROM students WHERE password='".$password."' AND username='".$username."'";
                // $result = mysqli_query($link, $sql);
                // $total_records = mysqli_num_rows($result);
                // if($total_records > 0){
                //     $_SESSION["login_session"] = true;
                //     $_SESSION["username"] = $username;
                //     header("Location: index.php");
                // }
                // else{
                //     $msg = "Wrong username or password";
                //     $_SESSION["login_session"] = false;
                // }
                if($username == "admin" && $password == "admintest"){
                    $_SESSION["login_session"] = true;
                    $_SESSION["username"] = $username;
                    header("Location: index.php");
                }
                else{
                    $msg = "Wrong username or password";
                    $_SESSION["login_session"] = false;
                }
                // mysqli_close($link);
            }
        ?>
        <div class="container mt-4">
            <h3>Login</h3>
            <form action=login.php method="post">
                <div class="mt-3 mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username"placeholder="username" autocomplete="off" minlength="4" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="password" autocomplete="off" minlength="8" required>
                    <div class="invalid-feedback">
                        Password should 
                    </div>
                </div>
                <div class="mb-3">
                    <?php echo $msg; ?>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>

        <!-- Bootstrap JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>