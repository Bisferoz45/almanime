<?php
//header("Location: ../loggin.php");

$servername = "127.0.0.1";
$username = "root";
$password = "";

try{
    $conn = new PDO("mysql:host=$servername;database=almanime", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    $_SESSION["error"] = $e->getMessage();
}