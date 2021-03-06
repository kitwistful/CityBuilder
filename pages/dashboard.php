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
include "../scripts/include.php";
CityBuilder::initSessionKeys();
?>
<html>
<head>
<?php CityBuilder::printIncludes() ?>
    <!-- game script -->
    <script type="text/javascript" src="../scripts/game.js"></script>
    <title>Play City Builder</title>
    
    <?php
include "../scripts/CityData.php";
function cityLabels($cities)
{
    if($cities != null)
    {
        $labels = "";
        foreach($cities as $i=>$city)
        {
            if($i == 0)
                $labels = "'$city'";
            else
                $labels = "$labels, '$city'";
        }
        
        echo $labels;
        
    }
}

function cityValues($cities)
{
    $len = count($cities);
    $values = "0";
    for($i = 1; $i < $len; $i++)
    for($i = 1; $i < $len; $i++)
    {
        $values = $values.", $i";
    }
    
    echo $values;
    
}

// get session values
$bLoggedIn = $_SESSION["citybuilder_bLoggedIn"];
$username = $_SESSION["citybuilder_username"];

// consider whether or not the user has any cities
$userOwnsCities = false;

// current city in game
$currCityInfo = CityData::getCityInfo(null, null);
$currCity = 0;

$cities = ["error"];


// check user's cities
if($bLoggedIn)
{
    
    $the_cities = CityData::getUserCities($username);
    $userOwnsCities = count($the_cities) > 0;
    if($userOwnsCities)
        $cities = $the_cities;
}

