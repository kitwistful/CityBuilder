<!DOCTYPE HTML>
<?php
/**
* dashboard.php
* Project: CityBuilder Application
* Author(s): Kathryn McKay
* Year: 2015
*
* This page is where the game can be found, provided the player is logged in.
*
**/
    // initialize session
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
    // has different content depending on whether or not user is logged in
    if(!$bLoggedIn)
    {
        echo "<article><header>Dashboard</header><content>Please <a href = 'login.php'>log in</a> or <a href = 'create_account.php'>sign up</a> to start playing the game.</content></article>";
        
    } else {
        include 'game.php';
    }
?>
    
</body>
</html>