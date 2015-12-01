<?php
/**
* database.php
* Project: CityBuilder Application
* Author(s): Kathryn McKay
* Year: 2015
*
* This page initializes the database.
* Change the "defines" to change the login information.... after I put it in.
*
**/    
   
    // create the database
    include "database/create_database.php";
    
    // initialize the created database
    include "database/init_database.php";
?>