<?php
session_start();
require "../conection/conect.php";
$_SESSION["error"] = "";

if(!$_SESSION["logged"]){
    header("Location: ../public/index.php");
}

$titulo = $_GET["id"];
$stmt = $conn->prepare("SELECT * FROM almanime.animes WHERE titulo = ?");
$stmt->execute([$titulo]);
$anime = $stmt->fetch(PDO::FETCH_ASSOC);

if($_SESSION["email"] != $anime["user"]){
    header("Location: ../public/anime.php?id=" . $_GET["id"]);
}
?>

<?php
    require "../conection/conect.php";

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        $tiAnt = $_GET["id"];
        $stmt = $conn->prepare("SELECT * FROM almanime.animes WHERE titulo = ?");
        $stmt->execute([$tiAnt]);
        $anime = $stmt->fetch(PDO::FETCH_ASSOC);

        if($_POST["aniName"] !== $anime["titulo"] && $_POST["aniName"] != ""){
            $titulo = $_POST["aniName"];   
        }else{
            $titulo = $anime["titulo"];
        }

        if($_POST["desc"] !== $anime["description"] && $_POST["desc"] != ""){
            $desc = $_POST["desc"];
        }else{
            $desc = $anime["description"];
        }

        if($_POST["autor"] !== $anime["autor"] && $_POST["autor"] != ""){
            $autor = $_POST["autor"];
        }else{
            $autor = $anime["autor"];
        }

        if($_POST["demo"] !== $anime["demo"] && $_POST["demo"] != ""){
            $demo = $_POST["demo"];
        }else{
            $demo = $anime["demo"];
        }

        if($_POST["date"] !== $anime["lnchdate"] && $_POST["date"] != "" && $_POST["date"] <= date("Y-m-d")){
            $date = $_POST["date"];
        }else{
            $date = $anime["lnchdate"];
        }

        if(!empty($_POST["genero"]) && count($_POST["genero"]) > 0){
            $genders = $_POST["genero"];
        }else{
            $stmt = $conn->prepare("SELECT gender FROM almanime.anigender WHERE titulo LIKE ?");
            $stmt->execute([$titulo]);
            foreach($stmt->fetchAll(PDO::FETCH_COLUMN) as $gender){
                $genders[] = $gender;
            }
        }

        if(!isset($_FILES['img']) || $_FILES['img']['error'] !== 0){
            $filePath = $anime["img"];
        }else{
            //PROCESADO DE LA IMAGEN
            if(!unlink($anime["img"])){//SUPESTAMENTE BORRA LA IMÁGEN
                $_SESSION["error"] = "No se borró la imágen ";
            }else{
                $dirRute = "../assets/img/img_anm/";
                $archName = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $_FILES["img"]["name"]);
                $filePath = $dirRute . date("Y-m-d") . "_" . date("H-m") . "-" . $archName; //RUTA DEL ARCHIVO + EL NOMBRE QUE LLEVARÁ; ECHO DE MANERA QUE SEA MUY DIFICIL QUE SE REPITA

                if(!move_uploaded_file($_FILES["img"]["tmp_name"], $filePath)){
                    $_SESSION['error'] .= "La imágen no se subió correctamente ";
                }
            }
        }

        if($_SESSION["error"] == ""){
            if(!update($titulo, $desc, $autor, $demo, $date, $filePath, $genders, $anime["titulo"])){
                $_SESSION["error"] .= ": Error al actualizar el anime.";
            }else{
                echo "Salió todo bien";
            }
        }

        if($_SESSION["error"] == ""){
            header("Location: ../public/anime.php?id=" . $titulo);
            exit;
        }else{
            header("Location: ../public/animeReg.php?id=" . $_GET["id"]);
            exit;
        }
    }
?>

    <?php
    function update($titulo, $desc, $autor, $demo, $date, $filePath, $genders, $titAnt){
        try {
            require "../conection/conect.php";
            $conn->beginTransaction();
            
            // ACTUALIZAR ANIME
            $stmt = $conn->prepare("UPDATE almanime.animes SET titulo = ?, description = ?, autor = ?, demo = ?, lnchdate = ?, img = ? WHERE titulo = ?");
            $stmt->execute([$titulo, $desc, $autor, $demo, $date, $filePath, $titAnt]);

            // ELIMINAR GÉNEROS
            $stmt = $conn->prepare("DELETE FROM almanime.anigender WHERE titulo = ?");
            $stmt->execute([$titulo]);

            // INSERTAR NUEVOS GÉNEROS
            $stmt = $conn->prepare("INSERT INTO almanime.anigender (titulo, gender) VALUES (?, ?)");
            foreach ($genders as $gender) {
                $stmt->execute([$titulo, $gender]);
            }
        
            $conn->commit();
            return true;
        
        } catch (PDOException $e) {
            $conn->rollBack();
            $_SESSION["error"] = 'Error al actualizar el anime o sus géneros -> ' . $e->getMessage();
            return false;
        }
    }
?>