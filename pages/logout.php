<!DOCTYPE HTML>
<?php
/**
* pages/logout.php
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
<?php include "../scripts/include.php"; ?>
    <title>Logged out of City Builder</title>
</head>
<body>
<?php
    define("CURRENT_PAGE", "../pages/logout.php");
    include "../scripts/header.php";
?>

    <article>
        <header>Successfully logged out</header>
        <content>
            Thank you for playing City Builder!
        </content>
    </article>
<?php include '../scripts/footer.php'?>
</body>
</html>