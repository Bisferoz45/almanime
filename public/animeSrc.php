<?php
session_start();
require "../conect.php";
    
// get the q parameter from URL
$q = clearSentence( $_REQUEST["q"]);

if($q !== ""){
    $rows = $conn->prepare("SELECT * FROM almanime.animes WHERE titulo LIKE ?");
    $rows->execute(["$q%"]);
    $rows = $rows->fetchAll(PDO::FETCH_ASSOC);
    if($rows){
        foreach($rows as $row){ 
            echo '<a href="aniShow.php?id=' . urldecode($row["titulo"]) .'"><img class="imgPort" height="200px" width="300px" src="' . htmlspecialchars($row["img"]) . '"></a>';
            echo '<p>Tírulo: ' . htmlspecialchars($row["titulo"]) . "<br> Demografía: " . htmlspecialchars($row["demo"]) . "<br> Descripción:<br>" . htmlspecialchars($row["description"]) . '</p>';
        }
    }
}else{
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
}

function clearSentence($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>