<!DOCTYPE HTML>
<html>
<head>
<?php include "include.php"; ?>
    <title>Login to City Builder</title>
</head>
<body>
<?php
    define("CURRENT_PAGE", "login.php");
    include "header.php";
?>
    <article>
        <header>Login</header>
        <form id = "login_form">
            <input id = "username" type = "text"></input>
            <input id = "password" type = "password"></input>
            <button id = "login_button">Go</input>
        </form>
    </article>
</body>
</html>