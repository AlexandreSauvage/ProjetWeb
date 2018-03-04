<?php
session_start();

require('php/config.php'); /* Contient la connexion à la $bdd */

if(isset($_SESSION['id']))
{
    $requser = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
    $requser->execute(array($_SESSION['id']));
    $user = $requser->fetch();

    if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] != $user['pseudo'])
    {
        $newpseudo = htmlspecialchars($_POST['newpseudo']);
        $insertpseudo = $bdd->prepare("UPDATE membres SET pseudo = ? WHERE id = ?");
        $insertpseudo->execute(array($newpseudo, $_SESSION['id']));
        header('location: profil.php?id='.$_SESSION['id']);
    }

    if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] != $user['mail'])
    {
        $newmail = htmlspecialchars($_POST['newmail']);
        $insertmail = $bdd->prepare("UPDATE membres SET mail = ? WHERE id = ?");
        $insertmail->execute(array($newmail, $_SESSION['id']));
        header('location: profil.php?id='.$_SESSION['id']);
    }

    if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2']))
    {
        $mdp1 = sha1($_POST['newmdp1']);
        $mdp2 = sha1($_POST['newmdp2']);

        if($mdp1 == $mdp2)
        {
            $insertmdp = $bdd->prepare("UPDATE membres SET motdepasse = ? WHERE id = ?");
            $insertmdp->execute(array($mdp1, $_SESSION['id']));
            header('location: profil.php?id='.$_SESSION['id']);
        }
        else
        {
            $msg = "Vos deux mdp ne correspondent pas";
        }
    }

    if(isset($_FILES['avatar']) AND !empty($_FILES['avatar'] ['name']))
    {
        $tailleMax = 2097152;
        $extensionsValides = array('jpg', 'jpeg', 'gif', 'png');
        if($_FILES['avatar']['size'] <= $tailleMax)
        {
            $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
            if(in_array($extensionUpload, $extensionsValides))
            {
                $chemin = "membres/avatars/".$_SESSION['id'].".".$extensionUpload;
                $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
                if($resultat)
                {
                    $updateavatar = $bdd->prepare('UPDATE membres SET avatar = :avatar WHERE id = :id');
                    $updateavatar->execute(array(
                        'avatar' => $_SESSION['id'].".".$extensionUpload,
                        'id' => $_SESSION['id']
                        ));
                    header('location: profil.php?id='.$_SESSION['id']);
                }
                else
                {
                    $msg = "Erreur durant l'importation de votre photo de profil";
                }
            }
            else
            {
                $msg = "Votre photo de profil doit être au format jpg, jpeg, gif ou png";
            }
        }
        else
        {
            $msg = "Votre photo de profil ne doit pas dépasser 2Mo";
        }
    }
    if(isset($_POST['newpseudo']) AND $_POST['newpseudo'] == $user['pseudo'])
    {
        header('location: profil.php?id='.$_SESSION['id']);
    }

?>
<!DOCTYPEhtml>
<html lang="fr">
<head>
    <title>Edition Profil</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/forum.css">
</head>
<body>
    <h1>FREESTYLE SUR GLACE</h1>
    <h2>Edition de mon profil</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>
                        <label>Pseudo :</label>
                    </td>
                    <td>
                        <input type="text" name="newpseudo" placeholder="Pseudo" value="<?php echo $user['pseudo']; ?>" /><br /><br />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Mail :</label>
                    </td>
                    <td>
                        <input type="text" name="newmail" placeholder="Mail" value="<?php echo $user['mail']; ?>" /><br /><br />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Mot de passe :</label>
                    </td>
                    <td>
                        <input type="password" name="newmdp1" placeholder="Mot de passe" /><br /><br />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Confirmation mot de passe :</label>
                    </td>
                    <td>
                        <input type="password" name="newmdp2" placeholder="Confirmation du mot de passe" /><br /><br />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Avatar :</label>
                    </td>
                    <td>
                        <input type="file" name="avatar" /><br /><br />
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" value="Mettre à jour mon profil" />
                    </td>
                </tr>
            </table>
        </form>
        <?php 
        if(isset($msg))
        {
            echo '<font color="red">'.$msg."</font>";
        }
        ?>
    </body>
</html>
<?php
}
else
{
    header("location: connexion.php");
}
?>