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
        $sql = "CREATE DATABASE $dbname";

        try {
            $conn = new PDO("mysql:host=$servername;", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $conn->exec($sql);
            
            echo "Database created successfully<br />";
        }   
        catch (PDOException $e)
        {
            echo $sql."<br />".$e->getMessage();
        }
        
        $conn = null;
    }

    function initDatabase($servername, $username, $password, $dbname)
    {
        //todo
    }

    // login info
    $servername = $_SERVER["SERVER_NAME"];
    $username = "root";
    $password = "";
    $dbname  = "citybdb";
    
    // todo
    
    // create database
    createDatabase($servername, $username, $password, $dbname);
    
    // initialize database
    initDatabase($servername, $username, $password, $dbname);
    
    
?>