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
                    <th class="main">Catégories</th>
                    <th class="sub-info messages hide-640">Réponses</th>
                    <th class="sub-info dmessage">Dernière réponse</th>
                </tr>
                <?php
                while($c = $categories->fetch()) {
                    $subcat->execute(array($c['id']));
                    $souscategories = '';
                    while($sc = $subcat->fetch()) { 
                        $souscategories .= '<a href="/ProjetWeb/forum_topic.php?categorie='.url_custom_encode($c['nom']).'&souscategorie='.url_custom_encode($sc['nom']).'">'.$sc['nom'].'</a> | ';
                    }
                    $souscategories = substr($souscategories, 0, -3);
                ?>
                <tr class="categories">
                    <td class="main">
                        <h4><a href="/ProjetWeb/forum_topic.php?categorie=<?= url_custom_encode($c['nom']) ?>"><?= $c['nom'] ?></a></h4>
                        <p>
                        <?= $souscategories ?>
                        </p>
                    </td>
                    <td class="sub-info hide-640"><?= reponse_nbr_categorie($c['id']) ?></td>
                    <td class="sub-info"><?= derniere_reponse_categorie($c['id']) ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
</body>
</html>