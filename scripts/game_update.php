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


$message = "<no thing>";
if($_SERVER["REQUEST_METHOD"] == "POST")
{   
    // get username
    $username = $_SESSION["citybuilder_username"];

    // get city name
    $currCity = $_POST["currcity"];
    
    // get city info
    //todo
    
}

//todo
echo "'$currCity' owned by '$username'";

?>