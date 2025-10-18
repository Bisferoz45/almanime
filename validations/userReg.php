<?php
session_start();
require "../conection/conect.php";
$_SESSION["error"] = "";

if($_SESSION["logged"]){
    header("Location: ../public/index.php");
}else{
    if(!$_SESSION["log"]){ //Registro de usuarios
        $user = $_SESSION["user"];
        $email = $_SESSION["email"];
        $passwd = $_SESSION["passwd"];
        $filePath = $_SESSION["filePath"];

        try{
            $stmt = $conn->prepare("INSERT INTO almanime.users (username, email, passwd, imgprf) VALUES(:username, :email, :passwd, :imgprf)");
            $stmt->bindParam(":username", $user);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":passwd", $passwd);
            $stmt->bindParam(":imgprf", $filePath);
            $stmt->execute();
        }catch(PDOException $e){
            $_SESSION['error'] = "La cuenta ya se encuentra registrada.";
        }

        if(isset($_SESSION["error"]) && $_SESSION["error"] != ""){
            header("Location: ../public/register.php");
        }else{
            $_SESSION["logged"] = true;
            header("Location: ../public/index.php");
        }

        $conn = null;


    }else{ //Loggin de usuarios
        if(!isset($_SESSION["email"]) || !isset($_SESSION["passwd"])){
            $_SESSION["error"] = "Rellene ambos campos para logearse.";
            header("Location: ../public/loggin.php");
        }else{
            $userEmail = $_SESSION["email"];
            $userPasswd = $_SESSION["passwd"];

            try{
                $stmt = $conn->prepare("SELECT * FROM almanime.users WHERE email=:email");
                $stmt->bindParam(":email", $userEmail, PDO::PARAM_STR);
                $stmt->execute();

                $res = $stmt->fetch(PDO::FETCH_ASSOC);

                if(!$res){
                    $_SESSION["error"] = "No se a hencontrado la cuenta.";
                    header("Location: ../public/loggin.php");
                }else{
                    if(password_verify($userPasswd, $res['passwd'])){
                        $_SESSION["logged"] = true;
                        if($_SESSION["error"] == ""){
                            $token = bin2hex(random_bytes(32));
                            setcookie('remember', $token, time() + (7 * 24 * 60 * 60),'/', '', false, true);

                            try{
                                $stmt = $conn->prepare("UPDATE almanime.users SET token = ? WHERE email = ?");
                                $stmt->execute([$token, $userEmail]);
                            }catch(PDOException $e){
                                $_SESSION["error"] = "Error al insertar el token" . $e->getMessage();
                            }
                        }
                    
                        if(isset($_SESSION["error"]) && $_SESSION["error"] != ""){
                            header("Location: ../public/loggin.php");
                        }else{
                            $_SESSION["logged"] = true;
                            header("Location: ../public/index.php");
                        }
                        header("Location: ../public/index.php");
                    }else{
                        $_SESSION["error"] = "La contraseña es incorrecta.";
                        echo "Las contraseñas no coinciden";
                        header("Location: ../public/loggin.php");
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