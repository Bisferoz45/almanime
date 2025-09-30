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
            echo "ERROR: ". $e->getMessage();
        }

        if(!isset($_SESSION["error"]) && $_SESSION["error"] == ""){
            $error = $_SESSION['error'];
            echo "ERROR: $error";
            $_SESSION["error"] = null;
        }else{
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

                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

                echo $res["email"];
                echo $res["passwd"];

                if(!$res){
                    $_SESSION["error"] = "No se a hencontrado la cuenta.";
                    header("Location: http://192.168.58.132/Almacen/loggin.php");
                }else{
                    if(password_verify($userPasswd, $res['passwd'])){
                        header("Location: http://192.168.58.132/Almacen/MainPage/index.php");
                    }else{
                        var_dump($userPasswd, $res['password']);
                        $_SESSION["error"] = "La contraseña es incorrecta.";
                        //header("Location: http://192.168.58.132/Almacen/loggin.php");
                    }
                }

            }catch(PDOException $e){
                $_SESSION["error"] = $e->getMessage();
            }

            $conn = null;
        }
    }
}
?>