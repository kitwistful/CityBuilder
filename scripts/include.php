<?php
/**
* scripts/include.php
* Project: CityBuilder Application
* Author(s): Kathryn McKay
* Year: 2015
*
* This script is meant to be referred to in the <head> section of each page.
* It has information that should be initialilzed for each page including the
* site's stylesheet, and session data.
*
**/

// connect to database
function getDatabaseConnection()
{
    // infos
    $servername = $_SERVER["SERVER_NAME"];
    $username = "root";
    $password = "";
    $dbname = "citybdb";
    
    // return connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
    return $conn;    
}

    // session key list
    $seshkeys = array(
      "citybuilder_bLoggedIn",
      "citybuilder_username"
    );
    
    // init session keys
    foreach($seshkeys as $keykey => $key)
    {
        if(!array_key_exists($key, $_SESSION))
        {
            $_SESSION[$key] = null;
        }
    }
    
    
?>

<!-- Stylesheet-->
<link rel = "stylesheet" type = "text/css" href = "../styles/style.css" />

<!-- JQuery -->
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
    
    