<?php
session_start();
if($_SESSION["logged"]){
    header("Location: http://192.168.58.132/Almacen/register.php");
}else{
    if(!$_SESSION["log"]){ //Registro de usuarios
        $user = $_SESSION["user"];
        $email = $_SESSION["email"];
        $passwd = $_SESSION["passwd"];

        $servername = "127.0.0.1";
        $username = "root";
        $password = "";


        try{
            $conn = new PDO("mysql:host=$servername;database=almanime", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
            $stmt = $conn->prepare("INSERT INTO almanime.users (username, email, passwd) VALUES(:username, :email, :passwd)");
            $stmt->bindParam(":username", $user);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":passwd", $passwd);
            $stmt->execute();
        }catch(PDOException $e){
            $_SESSION['error'] = "La cuenta ya se encuentra registrada.";
        }

        if(!isset($_SESSION["error"]) && $_SESSION["error"] == ""){
            header("Location: http://192.168.58.132/Almacen/register.php");
        }else{
            $_SESSION["logged"] = true;
            header("Location: http://192.168.58.132/Almacen/MainPage/index.php");
        }

        $conn = null;


    }else{ //Loggin de usuarios
        if(!isset($_SESSION["email"]) || !isset($_SESSION["passwd"])){
            $_SESSION["error"] = "Rellene ambos campos para logearse.";
            header("Location: http://192.168.58.132/Almacen/loggin.php");
        }else{
            $userEmail = $_SESSION["email"];
            $userPasswd = $_SESSION["passwd"];
            
            $servername = "127.0.0.1";
            $username = "root";
            $password = "";

            try{
                $conn = new PDO("mysql:host=$servername;database=almanime", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $conn->prepare("SELECT * FROM almanime.users WHERE email=:email");
                $stmt->bindParam(":email", $userEmail, PDO::PARAM_STR);
                $stmt->execute();

                $res = $stmt->fetch(PDO::FETCH_ASSOC);

                if(!$res){
                    $_SESSION["error"] = "No se a hencontrado la cuenta.";
                    header("Location: http://192.168.58.132/Almacen/loggin.php");
                }else{
                    if(password_verify($userPasswd, $res['passwd'])){
                        $_SESSION["logged"] = true;
                        header("Location: http://192.168.58.132/Almacen/MainPage/index.php");
                    }else{
                        $_SESSION["error"] = "La contraseña es incorrecta.";
                        echo "Las contraseñas no coinciden";
                        header("Location: http://192.168.58.132/Almacen/loggin.php");
                    }
                }

                $_SESSION["user"] = $res['user'];

            }catch(PDOException $e){
                $_SESSION["error"] = $e->getMessage();
            }

            $conn = null;
        }
    }
}
?>