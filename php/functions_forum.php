<?php
function get_pseudo($id) {
    global $bdd;
    $pseudo = $bdd->prepare('SELECT pseudo FROM membres WHERE id = ?');
    $pseudo->execute(array($id));
    $pseudo = $pseudo->fetch()['pseudo'];
    return $pseudo;
}
?>