<?php
session_start();
include "include.php";
CityBuilder::initSessionKeys();
include "CityData.php";

// update things
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    // get info
    $cityIndex = $_POST["cityIndex"];
    $cityName = $_POST["cityName"];
    $currentSector = $_POST["currentSector"];
    $growth = $_POST["growth"];
    
    // get username
    $username = $_SESSION["citybuilder_username"];
    
    // update city index in session
    $_SESSION["CityBuilder_currCity"] = $cityIndex;
    
    // lookup city info
    $cityInfo = CityData::getCityInfo($cityName, $username);
    
    // lookup cityID
    $cityID = $cityInfo->cityID;
    
    // make database connection
    $conn = CityBuilder::getDatabaseConnection();
    
    try {
        // get last timestamp
        $sql = "SELECT timestamp, created FROM Cities WHERE cityID = $cityID";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $record= $stmt->fetch();
        $prev_timestamp = $record["timestamp"];
        
        // use created timestamp if prev_timestamp is strange
        if($prev_timestamp == "0000-00-00 00:00:00")
        {
            $prev_timestamp = $record["created"];
        }
        
        // update to current timestamp
        // todo
        $sql = "SELECT NOW()";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $record = $stmt->fetch();
        $curr_timestamp = $record[0];
        
        // get number of allocated blocks
        // todo
        
        // proceed to calculate blocks if number of blocks allocated is less than
        // total number of blocks
        
        // -->get difference between timestamps
        $sql = "SELECT TIMESTAMPDIFF(MINUTE, '$prev_timestamp', '$curr_timestamp')";//todo
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $record = $stmt->fetch();
        $minutes_elapsed = $record[0];
        echo $minutes_elapsed;
        
        // -->determine number of blocks grown
        // todo
        
        // -->cap value if it is larger than number of blocks
        // todo
        
        // --> update blocks value
        // todo
        
        // change current sector
        if($currentSector != $cityInfo->currSector)
        {
            if($currentSector == SECTOR_NONE)
                $currentSector = "NULL";
            else
                $currentSector = "'$currentSector'";
            $sql = sprintf("UPDATE Cities SET currSector=$currentSector WHERE cityID=%d", $cityInfo->cityID);
            $conn->exec($sql);
        }
    } catch (PDOException $e) {
        echo "<table><tr><th>SQL</th><td>$sql</td></tr><tr><th>Error</th><td>".$e->getMessage()."</td></tr><tr><th>Line</th><td>". $e->getLine()."</td></tr></table><br />";
    }
    
    
    
    // disconnect from database
    $conn = null;
    
}
?>