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
    
    // don't change the current sector of this if the sector is null
    if($currentSector == null)
        $currentSector = $cityInfo->currSector;
    
    // lookup cityID
    $cityID = $cityInfo->cityID;
    
    // record prev sector
    $prevSector = $cityInfo->currSector;
    
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
        
        // get current timestamp
        $sql = "SELECT NOW()";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $record = $stmt->fetch();
        $curr_timestamp = $record[0];
        
        // update to current timestamp
        $sql = "UPDATE Cities SET timestamp='$curr_timestamp' WHERE cityID=$cityID";
        $conn->exec($sql);
        
        // get number of allocated blocks
        $nBlocks = $cityInfo->nBlocks;
        
        // get number of used blocks
        $nUsedBlocks = CityData::getUsedBlocksCount($cityInfo);
        
        // update old sector with timestamp
        if($prevSector != SECTOR_NONE && $nBlocks > $nUsedBlocks)
        {   
            // get difference between timestamps
            $sql = "SELECT TIMESTAMPDIFF(MINUTE, '$prev_timestamp', '$curr_timestamp')";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $record = $stmt->fetch();
            $minutes_elapsed = $record[0];
            
            // determine number of blocks grown
            $prevGrowth = $cityInfo->sectorBlocks[$prevSector] + $minutes_elapsed;
            
            // cap value if it is larger than number of blocks
            $prevGrowth = min($prevGrowth, $nBlocks - $nUsedBlocks);
            
            // update blocks value
            $sql = "UPDATE CityBlocks SET nBlocks=$prevGrowth WHERE cityID=$cityID AND sector='$prevSector'";
            $conn->exec($sql);
        }
        
        // update stuff
        $cityInfo = CityData::getCityInfo($cityName, $username);
        $nUsedBlocks = CityData::getUsedBlocksCount($cityInfo);
        
        // update current with growth
        if($currentSector != SECTOR_NONE && $nBlocks > $nUsedBlocks) {
            // determine growth level
            $nBlocks = min($cityInfo->sectorBlocks[$currentSector] + $growth, $nBlocks - $nUsedBlocks);
            
            // update blocks value
            $sql = "UPDATE CityBlocks SET nBlocks=$nBlocks WHERE cityID=$cityID AND sector='$currentSector'";
            $conn->exec($sql);
        }
        
        // make current sector name into mysql form
        if($currentSector == SECTOR_NONE)
            $currentSector = "NULL";
        else
            $currentSector = "'$currentSector'";
        
        // update sector
        $sql = sprintf("UPDATE Cities SET currSector=$currentSector WHERE cityID=%d", $cityInfo->cityID);
        $conn->exec($sql);
        
        
    } catch (PDOException $e) {
        echo "<table><tr><th>SQL</th><td>$sql</td></tr><tr><th>Error</th><td>".$e->getMessage()."</td></tr><tr><th>Line</th><td>". $e->getLine()."</td></tr></table><br />";
    }
    
    
    
    // disconnect from database
    $conn = null;
    
}
?>