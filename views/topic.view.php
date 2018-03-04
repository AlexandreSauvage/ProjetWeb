<table class="forum">
    <tr class="header">
        <th class="sub-info w10">Auteur</th>
        <th class="main center">Sujet: <?= $topic['sujet'] ?></th>
    </tr>
    <tr>
        <td><?= $auteur['pseudo'] ?></td>
        <td><?= $topic['contenu'] ?></td>
    </tr>
</table>
<br />
<?php if(isset($_SESSION['id'])) { ?>
    <form method="POST">
        <textarea placeholder="Votre réponse" name="topic_reponse" style="width:80%"><?php if(isset($reponse)) { echo $reponse; } ?></textarea><br />
        <input type="submit" name="topic_reponse_submit" value="Poster ma réponse"></form>
    </form>
    <?php if(isset($reponse_msg)) { echo $reponse_msg; } ?>
<?php } else { ?>
    <p>Veuillez vous connecter ou créer un compte pour poster une réponse</p>
<?php } ?>