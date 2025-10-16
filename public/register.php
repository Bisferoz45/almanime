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
        <link rel="stylesheet" href="../assets/css/style.css">
        <script>
            function showHint(str) {
                if (str.length == 0) {
                document.getElementById("txtHint").innerHTML = "";
                return;
                }else{
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("txtHint").innerHTML = this.responseText;
                        }
                    };
                    xmlhttp.open("GET", "gethint.php?q=" + str, true);
                    xmlhttp.send();
                }
            }
        </script>
    </head>
    <body>
        <header>
            <h1 class="headerTittle">Registrarse</h1>
        </header>
        <hr>
        <div class="body">
            <form accept-charset="utf-8" action="../validations/userVal.php" method="POST" enctype="multipart/form-data">
                Usuario: <input type="text" name="user" placeholder="Username" value="<?php echo $user?>" required> <br>
                E-mail: <input type="email" name="email" placeholder="example@domain.ext" value="<?php echo $email?>" required> <br>
                Contraseña: <input type="password" name="passwd1" placeholder="Password" onkeyup="showHint(this.value)" required> <br>
                Confirmar contraseña: <input type="password" name="passwd2" placeholder="Confirm password" required> <br>
                <article class="sugList">Suggestions: <span id="txtHint"></span></article>
                Inserte imágen de portada: <input type="file" accept="image/*" name="img" placeholder="Insert image"> <br>
                <input type="submit" name="submit" class="button"> <br> <br>
            </form>

            <h3>Ya tiene una cuenta?:<h3> <a href="./loggin.php"><button>Log in</button></a>

            <?php
                if(isset($_SESSION["error"]) && $_SESSION["error"] != ""){
                    echo "ERROR: " . $_SESSION["error"];
                    $_SESSION["error"] = null;
                }
            ?>
        </div>
    </body>
</html>