<?php
session_start();
$user = isset($_SESSION["user"]) ? $_SESSION["user"] :"";
$email = isset($_SESSION["email"]) ? $_SESSION["email"] :"";
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
            Usuario: <input type="text" name="user" placeholder="Username" value="<?php echo $user?>"> <br>
            E-mail: <input type="email" name="email" placeholder="example@domain.es" value="<?php echo $email?>"> <br>
            Contraseña: <input type="password" name="passwd1" placeholder="Password"> <br>
            Confirmar contraseña: <input type="password" name="passwd2" placeholder="Confirm password"> <br>
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