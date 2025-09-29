<?php
session_start();
$email = isset($_SESSION["email"]) ? $_SESSION["email"] :"";
$passwd = isset($_SESSION["passwd"]) ? $_SESSION["passwd"] : "";
$_SESSION["log"] = true;
$_SESSION["logged"] = false;
?>

<html>
    <head>
        <title>
            AlmAnime
        </title>
    </head>
    <body>
        <header>
            <h1>Inicio de sesión</h1>
        </header>
        
        <form action="validacion.php" method="POST">
            E-mail: <input type="email" name="email" value="<?php echo $email?>"> <br>
            Contraseña: <input type="password" name="passwd1" value="<?php echo $passwd?>"> <br>
            <input type="submit" name="submit"> <br> <br>
            <h3>Si aún no se ha registrado:<h3> <a href="register.php"><input type="button" value="Registrarse"></a>
        </form>

        <?php
            if(isset($_SESSION["error"])){
                echo "ERROR: " . $_SESSION["error"];
                $_SESSION["error"] = null;
            }
        ?>
    </body>
</html>