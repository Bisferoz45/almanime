<?php
session_start();

$_SESSION["error"] = '';
if(!(isset($_SESSION["logged"])) || $_SESSION["logged"] == ""){
    header("Location ./index.php");
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>AlmAnime</title>
        <link rel="stylesheet" href="../assets/css/style.css">
        <?php
            if($_SERVER['REQUEST_METHOD'] === "POST"){
                switch(true){
                    case (isset($_POST['user']) && $_POST['user'] != "") || (isset($_POST['email']) && $_POST['email'] != ""):
                        if(isset($_POST["email"]) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                            $email = $_POST['email'];
                        }else{
                            $user = userData($_SESSION["email"]);
                            $email = $user["email"];
                        }

                        if(!empty($_POST["user"])){
                            $user = $_POST["user"];
                        }else{
                            $usr = userData($_SESSION["email"]);
                            $user = $usr["user"];
                        }

                        $usr = userData($_SESSION["email"]);
                        if(updateUser($user, $email, $usr["passwd"], $usr["imgprf"], $_SESSION["email"])){
                            if($_POST["email"] != $_SESSION["email"]){
                                $_SESSION["email"] = $_POST["email"];
                                $_SESSION["user"] = $_POST["user"];
                            }
                        }else{
                            $_SESSION["error"] = "Los error al actualizar";
                        }
                    break;

                    case (isset($_POST['passwd1']) && $_POST['passwd1'] != "") && (isset($_POST['passwd2']) && $_POST['passwd2'] != ""):
                        if($_POST["passwd1"] == $_POST["passwd2"]){
                            if(isset($_POST["passwd1"]) && $_POST["passwd1"] == ""){
                                $_SESSION["error"] = 'Establezca una contraseña ';
                            }else{
                                if(strlen($_POST["passwd1"]) < 7){
                                    $_SESSION["error"] = "La contraseña no cumple con el mínimo de longitud ";
                                }
                                if(preg_match('/[A-Z]/', $_POST["passwd1"]) == 0 || preg_match('/[a-z]/', $_POST["passwd1"]) == 0){
                                    $_SESSION["error"] = "La contraseña debe tener mayúsculas y minúsculas ";
                                }
                                if(preg_match('/[0-9]/', $_POST["passwd1"]) == 0){
                                    $_SESSION["error"] = "La contraseña debe tener números ";
                                }
                                if(preg_match('/[^a-zA-Z0-9]/', $_POST["passwd1"]) == 0){
                                    $_SESSION["error"] = "La contraseña debe contener carácteres especiales ";
                                }

                                if($_SESSION["error"] == ""){
                                    $passwd = $_POST["passwd1"];
                                    $passwd = password_hash($passwd, PASSWORD_DEFAULT);
                                    $usr = userData($_SESSION["email"]);
                                    updateUser($usr["username"], $usr["email"], $passwd, $usr["imgprf"], $_SESSION["email"]);
                                }
                            }
                        }else{
                            $_SESSION["error"] = 'Las contraseñas no coinciden ';
                        }
                    break;

                    case isset($_POST["img"]) && $_POST["img"] != "":
                        $filepath = "";
                        if(!isset($_FILES['img']) || $_FILES['img']['error'] !== 0){
                            $usr = userData($_SESSION["email"]);
                            $filepath = $usr["imgprf"];
                        }else{
                            //PROCESADO DE LA IMAGEN
                            $dirRute =  "../assets/img/img_prf/";
                            $archName = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $_FILES["img"]["name"]);
                            $filepath = $dirRute . date("Y-m-d") . "_" . date("H-m") . "-" . $archName; //RUTA DEL ARCHIVO + EL NOMBRE QUE LLEVARÁ; ECHO DE MANERA QUE SEA MUY DIFICIL QUE SE REPITA
                            if(!move_uploaded_file($_FILES["img"]["tmp_name"], $filepath)){
                                $_SESSION['error'] = "La imágen no se subió correctamente ";
                            }
                        }
                        $usr = userData($_SESSION["email"]);
                        updateUser($usr["username"], $usr["email"], $usr["passwd"], $filepath, $_SESSION["email"]);
                    break;

                    default:
                        $_SESSION["error"] = "Algo salió mal en la inserción de datos";
                    break;
                }
            }
        ?>
        <script>
            function showHint(str) {
                if (str.length == 0) {
                document.getElementById("txtHint").innerHTML = "";
                return;
                }else{
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("txtHint").innerHTML = this.responseText;
                        }
                    };
                    xmlhttp.open("GET", "gethint.php?q=" + str, true);
                    xmlhttp.send();
                }
            }
        </script>
    </head>
    <body>
        <header>
            <h1 class="headerTittle">Mi perfil</h1>
            <div id="prfMenu">
                <button id="edit">Editar perfil</button>
                <button id="stats">Mostrar estadisticas</button>
            </div>
            <a href="index.php"><button>Volver</button></a>
        </header>
        <hr>
        <div class="body">
            <h1 id="prfTittle">Editar perfil</h1>
            <div id="prfEdit">
                <?php $user = userData($_SESSION["email"]) ?>
                <form class="userEditForm" accept-charset="utf-8" method="POST">
                    <h2>Cambiar nombre y correo</h2>
                    Usuario: <input type="text" name="user" placeholder="Username" value="<?php print $user["username"] ?>"> <br>
                    E-mail: <input type="email" name="email" placeholder="example@domain.ext" value="<?php echo $user["email"]?>"> <br>
                    <input type="submit" name="submit" class="button"> <br> <br>
                </form>
                <form class="userEditForm" accept-charset="utf-8" method="POST">
                    <h2>Cambiar contraseña</h2>
                    Contraseña: <input type="password" name="passwd1" placeholder="Password" onkeyup="showHint(this.value)"> <br>
                    Confirmar contraseña: <input type="password" name="passwd2" placeholder="Confirm password"> <br>
                    <article class="sugList">Suggestions: <span id="txtHint"></span></article>
                    <input type="submit" name="submit" class="button"> <br> <br>
                </form>
                <form class="userEditForm" accept-charset="utf-8" method="POST" enctype="multipart/form-data">
                    <h2>Cambiar imágen de perfíl</h2>
                    Inserte imágen de portada: <input type="file" accept="image/*" name="img" placeholder="Insert image"> <br>
                    <input type="submit" name="img" class="button"> <br> <br>
                </form>
                <?php
                    if(isset($_SESSION["error"]) && $_SESSION["error"] != ""){
                        print "ERROR: " . $_SESSION["error"];
                        $_SESSION["error"] = null;
                    }
                ?>
            </div>
            <div id="resAniSearch">
                <?php
                require "../conection/conect.php";
                $stmt = $conn->prepare("SELECT titulo, demo, img, view FROM almanime.animes WHERE user LIKE ?");
                $stmt->execute([$_SESSION["email"]]);
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($rows){
                    foreach($rows as $row){
                        echo '<a href="anime.php?id=' . urlencode($row["titulo"]) .'" id="prfRef">';
                        echo '<p class="viewText">Views: ' . $row["view"] . '</p>';
                        echo '<div class="animePrf" style="background-image: url(' . htmlspecialchars($row["img"]) . ');">';
                        echo '<p class="aniTittle">' . htmlspecialchars($row["titulo"]) . '</p>';
                        echo '<p class="aniDemo '. strtolower(htmlspecialchars($row["demo"])) .'">' . htmlspecialchars($row["demo"]) . '</p>';
                        echo '</div>';
                        echo '<p class="viewText">Rating: ' . (round(calcVotes($row["titulo"]), 2) == 0 ? "Sin votos" : round(calcVotes($row["titulo"]))."%") . '</p>';
                        echo '</a>';
                    }
                }else{
                    echo 'No has subido ningún anime.';
                }
            ?>
            </div>
        </div>
    </body>
    <script src="../assets/scripts/prf_states.js"></script>
