<?php
    require_once "entete.php"
?>
<?php

$requete = getBdd()->prepare("SELECT * FROM categories");
    $requete->execute();

    $categories = $requete->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST['submit'])){
   if(isset($_POST['titre']) && isset($_POST['contenu']) && isset($_POST['categories'])) {

      // Sécurisation des variables
      $sujet = $_POST['titre'];
      $contenu = $_POST['contenu'];
      $idcategories = $_POST['categories'];
      if (!empty($sujet) AND !empty($contenu) AND !empty($idcategories)) {

         // VERIFICATION
         if (strlen($sujet) <= 70 ) {
            // Insertition en BBD
            $requete = getBdd()->prepare('INSERT INTO sujets (id_createur, titre, contenu, f_date,id_categorie) VALUES(?,?,?,NOW(),?)');
            $requete->execute(array($_SESSION["id"], $sujet, $contenu, $idcategories));
         } else {
            $erreurTitre = "Le titre ne doit pas dépasser 70 caractères"; 
         }
      } else {
         $erreurts = "Veuillez compléter tous les champs";
      }
   }
}
?>
<div class="mt-2">
<form method="POST">
   <table>
      <tr>
         <th colspan="2">Nouveau Sujet</th>
      </tr>
      <tr style="margin-bottom :1rem;">
         <td>Titre :</td>
        </tr>
        <tr>
         <td><input type="text" name="titre" size="70" maxlength="70" /></td>
      </tr>
      <tr>
         <td>Catégorie :</td>
         <td>
            <select name="categories" id="categorie" class="form-control">
                <?php
                     foreach ($categories as $categorie) {
    ?>
                        <option
                        value="<?=$categorie["id_categorie"];?>">
                        <?=$categorie["nom"];?>
                        </option>
                        <?php
}
?>
            </select>
         </td>
      </tr>
      <tr>
         <td>Contenu :</td>
         <td><textarea name="contenu"></textarea></td>
      </tr>

      <tr>
         <td colspan="2"><input type="submit" name="submit" value="Poster l'article" style="margin-top :10px"/></td>
      </tr>
   </table>
</form>
   <?php
         if(isset($erreurts)) {
            echo "<div class='erreur align-center'>$erreurts</div>";
         }

         if (isset($erreurTitre)) {
            echo "<div class='erreur align-center'>$erreurTitre</div>";
         }
         ?>
</div>
<?php
    require_once "pied.php";
?>