<?php
session_start();
require "../conection/conect.php";

$_SESSION["error"] = "";

if(!$_SESSION["logged"]){
    header("Location: ../loggin.php");
}else{
    $user = $_SESSION["email"];
    $title = $_SESSION["aniName"];
    $desc = $_SESSION["desc"];
    $autor = $_SESSION["autor"];
    $demo = $_SESSION["demo"];
    $genderArr = $_SESSION["genero"];
    $date = $_SESSION["date"];
    $filePath = $_SESSION["filePath"];
    
    try{//TABLA ANIMES
        $stmt = $conn->prepare("INSERT INTO almanime.animes (titulo, description, autor, demo, lnchdate, img, user) VALUES(?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $desc, $autor, $demo, $date, $filePath, $user]);
    }catch(PDOException $e){
        $_SESSION['error'] = "Inserción en animes: " . $e->getMessage();
    }

    foreach($genderArr as $gender){//TABLA ANIGENDER
        try{
            $stmt = $conn->prepare("INSERT INTO almanime.anigender VALUES(?, ?)");
            $stmt->execute([$title, $gender]);
        }catch(PDOException $e){
            $_SESSION['error'] = "Inserción en anigender: " . $e->getMessage();
        }
    }

    if(isset($_SESSION["error"]) && $_SESSION["error"] != ""){
        header("Location: ../public/animeReg.php");
    }else{
        header("Location: ../public/index.php");
    }

    $conn = null;
}