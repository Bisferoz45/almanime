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
        <h2>Registro de libros</h2>
        <form action="valBook.php" method="post">
            Titulo: <br> <input type="text" name="aniName" placeholder="Anime name"> <br> <br>
            Descripción: <br> <input type="text" name="desc" placeholder="Description"> <br> <br>
            Autor: <br> <input type="text" name="autor" placeholder="Author name"> <br> <br>
            Demografía: <select name="demo">
                <option vaue="">-- Seleccione una demografía --</option>
                <option value="kodomo">Kodomo</option>
                <option value="shonen">Shonen</option>
                <option value="shoujo">Shoujo</option>
                <option value="seinen">Seinen</option>
                <option value="josei">Josei</option>
            </select> <br> <br>
            Genero/s: <br>
            <input type="checkbox" name="genero[]" value="Accion"> Acción <br>
            <input type="checkbox" name="genero[]" value="Aventura"> Avenura <br>
            <input type="checkbox" name="genero[]" value="Ciencia Ficcion"> Ciencia ficcón <br>
            <input type="checkbox" name="genero[]" value="Comedia"> Comedia <br>
            <input type="checkbox" name="genero[]" value="Ecchi"> Ecchi <br>
            <input type="checkbox" name="genero[]" value="Fantasia"> Fantasía <br>
            <input type="checkbox" name="genero[]" value="Gore"> Gore <br>
            <input type="checkbox" name="genero[]" value="Misterio"> Misterio <br>
            <input type="checkbox" name="genero[]" value="Terror"> Terror <br> <br>

            Fecha de lanzamiento: <input type="date" name="date"> <br> <br>
            Inserte imágen de portada: <input type="file" accept="image/*" name="img" placeholder="INsert image"> <br>
            <input type="submit" name="submit" value="Enviar">


        </form>

        <?php
            if(isset($_SESSION["error"])){
                echo "ERROR: " . $_SESSION["error"];
                $_SESSION["error"] = null;
            }
        ?>
    </body>
</html>