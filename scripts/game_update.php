<?php
/**
* scripts/game_update.php
* Project: CityBuilder Application
* Author(s): Kathryn McKay
* Year: 2015
*
* This script updates the database.
*
**/
session_start();

include "include.php";
include "CityData.php";


$message = "<no thing>";
if($_SERVER["REQUEST_METHOD"] == "POST")
{   
    // get username
    $username = $_SESSION["citybuilder_username"];

    // get city name
    $currCity = $_POST["currcity"];
    
    // get sector
    $currSector = $_POST["currsector"];
    
    // get city info
    $cityInfo = CityData::getCityInfo($currCity, $username);
    
    // grow current sector
    // todo
    
    // push update
    // todo
    
    //todo
    
    
}

//todo
echo "'$currCity' owned by '$username'<br />";
echo sprintf("change current sector from '%s' to '$currSector'<br />", $cityInfo->currSector);

?>