<?php
session_start();

require "../conect.php";

if(!$_SESSION["logged"]){
    header("Location: ../loggin.php");
}
?>

<html>
    <head>
        <title>AlmAnime</title>
        <link rel="stylesheet" href="style/style.css">
    </head>
    <body>
        <header>
            <div id="cntrLogo">
                <p>Logo</p>
            </div>
            <div id="cntrMenu">
                <a href="aniRegister.php"><button>Añadir libro</button></a>
            </div>
        </header>
        <br>
        <div id="body">
            <?php
                $res = $conn->query("SELECT titulo, description, demo, img FROM almanime.animes");
                $rows = $res->fetchAll(PDO::FETCH_ASSOC);

                if($rows){
                    foreach($rows as $row){
                        echo '<div class="aniCntnr">';
                        echo '<a href="aniShow.php?id=' . urldecode($row["titulo"]) .'"><img class="imgPort" height="200px" width="300px" src="' . htmlspecialchars($row["img"]) . '"></a>';
                        echo '<p>Tírulo: ' . htmlspecialchars($row["titulo"]) . "<br> Demografía: " . htmlspecialchars($row["demo"]) . "<br> Descripción:<br>" . htmlspecialchars($row["description"]) . '</p>';
                        echo '</div>';
                    }
                }else{
                    echo 'No hay animes para mostrar de momento.';
                }
            ?>
        </div>
    </body>
</html>