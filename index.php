<?php 
session_start();
require_once('config.php');
$sql = 'SELECT book.*, author.fullname FROM book LEFT JOIN author ON author.id=book.author_id';
$query = $pdo->prepare($sql);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);

/* ############SEARCHBAR############ */

if(isset($_GET['searchbarbooks']) && !empty($_GET['searchbarbooks'])){
    $search = strip_tags(addslashes($_GET['searchbarbooks']));
    $searchinbooks = $pdo->query('SELECT book.* FROM book LEFT JOIN author ON author.id=book.author_id WHERE book.title LIKE "%'.$search.'%" ORDER BY id');
}
if(isset($_GET['searchbarauthors']) && !empty($_GET['searchbarauthors'])){
    $search = strip_tags(htmlspecialchars($_GET['searchbarauthors']));
    $searchinbooks = $pdo->query('SELECT book.*, author.fullname FROM book LEFT JOIN author ON author.id=book.author_id WHERE author.id LIKE "%'.$search.'%"');
}
/* ############SEARCHBAR############ */
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>L'Île Lettrée</title>
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
                <h1 style="margin-left:10em;margin-top:1,5em;color:#007BFF;text-decoration:underline;">L'Île Lettrée</h1>
                <div class="form">
                    <i class="fa fa-search"></i>
                    <form method="GET">

                        <label for="book">Recherche par titre de livre</label>
                        <input type="search" name="searchbarbooks" placeholder="Rechercher un livre" class="form-control form-input">
                        <button style="float:right;" class="btn btn-primary" type="submit" name="Rechercher">Rechercher</button><br>
                        </form>

                        <form method="GET">

                        <label for="author">Recherche par auteur</label>
                        <select name="searchbarauthors" id="author" name="author_id" class="form-control">
                                <?php foreach ($authors as $author) {
                                    echo '<option value="' . $author['id'] . '">' . $author['fullname'] . '</option>';
                                }
                                ?>
                        </select>             
                    
                        <button style="float:right;" class="btn btn-primary" type="submit" name="Rechercher">Rechercher</button>
                        
                    </form>
                </div>
    <!-- ################################################## -->

    <section style="margin-left:5em;" class="search_results">
        <table class="table">
            <thead>
                <th style="color:#007BFF; text-decoration:underline; font-weight:bold; font-size:1.3em;">Titre</th>
                <th style="color:#007BFF; text-decoration:underline; font-weight:bold; font-size:1.3em;">Auteur</th>
            </thead>
            <?php
                if($searchinbooks->rowCount() > 0){
                    while($book = $searchinbooks->fetch()){
                        ?>                                       
                        <tbody>
                        <tr>
                            <td><?= $book['title'] ?></td>
                            <td><?= $book['fullname'] ?></td>
                            <td><a class="btn btn-outline-info" href="detail.php?id=<?= $book['id']?>">Détails</a>  <a class="btn btn-outline-warning" href="edit.php?id=<?= $book['id']?>">Edit</a>
                            <a class="btn btn-outline-danger" href="erase.php?id=<?= $book['id']?>">Supprimer</a></td>
                            <?php 
                                }
                                }else{
                            ?>
                            <p style="color:red; text-align:center; text-decoration:underline; font-weight:bold;font-size:2em;">Aucun livre ou auteur trouvé</p>
                            <?php
                                }
                            ?>
        </table>
    </section>

              <a style="width:100%;" class="btn btn-primary" href="add.php">Ajouter un livre</a>
            </section>
        </div>
    </main>
</body>
</html>