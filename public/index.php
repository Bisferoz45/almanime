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
                    xmlhttp.open("GET", "animeSrc.php?q=" + str, true);
                    xmlhttp.send();
                }else{
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("resAniSearch").innerHTML = this.responseText;
                        }
                    };
                    xmlhttp.open("GET", "animeSrc.php?q=" + str, true);
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
                if(!(isset($_SESSION["logged"])) || $_SESSION["logged"] == false){
                    echo "<a href='./loggin.php'><button>Log in</button></a>";
                    echo "<a href='./register.php'><button>Register</button></a>";
                }else{
                    require "../conection/conect.php";
                    $row = $conn->prepare("SELECT imgprf FROM almanime.users WHERE email LIKE ?");
                    $row->execute([$_SESSION["email"]]);
                    $row = $row->fetch(PDO::FETCH_ASSOC);

                    echo '<div id="profile">';
                    echo '<button id="img_prf" style="background-image: url(' . $row["imgprf"] . ')"></button>';
                    echo '<div id="prf_menu">';
                    echo '<form method="post">';
                    echo '<button type="submit" name="edit">Editar perfil</button>';
                    echo '<button type="submit" name="logout">Cerrar sesión</button>';
                    echo '</form>';
                    echo '</div>';
                    echo "</div>";
                }
                echo '</div>';
                ?>

                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    switch(true){
                        case isset($_POST['logout']) && isset($_POST['logout']) != "":
                            session_unset();
                            session_destroy();
                            
                            $_SESSION["logged"] = false;
                            header("Location: " . $_SERVER['PHP_SELF']);
                        break;

                        case isset($_POST['edit']) && isset($_POST['edit']) != "":
                            header("Location: ./editPrf.php");
                        break;

                        default:
                            header("Location: " . $_SERVER['PHP_SELF']);
                        break;
                    }
                }
                ?>
            </div>
        </header>
        <hr>
        <div class="body">
            <?php
            if(isset($_SESSION["logged"]) && $_SESSION["logged"] == true){
                echo '<a href="./animeReg.php"><button>Añadir anime</button></a><br>';
            }
            ?>
            BUSCADOR: <input type="serch" name="aniSerch" placeholder="Busca un anime" onkeyup="serchAnime(this.value)"><br>
            <div id="resAniSearch">
                <?php
                    showAnimesIndex();

                    function showAnimesIndex(){
                        require "../conection/conect.php";
                        $res = $conn->query("SELECT titulo, demo, img FROM almanime.animes");
                        $rows = $res->fetchAll(PDO::FETCH_ASSOC);
                        if($rows){
                            foreach($rows as $row){
                                echo '<a href="anime.php?id=' . urlencode($row["titulo"]) .'">';
                                echo '<div class="anime" style="background-image: url(' . htmlspecialchars($row["img"]) . ');">';
                                echo '<p class="aniTittle">' . htmlspecialchars($row["titulo"]) . '</p>';
                                echo '<p class="aniDemo '. strtolower(htmlspecialchars($row["demo"])) .'">' . htmlspecialchars($row["demo"]) . '</p>';
                                echo '</div></a>';
                            }
                        }else{
                            echo 'No hay animes para mostrar de momento.';
                        }
                    }
                ?>
            </div>
        </div>
        <script src="../assets/scripts/prf_menu.js"></script>
    </body>
</html>