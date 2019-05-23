<?php

function creationPanier() {
  if(!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = array();
    $_SESSION['panier']['Id_Produit'] = array();
    $_SESSION['panier']['Libelle_Produit'] = array();
    $_SESSION['panier']['Prix'] = array();
  }
}

function ajouterArticle($Id_Produit,$Libelle_Produit,$Prix) {
  // Si le panier existe
  if (isset($_SESSION['panier'])) {
    // On regarde si le produit est déjà dans le panier
    $position_pdt = array_search($Id_Produit, $_SESSION['panier']['Id_Produit']);
    if ($position_pdt !== false) {
      // S'il est déjà dans le panier on le notifie au client
      echo "<p>L'article est déjà dans le panier.</p>";
    } else {
      // Sinon on l'ajoute
      array_push($_SESSION['panier']['Id_Produit'], $Id_Produit);
      array_push($_SESSION['panier']['Libelle_Produit'], $Libelle_Produit);
      array_push($_SESSION['panier']['Prix'], $Prix);
      echo "<p>L'article a été ajouté au panier.</p>";
    }
  } else {
    // Sinon on le crée
    creationPanier();
  }
}

function supprimerArticle($Libelle_Produit) {
  // Si le panier existe
  if (isset($_SESSION['panier'])) {
    // Création du panier temporaire
    $tmp = array();
    $tmp['Id_Produit'] = array();
    $tmp['Libelle_Produit'] = array();
    $tmp['Prix'] = array();

    for ($i = 0; $i < count($_SESSION['panier']['Libelle_Produit']); $i++) {
      if ($_SESSION['panier']['Libelle_Produit'][$i] !== $Libelle_Produit) {
        array_push($tmp['Id_Produit'], $_SESSION['panier']['Id_Produit'][$i]);
        array_push($tmp['Libelle_Produit'], $_SESSION['panier']['Libelle_Produit'][$i]);
        array_push($tmp['Prix'], $_SESSION['panier']['Prix'][$i]);
      }
    }
    // On remplace notre panier session par le panier temp
    $_SESSION['panier'] = $tmp;
    // On efface le panier temporaire
    unset($tmp);
  } else {
    echo "Un problème est survenu veuillez contacter l'administrateur du site.";
  }
}

function MontantGlobal() {
  $total = floatval(0);
  for ($i = 0; $i < count($_SESSION['panier']['Libelle_Produit']); $i++) {
    $total += $_SESSION['panier']['Prix'][$i];
  }
  return $total;
}

function supprimerPanier() {
  unset($_SESSION['panier']);
}

function compterArticles() {
  if (isset($_SESSION['panier'])) {
    return count($_SESSION['panier']['Libelle_Produit']);
  } else {
    return 0;
  }
}
?>
