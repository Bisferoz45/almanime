<?php
session_start();
require "../conect.php";

$_SESSION["error"] = "";

if(!$_SESSION["logged"]){
    header("Location: ../loggin.php");
}else{
    
}