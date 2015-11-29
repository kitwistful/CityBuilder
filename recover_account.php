<!DOCTYPE HTML>
<html>
<head>
<?php include "include.php"; ?>
    <title>Recover City Builder Account</title>
</head>
<body>
<?php
    define("CURRENT_PAGE", "recover_account.php");
    include "header.php";
?>
    <article>
        <header>Recover An Account Abstract</header>
        <content>
            Even if your account is lost, there is still hope!
        </content>
        <ul>
            <li>In case of server failure/reboot, a player account can be reinitialized</li>
            <li>Existing users cannot be recovered</li>
            <li>Users that have been deleted cannot be recovered for 30 days.</li>
        </ul>
    </article>
    <article>
        <header>Recover from your browser session (EXPERIMENTAL)</header>
        <content>
            If cookies are enabled, your user account can be reconstructed from your last session.
        </content>
        <form id = "recover_account_cookies_form">
            <button id = "recover_account_cookies_button">Recover account</button>
        </form>
        <div id = "recover_account_cookies_result"></div>
    </article>
    <article>
        <header>Recover from a code (EXPERIMENTAL)</header>
        <content>
            Remember Castlevania? When you last logged out of your session, you recieved a code. Enter that code here to recover your account.
        </content>
        <form id = "recover_account_nes_form">
            <input id = "recover_account_nes_code" type = "text"></input>
            <button id = "recover_account_nes_button">Recover account</button>
        </form>
        <div id = "recover_account_nes_result"></div>
    </article>
</body>
</html>