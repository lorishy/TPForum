<?php
require_once "entete.php";

if (isset($_POST["nom"]) && !empty($_POST["nom"])) {
    try {
        $requete = getBdd()->prepare("INSERT INTO categories(nom) VALUES(?)");
        $requete->execute([$_POST["nom"]]);

        ?>
        <div class="alert alert-success">
            La catégorie a bien été ajoutée<br>
            Vous allez être redirigé vers l'accueil<br>
            <a href="index.php">Cliquez ici si vous ne voulez pas attendre</a>
        </div>

        <?php
header("refresh:5;index.php");
    } catch (Exception $e) {
        ?>
        <div class="alert alert-danger">
            Erreur : la catégorie n'a pas été ajoutée
        </div>

        <?php
}
}
?>

    <h1>Ajout d'une nouvelle catégorie</h1>
    <form method="post">
        <div class="form-group">
            <label for="nom">Nom de la catégorie :</label><br>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="nom" id="libelle" placeholder="Saisissez le nom de la catégorie"/>
        </div>
        <div class="form-group text-center">
            <input type="submit" class="btn btn-primary" value="Ajouter la catégorie">
        </div>
    </form>

<?php
require_once "pied.php";
