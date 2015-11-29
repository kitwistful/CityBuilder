<!DOCTYPE HTML>
<?php
    session_start();
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