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
        
        //todo
        
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
        
        // do some sql
        //todo
        
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
        $sql_check = "";//todo
        
        // query that inserts city into table
        $sql_insert_city = "";//todo
        
        // query that inserts sectors into table
        $sql_init_sector_blocks = "";//todo
        
        // those queries
        $sql_queries = array($sql_insert_city, $sql_init_sector_blocks);
        
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
                // do the stuff
                foreach($sql_queries as $i=>$sql)
                {
                    $conn->exec($sql);
                }
                
                // you did it
                $message = null;
            }
            
            
        } catch (PDOException $e) {
            $message = $e->getMessage();
        }
        
        // break connection
        $conn = null;
        
        // return error message
        return $message;
        
    }
    
    
    
}


?>