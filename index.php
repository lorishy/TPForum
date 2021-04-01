<?php
    require_once "entete.php";

?>

<?php
// Si je suis admin ou membre = mesage de bienvenue
if (isset($_SESSION["idrole"]) && !empty($_SESSION["idrole"])) {
  if($_SESSION['idrole'] == 2) {
    ?>
    <p class="bjr">Bonjour <?=$_SESSION["pseudo"] . " ! Vous êtes Admin !";?></p>
    <?php
  } else if($_SESSION['idrole'] == 3) {
    ?>
    <p class="bjr">Bonjour <?=$_SESSION["pseudo"] . " ! Vous êtes Modérateur !";?></p>
    <?php 
  } else { 
    ?>
    <p class="bjr">Bonjour <?=$_SESSION["pseudo"] . " ! Vous êtes membre !";?> </p>
    <?php
  }
}
?>

<?php

$req = getBdd()->query("SELECT * FROM categories ORDER BY nom DESC");
$req = $req->fetchAll();

?>
<div class="container mt-5">
    <div class="table-responsive">
        <table class="table table-striped">
        <tr>
            <th>Catégories :</th>
        </tr>
        <?php
            // On utilise la variable $r
            foreach($req as $r){ ?>
        <tr>
            <td>
                <a href="toutSujet.php?id=<?=$r["id_categorie"]?>"><?= $r['nom'] ?></a>
            </td>
        </tr>
        <?php
        }
        ?>
        </table>
    </div>
</div>


<?php
    require_once "pied.php";
?>