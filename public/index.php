<?php
session_start();

require "../conection/conect.php";
$_SESSION["error"] = '';
?>

<html>
    <head>
        <meta charset="utf-8">
        <title>AlmAnime</title>
        <link rel="stylesheet" href="../assets/css/style.css">
        <script>
            function serchAnime(str) {
                if (str.length == 0) {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("resAniSearch").innerHTML = this.responseText;
                        }
                    };
                    xmlhttp.open("GET", "aniSearch.php?q=" + str, true);
                    xmlhttp.send();
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
        </script>
    </head>
    <body>
        <header>
            <div id="cntrLogo">
                <p>Logo</p>
            </div>
            <div class="cntrMenu">
                <?php
                echo '<div id="userOpt">';
                if(!(isset($_SESSION["logged"])) || $_SESSION["logged"] == ""){
                    echo "<a href='./loggin.php'><button>Log in</button></a>";
                    echo "<a href='./register.php'><button>Register</button></a>";
                }else{
                    echo '<form method="post"><button type="submit" name="logout">Cerrar sesión</button></form>';
                }
                echo '</div>';
                ?>

                <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
                    // destruye la sesión
                    session_unset();
                    session_destroy();

                    // redirige antes de enviar HTML
                    $_SESSION["logged"] = "";
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit();
                }
                ?>
            </div>
        </header>
        <hr>
        <div class="body">
            <a href="aniRegister.php"><button>Añadir anime</button></a><br>
            BUSCADOR: <input type="serch" name="aniSerch" placeholder="Busca un anime" onkeyup="serchAnime(this.value)"><br>
            <div class="aniCntnr" id="resAniSearch">
                <?php
                    showAnimesIndex();

                    function showAnimesIndex(){
                        require "../conection/conect.php";
                        $res = $conn->query("SELECT titulo, demo, img FROM almanime.animes");
                        $rows = $res->fetchAll(PDO::FETCH_ASSOC);
                        if($rows){
                            foreach($rows as $row){
                                echo '<a href="aniShow.php?id=' . urldecode($row["titulo"]) .'">';
                                echo '<div class="anime" style="background-image: url(' . htmlspecialchars($row["img"]) . ');';
                                echo '<p class="aniTittle">' . htmlspecialchars($row["titulo"]) . '</p><p class ="aniDemo">' . htmlspecialchars($row["demo"]) . '</p>';
                                echo '</div></a>';
                            }
                        }else{
                            echo 'No hay animes para mostrar de momento.';
                        }
                    }
                ?>
            </div>
        </div>
    </body>
</html>