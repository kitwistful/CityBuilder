<?php
/**
* scripts/CityData.php
* Project: CityBuilder Application
* Author(s): Kathryn McKay
* Year: 2015
*
* Functions that bridge city table in database to PHP form
*
**/
include "CityInfo.php";

define("SECTOR_RESIDENTIAL", "Residential");
define("SECTOR_EDUCATIONAL", "Educational");
define("SECTOR_BUSINESS", "Business");
define("SECTOR_RECREATIONAL", "Recreational");
define("SECTOR_NONE", "None");

class CityData
{   
    function getUserCities($username)
    {
        // cities
        $cities = null;
        
        // connect to database
        $conn = CityBuilder::getDatabaseConnection();
        
        // here is query
        $sql = "SELECT Cities.name
        FROM Cities INNER JOIN Users ON Cities.userID=Users.userID
        WHERE Users.name='$username'";
        
        // let's do the query
        try {
            // execute query
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            
            // get results
            $results = $stmt->fetchAll();
            foreach($results as $k=>$record)
            {
                $cities[$k] = $record["name"];
            }
            
        } catch (PDOException $e) {
            $message = $e->getLine().": ".$e->getMessage();
        }
        
        // unconnect
        $conn = null;
        
        // return cities
        return $cities;
    }
    
    

    // sector enums
    function getCityInfo($cityname, $username)
    {
        // data
        $currSector = SECTOR_NONE;
        $nBlocks = 0;
        $sectorBlocks = array(SECTOR_RESIDENTIAL=>0, SECTOR_EDUCATIONAL=>0,
            SECTOR_BUSINESS=>0, SECTOR_RECREATIONAL=>0);
        $cityid = null;
        
        
        
                
        //sector names
        $sectors = array(SECTOR_RESIDENTIAL=>"Residential",
            SECTOR_EDUCATIONAL=>"Educational",
            SECTOR_BUSINESS=>"Business",
            SECTOR_RECREATIONAL=>"Recreational"
            );
            
        // return blank city info if no params
        if($cityname == null && $username == null)
            $cityInfo = new CityInfo($currSector, $nBlocks, $sectorBlocks, $cityid);
            
        // have you found the city?
        $isCityFound = false;
        
        // make connection
        $conn = CityBuilder::getDatabaseConnection();
        
        // query to retrieve city info
        $sql_select_city = "SELECT cityID, currSector, nBlocks, Users.nCoins
        FROM Cities INNER JOIN Users ON Cities.userID=Users.userID
        WHERE Users.name='$username' AND Cities.name='$cityname'";
        
        
        // query to retrieve city sector info
        $sql_select_sector_fmt = "SELECT nBlocks FROM CityBlocks WHERE
            cityID=%d AND sector='%s'";
        
        // do the stuff
        try {
            // query city info
            $stmt = $conn->prepare($sql_select_city);
            $stmt->execute();
            
            // get cityID
            $record = $stmt->fetch();
            $cityid = $record["cityID"];
            
            // record info
            if($cityid)
            {
                // record city info
                $currSector = $record["currSector"];
                $nCoins = $record["nCoins"];
                $nBlocks = $record["nBlocks"];
                
                // fix currSector
                if($currSector == null)
                    $currSector = SECTOR_NONE;
                else
                {
                    // convert good to key
                    foreach($sectors as $target=>$src)
                    {
                        if($currSector == $src)
                        {
                            $currSector = $target;
                            break;
                        }
                    }
                }
                
                // get sector block values
                foreach ($sectors as $k=>$name)
                {
                    // do query
                    $stmt = $conn->prepare(sprintf($sql_select_sector_fmt, $cityid, $name));
                    $stmt->execute();
                    
                    // record info
                    $record = $stmt->fetch();
                    $sectorBlocks[$sectors[$k]] = $record["nBlocks"];
                }
                
                // success
                $isCityFound = true;
            }
            
            
            
            
            
        } catch (PDOException $e) {
            $message = $e->getLine().": ".$e->getMessage();
        }
        
        
        // unmake connection
        $conn = null;
        
        // info object
        $cityInfo = null;
        
        // make the object if the search didn't fail
        if($isCityFound)
            $cityInfo = new CityInfo($currSector, $nBlocks, $sectorBlocks, $cityid);
        
        // return info
        return $cityInfo;
    }
    
