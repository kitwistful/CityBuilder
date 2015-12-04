<!DOCTYPE HTML>
<?php
/**
* pages/newcity.php
* Project: CityBuilder Application
* Author(s): Kathryn McKay
* Year: 2015
*
* Page that allows users to create a new city.
*
**/
// initialize session
session_start();
include "../scripts/include.php";
CityBuilder::initSessionKeys();
?>
<html>
<head>
<?php  CityBuilder::printIncludes()?>
    <title>Create City in City Builder</title>
</head>
<body>
<?php
include "../scripts/CityData.php";

$username = $_SESSION["citybuilder_username"];
if(!$_SESSION["citybuilder_bLoggedIn"] || $username == null)
{
    echo "ERROR: not logged in<br />";
}

// form validation
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    // get form info
    $cityname = CityBuilder::validateInput($_POST["cityname"], false);
    
    // create city
    $message = CityData::addCity($cityname, $username, 2000, 0);
    if($message != null)
    {
        echo "ERROR: $message<br />";
    } else {
        echo "Successfully created '$cityname'<br />";
    }
}


define("CURRENT_PAGE", "../pages/newcity.php");
include "../scripts/header.php";
?>

    <article>
        <header>Create City</header>
        <content>
            Let's make a city!
            <form action = "newcity.php" method = "POST">
                Name:
                <input type = "text" name = "cityname" maxlength = 40></input><br />
                <button>Create a city</button><br />
            </form>
        </content>
    </article>
<?php include '../scripts/footer.php'?>
</body>
</html>