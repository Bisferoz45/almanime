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

    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $_SESSION['error'] .= 'El email es invaido ';
        $_SESSION['email'] = '';
    }

    if(empty($_POST["user"])){
        $_SESSION["error"] .= "Debe introducir un usuario ";
        $_SESSION["user"] = "";
    }

    if(isset($_SESSION["error"]) && $_SESSION["error"] != ''){
        header("Location: http://192.168.58.132/Almacen/register.php");
    }else{
        $_SESSION["passwd"] = password_hash($_POST["passwd1"], PASSWORD_DEFAULT);
        header("Location: http://192.168.58.132/Almacen/conexion.php");
    }

}else{
    header("Location: http://192.168.58.132/Almacen/conexion.php");
}


/*
*/
?>
