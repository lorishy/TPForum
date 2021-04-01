<?php
require_once "entete.php";

   //===== VERIFICATION ===== // 
if(isset($_SESSION['id']) AND $_SESSION['id'] > 0) {
   $getid = intval($_SESSION['id']); // Conv en nombre
   $requser = getBdd()->prepare('SELECT * FROM utilisateurs WHERE id = ?');
   $requser->execute(array($getid));
   $userinfo = $requser->fetch();
?>
      <div align="center">
         <h2>Profil de <?php echo $userinfo['pseudo']; ?></h2>
         <br><br>
         <?php
         if(!empty($userinfo["avatar"])){
         ?>
         <img src="utilisateurs/avatars/<?php echo $userinfo["avatar"];?> " width="150px" height="150px"style="border-radius : 25%">
         <?php
         } else {
         ?>
         <img src="avatar.png" width="150px" height="150px"style="border-radius : 25%">
         <?php } ?>
         <br />
         <p class="edititems">Pseudo : <?php echo $userinfo['pseudo']; ?></p>
         <p class="edititems">Mail : <?php echo $userinfo['mail']; ?></p>
         <br />
         <?php
         // VERIFICATION DU PROFIL 
         if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) { // si la session est = a l'utilisateur 
         ?>
         <br />
         <a href="editionProfil.php" type="submit" class="edit">Editer mon profil</a>
         <a href="deconnexion.php" type="submit" class="deco">Se déconnecter</a>
         <br>
         <?php
         }
         ?>
      </div>
<?php   
}
require_once "pied.php";
?>