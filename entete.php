<?php
require_once "mesFonctions.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<header class="topbar">
    <a href="index.php" class="topbar-logo">Mon Forum</a>
    <nav class="topbar-nav">
        <a href="index.php">Accueil</a>
        <?php if (isset($_SESSION["mail"]) && !empty($_SESSION["mail"])) {?>
        <a href="profil.php">Profil</a>
        <?php } else { ?><a href="connexion.php">Profil</a><?php }?>
        <?php if(isset($_SESSION["mail"]) && !empty($_SESSION["mail"])) {?>
        <a href="ajoutSujet.php">Ajouter un Sujet</a>
        <?php } else { ?><a href="connexion.php">Ajouter un Sujet</a><?php }?>
        <?php if (isset($_SESSION["idrole"]) && !empty($_SESSION["idrole"])) {
        if($_SESSION['idrole'] == 2) {
        ?><a href="ajoutCategorie.php">Ajouter une Catégorie</a>
        <a href="categorie.php">Catégories<?php } ?>
        <a href="deconnexion.php">Déconnexion</a>
        <?php } else { ?><a href="inscription.php">Inscription</a>
        <a href="connexion.php">Connexion</a>
        <?php }?>
    </nav>
</header>