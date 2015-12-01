<?php
/**
* scripts/database.php
* Project: CityBuilder Application
* Author(s): Kathryn McKay
* Year: 2015
*
* This page initializes the database.
*
**/ 
    function createDatabase($servername, $username, $password, $dbname)
    {
        // includes
        include "create_database.php";
        include "init_database.php";
        
        // doings
        create_database($servername, $username, $password, $dbname);
        init_database($servername, $username, $password, $dbname);
    }

    // login info
    $servername = $_SERVER["SERVER_NAME"];
    $username = "root";
    $password = "";
    $dbname  = "citybdb";
    
    // todo
    
    // create database
    createDatabase($servername, $username, $password, $dbname);
    
    
    
?>