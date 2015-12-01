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
    
    
    // here's what you do
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        

        // login info
        $servername = $_SERVER["SERVER_NAME"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $dbname  = "citybdb";
        
        // create database
        createDatabase($servername, $username, $password, $dbname);
        
        // initialize database
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
