<?php
session_start();
require_once("includes/script.php");
require_once("fonctions_panier.php");
if(isset($_GET['Id_Membre'])AND $_GET['Id_Membre'] >0)
{
    $getid = intval($_GET['Id_Membre']);
    $requser = $bdd->prepare('SELECT * FROM membres WHERE Id_Membre = ?');
    $requser->execute(array($getid));
    $userinfo = $requser->fetch();
?>

<html>
    <head>
        <title>Profil</title>
        <meta charset="utf-8">
    </head>
    <body>
        <div align="center">
            <h2>Profil de <?php echo $userinfo['Pseudo'];?> </h2>
            <br /><br />
            Bonjour <?php echo $userinfo['Pseudo'];?>
            <br />
            Mail = <?php echo $userinfo['Mail'];?>
            <br /><br /><br /><br /><br /><br /><br />
            <?php
            if(isset($_SESSION['Id_Membre']) AND $userinfo['Id_Membre'] == $_SESSION['Id_Membre']);
            {
            ?>
            <a href="#">Acceder à mon panier</a>
            <br /><br />
            <a href="deconnexion.php">Se deconnecter</a>
            <?php
            }
            ?>
        </div>
    </body>
</html>

<?php
}
?>
