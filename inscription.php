<?php
session_start();
require_once("includes/script.php");
require_once("fonctions_panier.php");

    if(isset($_POST['forminscription']))
    {
        if(!empty($_POST['mail'])AND !empty($_POST['mdp']) AND !empty($_POST['mdp2']))
        {
            $mdp =sha1($_POST['mdp']);
            $mdp2 =sha1($_POST['mdp2']);
            $mail = htmlspecialchars($_POST['mail']);
            $nom = htmlspecialchars($_POST['nom']);
            $prenom = htmlspecialchars($_POST['prenom']);
            $adresse = htmlspecialchars($_POST['adresse']);
            $pseudo = htmlspecialchars($_POST['pseudo']);

            if($mdp == $mdp2)
            {
            $insert_membre = $bdd->prepare("INSERT INTO membres(Nom, Prenom, Adresse, Mail, MDP, Pseudo) VALUES(?,?,?,?,?,?)");
            $insert_membre->execute(array($nom, $prenom, $adresse, $mail, $mdp, $pseudo));
            $message = "Votre compte à bien été crée.";
            }
            else
            {
                $message = "Le mot de passe n'est pas le même, veuillez recommencer.";
            }
        }

        else
        {
        $message = " Tous les champs doivent être complétés.";
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
            <h3>Inscription</h3>
        </div>

        <div id="ensemble">
            <h2>Inscription</h2>
            <br /><br />
            <form method ="POST" action="">
                <table>
                    <tr>
                        <td>
                            <label for="nom">Nom :</label>
                        </td>
                        <td>
                            <input type="text" placeholder="Votre nom" id="nom" name="nom" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="prenom">Prenom :</label>
                        </td>
                        <td>
                            <input type="text" placeholder="Votre prénom" id="prenom" name="prenom" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="adresse">Adresse :</label>
                        </td>
                        <td>
                            <input type="text" placeholder="Votre adresse" id="adresse" name="adresse" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="mail">Mail :</label>
                        </td>
                        <td>
                            <input type="email" placeholder="Votre mail" id="pseudo" name="mail" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="mdp">Mot de passe :</label>
                        </td>
                        <td>
                            <input type="password" placeholder="Votre mot de passe" id="MDP" name="mdp" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="mdp2">Confirmation de mot de passe :</label>
                        </td>
                        <td>
                            <input type="password" placeholder="Votre mot de passe de confirmation" id="Mot de passe2" name="mdp2" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="pseudo">Pseudo :</label>
                        </td>
                        <td>
                            <input type="text" placeholder="Votre pseudo" id="pseudo" name="pseudo" />
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                        <br />
                            <input type="submit" name="forminscription" value="Inscription" />
                        </td>
                    </tr>
                </table>

            </form>
            <?php
            if (isset($message))
            {
                echo $message;
            }
            ?>
        </div>
    </body>
</html>
