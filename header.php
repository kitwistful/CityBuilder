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
        
        print_nav_link("Home", "index.php");
        print_nav_link("Dashboard", "dashboard.php");
        print_nav_link("Signup", "create_account.php");
        /*print_nav_link("Recover Account", "recover_account.php");*/
        
        // change links depending on whether or not you're logged in
        if($_SESSION["citybuilder_bLoggedIn"])
        {
            // you're logged in so maybe you wanna log out
            print_nav_link("Logout", "logout.php");
            
        } else{
            // you aren't login so...log in. 
            print_nav_link("Login", "login.php");
        }
        
    ?>
        </ul>
    </nav>
</div>