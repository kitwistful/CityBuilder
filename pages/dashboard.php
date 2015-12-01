<!DOCTYPE HTML>
<?php
/**
* pages/dashboard.php
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
<?php include "../scripts/include.php"; ?>
    <title>Play City Builder</title>
</head>
<body>
<?php
    // get session values
    $bLoggedIn = $_SESSION["citybuilder_bLoggedIn"];
    $username = $_SESSION["citybuilder_username"];

    // header
    define("CURRENT_PAGE", "../pages/dashboard.php");
    include "../scripts/header.php";
    
?>
<?php
    // has different content depending on whether or not user is logged in
    if(!$bLoggedIn)
    {
        echo "<article><header>Welcome to City Builder!</header><content>To get started, please <a href = 'create_account.php'>create a player account</a> or <a href = 'login.php'>login to an existing one</a>. <!--You can also <a href = 'recover_account.php'>recover an account</a> if you have a code.--> Have fun!</content></article>";
    } else {
        include '../scripts/game.php';
    }
?>
    
</body>
</html>