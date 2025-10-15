<?php
session_start();
// get the q parameter from URL
$q = $_REQUEST["q"];

$hint = '<ul>';

// lookup all hints from array if $q is different from ""
if ($q !== "") {
    if(preg_match('/[A-Z]/', $q) != 0){
        $hint .= '<li><p style="color: green">Introduzca mayúsculas</p></li>';
    }else{
        $hint .= '<li><p style="color: red">Introduzca mayúsculas</p></li>';
    }
    if(preg_match('/[a-z]/', $q) != 0){
        $hint .= '<li><p style="color: green">Introduzca minúsculas</p></li>';
    }else{
        $hint .= '<li><p style="color: red">Introduzca minúsculas</p></li>';
    }
    if(preg_match('/[0-9]/', $q) != 0){
        $hint .= '<li><p style="color: green">Introduzca mínimo un número </p></li>';
    }else{
        $hint .= '<li><p style="color: red">Introduzca mínimo un número </p></li>';
    }
    if(preg_match('/[^a-zA-Z0-9]/', $q) != 0){
        $hint .= '<li><p style="color: green">Introduzca carácteres especiales</p></li>';
    }else{
        $hint .= '<li><p style="color: red">Introduzca carácteres especiales</p></li>';
    }
    if(strlen($q) >= 8){
        $hint .= '<li><p style="color: green">La contraseña debe tener 8 o más carácteres </p></li>';
    }else{
        $hint .= '<li><p style="color: red">La contraseña debe tener 8 o más carácteres </p></li>';
    }
}
$hint .= "</ul>";
// Output "no suggestion" if no hint was found or output correct values
echo $hint === "" ? "no suggestion" : $hint;
?>