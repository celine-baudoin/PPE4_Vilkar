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
        <h3>Filtrer par catégorie</h3>
    </div>

    <div id="ensemble">
      <ul>
        <li><a href="tous.php">Tous nos articles</a></li>
        <li><a href="claviers.php">Claviers</a></li>
        <li><a href="ecrans.php">Ecrans</a></li>
        <li><a href="enceintes.php">Enceintes</a></li>
        <li><a href="pc_fixes.php">PC Fixes</a></li>
        <li><a href="pc_portables.php">PC Portables</a></li>
        <li><a href="souris.php">Souris</a></li>
      </ul>
    </div>

  </body>
</html>
