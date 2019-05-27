<meta charset="UTF-8" />
<?php
$bdd = new PDO('mysql:host=localhost;dbname=vilkar;charset=utf8', 'root', '');

if(isset($_GET['Id_Produit']) AND !empty($_GET['Id_Produit'])){
    $getid = htmlspecialchars($_GET['Id_Produit']);

    $article = $bdd->prepare('SELECT * FROM produits WHERE Id_Produit = ?');
    $article->execute(array($getid));
    $article = $article->fetch();

    if(isset($_POST['submit_commentaire'])){
        if(isset($_POST['pseudo'],$_POST['commentaire']) AND !empty($_POST['pseudo']) AND !empty($_POST['commentaire'])){
            $pseudo = htmlspecialchars($_POST['pseudo']);
            $commentaire = htmlspecialchars($_POST['commentaire']);
        }else{
            $c_erreur="Tous les champs doivent être complétés";
        }
    }
?>
<h1>Article</h1>
<p><?= $article['contenu']  ?></p>

<br />
<br />

<h2>Commentaires</h2>
<form method="POST">
<input type="text" name="pseudo" placeholder"Votre Pseudo" /><br />
<textarea name="commentaire" placeholder="Votre commentaire" /><br />
<input type="submit" class="bouton" value="Poster mon commentaire" name="submit_commentaire" /><br />
</form>
<?php if (isset($c_erreur)) {echo $c_erreur;}?>
<?php
}
?>
