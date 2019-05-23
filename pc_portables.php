<?php
session_start();
require_once("includes/script.php");
require_once("fonctions_panier.php");
?>

<!DOCTYPE html>
<html>
<?php require_once("includes/head.php")?>
<body>
    <?php require_once("includes/includes.php")?>

    <div id="headerPage">
        <h3>PC Portables</h3>
    </div>

    <div id="ensemble" class="catalogue">
      <?php
        $produits = $bdd->query('SELECT * FROM produits INNER JOIN images ON produits.Id_Image_Pro = images.Id_Image INNER JOIN types ON produits.Id_Type_Pro = types.Id_Type INNER JOIN membres ON produits.Id_Membre_Pro = membres.Id_Membre WHERE Libelle = "PC Portable"');
        $donnees = $produits->fetchAll();
        foreach ($donnees as $row) { ?>
        <div class="produit">
          <p class="title"><?php echo $row['Libelle_Produit'] ?></p>
          <a href="fiche_article.php?Id_Produit=<?= $row['Id_Produit'] ?>"><img src="<?php echo $row['Lien_Image'] ?>" /></a>
          <p><?php echo $row['Prix'] ?> €</p>
        </div>
        <?php } ?>
      </div>

    </body>
  </html>
