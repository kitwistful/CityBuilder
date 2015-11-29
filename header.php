<div id = "global_header">
    <header>
        City Builder
    </header>
    <content>
        What's your city?
    </content>
    <content>
<?php
    if($_SESSION["bLoggedIn"])
    {
        echo "you are logged in";
    } else {
        echo "you are logged out";
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
        print_nav_link("Login", "login.php");
        print_nav_link("Dashboard", "dashboard.php");
        print_nav_link("Signup", "create_account.php");
        /*print_nav_link("Recover Account", "recover_account.php");*/
    ?>
        </ul>
    </nav>
</div>