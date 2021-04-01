<?php
session_start();


    function getBdd() {
        return new PDO('mysql:host=localhost;dbname=forum;charset=UTF8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }

    function gererGuillemets($string)
{
    return trim(htmlspecialchars($string, ENT_QUOTES, 'UTF-8', false));
}

    function couleur($idrole) {
        if ($idrole == 2) {
            return "red";
        } else if($idrole == 3) {
            return "blue";
        } else {
            return "black";
        }
    }
?>