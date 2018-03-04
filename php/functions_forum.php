<?php

function get_pseudo($id) {
	global $bdd;
	$pseudo = $bdd->prepare('SELECT pseudo FROM membres WHERE id = ?');
	$pseudo->execute(array($id));
	$pseudo = $pseudo->fetch()['pseudo'];
	return $pseudo;
}

function reponse_nbr_categorie($id_categorie) {
	global $bdd;
	$nbr = $bdd->prepare('SELECT f_messages.id FROM f_messages LEFT JOIN f_topics_categories ON f_topics_categories.id_topic = f_messages.id_topic WHERE f_topics_categories.id_categorie = ?');
	$nbr->execute(array($id_categorie));
	return $nbr->rowCount();
}

function reponse_nbr_topic($id_topic) {
	global $bdd;
	$nbr = $bdd->prepare('SELECT f_messages.id FROM f_messages LEFT JOIN f_topics ON f_topics.id = f_messages.id_topic WHERE f_topics.id = ?');
	$nbr->execute(array($id_topic));
	return $nbr->rowCount();
}

function derniere_reponse_categorie($id_categorie) {
	global $bdd;
	$rep = $bdd->prepare('SELECT f_messages.* FROM f_messages LEFT JOIN f_topics_categories ON f_topics_categories.id_topic = f_messages.id_topic WHERE f_topics_categories.id_categorie = ? ORDER BY f_messages.date_heure_post DESC LIMIT 0,1');
	$rep->execute(array($id_categorie));
	if($rep->rowCount() > 0) {
		$rep = $rep->fetch();
		$dr = $rep['date_heure_post'];
		$dr .= '<br /> de '.get_pseudo($rep['id_posteur']);
	} else {
		$dr = 'Aucune réponse...';
	}
	return $dr;
}

function derniere_reponse_topic($id_topic) {
	global $bdd;
	$rep = $bdd->prepare('SELECT f_messages.* FROM f_messages LEFT JOIN f_topics ON f_topics.id = f_messages.id_topic WHERE f_topics.id = ? ORDER BY f_messages.date_heure_post DESC LIMIT 0,1');
	$rep->execute(array($id_topic));
	if($rep->rowCount() > 0) {
		$rep = $rep->fetch();
		$dr = $rep['date_heure_post'];
		$dr .= '<br /> de '.get_pseudo($rep['id_posteur']);
	} else {
		$dr = 'Aucune réponse...';
	}
	return $dr;
}

?>