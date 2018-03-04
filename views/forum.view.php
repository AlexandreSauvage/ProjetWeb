<table class="forum">
    <tr class="header">
        <th class="main">Catégories</th>
        <th class="sub-info messages">Messages</th>
        <th class="sub-info dmessage">Dernier message</th>
    </tr>
    <?php
    require('php/functions.php');
    while($c = $categories->fetch()) {
        $subcat->execute(array($c['id']));
        $souscategories = '';
        while($sc = $subcat->fetch()) { 
            $souscategories .= '<a href="/ProjetWeb/forum_topic.php?categorie='.url_custom_encode($c['nom']).'&souscategorie='.url_custom_encode($sc['nom']).'">'.$sc['nom'].'</a> | ';
        }
        $souscategories = substr($souscategories, 0, -3);
    ?>
    <tr>
        <td class="main">
            <h4><a href="/ProjetWeb/forum_topic.php?categorie=<?= url_custom_encode($c['nom']) ?>"><?= $c['nom'] ?></a></h4>
            <p>
            <?= $souscategories ?>
            </p>
        </td>
        <td class="sub-info">4083495</td>
        <td class="sub-info">jj.mm.aaaa à 14h52<br />de ...</td>
    </tr>
    <?php } ?>
</table>