<?php
session_start();

$_SESSION["error"] = '';
if(!(isset($_SESSION["logged"])) || $_SESSION["logged"] == ""){
    header("Location ./index.php");
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>AlmAnime</title>
        <link rel="stylesheet" href="../assets/css/style.css">
    </head>
    <body>
        
    </body>
</html>