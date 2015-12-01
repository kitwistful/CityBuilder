<?php
/**
* scripts/header.php
* Project: CityBuilder Application
* Author(s): Kathryn McKay
* Year: 2015
*
* This header should be inserted above content in the <body> section of a page.
* It displays the title of the application, links to each page, and anything
* else that should be visible and accessible on each page.
*
**/
?>

<div id = "global_header">
    <header>
        City Builder
    </header>
    <content>
        What's your city?
    </content>
    <content>
<?php
    if($_SESSION["citybuilder_bLoggedIn"])
    {
        echo "Welcome, ".$_SESSION["citybuilder_username"].".";
    } else {
        echo "You are logged out";
    }
?>
    </content>
    <nav>
        <ul>
    <?php
        function print_nav_link($name, $url)
        {
            if(CURRENT_PAGE == $url)
                echo "<li><a href = '$url' class = 'current_page'>$name</a></li>";
            else
                echo "<li><a href = '$url'>$name</a></li>";
        }
        
        print_nav_link("Home", "../index.php");
        print_nav_link("Dashboard", "../pages/dashboard.php");
        print_nav_link("Signup", "../pages/signup.php");
        /*print_nav_link("Recover Account", "recover_account.php");*/
        
        // change links depending on whether or not you're logged in
        if($_SESSION["citybuilder_bLoggedIn"])
        {
            // you're logged in so maybe you wanna log out
            print_nav_link("Logout", "../pages/logout.php");
            
        } else{
            // you aren't login so...log in. 
            print_nav_link("Login", "../pages/login.php");
        }
        
    ?>
        </ul>
    </nav>
</div>