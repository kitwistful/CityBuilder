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
include "../scripts/CityData.php";


define("CITY_NAMES", "citybuilder_citynames");

// get session values
$bLoggedIn = $_SESSION["citybuilder_bLoggedIn"];
$username = $_SESSION["citybuilder_username"];

// consider whether or not the user has any cities
$userOwnsCities = false;

// check user's cities
if($bLoggedIn)
{
    
    $_SESSION[CITY_NAMES] = CityData::getUserCities($username);
    $cities = $_SESSION[CITY_NAMES];
    $userOwnsCities = count($cities) > 0;
    
    
}

// header
define("CURRENT_PAGE", "../pages/dashboard.php");
include "../scripts/header.php";
    
?>
<?php
    // has different content depending on whether or not user is logged in
    if(!$bLoggedIn)
    {
        echo "<article><header>Welcome to City Builder!</header><content>To get started, please <a href = 'create_account.php'>create a player account</a> or <a href = 'login.php'>login to an existing one</a>. <!--You can also <a href = 'recover_account.php'>recover an account</a> if you have a code.--> Have fun!</content></article>";
    } else if(!$userOwnsCities) {
        echo "<article><header>No Cities Yet</header><content>It's time to make your first city! Click <a href = 'newcity.php'>here</a> to create your city.</content></article>";
    } else{
        include '../scripts/game.php';
    }
?>
    
</body>
</html>