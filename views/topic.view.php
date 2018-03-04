<table class="forum">
    <tr class="header">
        <th class="sub-info w10">Auteur</th>
        <th class="main center">Sujet: <?= $topic['sujet'] ?></th>
    </tr>
    <?php if($pageCourante == 1) { ?>
    <tr>
        <td><?= get_pseudo($topic['id_createur']) ?></td>
        <td><?= $topic['contenu'] ?></td>
    </tr>
    <?php } ?>
    <?php while($r = $reponses->fetch()) { ?>
    <tr>
        <td><?= get_pseudo($r['id_posteur']) ?></td>
        <td><?= $r['contenu'] ?></td>
    </tr>
    <?php } ?>
</table>
<?php
    for($i=1;$i<=$pagesTotales;$i++) {
        if($i == $pageCourante) {
            echo $i.' ';
        } else {
            echo '<a href="topic.php?titre='.$get_titre.'&id='.$get_id.'&page='.$i.'">'.$i.'</a> ';
        }
    }
    ?>
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