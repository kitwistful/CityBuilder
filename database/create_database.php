<?php
/**
* database/create_database.php
* Project: CityBuilder Application
* Author(s): Kathryn McKay
* Year: 2015
*
* This script creates the new empty database.
*
**/
    $servername = "localhost";
    $dbname = "citybdb";
    $username = "root";
    $password = "";
    
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
?>