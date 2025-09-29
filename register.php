<?php
session_start();
$user = isset($_SESSION["user"]) ? $_SESSION["user"] :"";
$email = isset($_SESSION["email"]) ? $_SESSION["email"] :"";
$passwd = isset($_SESSION["passwd"]) ? $_SESSION["passwd"] : "";
$_SESSION["log"] = false;
$_SESSION["logged"] = false;
?>

<html>
    <head>
        <title>AlmAnime</title>
    </head>
    <body>
            <h1>Registrarse</h1>
        </header>
        
        <form action="validacion.php" method="POST">
            Usuario: <input type="text" name="user" value="<?php echo $user?>"> <br>
            E-mail: <input type="email" name="email" value="<header><?php echo $email?>"> <br>
            Contraseña: <input type="password" name="passwd1" value="<?php echo $passwd?>"> <br>
            Confirmar contraseña: <input type="password" name="passwd2" value="<?php echo $passwd?>"> <br>
            <input type="submit" name="submit"> <br> <br>
            <h3>Ya tiene una cuenta?:<h3> <a href="loggin.php"><input type="button" value="Logearse"></a>
        </form>

        <?php
            if(isset($_SESSION["error"])){
                echo "ERROR: " . $_SESSION["error"];
                $_SESSION["error"] = null;
            }
        ?>
    </body>
</html>