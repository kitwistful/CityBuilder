<!DOCTYPE HTML>
<?php
/**
* logout.php
* Project: CityBuilder Application
* Author(s): Kathryn McKay
* Year: 2015
*
* This page causes the user to be logged out.
*
**/
    // initialize session
    session_start();
    
    // clear all session data
    session_unset();
?>
<html>
<head>
<?php include "include.php"; ?>
    <title>Logged out of City Builder</title>
</head>
<body>
<?php
    define("CURRENT_PAGE", "logout.php");
    include "header.php";
?>

    <article>
        <header>Successfully logged out</header>
        <content>
            Thank you for playing City Builder!
        </content>
    </article>
</body>
</html>