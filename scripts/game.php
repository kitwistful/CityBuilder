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
    function gameLoop(name, niters)
    {
        $(name).append("prepost for iter " + niters + "<br />");
        $.post("../scripts/game_update.php",
            {testmessage: "this is iter " + niters
            },
            function(text){
            $(name).append("got: "+text+"<br />" );
            },
            "text");
        if(niters > 0)
        {
            setTimeout(function(){
                gameLoop(name, niters-1);
                }, 1000);
            
        } else {
            $(name).append("maxed out<br/>");
        }
    }
    
    gameLoop("#testReload", 10);
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
<article>
    <header>How to Play</header>
    <content>
        <p>
            To grow '<?php echo $cities[$curr_city]?>', select a sector to focus on. It'll grow by one block right away, and keep growing in size as long as it is selected. You can make it grow faster by pressing the "build" button. Be careful, though! If your sector takes up too many blocks, all construction will cease. Your city has only so much space!
        </p>
        <p>
            If you want to make your city even bigger, you're going to need coins. You can purchase more blocks under 'City Expansion'.
        </p>
    </content>
</article>
<form method = "POST" action = "dashboard.php">
    <article>
        <header>Sectors</header>
<?php
    // print sector options
    foreach($sector_names as $k=>$name)
    {
        // print radio button
        echo "<input class = 'radio_input' type = 'radio' name = 'sector' value = $k ";
        
        // preselect the current entry
        if($k == $currCityInfo->currSector)
            echo "checked";
        
        // print the city name
        echo "></input>$name<br />";
    }
?>
    </article>
    <article>
        <header>Cities</header>
<?php
    // print city options
    foreach($cities as $k=>$city)
    {
        // print radio button
        echo "<input class = 'radio_input' type = 'radio' name = 'city' value = $k ";
        
        // preselect the current entry
        if($k == $curr_city)
            echo "checked";
        
        // print the city name
        echo "></input>$city<br />";
    }
?>
    </article>
    <article>
        <header>City Expansion</header>
        <content>
            Purchase more blocks for your city here! Current coin count: <b><?php echo $currCityInfo->nCoins?></b>
        </content>
<?php
    // print expansion options
    for($i = 0; $i <= 3; $i++)
    {
        // print radio button
        echo "<input class = 'radio_input' type = 'radio' name = 'expansion' value = $i ";
        
        // print none or some
        if($i == 0)
            echo "checked></input>None<br />";
        else
            echo sprintf("></input>%d blocks for %d coins<br />", $i*1000, $i*100);
    }
?>
    </article>
    <article>
        <header>Update City</header>
        <button>Build</button>
    </article>
    <article>
        <header>Create New City</header>
        <content>
            Go <a href = "../pages/newcity.php">here</a> to create a new city.
        </content>
    </article>
</form>