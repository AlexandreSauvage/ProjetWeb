<?php
session_start();

require('php/config.php'); /* Connexion à la base de donnée */
require('php/functions.php'); /* Mes fonctions */

/* Traitement du formulaire de création de Topic */
if(isset($_GET['categorie'])) {
    $get_categorie = htmlspecialchars($_GET['categorie']);
    $categorie = $bdd->prepare('SELECT * FROM f_categories WHERE id = ?');
    $categorie->execute(array($get_categorie));
    $cat_exist = $categorie->rowCount();
    /*Vérifie si existe*/
    if($cat_exist == 1) {
        $categorie = $categorie->fetch();
        $categorie = $categorie['nom'];
        /*Liste les sous catégories pour la sélection*/
        $souscategories = $bdd->prepare('SELECT * FROM f_souscategories WHERE id_categorie = ? ORDER BY nom');
        $souscategories->execute(array($get_categorie));
        if(isset($_SESSION['id'])) {
            if(isset($_POST['tsubmit'])) { /*Vérification si le formulaire est envoyé*/
                if(isset($_POST['tsujet'],$_POST['tcontenu'])) {
                    $sujet = htmlspecialchars($_POST['tsujet']);
                    $contenu = htmlspecialchars($_POST['tcontenu']);
                    $souscategorie = htmlspecialchars($_POST['souscategorie']);
                    /*Vérifie si les sous catégories correspondent bien*/
                    $verify_sc = $bdd->prepare('SELECT id FROM f_souscategories WHERE id = ? AND id_categorie = ?');
                    $verify_sc->execute(array($souscategorie,$get_categorie));
                    $verify_sc = $verify_sc->rowCount();
                    if($verify_sc == 1) {
                    if(!empty($sujet) AND !empty($contenu)) {
                        if(strlen($sujet) <= 70) {
                            if(isset($_POST['tmail'])) {
                                $notif_mail = 1;
                            } else {
                                $notif_mail = 0;
                            }
                            $ins = $bdd->prepare('INSERT INTO f_topics (id_createur, sujet, contenu, notif_createur, date_heure_creation) VALUES(?,?,?,?,NOW())');
                            $ins->execute(array($_SESSION['id'],$sujet,$contenu,$notif_mail));
                            /*Récupère le dernier topic*/
                            $lt = $bdd->query('SELECT id FROM f_topics ORDER BY id DESC LIMIT 0,1');
                            $lt = $lt->fetch();
                            $id_topic = $lt['id'];
                            $ins = $bdd->prepare('INSERT INTO f_topics_categories (id_topic, id_categorie, id_souscategorie) VALUES (?,?,?)');
                            $ins->execute(array($id_topic, $get_categorie, $souscategorie));
                        } else {
                            $terror = "Votre sujet ne peut pas dépasser 70 caractères";
                        }
                    } else {
                        $terror = "Veuillez compléter tous les champs";
                    }
                    } else {
                    $terror = "Sous-catégorie invalide";
                    }
                }
            }
        } else {
            $terror = "Veuillez vous connecter pour poster un nouveau topic . <a href=\"connexion.php\">Me connecter</a>";
        }
        } else {
        die('Catégorie invalide...');
        }
    } else {
        die('Aucune catégorie définie...');
    }
    
require('views/nouveau_topic.view.php'); /* Appel du fichier "vue" de notre page */
?>