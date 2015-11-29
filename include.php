<?php

    // session key list
    $seshkeys = array(
      "citybuilder_bLoggedIn",
      "citybuilder_username"
    );
    
    // init session keys
    foreach($seshkeys as $keykey => $key)
    {
        if(!array_key_exists($key, $_SESSION))
        {
            $_SESSION[$key] = null;
        }
    }
    
    
?>

<!-- Stylesheet-->
<link rel = "stylesheet" type = "text/css" href = "style.css" />