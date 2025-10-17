<?php
session_start();
require "../conection/conect.php";
    
// get the q parameter from URL
$q = clearSentence( $_REQUEST["q"]);

if($q !== ""){
    $res = $conn->prepare("SELECT titulo, demo, img FROM almanime.animes WHERE titulo LIKE ?");
    $res->execute(["$q%"]);
    $rows = $res->fetchAll(PDO::FETCH_ASSOC);
    if($rows){
        foreach($rows as $row){ 
            echo '<a href="anime.php?id=' . urlencode($row["titulo"]) .'">';
            echo '<div class="anime" style="background-image: url(' . htmlspecialchars($row["img"]) . ');">';
            echo '<p class="aniTittle">' . htmlspecialchars($row["titulo"]) . '</p>';
            echo '<p class="aniDemo '. strtolower(htmlspecialchars($row["demo"])) .'">' . htmlspecialchars($row["demo"]) . '</p>';
            echo '</div></a>';
        }
    }
}else{
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

function clearSentence($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>