<?php require_once "entete.php";?>

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
            foreach($req as $r){ ?>
        <tr>
            <td>
                <?= $r['nom'] ?>
                <span style="float:right">
                <a href="modifierCategorie.php?id=<?=$r["id_categorie"];?>" class="btn btn-warning btn-sm">Modifier</a>
                <a href="supprimerCategorie.php?id=<?=$r["id_categorie"];?>" class="btn btn-danger btn-sm">Supprimer</a>
            </td>
        </tr>
        <?php
        }
        ?>
        </table>
    </div>
</div>

<?php require_once "pied.php";?>