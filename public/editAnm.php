<?php
session_start();
require "../conection/conect.php";

$_SESSION["error"] = "";
$stmt = $conn->prepare("SELECT * FROM almanime.animes WHERE titulo LIKE ?");
$stmt->execute([$_GET["id"]]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$_SESSION["logged"] || $_SESSION["email"] != $row["user"]){
    header("Location: ./index.php");
}else{
    $titulo = $row["titulo"];
    $desc = $row["description"];
    $autor = $row["autor"];
    $demo = $row["demo"];
    $date = $row["lnchdate"];

    $stmt = $conn->prepare("SELECT g.gender FROM almanime.anigender ag INNER JOIN almanime.genders g ON ag.gender = g.gender WHERE ag.titulo LIKE ?");
    $stmt->execute([$_GET["id"]]);
    $genders = $stmt->fetchAll(PDO::FETCH_COLUMN);
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>AlmAnime</title>
        <link rel="stylesheet" href="../assets/css/style.css">
    </head>
    <body>
        <header>
            <h1 class="headerTittle">Edición de anime</h1>
            <?php
                echo '<a href="./anime.php?id=' . $_GET["id"] . '"><button>Volver</button></a>';
            ?>
        </header>
        <hr>
        <div class="body">
            <form action="../validations/animeUpd.php?id=<?php echo $_GET["id"] ?>" method="post" enctype="multipart/form-data">
                Titulo:  <input type="text" name="aniName" placeholder="Anime name" value="<?php echo $titulo ?>"> <br> <br>
                Descripción:<br><textarea name="desc" rows="10" cols="40" placeholder="Write the description here..."><?php echo $desc ?></textarea> <br>
                Autor:  <input type="text" name="autor" placeholder="Author name" value="<?php echo $autor ?>"> <br> 
                Demografía: <select name="demo">
                    <?php
                        require "../conection/conect.php";
                        $rows = $conn->query("SELECT * FROM almanime.demography");
                        $rows = $rows->fetchAll(PDO::FETCH_ASSOC);
                        foreach($rows as $row){
                            if($row == $demo){
                                echo '<option value="' . strtolower($row["demo"]) . '" selected>' . $row["demo"] . '</option>';
                            }else{
                                echo '<option value="' . strtolower($row["demo"]) . '">' . $row["demo"] . '</option>';
                            }
                        }
                    ?>
                </select> <br> <br>
                Genero/s: <br>
                <?php
                    require "../conection/conect.php";
                    $rows = $conn->query("SELECT * FROM almanime.genders");
                    $rows = $rows->fetchAll(PDO::FETCH_ASSOC);
                    foreach($rows as $row){
                        if(in_array($row["gender"], $genders)){
                            echo '<input type="checkbox" name="genero[]" value="' . strtolower($row["gender"]) . '" checked>' . $row["gender"] . '<br>';
                        }else{
                            echo '<input type="checkbox" name="genero[]" value="' . strtolower($row["gender"]) . '">' . $row["gender"] . '<br>';
                        }
                    }
                ?>
                Fecha de lanzamiento: <input type="date" name="date" value="<?php echo $date ?>"> <br> <br>
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