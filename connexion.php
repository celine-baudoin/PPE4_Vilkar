<?php
session_start();
require_once("includes/script.php");
require_once("fonctions_panier.php");

if(isset($_POST['form_connexion']))
{
    $mail_connect = htmlspecialchars($_POST['mail_connect']);
    $mdp_connect = sha1($_POST['mdp_connect']);

        if(!empty($mail_connect) AND !empty($mdp_connect))
        {
            $requser = $bdd->prepare("SELECT * FROM membres WHERE Mail = ? AND MDP = ?");
            $requser->execute(array($mail_connect, $mdp_connect));
            $user_exist = $requser->rowCount();
                if($user_exist == 1)
                {
                    $user_info = $requser->fetch();
                    $_SESSION['Id_Membre'] = $user_info['Id_Membre'];
                    $_SESSION['Mail'] = $user_info['Mail'];
                    $_SESSION['MDP'] = $user_info['MDP'];
                    header("Location: profil.php?Id_Membre=".$_SESSION['Id_Membre']);
                }
                else
                {
                    $message = "Vous n'avez pas saisi un mail ou un mot de passe valide";
                }
        }
        else
        {
            $message = "Tous les champs doivent être complétés !";
        }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <?php require_once("includes/head.php")?>
    </head>
    <body>
        <?php require_once("includes/includes.php")?>

        <div id="headerPage">
            <h3>Connexion</h3>
        </div>

        <div id="ensemble">
        <h2>Connexion</h2>
            <br /><br />
            <form method ="POST" action="">
                <p><input type="email" placeholder="Votre mail" name="mail_connect" /></p>
                <p><input type="password" placeholder="Votre mot de passe" name="mdp_connect" /></p>
                <p><input type="submit" value ="Se connecter" name="form_connexion" /></p>


            </form>

            <p>Pas encore de compte ? <a href="inscription.php">Inscrivez-vous !</a></p>

            <?php
            if (isset($message))
            {
                echo $message;
            }
            ?>
        </div>

    </body>
</html>
