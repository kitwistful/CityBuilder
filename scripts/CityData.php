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

define("SECTOR_RESIDENTIAL", "residential");
define("SECTOR_EDUCATIONAL", "educational");
define("SECTOR_BUSINESS", "business");
define("SECTOR_RECREATIONAL", "recreational");
define("SECTOR_NONE", "none");

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
        $nCoins = 0;
        
        // have you found the city?
        $isCityFound = false;
        
        // make connection
        $conn = getDatabaseConnection();
        
        // query to retrieve city info
        $sql_select_city = "";//todo
        
        // query to retrieve city sector info
        $sql_select_sector_fmt = "%d %s";//todo
        
        // do the stuff
        try {
            // query city info
            $stmt = $conn->prepare($sql_select_city);
            $stmt->execute();
            
            // record city info
            //todo
            $cityid = null;
            
            // query sector info
            $sectors = array(SECTOR_RESIDENTIAL=>"Residential",
                SECTOR_EDUCATIONAL=>"Educational",
                SECTOR_BUSINESS=>"Business",
                SECTOR_RECREATIONAL=>"Recreational"
                );
            foreach ($sectors as $k=>$name)
            {
                // do query
                $stmt = $conn->prepare(sprintf($sql_select_sector_fmt, $cityid, $name));
                $stmt->execute();
                
                // record info
                //todo
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
            $cityInfo = new CityInfo($currSector, $nBlocks, $sectorBlocks, $nCoins);
        
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
    
    
    
}


?>