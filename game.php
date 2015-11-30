<?php
    // sector enums
    define("SECTOR_RESIDENTIAL", "residential");
    define("SECTOR_EDUCATIONAL", "educational");
    define("SECTOR_BUSINESS", "business");
    define("SECTOR_RECREATIONAL", "recreational");

    // city names
    $cities = array("First City", "Someburb", "Polispolis");
    
    // city to change
    $curr_city = 0;
    
    // select new city
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $curr_city = $_POST["city"];
    }
    
    // sector to grow
    $curr_sector = SECTOR_RESIDENTIAL;
    
    // blocks allocated to each sector
    $sector_blocks = array(SECTOR_RESIDENTIAL=>100, SECTOR_EDUCATIONAL=>200, SECTOR_BUSINESS=>300, SECTOR_RECREATIONAL=>400);
    
    // number of blocks
    $n_blocks = 2000;
    
    // calculate unused blocks
    $n_blocks_unused = $n_blocks;
    foreach($sector_blocks as $k=>$n)
    {
        $n_blocks_unused = $n_blocks_unused - $n;
    }
    
    // funds
    $n_coins = 0;
    
    // selected
    $sector_display_class = array(SECTOR_RESIDENTIAL=>null, SECTOR_EDUCATIONAL=>null, SECTOR_BUSINESS=>null, SECTOR_RECREATIONAL=>null);
    foreach($sector_display_class as $k=>$v)
    {
        $sector_display_class[$k] = $k == $curr_city ? "selected_sector" : "unselected_sector";
    }
    
    
    
?>
<article id = "curr_city">
<header>'<?php echo $cities[$curr_city] ?>'</header>
<div id = "game_sector_display">
    <div id = "game_sector_display_q1" class = <?php echo $sector_display_class[SECTOR_RESIDENTIAL]?> >
        Residential: <?php echo $sector_blocks[SECTOR_RESIDENTIAL]?>
    </div>
    <div id = "game_sector_display_q2" class = <?php echo $sector_display_class[SECTOR_RESIDENTIAL]?> >
        Educational: <?php echo $sector_blocks[SECTOR_EDUCATIONAL]?>
    </div>
    <div id = "game_sector_display_q3" class = <?php echo $sector_display_class[SECTOR_RESIDENTIAL]?> >
        Business: <?php echo $sector_blocks[SECTOR_BUSINESS]?>
    </div>
    <div id = "game_sector_display_q4" class = <?php echo $sector_display_class[SECTOR_RESIDENTIAL]?> >
        Recreational: <?php echo $sector_blocks[SECTOR_RECREATIONAL]?>
    </div>
</div>
<content>
    <div id = "city_description">What is there to say about this place?</div>
</content>
<ul>
    <li>Blocks:  <?php echo $n_blocks?></li>
    <li>Unused Blocks: <?php echo $n_blocks_unused?></li>
    <li>Coins: <?php echo $n_coins?></li>
    <li>Current Sector: <?php echo $curr_sector?></li>
</ul>
</article>

<article>
    <header>Your Cities</header>
    <form method = "POST" action = "dashboard.php">
<?php
    foreach($cities as $k=>$city)
    {
        // print radio button
        echo "<input class = 'radio_input' type = 'radio' name = 'city' value = $k ";
        
        // preselect the first entry
        if($k == 0)
            echo "checked";
        
        // print the city name
        echo "></input>$city<br />";
    }
?>
    <button>Select</button>
    </form>
</article>