    // create city
    function addCity($cityname, $username, $nBlocks, $nCoins)
    {
        // message
        $message = "unknown error";
        
        //make connection
        $conn = CityBuilder::getDatabaseConnection();
        
        // query that checks city's existence
        $sql_check = "SELECT Cities.name, Users.name
        FROM Cities INNER JOIN Users ON Cities.userID=Users.userID
        WHERE Cities.name='$cityname' AND Users.name = '$username' ";
        
        // query that retrieves userID
        $sql_get_userID = "SELECT userID FROM Users WHERE name='$username'";
        
        // query that inserts city into table
        $sql_insert_city_fmt = "INSERT INTO Cities(name, userID, nBlocks)
        VALUES('$cityname', %d, $nBlocks)";
        
        // query that retrieves cityID
        $sql_get_cityID_fmt = "SELECT cityID FROM Cities WHERE name='$cityname' AND userID=%d";
        
        // query that inserts sectors into table
        $sql_init_sector_blocks_fmt = "INSERT INTO CityBlocks(cityID, sector, nBlocks)
        VALUES (%d,'%s', 0)";
        
        // do queries
        try {
            // check for existing city
            $stmt = $conn->prepare($sql_check);
            $stmt->execute();
            $cityExists = $stmt->rowCount() > 0;
            
            // add city
            if($cityExists)
            {
                // don't add city
                $message = "city '$cityname' already exists";
            } else {
                // get userID
                $stmt = $conn->prepare($sql_get_userID);
                $stmt->execute();
                $userrec = $stmt->fetch(PDO::FETCH_ASSOC);
                $userid = $userrec["userID"];
                
                // insert city
                $conn->exec(sprintf($sql_insert_city_fmt, $userid));
                
                // get cityID
                $stmt = $conn->prepare(sprintf($sql_get_cityID_fmt, $userid));
                $stmt->execute();
                $cityrec = $stmt->fetch(PDO::FETCH_ASSOC);
                $cityid = $cityrec["cityID"];
                
                // insert sectors
                $conn->exec(sprintf($sql_init_sector_blocks_fmt, $cityid, SECTOR_RESIDENTIAL));
                $conn->exec(sprintf($sql_init_sector_blocks_fmt, $cityid, SECTOR_EDUCATIONAL));
                $conn->exec(sprintf($sql_init_sector_blocks_fmt, $cityid, SECTOR_RECREATIONAL));
                $conn->exec(sprintf($sql_init_sector_blocks_fmt, $cityid, SECTOR_BUSINESS));
                
                // we're good
                $message = null;
                
            }
            
            
        } catch (PDOException $e) {
            $message = $e->getLine().": ".$e->getMessage();
        }
        
        // break connection
        $conn = null;
        
        // return error message
        return $message;
        
    }
    
    function getBiggestSectors($cityInfo)
    {
        // results
        $result = array("sectors"=>array(), "size"=>0);
        
        // look at each sector
        foreach($cityInfo->sectorBlocks as $sector=>$size)
        {
            // compare size
            if($result["size"] < $size)
            {
                // set as new biggest sector
                $result["sectors"] = array($sector);
                $result["size"] = $size;
            } else if ($result["size"] == $size) {
                // push sector on
                $result["sectors"][count($result["sectors"])] = $sector;
            }
        }
        
        // set sector to none if no sectors have developed
        if($result["size"] == 0)
            $result["sectors"] = array(SECTOR_NONE);
        
        // return results
        return $result;
    }
    
