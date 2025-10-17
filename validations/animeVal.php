<?php
session_start();
$_SESSION["error"] = "";

if(!$_SESSION["logged"]){
    header("Location: ../public/loggin.php");
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
    if(!isset($_FILES['img']) || $_FILES['img']['error'] !== 0){
        $_SESSION["filePath"] = "../assets/img/img_anm/10032-default.png";
    }else{
        //PROCESADO DE LA IMAGEN
        $dirRute = "../assets/img/img_anm/";
        $archName = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $_FILES["img"]["name"]);
        $filePath = $dirRute . date("Y-m-d") . "_" . date("H-m") . "-" . $archName; //RUTA DEL ARCHIVO + EL NOMBRE QUE LLEVARÁ; ECHO DE MANERA QUE SEA MUY DIFICIL QUE SE REPITA
        
        if(!move_uploaded_file($_FILES["img"]["tmp_name"], $filePath)){
            $_SESSION['error'] = "La imágen no se subió correctamente ";
        }else{
            $_SESSION["filePath"] = $filePath;
        }
    }

    
    if(isset($_SESSION["error"]) && $_SESSION["error"] != ""){
        header("Location: ../public/animeReg.php");
    }else{
        $_SESSION["aniName"] = $_POST["aniName"];
        $_SESSION["desc"] = $_POST["desc"];
        $_SESSION["autor"] = $_POST["autor"];
        $_SESSION["demo"] = $_POST["demo"];
        $_SESSION["genero"] = $_POST["genero"];
        $_SESSION["date"] = $_POST["date"];
        header("Location: ./animeIns.php");
    }
}


?>

