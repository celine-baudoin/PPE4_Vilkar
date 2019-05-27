<?php
session_start();
require_once("includes/script.php");
require_once("fonctions_panier.php");
$_SESSION['types'] = $bdd->query('SELECT * FROM types')->fetchAll();
if(isset($_POST['vendre'])) {
  if(!empty($_POST['libelle']) && !empty($_POST['description']) && !empty($_POST['prix']) && !empty($_POST['types'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES['fileToUpload']['name']);
    $upload_ok = 1;
    $image_file_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      $check = getimagesize($_FILES['fileToUpload']['tmp_name']);
      if ($check !== false) {
        $upload_ok = 1;
      } else {
        echo "<p>Le fichier n'est pas une image</p>";
        $upload_ok = 0;
      }
      if (file_exists($target_file)) {
        echo "<p>Désolé, l'image existe déjà. Choisissez-en une autre ou renommez-la.</p>";
        $upload_ok = 0;
      }
      if ($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg" && $image_file_type != "gif") {
        echo "<p>Désolé, seulement les extensions JPG, JPEG, PNG et GIF sont autorisées.";
        $upload_ok = 0;
      }
      if ($upload_ok == 0) {
        echo "<p>Désolé, votre image n'a pas pu être enregistrée.</p>";
      } else {
        if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file)) {
          $pdt_libelle = htmlspecialchars($_POST['libelle']);
          $pdt_description = htmlspecialchars($_POST['description']);
          $pdt_prix = htmlspecialchars(floatval($_POST['prix']));
          $pdt_type = htmlspecialchars($_POST['types']);
          $pdt_img_lien = "uploads/".$_FILES['fileToUpload']['name'];
          $pdt_membre = $_SESSION['Id_Membre'];

          try {
            $requete = $bdd->prepare('INSERT INTO produits(Libelle_Produit,Description_Produit,Prix_Produit,Id_Type_Produit,Image_Produit,Id_Membre_Produit) VALUES(?,?,?,?,?,?)');
            $requete->execute(array($pdt_libelle,$pdt_description,$pdt_prix,$pdt_type,$pdt_img_lien,$pdt_membre));
            echo "<p>Votre produit a bien été ajouté</p>";
          } catch(PDOException $e) {
            echo $requete . "<br>" . $e->getMessage();
          }
        }
      }
  } else {
    echo "<p>Tous les champs doivent être renseignés.</p>";
  }
}
?>
<!DOCTYPE html>
<html>
<?php require_once("includes/head.php")?>
<body>
    <?php require_once("includes/includes.php")?>

    <div id="headerPage">
        <h3>Vendre</h3>
    </div>
    <div id="ensemble">
        <h1>Vendre un article</h1>
            <?php
            if(isset($_SESSION['Id_Membre'])) {
              ?>
              <form class="" action="vendre.php" method="post" enctype="multipart/form-data">
                <table>
                  <tr>
                    <td>Titre du produit à mettre en vente</td>
                    <td><input type="text" name="libelle"></td>
                  </tr>
                  <tr>
                    <td>Description du produit</td>
                    <td><input type="text" name="description"></td>
                  </tr>
                  <tr>
                    <td>Prix</td>
                    <td><input type="text" name="prix"></td>
                  </tr>


                  <tr>
                    <td>Choisissez le type</td>
                    <td>
                      <select id="types" required="true" name="types">
                        <?php
                        foreach ($_SESSION['types'] as $row) {
                          echo "<option value=\"".$row['Id_Type']."\">".$row['Libelle_Type']."</option>";
                        }
                        ?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>Choisissez une image pour votre produit</td>
                    <td><input type="file" name="fileToUpload" id="fileToUpload"></td>
                  </tr>
                  <tr>
                    <td><input type="submit" class="bouton" value="Vendre" name="vendre"></td>
                  </tr>
                </table>
              </form>
              <?php
            } else {
              ?>
              <p>Vous devez d'abord vous connecter pour pouvoir vendre vos articles. <a href="connexion.php">Connexion</a></p>
              <p>Pas encore de compte ? <a href="inscription.php">Inscrivez-vous !</a></p>
              <?php
            }
            ?>
    </div>
</body>
</html>