    function pickSector($cityInfo, $sectors)
    {
        // return null if sector length isn't there
        if(count($sectors) == 0)
            return null;
        
        // look at each sector
        $selectSectorWithKey = null;
        foreach($sectors as $k=>$sector)
        {
            // consider sector
            if($sector == $cityInfo->currSector)
            {
                // prefer selected sector
                $selectSectorWithKey = $k;
                break;
            } else if($selectSectorWithKey == null) {
                // initialize sector to this
                $selectSectorWithKey = $k;
            } else {
                // ehh that's probably good enough
            }
        }
        
        // return selected sector
        return $sectors[$selectSectorWithKey];
        
    }
    
    function getDescription($cityInfo)
    {
        // find highest sector size
        $largest = CityData::getBiggestSectors($cityInfo);
        $largestSectorSize = $largest["size"];
        
        // determine sector
        $largestSectorName = CityData::pickSector($cityInfo, $largest["sectors"]);
        
        // connect to database
        $conn = CityBuilder::getDatabaseConnection();
        
        // description found
        $description = "error";
        
        // do queries
        try {
            // query for block rank values
            $stmt = $conn->prepare("SELECT rankID, nBlocks FROM SectorBlockRanks");
            $stmt->execute();
            $records = $stmt->fetchAll();
            
            // record block rank values
            $blockRanks = array();
            foreach($records as $i=>$record)
            {
                // add to array
                $blockRanks[$record["rankID"]] = $record["nBlocks"];
            }
            
            // array of already read values
            $alreadyRead = array();
            
            // lookup values based on this id
            $currentDescriptionID = 1;
            
            // start at 1 and keep going "next" until it's null
            while($currentDescriptionID != null)
            {
                // check id hasn't already been selected
                $stillOkay = true;
                foreach($alreadyRead as $i=>$id)
                {
                    if($currentDescriptionID == $id)
                    {
                        $stillOkay = false;
                        break;
                    }                        
                }
                
                // only continue if the above check worked out
                if(!$stillOkay)
                {
                   break; 
                } else {
                    // add id to list
                    $alreadyRead[count($alreadyRead)] = $currentDescriptionID;
                    
                    // get record
                    $stmt = $conn->prepare("SELECT nextDescID, sector, blockRank, content FROM CityDescriptions WHERE descID=$currentDescriptionID");
                    $stmt->execute();
                    $record = $stmt->fetch();
                    
                    // only continue if the block rank is low enough
                    if($blockRanks[$record["blockRank"]] >= $largestSectorSize)
                    {
                        // don't continue if the sector doesn't match, unless this is the first run.
                        if($record["sector"] == $largestSectorName || $currentDescriptionID == 1)
                        {
                            // update description
                            $description = $record["content"];
                            
                            // get next id
                            if($largestSectorName == SECTOR_NONE) {
                                // don't keep looking.
                                break;
                            } else if($currentDescriptionID == 1) {
                                // query for first sector rank
                                $stmt = $conn->prepare("SELECT descID FROM CityDescriptions WHERE sector=$largestSectorName AND blockRank=2");
                                $stmt->execute();
                                $record = $stmt->fetch();
                                
                                // set desc id to this one
                                $currentDescriptionID = $record["descID"];
                            } else {
                                // iterate to the next id
                                $currentDescriptionID = $record["nextDescID"];
                            }
                        } else {
                            // this is an error condition, by the way...
                            break;
                        }
                    } else {
                        // we are this kind of low
                        break;
                    }
                }
                
                
            }
        } catch (PDOException $e) {
            return $e->getLine().": ".$e->getMessage();
        }
        
        // disconnect from database
        $conn = null;
        
        // return description
        // todo
        return "selected sector '$largestSectorName' with size $largestSectorSize '$description'";
        
    }
    
    function getUsedBlocksCount($cityInfo)
    {
        // count
        $blocksCounted = 0;
        
        // iterate over each sector
        foreach($cityInfo->sectorBlocks as $k=>$sectorBlockCount)
        {
            $blocksCounted += $sectorBlockCount;
        }
        
        // return count
        return $blocksCounted;
    }
    
    
    
}


?>