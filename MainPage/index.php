<?php
session_start();

require "../conect.php";

if(!$_SESSION["logged"]){
    header("Location: ../loggin.php");
}
$_SESSION["error"] = '';
?>

<html>
    <head>
        <meta charset="utf-8">
        <title>AlmAnime</title>
        <script>
            function serchAnime(str) {
                if (str.length == 0) {
                    //document.getElementById("resAniSearch").innerHTML = "";
                    return;
                }else{
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("resAniSearch").innerHTML = this.responseText;
                        }
                    };
                    xmlhttp.open("GET", "aniSearch.php?q=" + str, true);
                    xmlhttp.send();
                }
            }

            function showAnimes(){
                
            }
        </script>
    </head>
    <body>
        <header>
            <div id="cntrLogo">
                <p>Logo</p>
            </div>
            <div id="cntrMenu">
                <a href="../loggin.php"><button>Cerrar sesión</button></a>
                <a href="aniRegister.php"><button>Añadir anime</button></a>
            </div>
        </header>
        <br>
        <div id="body">
            BUSCADOR: <input type="serch" name="aniSerch" placeholder="Busca un anime" onkeyup="serchAnime(this.value)"><br>
            <div class="aniCntnr" id="resAniSearch">
                <?php
                    $res = $conn->query("SELECT titulo, description, demo, img FROM almanime.animes");
                    $rows = $res->fetchAll(PDO::FETCH_ASSOC);

                    if($rows){
                        foreach($rows as $row){
                            echo '<a href="aniShow.php?id=' . urldecode($row["titulo"]) .'"><img class="imgPort" height="200px" width="300px" src="' . htmlspecialchars($row["img"]) . '"></a>';
                            echo '<p>Tírulo: ' . htmlspecialchars($row["titulo"]) . "<br> Demografía: " . htmlspecialchars($row["demo"]) . "<br> Descripción:<br>" . htmlspecialchars($row["description"]) . '</p>';
                        }
                    }else{
                        echo 'No hay animes para mostrar de momento.';
                    }
                ?>
            </div>
        </div>
    </body>
</html>