<?php
session_start();
require_once("includes/script.php");
require_once("fonctions_panier.php");
if(isset($_POST['libelle_produit'], $_POST['description_produit'], $_POST['prix_produit']))
{
    if(!empty($_POST['libelle_produit']) AND !empty($_POST['prix_produit']) AND !empty($_POST['description_produit']))
    {
       $libelle_produit = htmlspecialchars($_POST['libelle_produit']);
       $description_produit = htmlspecialchars($_POST['description_produit']);
       $prix_produit = htmlspecialchars($_POST['prix_produit']);

        $getid = intval($_GET['Id_Membre']);
        $requser = $bdd->prepare('SELECT * FROM membres WHERE Id_Membre=?');
        $requser->execute(array($getid));
        $userinfo = $requser->fetch();


        $insert = $bdd->prepare('INSERT INTO produits(Libelle_Produit, Description, Prix)VALUES(?, ?, ?)');
        $insert->execute(array($libelle_produit, $description_produit, $prix_produit));

        $message='Votre produit à bien été ajouté';
    }

    else
    {
        $message = 'Veuillez remplir tous les champs!';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vendre</title>
    <meta charset="utf-8">
</head>
<body>
    <form method="POST">
        <input type="text" name="libelle_produit" placeholder="Libelle" /><br />
        <input type="number" name="type_produit" placeholder="Type" step="1" min="0" max="6" /><br />
        <p>Merci de bien vouloir mettre le code lié à votre article</p>
            <ul>
            <li>Mettez 1 pour un PC fixe</li>
            <li>Mettez 2 pour un PC Portable</li>
            <li>Mettez 3 pour un ecran</li>
            <li>Mettez 4 pour une souris</li>
            <li>Mettez 5 pour des enceintes</li>
            <li>Mettez 6 pour un clavier</li>
        </ul>

   <label>Identifiant: </label>
        <input type="number" name="identifiant" placeholder="Identifiant" value="<?php echo $user['Id_Membre'];?>"/><br /><br />
        <textarea name="description_produit" placeholder="Description"></textarea><br />
        <input type="number" name="prix_produit" placeholder="1.0" step="0.50" min="0" max="500"><br />
        <input type="submit" value="Mettre l'article en vente" />
    </form>
    <br />
    <?php
        if(isset($message))
        {
            echo $message;
        }
    ?>
</body>
</html>
