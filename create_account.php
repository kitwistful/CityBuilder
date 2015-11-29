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
<?php
    
    
    $signup_message = "";

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        define("SIGNUP_SHOW_MESSAGE", true);
        
        $signup_message = "test";
    } else{
        define("SIGNUP_SHOW_MESSAGE", false);
    }
?>

    <article>
        <header>Sign up for City Builder</header>
<?php
    if(SIGNUP_SHOW_MESSAGE)
    {
        echo "<content><div class = 'signup_error'><header>Information</header><content>$signup_message</content></div></content>";
    } else {
        echo "<content>To continue, choose your username and password.</content>";
    }
?>
        <form id = "create_account_form" method = "POST" action = "create_account.php">
            <label>Username:</label>
            <input id = "create_account_username" name = "username" type = "text"></input>
            <label>Password:</label>
            <input id = "create_account_password" name = "password" type = "password"></input>
            <label>Re-enter your password:</label>
            <input id = "create_account_password_again" name = "password_again" type = "password"></input>
            <button id = "create_account_confirm">Signup</button>
        </form>
    </article>
</body>
</html>