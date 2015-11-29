<!DOCTYPE HTML>
<?php
    session_start();
?>
<html>
<head>
<?php include "include.php"; ?>
    <title>Play City Builder</title>
</head>
<body>
<?php
    define("CURRENT_PAGE", "dashboard.php");
    include "header.php";
?>
    <article>
        <header>Your Cities</header>
        <content>
            <ul>
                <li><a class = "dashboard_city_link" href = "#">First City</a></li>
                <li><a class = "dashboard_city_link" href = "#">Someburb</a></li>
                <li><a class = "dashboard_city_link" href = "#">Polispolis</a></li>
            </ul>
        </content>
    </article>
    <article>
        <div id = "dashboard_city_content"></div>
    </article>
    
</body>
</html>