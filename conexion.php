<?php
session_start();
if($_SESSION["logged"]){
    header("Location: http://192.168.58.132/Almacen/register.php");
}else{
    if(!$_SESSION["log"]){
        $user = $_SESSION["user"];
        $email = $_SESSION["email"];
        $passwd = $_SESSION["passwd"];

        $servername = "127.0.0.1";
        $username = "root";
        $password = "";


        try{
            $conn = new PDO("mysql:host=$servername;database=almanime", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
            $stmt = $conn->prepare("INSERT INTO test.myguests (nombre, email, contrasena) VALUES(:nombre, :email, :contrasena)");
            $stmt->bindParam(":nombre", $user);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":contrasena", $passwd);
            $stmt->execute();
        }catch(PDOException $e){
            echo "ERROR: ". $e->getMessage();
        }

        $conn = null;
    }else{
        if(!isset($_POST["email"]) || !isset($_POST["passwd"])){
            $_SESSION["error"] = "Rellene ambos campos para logearse.";
            header("Location: http://192.168.58.132/Almacen/loggin.php");
        }else{
            $userEmail = $_POST["email"];
            $userPasswd = $_POST["passwd"];
            
            $servername = "127.0.0.1";
            $username = "root";
            $password = "";

            try{
            $conn = new PDO("mysql:host=$servername;database=almanime", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
            $stmt = $conn->prepare("SELECT FROM almanime.users (email, contrasena) VALUES(:email, :contrasena)");
            
        }catch(PDOException $e){
            echo "ERROR: ". $e->getMessage();
        }
        }
    }
}




echo"USUARIO INTRODUCIDO CON ÉXITO";

?>