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
            echo $sql."<br />".$e->getMessage()."<br />";
        }
        
        $conn = null;
    }

    function initDatabase($servername, $username, $password, $dbname)
    {
        
        
        
        
        // reference current query here
        $sql = "...";
        
        // do queries
        try {
            // init connection
            $conn = new PDO("mysql:host=$servername;dbname=$dbname;", $username, $password);
            
            // set to exception mode
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // create user table
            $sql = "CREATE TABLE IF NOT EXISTS Users(
            userID BIGINT NOT NULL AUTO_INCREMENT UNIQUE KEY PRIMARY KEY,
            name VARCHAR(255) NOT NULL UNIQUE KEY,
            password VARCHAR(255) NOT NULL,
            ncoins BIGINT DEFAULT 0 NOT NULL, 
            description VARCHAR(255),
            email VARCHAR(255)
            )";
            $conn->exec($sql);

            // create sector table
            $sql = "CREATE TABLE IF NOT EXISTS Sectors(
            sector VARCHAR NOT NULL UNIQUE,
            PRIMARY KEY (sector)
            )
            ;

            CREATE TABLE IF NOT EXISTS Cities(
            cityID BIGINT NOT NULL AUTO_INCREMENT UNIQUE PRIMARY, 
            userID BIGINT NOT NULL,
            name VARCHAR NOT NULL, 
            nBlocks BIGINT NOT NULL,
            created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            timestamp TIMESTAMP, 
            currSector VARCHAR,
            FOREIGN KEY (userID) REFERENCES Users(userID),
            FOREIGN KEY (currSector) REFERENCES Sectors(sectorID)
            )
            ;

            CREATE TABLE IF NOT EXISTS CityBlocks(
            cityID BIGINT NOT NULL,
            sector VARCHAR NOT NULL, 
            nBlocks BIGINT NOT NULL,
            FOREIGN KEY(cityID) REFERENCES Cities(cityID),
            FOREIGN KEY(sector) REFERENCES Sectors(sector)
            )
            ;

            INSERT INTO Sectors VALUES(
            'Recreational',
            'Educational',
            'Residential',
            'Business'
            )
            ;

                
            )
            ;";
            
            
            
            $conn->exec($sql);
        
        } catch (PDOException $e) {
            echo $sql."<br />".$e->getMessage()."<br />".$e->getTraceAsString()."<br />";
        }
        
        
        
    }
    
    
    // here's what you do
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        

        // login info
        $servername = $_SERVER["SERVER_NAME"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $dbname  = "citybdb";
        
        // create database
        echo "Create Database:<br />";
        createDatabase($servername, $username, $password, $dbname);
        
        // initialize database
        echo "Initialize Database:<br />";
        initDatabase($servername, $username, $password, $dbname);
    
    }
    
    
?>

<form action = "database.php" method = "post">
Username:
<input type = "text" name = "username" value = "root"></input><br />
Password:
<input type = "password" name = "password"></input><br />
<button>Create database</button>
</form>
