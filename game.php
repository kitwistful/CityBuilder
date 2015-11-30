<?php
    // city names
    $cities = array("First City", "Someburb", "Polispolis");
    
    // city to change
    $curr_city = 0;
    
    // select new city
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $curr_city = $_POST["city"];
    }
?>
<article>
<header>'<?php echo $cities[$curr_city] ?>'</header>
<content>
    Todo
</content>
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