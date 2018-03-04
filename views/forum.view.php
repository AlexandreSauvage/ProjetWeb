<?php
require('php/config.php');
?>
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
                <?php /*Affichage des catégories et sous-catégories*/
                $categories = $bdd->query('SELECT * FROM f_categories ORDER BY nom');
                $subcat = $bdd->prepare('SELECT * FROM f_souscategories WHERE id_categorie = ? ORDER BY nom');

                while($c = $categories->fetch()) {
                    $subcat->execute(array($c['id']));/*fais passer l'id de la catégorie en cours dans la boucle*/
                    $souscategories = '';
                    while($sc = $subcat->fetch()) { 
                        $souscategories .= '<a href="/ProjetWeb/forum_topic.php?categorie='.url_custom_encode($c['nom']).'&souscategorie='.url_custom_encode($sc['nom']).'">'.$sc['nom'].'</a> | ';
                    }               /*réduit la taille de la chaine de caractère*/
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
            <?php if(isset($_SESSION['id']))
            {
            ?>
            <a class="btn ntopic" href="editionprofil.php">Editer mon profil</a>
            <a class="btn ntopic" href="deconnexion.php">Se déconnecter</a>
            <?php } ?>
        </div>
    </div>
</div>
</body>
</html>