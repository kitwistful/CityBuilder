<!DOCTYPE HTML>
<html>
<head>
<?php include "include.php"; ?>
    <title>City Builder</title>
</head>
<body>
<?php
    define("CURRENT_PAGE", "index.php");
    include "header.php";
?>

    <article>
        <header>Welcome to City Builder!</header>
        <content>
            To get started, please <a href = "create_account.php">create a player account</a> or <a href = "login.php">login to an existing one</a>. You can also <a href = "recover_account.php">recover an account</a> if you have a code. Have fun!
        </content>
    </article>
</body>
</html>