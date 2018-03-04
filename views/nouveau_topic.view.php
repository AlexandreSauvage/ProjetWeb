<form class="fntopic" method="POST">
    <table class="forum ntopic">
        <tr class="header">
            <th class="main">Nouveau Topic</th>
            <th></th>
        </tr>
        <tr>
            <td>Sujet</td>
            <td><input type="text" name="tsujet" size="70" maxlength="70" /></td>
        </tr>
        <tr>
            <td>Catégorie</td>
            <td>
            <?= $categorie ?>
            </td>
        </tr>
        <tr>
            <td>Sous-Catégorie</td>
            <td>
                <select name="souscategorie">
                <?php while($sc = $souscategories->fetch()) { ?>
                <option value="<?= $sc['id'] ?>"><?= $sc['nom'] ?></option>
                <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Message</td>
            <td><textarea name="tcontenu"></textarea></td>
        </tr>
        <tr>
            <td>Me notifier des réponses par mail</td>
            <td><input type="checkbox" name="tmail" /></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" name="tsubmit" value="Poster le Topic" /></td>
        </tr>
        <?php if(isset($terror)) { ?>
        <tr>
            <td colspan="2"><?= $terror ?></td>
        </tr>
        <?php } ?>
    </table>
</form>