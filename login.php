<!DOCTYPE HTML>
<?php
    session_start();
?>
<html>
<head>
<?php include "include.php"; ?>
    <title>Login to City Builder</title>
</head>
<body>
<?php
    
    // message to display
    $signup_message = null;
    
    // form info
    $username = "";
    
    // add warning if logged in
    if($_SESSION["citybuilder_bLoggedIn"])
    {
        $signup_message = "<li>You are already logged in as '".$_SESSION["citybuilder_username"]."'.</li>";
    }

    // form validation
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // get form info
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        // begin listing errors
        if($signup_message == null)
            $signup_message = "";
        
        // check username
        if($username == null)
        {
            $signup_message = $signup_message."<li>username is required</li>";
            $username = "";
        }
        
        // check password
        if($password == null)
        {
            $signup_message = $signup_message."<li>password is required</li>";
        }
        
        // compile list
        if($signup_message != "")
        {
            $signup_message = "<content>Found the following errors:</content><ul>".$signup_message."</ul>";
        } else {
            // obviously nothing is wrong
            $signup_message = "successful";
            
            // consider yourself logged in
            $_SESSION["citybuilder_bLoggedIn"] = true;
            
            // let's remember your name
            $_SESSION["citybuilder_username"] = $username;
            
            // actually something is wrong
            $signup_message = "You are now 'logged in' (Quotes for debug behaviour).";
        }
    }
    
    
    // header
    define("CURRENT_PAGE", "login.php");
    include "header.php";
?>
    <article>
        <header>Login</header>
<?php
    if($signup_message != null)
    {
        echo "<content><div class = 'signup_error'><header>Information</header><content>$signup_message</content></div></content>";
    }
?>
        <form id = "login_form" method = "POST" action = "login.php">
            <label>Username:</label>
            <input id = "username" type = "text" name = "username" value = <?php echo "\"$username\""?>></input>
            <label>Password:</label>
            <input id = "password" type = "password" name = "password"></input>
            <button id = "login_button">Go</input>
        </form>
    </article>
</body>
</html>