<div id = "global_header">
<header>
    City Builder
</header>
<content>
    What's your city?
</content>
<nav>
    <ul>
<?php
    function print_nav_link($name, $url)
    {
        if(CURRENT_PAGE == $url)
            echo "<li id = 'nav_currpage'>$name</li>";
        else
            echo "<li><a href = '$url'>$name</a></li>";
    }
    
    print_nav_link("Home", "index.php");
    print_nav_link("Login", "login.php");
    print_nav_link("Dashboard", "dashboard.php");
    print_nav_link("Recover Account", "recover_account.php");
    ?>
    </ul>
</nav>
</div>