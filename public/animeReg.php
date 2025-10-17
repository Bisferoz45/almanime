<?php
session_start();
if(!$_SESSION["logged"]){
    header("Location: http://192.168.58.132/Almacen/loggin.php");
}?>

<html>
    <head>
        <title>AlmAnime</title>
        <link rel="stylesheet" href="../assets/css/style.css">
    </head>
    <body>
        <header>
            <h1 class="headerTittle">Registro de animes</h1>
        </header>
        <hr>
        <div class="body">
            <form action="../validations/animeVal.php" method="post" enctype="multipart/form-data">
                Titulo:  <input type="text" name="aniName" placeholder="Anime name">* <br> <br>
                Descripción:<br><textarea name="desc" rows="10" cols="40" placeholder="Write the description here..."></textarea> <br>
                Autor:  <input type="text" name="autor" placeholder="Author name">* <br> 
                Demografía: <select name="demo">
                    <option vaue="">-- Seleccione una demografía --</option>
                    <?php
                        require "../conection/conect.php";
                        $rows = $conn->query("SELECT * FROM almanime.demography");
                        $rows = $rows->fetchAll(PDO::FETCH_ASSOC);
                        foreach($rows as $row){
                            echo '<option value="' . strtolower($row["demo"]) . '">' . $row["demo"] . '</option>';
                        }
                    ?>
                </select>* <br> <br>
                Genero/s: *<br>
                <?php
                    require "../conection/conect.php";
                    $rows = $conn->query("SELECT * FROM almanime.genders");
                    $rows = $rows->fetchAll(PDO::FETCH_ASSOC);
                    foreach($rows as $row){
                        echo '<input type="checkbox" name="genero[]" value="' . strtolower($row["gender"]) . '">' . $row["gender"] . '<br>';
                    }
                ?>
                Fecha de lanzamiento: <input type="date" name="date">* <br> <br>
                Inserte imágen de portada: <input type="file" accept="image/*" name="img" placeholder="Insert image"> <br>
                <input type="submit" name="submit" value="Enviar" class="button">
            </form>

            <?php
                if(isset($_SESSION["error"]) && $_SESSION["error"] != ""){
                    print "ERROR: " . $_SESSION["error"];
                    $_SESSION["error"] = null;
                }
            ?>
        </div>
    </body>
</html>