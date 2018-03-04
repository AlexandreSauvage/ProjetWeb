<?php
session_start();

require('php/config.php'); /* Contient la connexion à la $bdd */

if(isset($_GET['id']) AND $_GET['id'] > 0)
{
    $getid = intval($_GET['id']);
    $requser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
    $requser->execute(array($getid));
    $userinfo = $requser->fetch();
?>
<!DOCTYPEhtml>
<html lang="fr">
<head>
    <title>Profil</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/forum.css">
</head>
<body>
    <h1>FREESTYLE SUR GLACE</h1>
    <h2>Profil de <?php echo $userinfo['pseudo']; ?></h2>
    <br /><br />
    <?php
    if(!empty($userinfo['avatar']))
    {
    ?>
    <img src="membres/avatars/<?php echo $userinfo['avatar']; ?>" width="150" />
    <?php
    }
    ?>
    <br />
    <p>Pseudo = <?php echo $userinfo['pseudo']; ?></p>
    <br />
    <p>Mail = <?php echo $userinfo['mail']; ?></p>
    <br />
    <?php
    if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id'])
    {
    ?>
    <a class="btn ntopic" href="editionprofil.php">Editer mon profil</a>
    <a class="btn ntopic" href="forum.php">Forum</a>
    <a class="btn ntopic" href="deconnexion.php">Se déconnecter</a>
    <?php
    }
    ?>
</body>
</html>
<?php
}
?>