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
        <header><div id = "CurrentCityName"></div></header>
        <content>
            <div id = "CurrentCitySectors"></div>
            <div id = "CurrentCityDescription"></div>
            <ul id = "CurrentCityInfo">
                <li>Blocks:  <div id = "CurrentCityInfoBlocks"></div></li>
                <li>Unused Blocks: <div id = "CurrentCityInfoUnusedBlocks"></div></li>
                <li>Current Sector: <div id = "CurrentCityInfoCurrentSector"></div></li>
            </ul>
        </content>
    </article>
    <article id = "CitiesBlock">
        <header>Cities</header>
        <content>
            <div id = "CitiesContent"></div>
        </content>
    </article>
    <article id = "SectorsBlock">
        <header>Sectors</header>
        <content>
            <div id = "SectorsContent"></div>
        </content>
    </article>
    <article id = "CityExpansionBlock">
        <header>City Expansion</header>
        <content>
            <div id = "CityExpansionContent"></div>
        </content>
    </article>
    <!-- wait, where's the build button? -->
    <article id = "CreateNewCityBlock">
        <header>Create New City</header>
        <content>
            Go <a href = "../pages/newcity.php">here</a> to create a new city.
        </content>
    </article>
</div>
<script>
    // get name of element to show
    var visibleElement = <?php echo "\"$elementShownName\"" ?>;

    // load game stuff
    if(visibleElement == "#GameContent")
    {
        // todo
        $("#CurrentCityName").html("'Todo'");
        
        // sectors list
        var sectors = ["Residential", "Educational", "Recreational", "Business"];

        // currently selected sector
        var selectedSector = 0; //todo
        
        // cities list
        var citiesLabels = [/*todo*/];
        var citiesValues = [/*todo*/];
        
        // expansion options list
        var expansionsLabels = ["3000 coins->blocks", "2000 coins->blocks", "1000 coins->blocks", "none"];
        var expansionsValues = [3000, 2000, 1000, 0];
        
        // fill out current city sectors
        $("#CurrentCitySectors").html("Sectors: todo");
        
        // put in description
        $("#CurrentCityDescription").html("Description: todo");
        
        // put in stats
        $("#CurrentCityInfoBlocks").html("todo1");
        $("#CurrentCityInfoUnusedBlocks").html("todo2");
        $("#CurrentCityInfoCurrentSector").html("todo3");
        
        
        // populate sectors block
        CityBuilder_appendRadioInputs("#SectorsContent", "sector", 0, sectors);
        
        // populate cities
        CityBuilder_appendRadioInputs("#CitiesContent", "city", selectedSector, citiesLabels, citiesValues);
        
        // populate city expansion block
        CityBuilder_appendRadioInputs("#CityExpansionContent", "expansion", 3, expansionsLabels, expansionsValues);
        
        
        
    }

    // show correct div
    CityBuilder_makeUnhidden(visibleElement);
</script>
<?php include '../scripts/footer.php'?>
</body>
</html>