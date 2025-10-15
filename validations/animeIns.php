<?php
session_start();
require "../conect.php";

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
    $gender = "";
    $date = $_SESSION["date"];
    $filePath = $_SESSION["filePath"];

    foreach($genderArr as $value){
        $gender .= $value . " ";
    }
    
    try{
        $stmt = $conn->prepare("INSERT INTO almanime.animes (titulo, description, autor, demo, genders, lnchdate, img, username) VALUES(:titulo, :description, :autor, :demo, :genders, :lnchdate, :img, :username)");
        $stmt->bindParam(":titulo", $title);
        $stmt->bindParam(":description", $desc);
        $stmt->bindParam(":autor", $autor);
        $stmt->bindParam(":demo", $demo);
        $stmt->bindParam(":genders", $gender);
        $stmt->bindParam(":lnchdate", $date);
        $stmt->bindParam(":img", $filePath);
        $stmt->bindParam(":username", $user);
        $stmt->execute();
    }catch(PDOException $e){
        $_SESSION['error'] = $e->getMessage();
    }

    if(isset($_SESSION["error"]) && $_SESSION["error"] != ""){
        header("Location: aniRegister.php");
    }else{
        header("Location: index.php");
    }

    $conn = null;
}