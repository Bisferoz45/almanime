<?php
session_start();
if(!$_SESSION["logged"]){
    header("Location: http://192.168.58.132/Almacen/loggin.php");
}?>

<html>
    <head>
        <title>AlmAnime</title>
    </head>
    <body>
        <header>
            <div id="cntrLogo">
                <p>Logo</p>
            </div>
            <div id="cntrMenu">
                <a href="bookRegister.php"><button>Añadir libro</button></a>
            </div>
        </header>
        <div id="cntrBody">
            <div class="cntrArt">
                <p>Imagen</p>
                <p>Texto Descriptivo</p>
            </div>
        </div>
    </body>
</html>