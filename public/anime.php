<?php
session_start();
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
        <link rel="stylesheet" href="../assets/css/style.css">
    </head>
    <body>
        <header>
            <?php
                if(isset($_GET["id"])){
                    $anime = animeData($_GET["id"]);
                    echo '<h1 class="headerTittle">Anime Data</h1>';
                    if(isset($_SESSION["logged"]) && $anime["user"] == $_SESSION["email"]){
                        echo '<div id="animeUserOpt">';
                        echo '<a href="editAnm.php?id=' . urlencode($_GET["id"]) . '"><button>Editar anime</button></a>';
                        echo '<br><form action="" method="post">';
                        echo '<input type="submit" name="del" value="Borrar" class="button">';
                        echo '</form>';
                        echo '</div">';
                    }
                }
                echo '<a href="index.php"><button>Volver</button></a>';
            ?>
            <?php
                require "../conection/conect.php";
                if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION["logged"]) && $_SESSION["logged"] == true){
                    $stmt = $conn->prepare('SELECT * FROM almanime.votes WHERE titulo LIKE ? AND user LIKE ?');
                    $stmt->execute([$_GET['id'], $_SESSION["email"]]);
                    if($stmt->rowCount() == 0){
                        switch(true){
                            case isset($_POST['like']) && isset($_POST['like']) != "":
                                $stmt = $conn->prepare("INSERT INTO almanime.votes VALUE (?, ?, ?)");
                                $stmt->execute([$_GET["id"], $_SESSION["email"], true]);
                            break;

                            case isset($_POST['dislike']) && isset($_POST['dislike']) != "":
                                $stmt = $conn->prepare("INSERT INTO almanime.votes VALUE (?, ?, ?)");
                                $stmt->execute([$_GET["id"], $_SESSION["email"], false]);
                            break;
                        }    
                    }
                }
            ?>
        </header>
        <hr>
        <body>
            <div class="body">
                <?php
                    if(!isset($_GET["id"])){
                        echo "No se seleccionó ningún anime.";
                    }else{
                        $anime = animeData($_GET["id"]);

                        if($anime){
                            echo '<h1>' . htmlspecialchars($anime["titulo"]) . '</h1>';
                            echo '<div id="animeDataMenu" style="background-image: url(' . htmlspecialchars($anime["img"]) . ')">';
                            echo '<p class="rating">Le gusta al: '. round(calcVotes($_GET["id"]), 2) . '%</p>';
                            echo '<form method="post"><button name="like" value"like" id="like">Like</button><button name="dislike" value"dislike" id="dislike">Dislike</button></form>';
                            echo '</div>';
                            echo "<p>Descripción:<br>" . htmlspecialchars($anime["description"]) . "</p>";
                            echo "<p>Demografía: " . htmlspecialchars($anime["demo"]) . "</p>";
                            echo "<p>Generos: " . htmlspecialchars(getGenders($_GET["id"])) . "</p>";
                            echo "<p>Fecha de lanzamiento: ". htmlspecialchars($anime["lnchdate"]) . "</p>";
                        }else{
                            echo "No se encontró ningún anime.";
                        }
                    }
                ?>
            </div>
        </body>
    </body>
</html>

<?php
    function animeData($id){
        require "../conection/conect.php";
        
        $titulo = $_GET["id"];
        $stmt = $conn->prepare("SELECT * FROM almanime.animes WHERE titulo = ?");
        $stmt->execute([$titulo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function del($id){
        require "../conection/conect.php";
        
        $stmt = $conn->prepare("DELETE FROM almanime.animes WHERE titulo = ?");
        $stmt->execute([$id]);
    }

    function getGenders($id){
        require "../conection/conect.php";
        $genders = "";
        $stmt = $conn->prepare("SELECT titulo, GROUP_CONCAT(gender SEPARATOR ', ') AS generos FROM almanime.anigender WHERE titulo LIKE ? GROUP BY titulo");
        $stmt->execute([$id]);
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $gender){
            $genders .= $gender["generos"];
        }
        return $genders;
    }

    function calcVotes($id){
        require "../conection/conect.php";
        $stmt = $conn->prepare("SELECT a.titulo, COUNT(v.vote) as vt, (((SELECT COUNT(vote) FROM almanime.votes WHERE vote = 1) / COUNT(v.vote)) * 100) as prcj_votos FROM almanime.animes a LEFT JOIN almanime.votes v ON a.titulo = v.titulo WHERE a.titulo LIKE ? GROUP BY a.titulo");
        $stmt->execute(["$id"]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if($res["vt"] == 0){
            return "No hay votaciónes de usuarios";
        }else{
            return $res["prcj_votos"];
        }

    }
?>

