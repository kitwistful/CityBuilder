<?php
/**
* scripts/database.php
* Project: CityBuilder Application
* Author(s): Kathryn McKay
* Year: 2015
*
* This page initializes the database.
* Change the "defines" to change the login information.... after I put it in.
*
**/    
   
    // create the database
    include "create_database.php";
    
    // initialize the created database
    include "init_database.php";
?>