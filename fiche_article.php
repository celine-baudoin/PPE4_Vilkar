<?php
session_start();
require_once("includes/script.php");
require_once("fonctions_panier.php");

if(isset($_GET['Id_Produit']) AND !empty($_GET['Id_Produit']))
{
    $Id_Produit = htmlspecialchars($_GET['Id_Produit']);
    $article = $bdd->prepare('SELECT * FROM produits INNER JOIN images ON produits.Id_Image_Pro = images.Id_Image INNER JOIN types ON produits.Id_Type_Pro = types.Id_Type INNER JOIN membres ON produits.Id_Membre_Pro = membres.Id_Membre WHERE Produits.Id_Produit = ?');
    $article->execute(array($Id_Produit));


    if($article->rowCount() == 1)
    {
        $article = $article->fetch();
        $Libelle_Produit = $article['Libelle_Produit'];
        $Description = $article['Description'];
        $Prix = $article['Prix'];
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



$commentaires = $bdd->query('SELECT * FROM commentaires INNER JOIN membres ON commentaires.Id_Membre_Comment = membres.Id_Membre INNER JOIN produits ON commentaires.Id_Produit_Comment = produits.Id_Produit WHERE Produits.Id_Produit ='.$Id_Produit);
$donnees = $commentaires->fetchAll();
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
    <div id="ensembleFicheProduit">
      <h1><?= $Libelle_Produit ?></h1>
      <img src="<?php echo $article['Lien_Image'] ?>" alt="Image produit"/>
      <p><?= $Description ?></p>
      <p><?= $Prix ?>€
        <form action="fiche_article.php?Id_Produit=<?= $article['Id_Produit'] ?>" method="POST"><input type="submit" name="ajout_panier" value="Ajouter au panier"></form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['ajout_panier'])) {
          ajouterArticle($Id_Produit,$Libelle_Produit,$Prix);
        }
        ?>
      </p>

      <div class="commentaire">
        <h2>Posez une question au vendeur</h2>
        <form class="" action="fiche_article.php" method="post">
          <input type="text" name="objet" placeholder="Objet">
          <input type="text" name="commentaire" placeholder="Commentaire"/>
          <input type="submit" value="Envoyer"/>
        </form>
        <?php
          foreach ($donnees as $row) {
            if ($row['Id_Membre_Comment'] == $row['Id_Membre_Pro']) { ?>
            <div class="reponse">
              <h3 class="objet"><?php echo $row['Objet'] ?></h3>
              <p><?php echo $row['Texte'] ?></p>
              <p>Réponse postée le <?php echo $row['DateCom'] ?></p>
            </div>
          <?php } else { ?>
              <div class="question">
                <h3 class="objet"><?php echo $row['Objet'] ?></h3>
                <p><?php echo $row['Texte'] ?></p>
                <p>Question posée par <?php echo $row['Prenom'] ?> le <?php echo $row['DateCom'] ?></p>
              </div>
          <?php }
        } ?>
      </div>
    </div>
  </div>

</body>
</html>
