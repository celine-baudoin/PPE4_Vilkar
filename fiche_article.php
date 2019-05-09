<?php
$bdd = new PDO('mysql:host=localhost;dbname=vilkar;charset=utf8', 'root', '');

if(isset($_GET['Id_Produit']) AND !empty($_GET['Id_Produit']))
{
    $get_id = htmlspecialchars($_GET['Id_Produit']);
    $article = $bdd->prepare('SELECT * FROM produits WHERE Id_Produit = ?');
    $article->execute(array($get_id));

    if($article->rowCount() == 1)
    {
        $article = $article->fetch();
        $libelle = $article['Libelle_Produit'];
        $description = $article['Description'];
        $prix = $article['Prix'];

    }
    else
    {
        die('Cet article n\'existe pas');
    }
}
else
{
    die('Erreur');
}
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
    <h1><?= $libelle ?></h1>
    <p><?= $description ?></p>
    <p><?= $prix ?></p>
  </div>

</body>
</html>
