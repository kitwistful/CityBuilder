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
    <!-- game script -->
    <script type="text/javascript" src="../scripts/game.js"></script>
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
    // select which content to show
    $elementShownName = "#GameContent";
    if(!$bLoggedIn)
    {
        $elementShownName = "#LoggedOutContent";
    } else if(!$userOwnsCities) {
        $elementShownName = "#NoCitiesContent";    
    }
?>

<div id = "LoggedOutContent" class = "hidden">
    <article>
        <header>Welcome to City Builder!</header>
        <content>
            To get started, please <a href = 'create_account.php'>create a player account</a> or <a href = 'login.php'>login to an existing one</a>. Have fun!
        </content>
    </article>
</div>
<div id = "NoCitiesContent" class = "hidden">
    <article>
        <header>No Cities Yet</header>
        <content>
            It's time to make your first city! Click <a href = 'newcity.php'>here</a> to create your city.
        </content>
    </article>
</div>
<div id = "GameContent" class = "hidden">
    <article id = "CurrentCityBlock">
        <header><div id = "CityName"></div></header>
        <content>
            todo
        </content>
    </article>
    <article id = "HowToPlayBlock">
        <header>How To Play</header>
        <content>
            todo
        </content>
    </article>
    <article id = "SectorsBlock">
        <header>Sectors</header>
        <content>
            todo
        </content>
    </article>
    <article id = "CitiesBlock">
        <header>Cities</header>
        <content>
            todo
        </content>
    </article>
    <article id = "CityExpansionBlock">
        <header>City Expansion</header>
        <content>
            todo
        </content>
    </article>
    <!-- wait, where's the build button? -->
    <article id = "CreateNewCityBlock">
        <header>CreateNewCity</header>
        <content>
            todo
        </content>
    </article>
</div>
<script>
    // show correct div
    CityBuilder_makeUnhidden(<?php echo "\"$elementShownName\"" ?>);
</script>
</body>
</html>