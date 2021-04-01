<?php require_once "entete.php" ?>

<?php 

if ($_SESSION["idrole"] == 3 || $_SESSION["idrole"] == 2) {
    
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        
        $idmessage = $_GET['id'];

        if(isset($_POST["newmessage"])) {

            if(!empty($_POST["newmessage"])) {

                $requete = getBdd()->prepare("SELECT id_sujet FROM messages WHERE id_message = ?");
                $requete->execute([$idmessage]);
                $idsujet = $requete->fetch()["id_sujet"];
                
                    if (isset($_POST["newmessage"]) && !empty($_POST["newmessage"])) {
                        
                        $requete = getBdd()->prepare('UPDATE messages SET contenu_message = ? WHERE id_message = ?');
                        $requete->execute([$_POST["newmessage"], $idmessage]);
                        
                        header("location:sujet.php?id=$idsujet");
                    }
            }  else {
                $erreur = "Veuillez saisir le nouveau message";
                }
        }
    }
}
?>
<h1>Modification du message n°<?=$idmessage;?></h1>
<form method="POST" style="margin-top : 60px">
   <table>
      <tr>
         <th colspan="2">Modifier le message :</th>
      </tr>
     
      <tr>
         <td>Contenu :</td>
         <td><textarea name="newmessage"></textarea></td>
      </tr>

      <tr>
         <td colspan="2"><input type="submit" name="envoinew" value="Modifier le message" style="margin-top :10px"/></td>
      </tr>
   </table>
</form>
<?php
         if(isset($erreur)) {
            echo "<div class='erreur align-center'>$erreur</div>";
         }
         ?>
