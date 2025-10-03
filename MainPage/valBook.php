<?php
session_start();
$_SESSION["error"] = "";

if(!$_SESSION["logged"]){
    header("Location: ../loggin.php");
}else{
    if(!isset($_POST["aniName"]) || $_POST["aniName"] == ""){
        $_SESSION["error"] = "Rellene el campo del título. ";
    }
    if(!isset($_POST["desc"]) || $_POST["desc"] == ""){
        $_POST["desc"] = "Descripción no introducida.";
    }
    if(!isset($_POST["autor"]) || $_POST["autor"] == ""){
        $_SESSION["error"] = "Inserte el nombre del autor. ";
    }
    if(!isset($_POST["demo"]) || $_POST["demo"] == "" || $_POST["demo"] == "-- Seleccione una demografía --"){
        $_SESSION["error"] = "Seleccione una demografía. ";
    }
    if(!isset($_POST["genero"]) || $_POST["genero"] == ""){
        $_SESSION["error"] = "Seleccione uno o varios géneros. ";
    }
    if(!isset($_POST["date"]) || $_POST["date"] > date("Y-m-d")){
        $_SESSION["error"] = "Establezca una fecha adecuada.";
    }
    
    
    if(isset($_SESSION["error"]) && $_SESSION["error"] != ""){
        header("Location: bookRegister.php");
    }else{
        
    }
}


?>

