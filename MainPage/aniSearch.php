<?php
session_start();
require "../conect.php";
    
// get the q parameter from URL
$q = clearSentence( $_REQUEST["q"]);

echo $q . "<br>";

if($q !== ""){
    $res = $conn->prepare("SELECT titulo, description, demo, img FROM almanime.animes WHERE titulo LIKE ?");
    echo print_r($res);
    $res->execute([$q]);
    $res->fetchAll(PDO::FETCH_ASSOC);
    echo print_r($res);

}else{
    $res = $conn->query("SELECT titulo, description, demo, img FROM almanime.animes");
    $rows = $res->fetchAll(PDO::FETCH_ASSOC);
    if($rows){
        foreach($rows as $row){
            echo '<a href="aniShow.php?id=' . urldecode($row["titulo"]) .'"><img class="imgPort" height="200px" width="300px" src="' . htmlspecialchars($row["img"]) . '"></a>';
            echo '<p>Tírulo: ' . htmlspecialchars($row["titulo"]) . "<br> Demografía: " . htmlspecialchars($row["demo"]) . "<br> Descripción:<br>" . htmlspecialchars($row["description"]) . '</p>';
        }
    }
}


function clearSentence($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>