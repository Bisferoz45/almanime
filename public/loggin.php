<?php
session_start();
$email = isset($_SESSION["email"]) ? $_SESSION["email"] :"";
$_SESSION["log"] = true;
$_SESSION["logged"] = false;
?>

<html>
    <head>
        <title>AlmAnime</title>
        <link rel="stylesheet" href="../assets/css/style.css">
    </head>
    <body>
        <header>
            <h1 class="headerTittle">Inicio de sesión</h1>
        </header>
        <hr>
        <div class="body"> 
            <form action="../validations/userVal.php" method="POST">
                E-mail: <input type="email" name="email" placeholder="example@domain.es" value="<?php echo $email?>"> <br>
                Contraseña: <input type="password" name="passwd1" placeholder="Password"> <br>
                <input type="submit" name="submit" class="button"> <br> <br>
            </form>
            <h3>Si aún no se ha registrado:<h3> <a href="./register.php"><button>Registrarse</button></a>
        </div>

        <?php
            if(isset($_SESSION["error"]) && $_SESSION["error"] != ""){
                echo "ERROR: " . $_SESSION["error"];
                $_SESSION["error"] = null;
            }
        ?>
    </body>
</html>