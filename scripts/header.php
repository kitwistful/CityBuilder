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
<?php
    if($_SESSION["citybuilder_bLoggedIn"])
    {
        echo "Welcome, ".$_SESSION["citybuilder_username"].". <a href = '../pages/logout.php'>Logout</a>";
    } else {
        echo "Currently, you are not logged in. <a href = '../pages/login.php'>Login</a>";
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
        print_nav_link("Dashboard", "../pages/dashboard.php");
        print_nav_link("How to Play", "../pages/howtoplay.php");
        print_nav_link("Signup", "../pages/signup.php");
        
    ?>
        </ul>
    </nav>
</div>