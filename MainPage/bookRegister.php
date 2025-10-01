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
        <form>
            Titulo: <br> <input type="text" placeholder="Anime name"> <br> <br>
            Descripción: <br> <input type="text" placeholder="Description"> <br> <br>
            Autor: <br> <input type="text" placeholder="Author name"> <br> <br>
            Demografía: <select>
                <option vaue="">-- Seleccione una demografía --</option>
                <option value="kodomo">Kodomo</option>
                <option value="shonen">Shonen</option>
                <option value="shoujo">Shoujo</option>
                <option value="seinen">Seinen</option>
                <option value="josei">Josei</option>
            </select> <br> <br>
            Genero/s <br>
            <input type="checkbox" name="intereses" value="Acción"> Acción <br>
            <input type="checkbox" name="intereses" value="Aventura"> Avenura <br>
            <input type="checkbox" name="intereses" value="Ciencia Ficción"> Ciencia ficcón <br>
            <input type="checkbox" name="intereses" value="Comedia"> Comedia <br>
            <input type="checkbox" name="intereses" value="Ecchi"> Ecchi <br>
            <input type="checkbox" name="intereses" value="Fantasía"> Fantasía <br>
            <input type="checkbox" name="intereses" value="Gore"> Gore <br>
            <input type="checkbox" name="intereses" value="Terror"> Terror <br>
        </form>
    </body>
</html>