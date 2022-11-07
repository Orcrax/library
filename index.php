<?php 
session_start();
require_once('config.php');
$sql = 'SELECT book.*, author.fullname FROM book LEFT JOIN author ON author.id=book.author_id';
$query = $pdo->prepare($sql);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);

/* ############SEARCHBAR############ */
if(isset($_GET['searchbar']) && !empty($_GET['searchbar'])){
    $search = htmlspecialchars($_GET['searchbar']);
    $searchinbooks = $pdo->query('SELECT book.*, author.fullname FROM book LEFT JOIN author ON author.id=book.author_id WHERE book.title LIKE "%'.$search.'%" OR author.fullname LIKE "%'.$search.'%" ORDER BY id');
}
/* ############SEARCHBAR############ */
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Ma Biblio</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<?php
    $books = $pdo->query('SELECT b.*, a.fullname FROM library.book b LEFT JOIN author a on a.id = b.author_id');
?>

    <main class="container">
        <div class="row">
            <section class="col-12">
                <?php
                    if(!empty($_SESSION['erreur'])){
                        echo '<div class="alert alert-danger" role="alert">'.$_SESSION['erreur'].'</div>';
                        $_SESSION['erreur'] = "";
                    }
                ?>                
                <h1>Bibliothèque</h1>
                <div class="form">
                    <i class="fa fa-search"></i>
                    <form method="GET">
                        <input type="search" name="searchbar" placeholder="Rechercher un livre ou un auteur..." class="form-control form-input">
                        <input class="btn btn-primary" type="submit" name="Rechercher">
                    </form>
                </div>
    <!-- ################################################## -->

    <section class="search_results">
    <table class="table">
        <thead>
            <th>Titre</th>
            <th>Auteur</th>
            <th></th>
        </thead>
        <?php
            if($searchinbooks->rowCount() > 0){
                while($book = $searchinbooks->fetch()){
                    ?>                                       
                    <tbody>
                    <tr>
                        <td><?= $book['title'] ?></td>
                        <td><?= $book['fullname'] ?></td>
                        <td><a href="detail.php?id=<?= $book['id']?>">Détails</a>  <a href="edit.php?id=<?= $book['id']?>">Edit</a>
                        <a href="erase.php?id=<?= $book['id']?>">Supprimer</a></td>
        <?php 
        }

        }else{
            ?>
            <p>Aucun livre trouvé</p>
            <?php
            }
        ?>
        </table>
    </section>

              <a class="btn btn-primary" href="add.php">Ajouter un livre</a>
            </section>
        </div>
    </main>
</body>
</html>