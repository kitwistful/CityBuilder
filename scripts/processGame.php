<?php
session_start();
    
// update things
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    // get info
    $cityIndex = $_POST["cityIndex"];
    $cityName = $_POST["cityName"];
    $currentSector = $_POST["currentSector"];
    $growth = $_POST["growth"];
    
    // get username
    $username = $SESSION["CityBuilder_username"];
    
    // update city index in session
    $_SESSION["CityBuilder_currCity"] = $cityIndex;
    
    // lookup city info
    $cityInfo = CityData::getCityInfo($cityName, $username);
    
    // make database connection
    $conn = CityData::getDatabaseConnection();
    
    // get last timestamp
    // todo
    
    // update to current timestamp
    //todo
    
    // get number of allocated blocks
    // todo
    
    // proceed to calculate blocks if number of blocks allocated is less than
    // total number of blocks
    
    // -->get difference between timestamps
    // todo
    
    // -->determine number of blocks grown
    // todo
    
    // -->cap value if it is larger than number of blocks
    // todo
    
    // --> update blocks value
    // todo
    
    // change current sector
    // todo
    
    // disconnect from database
    $conn = null;
    
}
?>