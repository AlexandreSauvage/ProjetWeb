<!DOCTYPEhtml>
<html lang="fr">
<head>
    <title>FORUM</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/forum.css">
</head>
<body class="kp-blog page-1-sidebar">
<div id="content" class="container clearfix">
    <div id="main-content">
        <div class="pull-left full-width">
            <table class="forum">
                <tr class="header">
                    <th class="main">Sujet</th>
                    <th class="sub-info">Auteur</th>
                    <th class="sub-info hide-640">Réponses</th>
                    <th class="sub-info">Dernière rép.</th>
                </tr>
                <?php while($t = $topics->fetch()) { /*Va chercher les topics*/ ?>
                <tr>
                    <td class="main">
                    <h4><a href=""><a href="topic.php?titre=<?= url_custom_encode($t['sujet']) ?>&id=<?= $t['topic_base_id'] ?>"><?= $t['sujet'] ?></a></a></h4>
                    </td>
                    <td class="sub-info"><p><?= $t['pseudo'] ?></p><?= $t['date_heure_creation'] ?></p></td>
                    <td class="sub-info hide-640"><p><?= reponse_nbr_topic($t['topic_base_id']) ?></p></td>
                    <td class="sub-info"><p><?= derniere_reponse_topic($t['topic_base_id']) ?></p></td>
                </tr>
                <?php } ?>
            </table>
            <a class="btn ntopic" href="/ProjetWeb/nouveau_topic.php?categorie=<?= $id_categorie ?>"><span class="icon-quill"></span>Créer un nouveau topic</a>
        </div>
    </div>
</div>
</body>
</html>