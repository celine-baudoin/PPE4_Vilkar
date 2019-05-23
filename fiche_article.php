<?php
session_start();
require_once("includes/script.php");
require_once("fonctions_panier.php");

if(isset($_GET['Id_Produit']) AND !empty($_GET['Id_Produit']))
{
    $get_id = htmlspecialchars($_GET['Id_Produit']);
    $article = $bdd->prepare('SELECT * FROM produits INNER JOIN images ON produits.Id_Image_Pro = images.Id_Image INNER JOIN types ON produits.Id_Type_Pro = types.Id_Type INNER JOIN membres ON produits.Id_Membre_Pro = membres.Id_Membre WHERE Produits.Id_Produit = ?');
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



$commentaires = $bdd->query('SELECT * FROM commentaires INNER JOIN membres ON commentaires.Id_Membre_Comment = membres.Id_Membre INNER JOIN produits ON commentaires.Id_Produit_Comment = produits.Id_Produit WHERE Produits.Id_Produit ='.$get_id);
$donnees = $commentaires->fetchAll();
//var_dump($donnees[0]['Id_Commentaire']);
//exit();
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
      <h1><?= $libelle ?></h1>
      <img src="<?php echo $article['Lien_Image'] ?>" alt="Image produit"/>
      <p><?= $description ?></p>
      <p><?= $prix ?>€ <button type="button" name="ajout_panier">Ajouter au panier</button></p>

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
