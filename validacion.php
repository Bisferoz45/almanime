<?php
session_start();

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

    if(isset($_SESSION["error"]) && $_SESSION["error"] != ''){
        header("Location: register.php");
    }else{
        $_SESSION["passwd"] = password_hash($_POST["passwd1"], PASSWORD_DEFAULT);
        header("Location: conexion.php");
    }

}else{
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["passwd"] = $_POST["passwd1"];
    header("Location: conexion.php");
}
?>
