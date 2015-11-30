<!DOCTYPE HTML>
<?php
    session_start();
?>
<html>
<head>
<?php include "include.php"; ?>
    <title>Play City Builder</title>
</head>
<body>
<?php
    // get session values
    $bLoggedIn = $_SESSION["citybuilder_bLoggedIn"];
    $username = $_SESSION["citybuilder_username"];

    // header
    define("CURRENT_PAGE", "dashboard.php");
    include "header.php";
    
?>
<?php
    $dashboard_title = ($username ? ($username."'s") : "Your")." Dashboard";
    
    echo "<article><header>$dashboard_title</header><content>";
    if(!$bLoggedIn)
    {
        echo "Please <a href = 'login.php'>log in</a> or <a href = 'create_account.php'>sign up</a> to start playing the game.</content></article>";
        
    } else {
        echo "Hey, ".$username.", let's get rolling!</content></article>";
        include 'game.php';
    }
?>
    
</body>
</html>