<?php

require_once "entete.php";

   //===== VERIFICATION ===== // 
    if(isset($_SESSION['id'])) { // Si la personne existe bien Pour que seul la personne qui a l'id qui correspond puissent editer le profil

   //===== VERIFICATION DANS LA BBD (verification si l'utilisateur existe) ===== //
   $requser = getBdd()->prepare("SELECT * FROM utilisateurs WHERE id = ?");
   $requser->execute(array($_SESSION['id']));
   $user = $requser->fetch();
   if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] != $user['pseudo']) {
      $newpseudo = htmlspecialchars($_POST['newpseudo']);
      $insertpseudo = getBdd()->prepare("UPDATE utilisateurs SET pseudo = ? WHERE id = ?");
      $insertpseudo->execute(array($newpseudo, $_SESSION['id']));
      header('Location: profil.php?id='.$_SESSION['id']);
   }
   if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2'])) {
      $mdp1 = $_POST['newmdp1'];
      $mdp2 = $_POST['newmdp2'];
      if($mdp1 == $mdp2) {
         $insertmdp = getBdd()->prepare("UPDATE utilisateurs SET motdepasse = ? WHERE id = ?");
         $insertmdp->execute(array(password_hash($mdp1, PASSWORD_BCRYPT), $_SESSION['id']));
         header('Location: profil.php?id='.$_SESSION['id']);
      } else {
         $msg = "Vos deux mdp ne correspondent pas !";
      }
   }
   
   // Modification de la photo de l'avatar
   if (isset($_FILES["avatar"]) AND !empty($_FILES["avatar"]["name"])) {
      $taillemax = 3000000;
      $extensionsValides = array('jpg', 'jpeg', 'gif', 'png');
      if($_FILES["avatar"]["size"] <= $taillemax) {
         $extensionUpload = strtolower(substr(strrchr($_FILES["avatar"]["name"], "."), 1));
         if (in_array($extensionUpload, $extensionsValides)) {
            $chemin = "utilisateurs/avatars/". $_SESSION["id"].".".$extensionUpload;
            $resultat = move_uploaded_file($_FILES["avatar"]["tmp_name"], $chemin);
            if($resultat) {
                  $updateavatar = getBdd()->prepare("UPDATE utilisateurs SET avatar = :avatar WHERE id = :id");
                  $updateavatar-> execute(array(
                     "avatar" => $_SESSION['id'].".".$extensionUpload,
                     "id" => $_SESSION["id"]));
                  header('Location: profil.php?id='.$_SESSION['id']);
            } else {
               $msg = "Erreur durant l'importation de l'avatar";
            }
         } else {
            $msg = "Votre avatar n'est pas au bon format";
         }
      } else {
         $msg ="Votre avatar ne doit pas dépasser 3Mo";
      }
   }
   
?>
      <div align="center">
         <h2>Edition de mon profil</h2>
         <br><br>
            <form method="POST" action="" enctype="multipart/form-data">
               <table>
                  <tr style="margin-bottom:1rem;">
                     <td>
                        <label>Changer le Pseudo :</label><br>
                     </td>
                  </tr>
                  <tr style="margin-bottom:1rem;">
                     <td>
                        <input type="text" name="newpseudo" placeholder="Pseudo" value="<?php echo $user['pseudo']; ?>" /><br /><br />
                     </td>
                  </tr>
                  <tr style="margin-bottom:1rem;">
                     <td>
                        <label>Changer votre avatar :</label>
                     </td>
                  </tr>
                  <tr style="margin-bottom:1rem;">
                     <td>
                        <input type="file" name="avatar"/>
                     </td>
                  </tr>
                  <tr style="margin-bottom:1rem;">
                     <td>
                        <label>Changer le Mot de passe :</label><br>
                     </td>
                  </tr>
                  <tr style="margin-bottom:1rem;">
                     <td>
                        <input type="password" name="newmdp1" placeholder="Mot de passe"/><br /><br />
                     </td>
                  </tr>
                  <tr style="margin-bottom:1rem;">
                     <td>
                        <label>Confirmation du nouveau mot de passe :</label><br>
                     </td>
                  </tr>
                  <tr style="margin-bottom:1rem;">
                     <td>
                        <input type="password" name="newmdp2" placeholder="Confirmation du mot de passe" /><br /><br />
                     </td>
                  </tr>
                  <tr style="margin-bottom:1rem;">
                     <td>
                        <input type="submit" value="Mettre à jour mon profil !" />
                     </td>
                  </tr>
               </table>
            </form>
            <?php if(isset($msg)) { echo $msg; } ?>
      </div>
   </body>
</html>
<?php   
}
else {
   header("Location: connexion.php");
}
require_once "pied.php";
?>