<?php
session_start();
require_once("includes/script.php");
require_once("fonctions_panier.php");

if(isset($_GET['Id_Produit']) AND !empty($_GET['Id_Produit']))
{
    $Id_Produit = htmlspecialchars($_GET['Id_Produit']);
    $article = $bdd->prepare('SELECT * FROM produits INNER JOIN types ON produits.Id_Type_Produit = types.Id_Type INNER JOIN membres ON produits.Id_Membre_Produit = membres.Id_Membre WHERE Produits.Id_Produit = ?');
    $article->execute(array($Id_Produit));
    $Donnees_Produit = $article->fetch();
    $Libelle_Produit = $Donnees_Produit['Libelle_Produit'];
    $Description_Produit = $Donnees_Produit['Description_Produit'];
    $Prix_Produit = $Donnees_Produit['Prix_Produit'];
    $commentaires = $bdd->query('SELECT * FROM commentaires INNER JOIN membres ON commentaires.Id_Membre_Com = membres.Id_Membre INNER JOIN produits ON commentaires.Id_Produit_Com = produits.Id_Produit WHERE Produits.Id_Produit ='.$Id_Produit);
    if ($commentaires !== false) {
        $Donnees_Commentaire = $commentaires->fetchAll();
    }




}
else
{
    die('Erreur');
}
if (isset($_POST['comment'])) {
    if (!empty($_POST['objet']) && !empty($_POST['commentaire'])) {
        $Objet_Com = htmlspecialchars($_POST['objet']);
        $Texte_Com = htmlspecialchars($_POST['commentaire']);
        $Date_Com = date("Y-m-d H:i:s");
        $Id_Produit_Com = $Id_Produit;
        $Id_Membre_Com = intval($_SESSION['Id_Membre']);
        try {
            $req = $bdd->prepare('INSERT INTO commentaires(Objet_Com, Date_Com, Texte_Com, Id_Produit_Com, Id_Membre_Com) VALUES (?,?,?,?,?)');
            $req->execute(array($Objet_Com,$Date_Com,$Texte_Com,$Id_Produit_Com,$Id_Membre_Com));
            echo "<p>Votre commentaire a bien été posté</p>";
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}



?>


<!DOCTYPE html>
<html>
<?php require_once("includes/head.php")?>
<body>
  <?php require_once("includes/includes.php")?>

  <div id="headerPage">
      <h3><?= $Libelle_Produit ?></h3>
  </div>

  <div id="ensemble">
    <div id="ensembleFicheProduit">
      <img src="<?php echo $Donnees_Produit['Image_Produit'] ?>" alt="Image produit"/>
      <p><?= $Description_Produit ?></p>
      <p><?= $Prix_Produit ?>€
        <form action="fiche_article.php?Id_Produit=<?=$Donnees_Produit['Id_Produit'] ?>" method="POST">
          <input type="submit" class="bouton" name="ajout_panier" value="Ajouter au panier">
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['ajout_panier'])) {
          ajouterArticle($Id_Produit,$Libelle_Produit,$Prix_Produit);
        }
        ?>
      </p>

      <div class="commentaire">
        <h2>Posez une question au vendeur</h2>
        <form class="" action="fiche_article.php?Id_Produit=<?=$Donnees_Produit['Id_Produit'];?>" method="post">
          <input type="text" class="texte" name="objet" placeholder="Objet">
          <input type="text" class="texte" name="commentaire" placeholder="Commentaire"/>
          <input type="submit" class="bouton" value="Envoyer" name="comment"/>
        </form>
        <?php
          foreach ($Donnees_Commentaire as $row) {
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
    </div>
  </div>

</body>
</html>
