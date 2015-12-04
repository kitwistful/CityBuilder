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
        $conn = getDatabaseConnection();
        
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
        $conn = getDatabaseConnection();
        
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
            $cityInfo = new CityInfo($currSector, $nBlocks, $sectorBlocks, $nCoins, $cityid);
        
        // return info
        return $cityInfo;
    }
    
    // create city
    function addCity($cityname, $username, $nBlocks, $nCoins)
    {
        // message
        $message = "unknown error";
        
        //make connection
        $conn = getDatabaseConnection();
        
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
    
    function getDescription($cityInfo)
    {
        // find highest sector size
        // todo
        
        // determine sector size
        // --->pick between equal sector sizes
        // todo
        
        // connect to database
        // todo
        
        // query selecting descriptions, ids, and next ids based on sector
        // todo
        
        // array of already read values
        // todo
        
        // description string
        // todo
        
        // start at 0 and keep going "next" until it's null OR the size is
        // too big.
        // --> check id hasn't already been selected
        // --> add id to list
        // --> iterate
        // todo
        
        // disconnect from database
        // todo
        
        // return description
        // todo
        return "uhhhh";
        
    }
    
    
    
}


?>