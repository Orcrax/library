<?php 
session_start();
require_once('config.php');

if($_POST){
    if(!empty($_POST['title']) && !empty($_POST['author_id'])){

    $title = strip_tags($_POST['title']);
    $authorsid = strip_tags($_POST['author_id']);
    $descr = strip_tags($_POST['descr']);

    $sql= "INSERT INTO book(`title`, `author_id`, `descr`) VALUES (:title, :author_id, :descr);";

    $query = $pdo->prepare($sql);
    $query->bindValue(':title', $title, PDO::PARAM_STR);
    $query->bindValue(':author_id', $authorsid, PDO::PARAM_INT);
    $query->bindValue(':descr', $descr, PDO::PARAM_STR);
    $query->execute();

    $_SESSION['message'] = "Livre ajouté";
    require_once('close.php');
    header('Location: index.php');
    
    }else{
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Ma Biblio</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
            <?php
                    if(!empty($_SESSION['erreur'])){
                        echo '<div class="alert alert-danger" role="alert">'. $_SESSION['erreur'].'</div>';
                        $_SESSION['erreur'] = "";
                    }
                ?>
                <h1>Ajout de livre</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="title">Titre</label>
                        <input type="text" id="title" name="title" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="author">Auteur</label>
                        <select id="author" name="author_id" class="form-control">
                                <?php foreach ($authors as $author) {
                                    echo '<option value="' . $author['id'] . '">' . $author['fullname'] . '</option>';
                                }
                                ?>
                        </select>             
                    </div>
                    <div class="form-group">
                        <label for="descr">Description (Facultatif)</label>
                        <input type="text" id="descr" name="descr" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Envoyer</button><a href="index.php">   Retour</a>
                </form>
            </section>
        </div>
    </main>
</body>
</html>