// select which content to show
$elementShownName = "#GameContent";
if(!$bLoggedIn)
{
    $elementShownName = "#LoggedOutContent";
} else if(!$userOwnsCities) {
    $elementShownName = "#NoCitiesContent";    
} else {
    // retrieve current city
    define("CURRCITY", "CityBuilder_currCity");
    $currCity = 0;
    if(!array_key_exists(CURRCITY, $_SESSION))
    {
        $_SESSION[CURRCITY] = $currCity;
    } else {
        $currCity = $_SESSION[CURRCITY];
    }
    
    // retrieve current city info
    if($currCity == null)
    {
        $currCity = 0;
    }
        
    $currCityInfo = CityData::getCityInfo($cities[$currCity], $username);
    
}
?>
<script>
function loadPage()
{
    // get name of element to show
    var visibleElement = <?php echo "\"$elementShownName\"" ?>;

    // load game stuff
    if(visibleElement == "#GameContent")
    {
        // update page
        var data = {
            cityIndex: <?php echo $currCity?>,
            cityName: <?php echo "\"$cities[$currCity]\""?>,
            currentSector: <?php echo sprintf("\"%s\"", $currCityInfo != null && $currCityInfo->currSector != null ? $currCityInfo->currSector : SECTOR_NONE) ?>,
            growth: 0
            };
        $.post("../scripts/processGame.php", data);
        
        // insert city name
        $("#CurrentCityName").html(<?php echo sprintf("\"'%s'\"", !array_key_exists($currCity, $cities) ? "" : $cities[$currCity])?>);
        
        // sectors list
        var sectors = ["Residential", "Educational", "Recreational", "Business", "None"];
        
        // cities list
        var citiesLabels = [<?php cityLabels($cities)?>];
        var citiesValues = [<?php cityValues($cities)?>];
        
        // expansion options list
        var expansionsLabels = ["3000 coins->blocks", "2000 coins->blocks", "1000 coins->blocks", "none"];
        var expansionsValues = [3000, 2000, 1000, 0];
        
        // sector blocks
        var sectorBlocks = [<?php if($currCityInfo != null && $currCityInfo->sectorBlocks != null) echo sprintf("%d, %d, %d, %d",
            $currCityInfo->sectorBlocks[SECTOR_RESIDENTIAL],
            $currCityInfo->sectorBlocks[SECTOR_EDUCATIONAL],
            $currCityInfo->sectorBlocks[SECTOR_RECREATIONAL],
            $currCityInfo->sectorBlocks[SECTOR_BUSINESS])?>];

        // currently selected city
        var selectedCity = <?php echo $currCity == null ? "\"\"" : $currCity?>;
        
        // get description
        var description = <?php echo $currCityInfo ? "\"".CityData::getDescription($currCityInfo)."\"" : "\"\""?>;
       
        // description updates largest sector value in session
<?php        
// figure out largest sector
$largestSector = SECTOR_NONE;
if(array_key_exists("CityBuilder_largestSector", $_SESSION))
    $largestSector = $_SESSION["CityBuilder_largestSector"];
?>
            
        // currently selected sector
        var selectedSectorName = <?php echo $currCityInfo && $currCityInfo->currSector ? "\"$currCityInfo->currSector\"" : sprintf("\"%s\"", SECTOR_NONE)?>;
        var selectedSector = 4;
        var largestSectorName = <?php echo sprintf("\"%s\"", $largestSector == null ? SECTOR_NONE : $largestSector) ?>;
        var largestSector = 4;
        for(var i = 0; i < sectors.length; i++)
        {
            if(sectors[i] == selectedSectorName)
            {
                selectedSector = i;
            }
            
            if(sectors[i] == largestSectorName)
            {
                largestSector = i;
            }
        }
        
        // number of blocks
        var nBlocks = <?php echo $currCityInfo && $currCityInfo->nBlocks ? $currCityInfo->nBlocks : "\"\""?>;
        
        // figure out used blocks
        var unusedBlocks = nBlocks;
        
        // iterate over blocks
        for(var i = 0; i < 4; i++)
        {
            // highlight selected
            var classname = "unselected_sector";
            if(i == selectedSector)
                classname = "selected_sector";
            
            sectorLabel = sectors[i];
            
            $("#CurrentCitySectors").append("<div class = '" + classname + "'>"+ sectorLabel + ": " + sectorBlocks[i] + "</div>");
            
            // calculate usedBlocks
            unusedBlocks -= sectorBlocks[i];
        }
        
        // put in description
        $("#CurrentCityDescription").html(description);
        
        // put in stats
        $("#CurrentCityInfoBlocks").html(nBlocks);
        $("#CurrentCityInfoUnusedBlocks").html(unusedBlocks);
        $("#CurrentCityInfoCurrentSector").html(sectors[selectedSector]);
        $("#CurrentCityInfoLargestSector").html(largestSectorName);
        
        // populate sectors block
        CityBuilder_appendRadioInputs("#SectorsContent", "sector", selectedSector, sectors, sectors, selectedCity, citiesLabels, false, 1);
        var currElement = $("#SectorsContent").find("input");
<?php
    for($i = 0; $i < 5; $i++)
    {   
        // create onclick for sectors
        echo sprintf("$(currElement.get($i)).change(data$i = {index: $i}, function()
            {
                CityBuilder_postForm(selectedCity, \"%s\", sectors[$i], 1); 
            });", $cities[$currCity]);
    }
?>
        
        // populate cities
        CityBuilder_appendRadioInputs("#CitiesContent", "city", selectedCity, citiesLabels, citiesValues, false, citiesLabels, selectedSector, 1);
        var currElement = $("#CitiesContent").find("input");
<?php
    if($currCityInfo)
    {
        for($i = 0; $i < count($cities); $i++)
        {
            // create onclick for cities
            echo sprintf("$(currElement.get($i)).change(cityData$i = {index: $i, selected: selectedCity}, function()
                {
                    CityBuilder_postForm($i, \"%s\", null, 1); 
                });", $cities[$i]);
        }
        
    }
?>        
        
        
    }

    // show correct div
    CityBuilder_makeUnhidden(visibleElement);
}
    
</script>
</head>
<body onload = "loadPage()">
<div id = "errorBro"></div>
<?php
// header
define("CURRENT_PAGE", "../pages/dashboard.php");
include "../scripts/header.php";
?>


<div id = "LoggedOutContent" class = "hidden">
    <article>
        <header>Welcome to City Builder!</header>
        <content>
            To get started, please <a href = 'signup.php'>create a player account</a> or <a href = 'login.php'>login to an existing one</a>. Have fun!
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
                <li>Largest Sector: <div id = "CurrentCityInfoLargestSector"></div></li>
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
    <article id = "CreateNewCityBlock">
        <header>Create New City</header>
        <content>
            Go <a href = "../pages/newcity.php">here</a> to create a new city.
        </content>
    </article>
</div>
<?php include '../scripts/footer.php'?>
</body>
</html>