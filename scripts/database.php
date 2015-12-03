<?php
/**
* scripts/database.php
* Project: CityBuilder Application
* Author(s): Kathryn McKay
* Year: 2015
*
* This page initializes the database.
*
* Notes:
* Some of these "auto_increment" primary key IDs, particularly for tables with
* values that are initalized here, are meaningless. The values are initialized
* with their IDs.
*
**/ 
    function createDatabase($servername, $username, $password, $dbname)
    {
        $sql = "CREATE DATABASE IF NOT EXISTS $dbname";

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
            
            // amend user table
            // ... no amends yet

            // create sector table
            $sql = "CREATE TABLE IF NOT EXISTS Sectors(
            sector VARCHAR(255) NOT NULL UNIQUE KEY PRIMARY KEY
            )";
            $conn->exec($sql);
            
            // amend sector table
            $amend_sector_sqls = array(
                // nothing to amend
                );
            foreach($amend_sector_sqls as $k=>$sql)
                $conn->exec($sql);
            
            // create cities table
            $sql = "CREATE TABLE IF NOT EXISTS Cities(
            cityID BIGINT NOT NULL AUTO_INCREMENT UNIQUE KEY PRIMARY KEY, 
            userID BIGINT NOT NULL,
            name VARCHAR(255) NOT NULL, 
            nBlocks BIGINT NOT NULL,
            created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            timestamp TIMESTAMP, 
            currSector VARCHAR(255),
            FOREIGN KEY (userID) REFERENCES Users(userID),
            FOREIGN KEY (currSector) REFERENCES Sectors(sector)
            )";
            $conn->exec($sql);
            
            // amend cities table
            // ....no amends yet
            
            // create table of sector ranks
            $sql = "CREATE TABLE IF NOT EXISTS SectorBlockRanks(
            rankID BIGINT NOT NULL AUTO_INCREMENT UNIQUE KEY PRIMARY KEY,
            nBlocks BIGINT NOT NULL UNIQUE KEY
            )";
            $conn->exec($sql);
            
            // amends for sector ranks
            // ... no amends yet
            
            // create descriptions table
            $sql = "CREATE TABLE IF NOT EXISTS CityDescriptions(
            descID BIGINT NOT NULL AUTO_INCREMENT UNIQUE KEY PRIMARY KEY,
            content TEXT NOT NULL,
            sector VARCHAR(255),
            FOREIGN KEY(sector) REFERENCES Sectors(sector)
            )";
            $conn->exec($sql);
            
            // amend descriptions table
            $sqls = array("ALTER TABLE CityDescriptions ADD COLUMN IF NOT EXISTS upToBlockLevel BIGINT NOT NULL",
            "ALTER TABLE CityDescriptions DROP COLUMN upToBlockLevel;",
            "ALTER TABLE CityDescriptions ADD COLUMN IF NOT EXISTS nextDescID BIGINT;",
            "ALTER TABLE CityDescriptions ADD COLUMN IF NOT EXISTS nBlocks BIGINT NOT NULL;",
            "ALTER TABLE CityDescriptions ADD CONSTRAINT FOREIGN KEY(nextDescID) REFERENCES CityDescriptions(descID);",
            "ALTER TABLE CityDescriptions DROP COLUMN nBlocks",
            "ALTER TABLE CityDescriptions ADD COLUMN IF NOT EXISTS blockRank BIGINT NOT NULL",
            "ALTER TABLE CityDescriptions ADD CONSTRAINT FOREIGN KEY(blockRank) REFERENCES SectorBlockRanks(rankID);",
            );
            foreach($sqls as $k=>$sql)
                $conn->exec($sql);
            
            // create city-sector relationship
            $sql = "CREATE TABLE IF NOT EXISTS CityBlocks(
            cityID BIGINT NOT NULL,
            sector VARCHAR(255) NOT NULL, 
            nBlocks BIGINT NOT NULL,
            FOREIGN KEY(cityID) REFERENCES Cities(cityID),
            FOREIGN KEY(sector) REFERENCES Sectors(sector)
            )";
            $conn->exec($sql);
            
            // amend city-sector relationship
            // ... no amends yet
            
            // array of block ranks
            $blockRanks = array(1=>0, 2=>100, 3=>1000, 4=>2000);
            
            // insert block ranks
            foreach($blockRanks as $rankID=>$rankValue)
            {
                $sql = "INSERT INTO SectorBlockRanks(nBlocks) VALUES ($rankValue) ON DUPLICATE KEY UPDATE rankID=$rankID";
                $conn->exec($sql);
            }
            
            
            // truncate descriptions
            $sql = "TRUNCATE CityDescriptions";
            $conn->exec($sql);
            
            // array of descriptions
            $descriptions = array(
                    "Recreational"=>array(
                        1=>"first",
                        2=>"second",
                        3=>"third",
                        4=>"fourth"
                        ),
                    "Educational"=>array(
                        1=>"first",
                        2=>"second",
                        3=>"third",
                        4=>"fourth"
                        ),
                    "Residential"=>array(
                        1=>"first",
                        2=>"second",
                        3=>"third",
                        4=>"fourth"
                        ),
                    "Business"=>array(
                        1=>"first",
                        2=>"second",
                        3=>"third",
                        4=>"fourth"
                        )
                );
                
            // build description values
            $sql = "";
            $descCount = 1;
            foreach($descriptions as $sector=>$list)
            {
                foreach($list as $rankID=>$description)
                {
                    // delimit
                    if($descCount != 1)
                        $sql = ", $sql";
                    
                    // get next rank
                    $nextRank = $descCount + 1;
                    if($rankID == 4)
                    {
                        $nextRank = "NULL";
                    }
                    
                    // append
                    $sql = "($descCount, '$sector', $rankID, '$description', $nextRank)$sql";
                    
                    // increment
                    $descCount++;
                    
                }
            }
            
            // prep query
            $sql = "INSERT INTO CityDescriptions(descID, sector, blockRank, content, nextDescID) VALUES ".$sql;
            
            
            //todo
            echo $sql;
            
            // insert descriptions
            //todo
            
            // check if sectors is initialized
            $sql = "SELECT * FROM Sectors";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            
            // initialize sectors
            if($stmt->rowCount() == 0)
            {
                // initialize sectors
                $sql = "INSERT INTO Sectors(sector) VALUES
                ('Recreational'),
                ('Educational'),
                ('Residential'),
                ('Business')
                ";
                $conn->exec($sql);
            }
            
            
        
        } catch (PDOException $e) {
            echo "<table><tr><th>SQL</th><td>$sql</td></tr><tr><th>Error</th><td>".$e->getMessage()."</td></tr><tr><th>Line</th><td>". $e->getLine()."</td></tr></table><br />";
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
