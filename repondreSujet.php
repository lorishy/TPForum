<?php
    require_once "entete.php"
?>
<?php


    if(isset($_POST["repondre"])) {

        if(isset($_POST["message"]) && !empty($_POST["message"])) {

            $message = $_POST["message"];
            if (!empty($message)) {
            
            $requete = getBdd()->prepare ("INSERT INTO messages (contenu_message, id_sujet, date) VALUES (?,?, NOW())");
            $requete->execute([$message, $_GET["id"]]);
            
            } $id = $_GET["id"];
            header("location:sujet.php?id=$id");

        } else {
            $erreur = "Veuillez remplir votre message";

        }
    
    }

?>


<form method="POST" style="margin-top : 60px">
   <table>
      <tr>
         <th colspan="2">Répondre à ce sujet :</th>
      </tr>
     
      <tr>
         <td>Contenu :</td>
         <td><textarea name="message"></textarea></td>
      </tr>

      <tr>
         <td colspan="2"><input type="submit" name="repondre" value="Répondre" style="margin-top :10px"/></td>
      </tr>
   </table>
</form>
<?php
         if(isset($erreur)) {
            echo "<div class='erreur align-center'>$erreur</div>";
         }
         ?>
<?php
    require_once "pied.php";
?>