</html>

<?php
    function calcVotes($id){
        require "../conection/conect.php";
        $stmt = $conn->prepare("SELECT a.titulo, COUNT(v.vote) as vt, (((SELECT COUNT(vote) FROM almanime.votes WHERE vote = 1) / COUNT(v.vote)) * 100) as prcj_votos FROM almanime.animes a LEFT JOIN almanime.votes v ON a.titulo = v.titulo WHERE a.titulo LIKE ? GROUP BY a.titulo");
        $stmt->execute(["$id"]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if($res["vt"] == 0){
            return 0;
        }else{
            return $res["prcj_votos"];
        }
    }

    function userData($user){
        require "../conection/conect.php";
        $stms = $conn->prepare("SELECT * FROM almanime.users WHERE email LIKE ?");
        $stms->execute([$user]);
        return $stms->fetch(PDO::FETCH_ASSOC);
    }

    function updateUser($user, $email, $passwd, $imgprf, $emailAnt){
        try{
            require "../conection/conect.php";
            $stmt = $conn->prepare("UPDATE almanime.users SET username = ?, email = ?, passwd = ?, imgprf = ? WHERE email = ?");
            $stmt->execute([$user, $email, $passwd, $imgprf, $emailAnt]);
        }catch(PDOException $e){
            $_SESSION["error"] = "Error durante la actualización: " . $e->getMessage();
            return false;
        }
        return true;
    }
?>