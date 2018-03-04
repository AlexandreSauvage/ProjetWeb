<?php
require('php/config.php'); /* Contient la connexion à la $bdd */

if(isset($_POST['forminscription']))
{
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $mail = htmlspecialchars($_POST['mail']);
    $mail2 = htmlspecialchars($_POST['mail2']);
    $mdp = sha1($_POST['mdp']);
    $mdp2 = sha1($_POST['mdp2']);

    if(!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2']))
    {
        $pseudolength = strlen($pseudo);
        if($pseudolength <= 255)
        {
            if($mail == $mail2)
            {
                if(filter_var($mail, FILTER_VALIDATE_EMAIL))
                {   /*Vérifie si le mail éxiste déjà*/  
                    $reqmail = $bdd->prepare("SELECT * FROM membres WHERE mail = ?");
                    $reqmail->execute(array($mail));
                    $mailexist = $reqmail->rowCount();
                    if($mailexist == 0)
                    {
                        if($mdp == $mdp2)
                        {
                            $insertmbr = $bdd->prepare("INSERT INTO membres(pseudo, mail, motdepasse) VALUE(?, ?, ?)");
                            $insertmbr->execute(array($pseudo, $mail, $mdp));
                            $erreur = "Votre compte a bien été créé ! <a href=\"connexion.php\">Me connecter</a>";
                        }
                        else
                        {
                            $erreur = "Vos mots de passes ne correspondent pas !";
                        }
                    }
                    else
                    {
                        $erreur = "Adresse mail déjà utilisée !";
                    }
                }
                else
                {
                    $erreur = "Votre adresse mail n'est pas valide !";
                }
            }
            else
            {
                $erreur = "Vos adresses mail ne correspondent pas !";
            }
        }
        else
        {
            $erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";
        }
    }
    else
    {
        $erreur = "Tous les champs doivent être complétés !";
    }
}


?>
<!DOCTYPEhtml>
<html lang="fr">
<head>
    <title>Inscription</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/forum.css">
</head>
<body>
    <h1>FREESTYLE SUR GLACE</h1>
        <form class="fntopic" method="POST" action="">
            <table>
                <tr>
                    <td>
                        <label for="pseudo">Pseudo :</label>
                    </td>
                    <td>
                        <input type="text" placeholder="Votre pseudo" id="pseudo" name="pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="mail">Mail :</label>
                    </td>
                    <td>
                        <input type="email" placeholder="Votre mail" id="mail" name="mail" value="<?php if(isset($mail)) { echo $mail; } ?>" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="mail2">Confirmation du mail :</label>
                    </td>
                    <td>
                        <input type="email" placeholder="Confirmer votre adresse mail" id="mail2" name="mail2" value="<?php if(isset($mail2)) { echo $mail2; } ?>" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="mdp">Mot de passe :</label>
                    </td>
                    <td>
                        <input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="mdp2">Confirmation du mot de passe :</label>
                    </td>
                    <td>
                        <input type="password" placeholder="Confirmer votre mot de passe" id="mdp2" name="mdp2" />
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <br />
                        <input type="submit" name="forminscription" value="Je m'inscris" />
                    </td>
                </tr>
            </table>
        </form>
        <?php
        if(isset($erreur))
        {
            echo '<font color="red">'.$erreur."</font>";
        }
        ?>
</body>
</html>