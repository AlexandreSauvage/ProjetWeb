<?php
session_start();

require('php/config.php'); /* Contient la connexion à la $bdd */

if(isset($_POST['formconnexion']))
{
    $mailconnect = htmlspecialchars($_POST['mailconnect']);
    $mdpconnect = sha1($_POST['mdpconnect']);
    if(!empty($mailconnect) AND !empty($mdpconnect))
    {
        $requser = $bdd->prepare("SELECT * FROM membres WHERE mail = ? AND motdepasse = ?");
        $requser->execute(array($mailconnect, $mdpconnect));
        $userexist = $requser->rowCount();
        if($userexist == 1)
        {
            $userinfo = $requser->fetch();
            $_SESSION['id'] = $userinfo['id'];
            $_SESSION['pseudo'] = $userinfo['pseudo'];
            $_SESSION['mail'] = $userinfo['mail'];
            header("location: profil.php?id=".$_SESSION['id']);
        }
        else
        {
            $erreur = "Mauvais mail ou mot de passe !";
        }
    }
    else
    {
        $erreur = "Tous les champs doivent être complétés !";
    }
}

?>
<!DOCTYPEhtml>
<html>
    <head>
        <title>Connexion</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="css/forum.css" />
    </head>

    <body>
        <h1>FREESTYLE SUR GLACE</h1>
            <form method="POST" action="">
                <input type="email" name="mailconnect" placeholder="Mail" />
                <input type="password" name="mdpconnect" placeholder="Mot de passe" />
                <input type="submit" name="formconnexion" value="Se connecter" />
            </form>
            <a href="inscription.php">S'inscrire</a>
            <?php
            if(isset($erreur))
            {
                echo '<font color="red">'.$erreur."</font>";
            }
            ?>
    </body>
</html>