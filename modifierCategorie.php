<?php
require_once "entete.php";
$erreurs = 0;

if (isset($_GET["id"]) && !empty($_GET["id"])) {
    $idCategorie = $_GET["id"];
} else {
    header("location:categorie.php");
}

try {
    // récupérer les infos de la catégorie
    $requete = getBdd()->prepare("SELECT * FROM categories WHERE id_categorie = ?");
    $requete->execute([$idCategorie]);
    $categorie = $requete->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    // gérer les erreurs éventuelles
    $erreurs++;
    ?>
        <div class="alert alert-danger">
            Erreur : la catégorie n'a pas pu être récupérée.<br>
            Vous allez être redirigé vers la liste des catégories<br>
            <a href="categorie.php">Cliquez ici si vous ne voulez pas attendre</a>
        </div>
    <?php
header("refresh:5;categorie.php");

}
if ($erreurs === 0) {
    if (isset($_POST["nom"]) && !empty($_POST["nom"])) {
        try {
            $requete = getBdd()->prepare("UPDATE categories SET nom = ? WHERE id_categorie = ?");
            $requete->execute([$_POST["nom"], $idCategorie]);
            ?>
            <div class="alert alert-success">
            La catégorie a bien été modifiée.<br>
            Vous allez être redirigé vers la liste des catégories<br>
            <a href="categorie.php">Cliquez ici si vous ne voulez pas attendre</a>
        </div>
            <?php
header("refresh:5;categorie.php");

        } catch (Exception $e) {
            ?>
            <div class="alert alert-danger">
                Une erreur s'est produite lors de la modification de la catégorie
            </div>
            <?php
}
    } else {
        ?>
     
<?php
}
}
require_once "pied.php";
?>