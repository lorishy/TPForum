<?php
    require_once "entete.php";

?>
<?php

    $requete = getBdd()->prepare('SELECT * FROM sujets INNER JOIN utilisateurs ON sujets.id_createur=utilisateurs.id LEFT JOIN categories USING (id_categorie) WHERE id_categorie = ? ORDER BY id_sujet DESC');
    $requete->execute([$_GET["id"]]);
    $sujets = $requete->fetchAll();
?>
  <div class="container mt-2">
    <main class="main">
      <?php foreach($sujets as $s){ 
        if(empty($s['nom'])) {
        $s["nom"] = "Aucune";
      }
      ?>
      <article class="card">
        <header class="card-header">
        <?php
         if(empty($s["avatar"])){
         ?>
         <img src="avatar.png" width="90px" height="90px"style="border-radius : 25%">
         <?php
         } else {
         ?>
         <img src="utilisateurs/avatars/<?=$s["avatar"]?>" width="90px" height="90px"style="border-radius : 25%">
         <?php } ?>
          <div class="info">
            <h2 class="card-title">Pseudo : <span style="color : <?=couleur($s['idrole'])?>"><?=$s["pseudo"]?></span></h2>
            <h2 class="card-title">Categorie : <?=$s["nom"]?></h2>
            <h2 class="card-title">Titre : <?=$s["titre"]?></h2>
            <div class="card-date"><?=$s["f_date"]?></div>
        </div>
        </header>
        <div class="card-body">
          <h2 class="card-title">Contenu :</h2>
          <p><?= $s["contenu"]?></p><hr>
          <a href="sujet.php?id=<?=$s["id_sujet"]?>">Voir le sujet</a>
        </div>
      </article>
      <?php } ?>
    </main>
  </div>
<?php
    require_once "pied.php";
?>