<?php require_once "entete.php";

if ($_SESSION["idrole"] == 3 || $_SESSION["idrole"] == 2) {
    if (isset($_GET['id']) && !empty($_GET['id'])) {

        $idmessage = $_GET['id'];

        $requete = getBdd()->prepare("SELECT id_sujet FROM messages WHERE id_message = ?");
        $requete->execute([$idmessage]);
        $idsujet = $requete->fetch()["id_sujet"];

        $requete = getBdd()->prepare("DELETE FROM messages WHERE id_message = ?");
            $requete->execute([$idmessage]);

            header("location:sujet.php?id=$idsujet");
    }
}