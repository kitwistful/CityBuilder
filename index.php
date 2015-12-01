<!DOCTYPE HTML>
<?php
/**
* index.php
* Project: CityBuilder Application
* Author(s): Kathryn McKay
* Year: 2015
*
* The homepage, which helps newcomers figure out how to get started.
*
**/
    // initialize session
    session_start();
?>
<html>
<head>
<?php include "scripts/include.php"; ?>
    <title>City Builder</title>
</head>
<body>
    <script>
        window.location.assign("./pages/dashboard.php");
    </script>
</body>
</html>