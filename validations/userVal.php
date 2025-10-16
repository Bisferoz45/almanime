<?php
session_start();

$_SESSION["error"] = "";

if(!$_SESSION["log"]){
    $_SESSION["user"] = $_POST["user"];
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["passwd"] = $_POST["passwd1"];
    $_SESSION["error"] = "";

    if($_POST["passwd1"] !== $_POST["passwd2"]){
        $_SESSION["error"] = 'Las contraseñas no coinciden ';
        $_SESSION["passwd"] = '';
    }

    if(isset($_POST["passwd1"]) && $_POST["passwd1"] == ""){
        $_SESSION["error"] = 'Establezca una contraseña ';
        $_SESSION["passwd"] = '';
    }else{
        if(strlen($_POST["passwd1"]) < 7){
            $_SESSION["error"] = "La contraseña no cumple con el mínimo de longitud ";
        }
        if(preg_match('/[A-Z]/', $_POST["passwd1"]) == 0 || preg_match('/[a-z]/', $_POST["passwd1"]) == 0){
            $_SESSION["error"] = "La contraseña debe tener mayúsculas y minúsculas ";
        }
        if(preg_match('/[0-9]/', $_POST["passwd1"]) == 0){
            $_SESSION["error"] = "La contraseña debe tener números ";
        }
        if(preg_match('/[^a-zA-Z0-9]/', $_POST["passwd1"]) == 0){
            $_SESSION["error"] = "La contraseña debe contener carácteres especiales ";
        }
    }

    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $_SESSION['error'] .= 'El email es invaido ';
        $_SESSION['email'] = '';
    }

    if(empty($_POST["user"])){
        $_SESSION["error"] .= "Debe introducir un usuario ";
        $_SESSION["user"] = "";
    }

    if(!isset($_FILES['img']) || $_FILES['img']['error'] !== 0){
        $_SESSION["filePath"] = "../assets/img/img_prf/default_prf.jpg";
    }else{
        //PROCESADO DE LA IMAGEN
        $dirRute =  "../assets/img/img_prf/";
        $archName = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $_FILES["img"]["name"]);
        $filePath = $dirRute . date("Y-m-d") . "_" . date("H-m") . "-" . $archName; //RUTA DEL ARCHIVO + EL NOMBRE QUE LLEVARÁ; ECHO DE MANERA QUE SEA MUY DIFICIL QUE SE REPITA
        if(!move_uploaded_file($_FILES["img"]["tmp_name"], $filePath)){
            $_SESSION['error'] = "La imágen no se subió correctamente ";
        }else{
            $_SESSION["filePath"] = $filePath;
        }
    }

    if(isset($_SESSION["error"]) && $_SESSION["error"] != ''){
        header("Location: ../public/register.php");
    }else{
        $_SESSION["passwd"] = password_hash($_POST["passwd1"], PASSWORD_DEFAULT);
        header("Location: ./userReg.php");
    }

    print_r ($_SESSION["filePath"]);

}else{
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["passwd"] = $_POST["passwd1"];
    header("Location: ./userReg.php");
}
?>
