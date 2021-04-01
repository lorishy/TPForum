<?php
require_once "entete.php";

   //===== VERIFICATION ===== // 
if(isset($_POST['formconnexion'])) { // Si la l'utilisateur envoie le formulaire isset — Détermine si une variable est déclarée et est différente de null
   $mailconnect = htmlspecialchars($_POST['mailconnect']);
   $mdpconnect = $_POST['mdpconnect'];
   if(!empty($mailconnect) AND 
      !empty($mdpconnect)) {

    //===== VERIFICATION DANS LA BBD (verification si l'utilisateur existe) ===== //
      $requser = getBdd()->prepare("SELECT * FROM utilisateurs WHERE mail = ? ");
      $requser->execute(array($mailconnect));
      $userexist = $requser->rowCount(); // Retourne le nombre de lignes affectées par le dernier appel à la fonction PDOStatement::execute()
      if($userexist == 1) {
         $userinfo = $requser->fetch(); // PDOStatement::fetch — Récupère la ligne suivante d'un jeu de résultats PDO
         if (password_verify($mdpconnect, $userinfo["motdepasse"])) {
            $_SESSION['id'] = $userinfo['id'];
            $_SESSION['pseudo'] = $userinfo['pseudo'];
            $_SESSION['mail'] = $userinfo['mail'];
            $_SESSION['idrole'] = $userinfo['idrole'];
            header("location:index.php");
         } else { 
            $erreur = "Mauvais mot de passe !";
         }
      } else {
         $erreur = "Mauvais mail !";
      }
   } else {
      $erreur = "Tous les champs doivent être complétés !";
   }
}
?>
      <div align="center">
         <h2>Connexion</h2>
         <br /><br />
         <form method="POST" action="">
            <table>
               <tr style="margin-bottom:1rem;">
                  <td>
                     <label for="mail">Mail</label>
                  </td>
               </tr>
               <tr>
                  <td>
                     <input type="email" placeholder="Votre mail" id="mail" name="mailconnect" value="<?php if(isset($mailconnect)) { echo $mailconnect; } ?>" />                                           
                  </td>
               </tr>
               <tr style="margin-bottom:1rem;">
                  <td>
                     <label for="mdp">Mot de passe</label>
                  </td>
               </tr>
               <tr>
                  <td>
                     <input type="password" placeholder="Votre mot de passe" id="mdp" name="mdpconnect" />
                  </td>
               </tr>
               <tr>
                  <td></td>
                  <td align="center">
                     <br />
                     <input type="submit" name="formconnexion" value="Je me connecte" />
                  </td>
               </tr>
            </table>
         </form>
         <?php
            if(isset($erreur)) {
               echo "<div class='erreur'>$erreur</div>";
                     }
                     ?>
      </div>
   </body>
</html>