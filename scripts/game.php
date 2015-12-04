<?php
/**
* scripts/game.php
* Project: CityBuilder Application
* Author(s): Kathryn McKay
* Year: 2015
*
* This contains the game view.
*
**/
?>

<!-- game script -->
<script type="text/javascript" src="../scripts/game.js"></script>
<?php
    

// sectors
$sector_names = array(SECTOR_RESIDENTIAL=>"Residential", SECTOR_EDUCATIONAL=>"Educational", SECTOR_BUSINESS=>"Business", SECTOR_RECREATIONAL=>"Recreational", SECTOR_NONE=>"None");

// get cities
$cities = $_SESSION[CITY_NAMES];

//todo
if($cities == null)
{
    $cities = array("Needs Implementation");
}

// city to change
$curr_city = 0;

// update stuff
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $curr_city = $_POST["city"];
    $curr_sector = $_REQUEST["sector"];
}



// initialize current city info
$currCityInfo = CityData::getCityInfo($cities[$curr_city], $_SESSION["citybuilder_username"]);

// calculate interesting information
$nUnusedBlocks = null;
$sector_display_class = array(SECTOR_RESIDENTIAL=>false, SECTOR_EDUCATIONAL=>false, SECTOR_BUSINESS=>false, SECTOR_RECREATIONAL=>false);
if($currCityInfo == null)
{
    // error
    echo sprintf("ERROR: failure loading city '%s'<br />", $cities[$curr_city]);
} else {
    // calculate unused blocks
    $nUnusedBlocks = $currCityInfo->nBlocks;
    foreach($currCityInfo->sectorBlocks as $k=>$n)
    {
        $nUnusedBlocks = $nUnusedBlocks - $n;
    }
    
    
    // selected
    foreach($sector_display_class as $k=>$v)
    {
        $sector_display_class[$k] = $k == $currCityInfo->currSector ? "selected_sector" : "unselected_sector";
    }
}
    
    
    
    
    
?>
<div id = "testReload"></div>
<script>
CityBuilder_gameLoop(<?php echo "\"$cities[$curr_city]\""?>, <?php echo "\"$currCityInfo->currSector\""?>);
$(name).append("but does it block?");
</script>
<article id = "curr_city">
    <header>'<?php echo $cities[$curr_city] ?>'</header>
    <div id = "game_sector_display">
        <div id = "game_sector_display_q1" class = <?php echo $sector_display_class[SECTOR_RESIDENTIAL]?> >
            Residential: <?php echo $currCityInfo->sectorBlocks[SECTOR_RESIDENTIAL]?>
        </div>
        <div id = "game_sector_display_q2" class = <?php echo $sector_display_class[SECTOR_EDUCATIONAL]?> >
            Educational: <?php echo $currCityInfo->sectorBlocks[SECTOR_EDUCATIONAL]?>
        </div>
        <div id = "game_sector_display_q3" class = <?php echo $sector_display_class[SECTOR_BUSINESS]?> >
            Business: <?php echo $currCityInfo->sectorBlocks[SECTOR_BUSINESS]?>
        </div>
        <div id = "game_sector_display_q4" class = <?php echo $sector_display_class[SECTOR_RECREATIONAL]?> >
            Recreational: <?php echo $currCityInfo->sectorBlocks[SECTOR_RECREATIONAL]?>
        </div>
    </div>
    <content>
        <div id = "city_description">What is there to say about this place?</div>
    </content>
    <ul>
        <li>Blocks:  <?php echo $currCityInfo->nBlocks?></li>
        <li>Unused Blocks: <?php echo $nUnusedBlocks?></li>
        <li>Coins: <?php echo $currCityInfo->nCoins?></li>
        <li>Current Sector: <?php echo $sector_names[$currCityInfo->currSector]?></li>
    </ul>
</article>