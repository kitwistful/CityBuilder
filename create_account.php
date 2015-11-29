<!DOCTYPE HTML>
<html>
<head>
<?php include "include.php"; ?>
    <title>Join City Builder</title>
</head>
<body>
<?php
    define("CURRENT_PAGE", "create_account.php");
    include "header.php";
?>

    <article>
        <header>Sign up for City Builder</header>
        <content>
            To continue, choose your username and password.
        </content>
        <form id = "create_account_form">
            <label>Username:</label>
            <input id = "create_account_username" type = "text"></input>
            <label>Password:</label>
            <input id = "create_account_password" type = "password"></input>
            <label>Re-enter your password:</label>
            <input id = "create_account_password_again" type = "password"></input>
            <button id = "create_account_confirm">Signup</button>
        </form>
        <div id = "create_account_message"></div>
    </article>
</body>
</html>