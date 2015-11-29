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
    // header
    define("CURRENT_PAGE", "login.php");
    include "header.php";
    
    // message to display
    $signup_message = null;
    
    // form info
    $username = "";

    // form validation
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // get form info
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        // begin listing errors
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
            $_SESSION["bLoggedIn"] = true;
        }
    }
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