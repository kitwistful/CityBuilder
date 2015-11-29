<?php

    $bLoggedIn = "bLoggedIn";

    
    if(!array_key_exists($bLoggedIn, $_SESSION))
    {
        $_SESSION[$bLoggedIn] = false;
    }
    
?>

<!-- Stylesheet-->
<link rel = "stylesheet" type = "text/css" href = "style.css" />