<?php
/**
* include.php
* Project: CityBuilder Application
* Author(s): Kathryn McKay
* Year: 2015
*
* This script is meant to be referred to in the <head> section of each page.
* It has information that should be initialilzed for each page including the
* site's stylesheet, and session data.
*
**/

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