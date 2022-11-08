<?php
session_start();

if(isset($_GET['id']) && !empty($_GET['id'])){
    require_once('config.php');
    $id = strip_tags($_GET['id']);
    $sql = 'SELECT book.*, author.fullname FROM book JOIN author ON author.id=book.author_id WHERE book.id = :id;';
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

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Détails du livre <?= $book['title']?></title>
</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <h1>Informations du livre <?= $book['book']?></h1>
                <p>Titre : <?= $book['title']?></p>
                <p>Auteur : <?= $book['fullname']?></p>
                <p>Synopsis : <?= $book['descr']?></p>
                <p><a class="btn btn-secondary btn-sm" href="index.php">Retour</a>    <a class="btn btn-outline-warning" href="edit.php?id=<?= $book['id'] ?>">Modifier</a>                <a class="btn btn-outline-danger" href="erase.php?id=<?= $book['id']?>">Supprimer</a></p>
            </section>
        </div>
    </main>
</body>
</html>