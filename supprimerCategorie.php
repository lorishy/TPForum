<?php
require_once "entete.php";

if (isset($_GET["id"]) && !empty($_GET["id"])) {
    $idCategorie = $_GET["id"];
} else {
    header("location:categorie.php");
}

if (isset($_POST["idcategorie"]) && !empty($_POST["idcategorie"])) {
    try {
        $requete = getBdd()->prepare("DELETE FROM categories WHERE id_categorie = ?");
        $requete->execute([$_POST["idcategorie"]]);

        ?>
            <div class="alert alert-success">
                La catégorie a bien été supprimée<br>
                Vous allez être redirigé vers la liste des catégories<br>
                <a href="categorie.php">Cliquez ici si vous ne souhaitez pas attendre</a>
            </div>
        <?php
header("refresh:5;categorie.php");
    } catch (Exception $e) {
        ?>
        <div class="alert alert-danger">
            Une erreur s'est produite lors de la suppression
        </div>
        <?php
}
} else {
    ?>

<p>Êtes-vous sûr de vouloir supprimer la catégorie n°<?=$idCategorie;?> ?</p>
<form method="post">
    <input type="hidden" name="idcategorie" value="<?=$idCategorie;?>"/>
    <button type="submit" class="btn btn-warning">Oui</button>
    <a href="categorie.php" class="btn btn-secondary">Annuler la suppression et retourner à la liste des catégories</a>
</form>


<?php
}
require_once "pied.php";
?>