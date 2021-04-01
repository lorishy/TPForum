<?php
    require_once "entete.php"
?>

<?php
        $req = getBdd()->prepare('SELECT * FROM messages INNER JOIN sujets USING(id_sujet) WHERE id_sujet = ?');
        $req->execute([$_GET["id"]]);
        $messages = $req->fetchAll();
    
        $requete = getBdd()->prepare('SELECT * FROM sujets INNER JOIN utilisateurs ON sujets.id_createur=utilisateurs.id LEFT JOIN categories USING (id_categorie) WHERE id_sujet = ? ORDER BY id_sujet');
        $requete->execute([$_GET["id"]]);
        $sujets = $requete->fetch();

        if(isset($_SESSION["id"]) && !empty($_SESSION["id"])) {
        $requete = getBdd()->prepare('SELECT COUNT(*) AS compteur FROM moderation WHERE id_categorie = ? AND id_utilisateur = ?');
        $requete->execute([$sujets["id_categorie"], $_SESSION["id"]]);
        $estModo = $requete->fetch()["compteur"];
        }
    ?>


  <div class="container mt-2">
    <main class="main">
    <?php
        if(empty($sujets['nom'])) {
        $sujets["nom"] = "Aucune";
      }
      ?>
      <article class="card">
        <header class="card-header">
        <?php
         if(empty($sujets["avatar"])){
         ?>
         <img src="avatar.png" width="90px" height="90px"style="border-radius : 25%">
         <?php
         } else {
         ?>
         <img src="utilisateurs/avatars/<?=$sujets["avatar"]?>" width="90px" height="90px"style="border-radius : 25%">
         <?php } ?>
          <div class="info">
          <h2 class="card-title">Pseudo : <span style="color : <?=couleur($sujets['idrole'])?>"><?=$sujets["pseudo"]?></span></h2>
            <h2 class="card-title">Categorie : <?=$sujets["nom"]?></h2>
            <h2 class="card-title">Titre : <?=$sujets["titre"]?></h2>
            <div class="card-date"><?=$sujets["f_date"]?></div>
        </div>
        </header>
        <div class="card-body">
          <h2 class="card-title">Contenu :</h2>
          <p><?= $sujets["contenu"]?></p><hr>
          <a href="repondreSujet.php?id=<?=$sujets["id_sujet"]?>">Répondre</a>
        </div>
        <?php foreach ($messages as $message) { ?>
        <div class="card-body">
            <hr>
          <p><?= $message["contenu_message"]?>
            <?php if(isset($_SESSION["id"]) && !empty($_SESSION["id"])) {
                      if ($_SESSION["idrole"] == 3 && $estModo >= 1 || $_SESSION["idrole"] == 2) { ?>
                      <span style="float:right">
                            <a href="modifierMessage.php?id=<?=$message["id_message"];?>" class="btn btn-warning btn-sm">Modifier</a>
                            <a href="supprimerMessage.php?id=<?=$message["id_message"];?>" class="btn btn-danger btn-sm">Supprimer</a>
                            <?php }
                } ?>
          </p>
        </div>
        <?php } ?>
      </article>
    </main>
  </div>