<?php
session_start();
require "../conect.php";

if(!$_SESSION["logged"]){
    header("Location: ../loggin.php");
}

$titulo = $_GET["id"];
$stmt = $conn->prepare("SELECT * FROM almanime.animes WHERE titulo = ?");
$stmt->execute([$titulo]);
$anime = $stmt->fetch(PDO::FETCH_ASSOC);

if($_SESSION["email"] != $anime["username"]){
    header("Location: aniShow.php?id=" . $_GET["id"]);
}
?>

<?php
    require "../conect.php";

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        $titulo = $_GET["id"];
        $stmt = $conn->prepare("SELECT * FROM almanime.animes WHERE titulo = ?");
        $stmt->execute([$titulo]);
        $anime = $stmt->fetch(PDO::FETCH_ASSOC);

        $title = "";
        $description = "";
        $autor = "";
        $demo = "";
        $gendersArr = "";
        $genders = "";
        $lnchdate = "";
        $filePath = "";

        print_r($anime) . "<br>";

        if(!isset($_POST["aniName"]) || $_POST["aniName"] == ""){
            $title = $anime["titulo"];
        }else{
            $title = $_POST["aniName"];
        }
        if(!isset($_POST["desc"]) || $_POST["desc"] == ""){
            $desc = $anime["description"];
        }else{
            $desc = $_POST["desc"];
        }
        if(!isset($_POST["autor"]) || $_POST["autor"] == ""){
            $autor = $anime["autor"];
        }else{
            $autor = $_POST["autor"];
        }
        if(!isset($_POST["demo"]) || $_POST["demo"] == "" || $_POST["demo"] == "-- Seleccione una demografía --"){
            $demo = $anime["demo"];
        }else{
            $demo = $_POST["demo"];
        }
        if(!isset($_POST["genero"]) || $_POST["genero"] == ""){
            $genders = $anime["genders"];
        }else{
            $gendersArr = $_POST["genero"];
        }
        if(!isset($_POST["date"]) || $_POST["date"] > date("Y-m-d")){
            $lnchdate = $anime["lnchdate"];
        }else{
            $lnchdate = $_POST["date"];
        }
        if(!isset($_FILES['img']) || $_FILES['img']['error'] !== 0){
            $filePath = $anime["img"];
        }else{
            //PROCESADO DE LA IMAGEN
            $dirRute = "img/";
            $archName = $_FILES["img"]["name"];
            $filePath = $dirRute . date("Y-m-d") . "_" . date("H-m") . "-" . $archName; //RUTA DEL ARCHIVO + EL NOMBRE QUE LLEVARÁ; ECHO DE MANERA QUE SEA MUY DIFICIL QUE SE REPITA

            if(!move_uploaded_file($_FILES["img"]["tmp_name"], $filePath)){
                $_SESSION['error'] = "La imágen no se subió correctamente ";
            }else{
                $_SESSION["filePath"] = $filePath;
            }
        }

        if($gendersArr != ""){
            foreach($gendersArr as $value){
                $genders .= $value . " ";
            }
        }

        
        print $title . " " . $desc . " " . $autor . " " . $demo . " " . $genders . " " . $lnchdate . " " . $filePath . "<br>";
        print $anime["img"] . "<br>";
        print $_FILES["img"]["name"];
        update($title, $desc, $autor, $demo, $genders, $lnchdate, $filePath);
        
        header("Location: aniShow.php?id=" . $_GET["id"]);
    }
    ?>

    <?php
    function update($title, $desc, $autor, $demo, $genders, $date, $filePath){
        require "../conect.php";
        
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $stmt = $conn->prepare("UPDATE almanime.animes SET titulo = :titulo, description = :description, autor = :autor, demo = :demo, genders = :genders, lnchdate = :lnchdate, img = :img, username = :username WHERE titulo = :id");
            $stmt->bindParam(":titulo", $title);
            $stmt->bindParam(":description", $desc);
            $stmt->bindParam(":autor", $autor);
            $stmt->bindParam(":demo", $demo);
            $stmt->bindParam(":genders", $genders);
            $stmt->bindParam(":lnchdate", $date);
            $stmt->bindParam(":img", $filePath);
            $stmt->bindParam(":username", $_SESSION["email"]);
            $stmt->bindParam(":id", $title);
            $stmt->execute();
        }
    }
    
?>