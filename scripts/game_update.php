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


function updateGame()
{
    
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //todo
        $message = $_POST["testmessage"];
    }
}

//todo
echo "'$message'???";

?>