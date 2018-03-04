<?php
require('php/config.php');
require('php/functions.php');
if(isset($_GET['titre'],$_GET['id']) AND !empty($_GET['titre']) AND !empty($_GET['id'])) {
    $get_titre = htmlspecialchars($_GET['titre']);
    $get_id = htmlspecialchars($_GET['id']);
    $titre_original = $bdd->prepare('SELECT sujet FROM f_topics WHERE id = ?');
    $titre_original->execute(array($get_id));
    $titre_original = $titre_original->fetch()['sujet'];
    if($get_titre == url_custom_encode($titre_original)) {
        $topic = $bdd->prepare('SELECT * FROM f_topics WHERE id = ?');
        $topic->execute(array($get_id));
        $topic = $topic->fetch();
        $auteur = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
        $auteur->execute(array($topic['id_createur']));
        $auteur = $auteur->fetch();
        if(isset($_POST['topic_reponse_submit'],$_POST['topic_reponse'])) {
            $reponse = htmlspecialchars($_POST['topic_reponse']);
            if(isset($_SESSION['id'])) {
                if(!empty($reponse)) {
                $ins = $bdd->prepare('INSERT INTO f_messages(id_topic,id_posteur,contenu,date_heure_post) VALUES (?,?,?,NOW())');
                $ins->execute(array($get_id,$_SESSION['id'],$reponse));
                $reponse_msg = "Votre réponse a bien été postée";
                unset($reponse);
                } else {
                $reponse_msg = "Votre réponse ne peut pas être vide !";
                }
            } else {
                $reponse_msg = "Veuillez vous connecter ou créer un compte pour poster une réponse";
            }
        }
    } else {
        die('Erreur: Le titre ne correspond pas à l\'id');
    }
    require('views/topic.view.php');
} else {
   die('Erreur...');
}
?>