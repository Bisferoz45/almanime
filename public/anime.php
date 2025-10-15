<?php
session_start();

if(!$_SESSION["logged"]){
    header("Location: ../loggin.php");
}
?>

<?php
    if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST["del"])){
        del($_GET["id"]);
        header("Location: index.php");
    }
?>

<html>
    <head>
        <title>AlmAnime</title>
    </head>
    <body>
        <header>
            <?php
                if(isset($_GET["id"])){
                    $anime = animeData($_GET["id"]);

                    if($anime["username"] == $_SESSION["email"]){
                        echo '<a href="aniUpdate.php?id=' . urlencode($_GET["id"]) . '"><button>Editar anime</button></a>';
                        echo '<br><form action="" method="post">';
                        echo '<input type="submit" name="del" value="Borrar">';
                        echo '</form>';
                    }
                }
                echo '<a href="index.php"><button>Volver</button></a>';
            ?>
        </header>
        <body>
            <?php
                if(!isset($_GET["id"])){
                    echo "No se seleccionó ningún anime.";
                }else{
                    $anime = animeData($_GET["id"]);

                    if($anime){
                        echo "<h1>" . htmlspecialchars($anime["titulo"]) . "</h1>";
                        echo "<img src='" . htmlspecialchars($anime["img"]) . "'>";
                        echo "<p>Descripción:<br>" . htmlspecialchars($anime["description"]) . "</p>";
                        echo "<p>Demografía: " . htmlspecialchars($anime["demo"]) . "</p>";
                        echo "<p>Generos:<br>" . htmlspecialchars($anime["genders"]) . "</p>";
                        echo "<p>Fecha de lanzamiento: ". htmlspecialchars($anime["lnchdate"]) . "</p>";
                    }else{
                        echo "No se encontró ningún anime.";
                    }
                }
            ?>
        </body>
    </body>
</html>

<?php
    function animeData($id){
        require "../conect.php";
        
        $titulo = $_GET["id"];
        $stmt = $conn->prepare("SELECT * FROM almanime.animes WHERE titulo = ?");
        $stmt->execute([$titulo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function del($id){
        require "../conect.php";
        
        $stmt = $conn->prepare("DELETE FROM almanime.animes WHERE titulo = ?");
        $stmt->execute([$id]);
    }
?>

