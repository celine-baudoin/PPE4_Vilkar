<?php
session_start();
require_once("includes/script.php");
require_once("fonctions_panier.php");

if(isset($_GET['Id_Produit']) AND !empty($_GET['Id_Produit']))
{
    $Id_Produit = htmlspecialchars($_GET['Id_Produit']);
    $article = $bdd->prepare('SELECT * FROM produits INNER JOIN types ON produits.Id_Type_Produit = types.Id_Type INNER JOIN membres ON produits.Id_Membre_Produit = membres.Id_Membre WHERE Produits.Id_Produit = ?');
    $article->execute(array($Id_Produit));


    if($article->rowCount() == 1)
    {
        $article = $article->fetch();
        $Libelle_Produit = $article['Libelle_Produit'];
        $Description = $article['Description_Produit'];
        $Prix = $article['Prix_Produit'];
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



$commentaires = $bdd->query('SELECT * FROM commentaires INNER JOIN membres ON commentaires.Id_Membre_Com = membres.Id_Membre INNER JOIN produits ON commentaires.Id_Produit_Com = produits.Id_Produit WHERE Produits.Id_Produit ='.$Id_Produit);
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
      <img src="<?php echo $article['Image_Produit'] ?>" alt="Image produit"/>
      <p><?= $Description ?></p>
      <p><?= $Prix ?>€
              <?php
         if(isset($_SESSION['Id_Membre'])) {
        ?><form action="fiche_article.php?Id_Produit=<?= $article['Id_Produit'] ?>" method="POST"><input type="submit" name="ajout_panier" value="Ajouter au panier"></form>
        <?php
         } else {
             ?>
              <p>Vous devez d'abord vous connecter pour pouvoir vendre vos articles. <a href="connexion.php">Connexion</a></p>
              <p>Pas encore de compte ? <a href="inscription.php">Inscrivez-vous !</a></p>
              <?php
         }
    ?>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['ajout_panier'])) {
          ajouterArticle($Id_Produit,$Libelle_Produit,$Prix);
        }
        ?>
      </p>
      <?php
 if(isset($_SESSION['Id_membre'])) {
?>
      <div class="commentaire">
        <h2>Posez une question au vendeur</h2>
        <form class="" action="fiche_article.php" method="post">
          <input type="text" name="objet" placeholder="Objet">
          <input type="text" name="commentaire" placeholder="Commentaire"/>
          <input type="submit" value="Envoyer"/>
        </form>
        <?php
          foreach ($donnees as $row) {
            if ($row['Id_Membre_Com'] == $row['Id_Membre_Produit']) { ?>
            <div class="reponse">
              <h3 class="objet"><?php echo $row['Objet_Com'] ?></h3>
              <p><?php echo $row['Texte_Com'] ?></p>
              <p>Réponse postée le <?php echo $row['Date_Com'] ?></p>
            </div>
          <?php } else { ?>
              <div class="question">
                <h3 class="objet"><?php echo $row['Objet_Com'] ?></h3>
                <p><?php echo $row['Texte_Com'] ?></p>
                <p>Question posée par <?php echo $row['Prenom'] ?> le <?php echo $row['Date_Com'] ?></p>
              </div>
          <?php }
        } ?>
      </div>
          <?php 
        } ?>
    </div>
  </div>

</body>
</html>
