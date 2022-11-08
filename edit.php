<?php 
session_start();
require_once('config.php');

if($_POST){
    if(!empty($_POST['title']) && !empty($_POST['author_id'])){

    $id = strip_tags($_POST['id']);
    $title = strip_tags($_POST['title']);
    $authorsid = strip_tags($_POST['author_id']);
    $descr = strip_tags($_POST['descr']);

    $sql= 'UPDATE `book` SET `title`=:title, `author_id`=:author_id, `descr`=:descr WHERE `id`=:id;';

    $query = $pdo->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_STR);
    $query->bindValue(':title', $title, PDO::PARAM_STR);
    $query->bindValue(':author_id', $authorsid, PDO::PARAM_INT);
    $query->bindValue(':descr', $descr, PDO::PARAM_STR);
    $query->execute();

    $_SESSION['message'] = "Livre modifié";
    require_once('close.php');
    header('Location: index.php');
    
    }else{
    $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}

if(!empty($_GET['id'])){
    require_once('config.php');
    $id = strip_tags($_GET['id']);
    $sql = 'SELECT book.*, author.fullname FROM book JOIN author ON author.id=book.author_id WHERE book.id=:id;';
    $query = $pdo->prepare($sql);
    $query->bindValue('id', $id, PDO::PARAM_INT);
    $query->execute();
    $book = $query->fetch();

    if(!$book){
        $_SESSION['erreur'] = "Livre introuvable";
        header('Location: index.php');
    }
}else{
    $_SESSION['erreur'] = "URL Invalide";
    header('Location: index.php');
}

?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Modification de <?= $book['title']?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <main class="container">
        <?php
            if(!empty($_SESSION['erreur'])){
            echo '<div class="alert alert-danger" role="alert">'.$_SESSION['erreur'].'</div>';
            $_SESSION['erreur'] = "";
            }
        ?>
        <div class="row">
            <section class="col-12">           
                <h1>Modification de livre <?= $book['title']?></h1>
                <form method="post">
                    <div class="form-group">
                        <label for="title">Titre</label>
                        <input type="text" id="title" name="title" class="form-control" value="<?= $book['title'] ?>">
                    </div>
                    <div class="form-group">
                    <label for="author_id">Auteur</label>
                        <select name="author_id" id="author_id" value="<?= $book['author_id']?>" class="form-control">
                        <?php 
                            foreach ($authors as $author) {
                            echo '<option value="' . $author['id'] . '"';
                            if($author['id']==$book['author_id']){
                            echo 'selected';
                            }
                            echo '>'. $author['fullname'] . '</option>';
                            }
                        ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="descr">Description (Facultatif)</label>
                        <input type="text" id="descr" name="descr" class="form-control" value="<?= $book['descr'] ?>">
                    </div>
                    <input type="hidden" value="<?= $book['id']?>" name="id">
                    <button name="modify" type="submit" class="btn btn-primary">Envoyer</button><a href="index.php">   Retour</a>
                </form>
            </section>
        </div>
    </main>
</body>
</html>