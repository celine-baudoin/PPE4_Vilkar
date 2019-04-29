<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=vilkar', 'root', '');

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
        <?php require_once("includes/header.php")?>
        <?php require_once("includes/nav.php")?>
        <?php require_once("includes/navig.php")?>
        <div id="ensemble">
        <h2>Connexion</h2>
            <br /><br />
            <form method ="POST" action="">
                <input type="email" placeholder="Votre mail" name="mail_connect" />
                <input type="password" placeholder="Votre mot de passe" name="mdp_connect" />
                <input type="submit" value ="Se connecter" name="form_connexion" />


            </form>
            <?php
            if (isset($message))
            {
                echo $message;
            }
            ?>
        </div>
        <?php require_once("includes/footer.php")?>
    </body>
</html>