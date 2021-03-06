<!DOCTYPE HTML>
<?php
/**
* pages/howtoplay.php
* Project: CityBuilder Application
* Author(s): Kathryn McKay
* Year: 2015
*
* Teaches players the rules of the game.
*
**/
// initialize session
session_start();
include "../scripts/include.php";
CityBuilder::initSessionKeys();
?>
<html>
<head>
<?php CityBuilder::printIncludes() ?>
    <title>How To Play City Builder</title>
</head>
<body>
<?php
// header
define("CURRENT_PAGE", "../pages/howtoplay.php");
include "../scripts/header.php";
    
?>
    <article id = "HowToPlayBlock">
        <header>How To Play</header>
        <content>
                To start construction, select a sector to focus on. It'll grow by one block right away, and keep growing in size as long as it is selected. Be careful, though! If your sector takes up too many blocks, all construction will cease. Your city has only so much space!
        </content>
    </article>
<?php include '../scripts/footer.php'?>
</body>
</html>