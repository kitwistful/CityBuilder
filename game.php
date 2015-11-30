<?php
    // sector enums
    define("SECTOR_RESIDENTIAL", "residential");
    define("SECTOR_EDUCATIONAL", "educational");
    define("SECTOR_BUSINESS", "business");
    define("SECTOR_RECREATIONAL", "recreational");
    define("SECTOR_NONE", "none");

    // city names
    $cities = array("First City", "Someburb", "Polispolis");
    
    // city to change
    $curr_city = 0;
    
    // sector to grow
    $curr_sector = SECTOR_RESIDENTIAL;
    
    // update stuff
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $curr_city = $_POST["city"];
        $curr_sector = $_REQUEST["sector"];
    }
    
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
    
    // sectors
    $sector_names = array(SECTOR_RESIDENTIAL=>"Residential", SECTOR_EDUCATIONAL=>"Educational", SECTOR_BUSINESS=>"Business", SECTOR_RECREATIONAL=>"Recreational", SECTOR_NONE=>"None");
    
    // selected
    $sector_display_class = array(SECTOR_RESIDENTIAL=>null, SECTOR_EDUCATIONAL=>null, SECTOR_BUSINESS=>null, SECTOR_RECREATIONAL=>null);
    foreach($sector_display_class as $k=>$v)
    {
        $sector_display_class[$k] = $k == $curr_sector ? "selected_sector" : "unselected_sector";
    }
    
    
    
?>
<article id = "curr_city">
    <header>'<?php echo $cities[$curr_city] ?>'</header>
    <div id = "game_sector_display">
        <div id = "game_sector_display_q1" class = <?php echo $sector_display_class[SECTOR_RESIDENTIAL]?> >
            Residential: <?php echo $sector_blocks[SECTOR_RESIDENTIAL]?>
        </div>
        <div id = "game_sector_display_q2" class = <?php echo $sector_display_class[SECTOR_EDUCATIONAL]?> >
            Educational: <?php echo $sector_blocks[SECTOR_EDUCATIONAL]?>
        </div>
        <div id = "game_sector_display_q3" class = <?php echo $sector_display_class[SECTOR_BUSINESS]?> >
            Business: <?php echo $sector_blocks[SECTOR_BUSINESS]?>
        </div>
        <div id = "game_sector_display_q4" class = <?php echo $sector_display_class[SECTOR_RECREATIONAL]?> >
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
        <li>Current Sector: <?php echo $sector_names[$curr_sector]?></li>
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
        if($k == $curr_sector)
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
            Purchase more blocks for your city here! Current coin count: <b><?php echo $n_coins?></b>
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
</form>