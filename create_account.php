<!DOCTYPE HTML>
<?php
    session_start();
?>
<html>
<head>
<?php include "include.php"; ?>
    <title>Join City Builder</title>
</head>
<body>
<?php
    // header
    define("CURRENT_PAGE", "create_account.php");
    include "header.php";
    
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
        $password_again = $_POST["password_again"];
        
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
        else
        {
            if($password_again != $password)
                $signup_message = $signup_message."<li>passwords do not match</li>";
        }
        
        // compile list
        if($signup_message != "")
        {
            $signup_message = "<content>Found the following errors:</content><ul>".$signup_message."</ul>";
        } else {
            // obviously nothing is wrong
            $signup_message = "successful";
            
            // actually, this isn't implemented yet sooo
            $signup_message = "Account creation is currently unsupported. Sorry";
        }
    }
?>

    <article>
        <header>Sign up for City Builder</header>
<?php
    if($signup_message != null)
    {
        echo "<content><div class = 'signup_error'><header>Information</header><content>$signup_message</content></div></content>";
    } else {
        echo "<content>To continue, choose your username and password.</content>";
    }
?>
        <form id = "create_account_form" method = "POST" action = "create_account.php">
            <label>Username:</label>
            <input id = "create_account_username" name = "username" type = "text" value = <?php echo "\"$username\"" ?>></input>
            <label>Password:</label>
            <input id = "create_account_password" name = "password" type = "password"></input>
            <label>Re-enter your password:</label>
            <input id = "create_account_password_again" name = "password_again" type = "password"></input>
            <button id = "create_account_confirm">Signup</button>
        </form>
    </article>
</body>
</html>