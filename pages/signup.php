<!DOCTYPE HTML>
<?php
/**
* pages/signup.php
* Project: CityBuilder Application
* Author(s): Kathryn McKay
* Year: 2015
*
* This page is where players can create their accounts.
*
**/
    // initialize session
    session_start();
    include "../scripts/include.php";
    CityBuilder::initSessionKeys();
?>
<html>
<head>
    <?php CityBuilder::printIncludes()?>
    <title>Join City Builder</title>
</head>
<body>
<?php
// signup
function addUser($username, $password)
{
    // make connection
    $conn = CityBuilder::getDatabaseConnection();
    
    // message
    $message = "unknown error";
    
    // statements
    $sql_check = "SELECT * FROM Users WHERE name='$username'";
    $sql_add = "INSERT INTO Users(name, password) VALUES('$username', '$password')";
    $sql = "";
    // access database
    try {
        // search for username
        $sql = $sql_check;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        // evaluate results
        $userExists = $stmt->rowCount() > 0;
        
        // try to add user
        if($userExists)
        {
            $message = "username '$username' is taken";
        } else {
            $sql = $sql_add;
            $conn->exec($sql);
            $message = null;
        }
        
    } catch (PDOException $e) {
        $message = $e->getMessage();
    }
    
    // break connection
    $conn = null;
    
    // return success
    return $message;
    
}

    // header
    define("CURRENT_PAGE", "../pages/signup.php");
    include "../scripts/header.php";
    
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
        $username = CityBuilder::validateInput($_POST["username"], true);
        $password = CityBuilder::validateInput($_POST["password"], true);
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
            // check if passwords match
            if($password_again != $password)
                $signup_message = $signup_message."<li>passwords do not match</li>";
            // finally try to add user
            else if($username != null) {
                $message = addUser($username, $password);
                if($message != null)
                    $signup_message = $signup_message."<li>$message</li>";
            }
        }
        
        
        // compile list
        if($signup_message != "")
        {
            $signup_message = "<content>Found the following errors:</content><ul>".$signup_message."</ul>";
        } else {
            // obviously nothing is wrong
            $signup_message = "successful";
        }
    }
?>

    <article>
        <header>Sign up for City Builder</header>
        <content>
<?php
    if($signup_message != null)
    {
        echo "<div class = 'signup_error'><header>Information</header><content>$signup_message</content></div>";
    } else {
        echo "To continue, choose your username and password.";
    }
?>
            <form id = "create_account_form" method = "POST" action = "signup.php">
                <label>Username:</label>
                <input id = "create_account_username" name = "username" type = "text" maxlength = 40 value = <?php echo "\"$username\"" ?>></input>
                <label>Password:</label>
                <input id = "create_account_password" name = "password" type = "password" maxlength = 40></input>
                <label>Re-enter your password:</label>
                <input id = "create_account_password_again" name = "password_again" type = "password" maxlength = 40></input>
                <button id = "create_account_confirm">Signup</button>
            </form>
        </content>
    </article>
<?php include '../scripts/footer.php'?>
</body>
</html>