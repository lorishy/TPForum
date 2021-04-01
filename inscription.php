<?php
require_once "entete.php";

   //===== VERIFICATION ===== // 
   if(isset($_POST['forminscription'])) { // Si la l'utilisateur envoie le formulaire  isset — Détermine si une variable est déclarée et est différente de null
   
   // ===== STOCKAGE DES VARIABLES ===== //
   $pseudo = htmlspecialchars($_POST['pseudo']); // htmlspecialchars — Convertit les caractères spéciaux en entités HTML
   $mail = htmlspecialchars($_POST['mail']);
   $mail2 = htmlspecialchars($_POST['mail2']);
   $mdp = $_POST['mdp'];
   $mdp2 = $_POST['mdp2'];

   // VERIFICATION QUE TOUS LES CHAMPS ON ETAIT COMPLETER //
   if(!empty($_POST['pseudo']) AND // empty — Détermine si une variable est vide
      !empty($_POST['mail']) AND 
      !empty($_POST['mail2']) AND 
      !empty($_POST['mdp']) AND 
      !empty($_POST['mdp2'])) {

      $pseudolength = strlen($pseudo); // strlen — Calcule la taille d'une chaîne
      if($pseudolength <= 255) {
         if($mail == $mail2) {
            if(filter_var($mail, FILTER_VALIDATE_EMAIL)) { // Verifier si c'est bien a e-mail (car possibiliter de changer en inspectant la page).
               //===== VERIFICATION DANS LA BBD (verification si l'email existe deja)===== //
               $reqmail = getBdd()->prepare("SELECT * FROM utilisateurs WHERE mail = ?");
               $reqmail->execute(array($mail));
               $mailexist = $reqmail->rowCount(); // Retourne le nombre de lignes affectées par le dernier appel à la fonction PDOStatement::execute()
               if($mailexist == 0) {
                  if($mdp == $mdp2) {
                      //===== INSERTION (membre) EN BBD ===== //
                     $insertmbr = getBdd()->prepare("INSERT INTO utilisateurs(pseudo, mail, motdepasse) VALUES(?, ?, ?)");
                     $insertmbr->execute(array($pseudo, $mail, password_hash($mdp, PASSWORD_BCRYPT)));
                     $message = "Votre compte a bien été créé ! <a href=\"connexion.php\">Me connecter</a>";
                  } else {
                     $erreurmdp = "Vos mots de passes ne correspondent pas !";
                  }
               } else {
                  $erreurmail0 = "Adresse mail déjà utilisée !";
               }
            } else {
               $erreurmail1 = "Votre adresse mail n'est pas valide !";
            }
         } else {
            $erreurmail2 = "Vos adresses mail ne correspondent pas !";
         }
      } else {
         $erreurpseudo = "Votre pseudo ne doit pas dépasser 255 caractères !";
      }
   } else {
      $erreur = "Tous les champs doivent être complétés !";
   }
}
// Faire le verif si meme pseudo 
?>
<?php
?>
      <div align="center">
         <h2>Inscription</h2>
         <br /><br />
         <form method="POST" action="">
            <table>
               <tr style="margin-bottom:1rem;">
                  <td>
                     <label for="pseudo">Pseudo</label>
                  </td>
               </tr>
               <tr>
                  <td>
                     <input type="text" placeholder="Votre pseudo" id="pseudo" name="pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>" />
                     <?php
                     if(isset($erreurpseudo)) {
                        echo "<div class='erreur'>$erreurpseudo</div>";
                     }
                     ?>
                  </td>
               </tr>
               <tr style="margin-bottom:1rem;">
                  <td>
                     <label for="mail">Mail</label>
                  </td>
               </tr>
               <tr>
                  <td>
                     <input type="email" placeholder="Votre mail" id="mail" name="mail" value="<?php if(isset($mail)) { echo $mail; } ?>" />
                     <?php
                     if(isset($erreurmail1)) {
                        echo "<div class='erreur'>$erreurmail1</div>";
                     }
                     if(isset($erreurmail0)) {
                        echo "<div class='erreur'>$erreurmail0</div>";
                     }
                     ?>
                                            
                  </td>
               </tr>
               <tr style="margin-bottom:1rem;">
                  <td>
                     <label for="mail2">Confirmation du mail</label>
                  </td> 
               </tr>
               <tr>               
                  <td>
                     <input type="email" placeholder="Confirmez votre mail" id="mail2" name="mail2" value="<?php if(isset($mail2)) { echo $mail2; } ?>" />
                     <?php
                     if(isset($erreurmail2)) {
                        echo "<div class='erreur'>$erreurmail2</div>";
                     }
                     ?>                    
                  </td>
               </tr>
               <tr style="margin-bottom:1rem;">
                  <td>
                     <label for="mdp">Mot de passe</label>
                  </td>
               </tr>
               <tr>
                  <td>
                     <input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp" />
                  </td>
               </tr>
               <tr style="margin-bottom:1rem;">
                  <td>
                     <label for="mdp2">Confirmation du mot de passe</label>
                  </td>
               </tr>
               <tr>
                  <td>
                     <input type="password" placeholder="Confirmez votre mdp" id="mdp2" name="mdp2" />
                     <?php
                     if(isset($erreurmdp)) {
                        echo "<div class='erreur'>$erreurmdp</div>";
                     }
                     ?>  
                  </td>
               </tr>
               <tr>
                  <td></td>
                  <td align="center">
                     <br />
                     <input type="submit" name="forminscription" value="Je m'inscris" />
                  </td>
               </tr>
            </table>
         </form>
         <?php
         if(isset($erreur)) {
            echo "<div class='erreur'>$erreur</div>";
         }
         if(isset($message)) {
            echo "<div class='inscrit'>$message</div>";
         }
         ?>
      </div>
<?php
   require_once "pied.php"
?>