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

<!DOCTYPE html>
<html>
<?php require_once("includes/head.php")?>
<body>
    <?php require_once("includes/includes.php")?>

    <div id="headerPage">
        <h3>Accueil</h3>
    </div>

    <div id="ensemble">
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
