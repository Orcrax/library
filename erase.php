<?php
session_start();

if(isset($_GET['id']) && !empty($_GET['id'])){
    require_once('config.php');
    $id = strip_tags($_GET['id']);
    $sql = 'SELECT * FROM book WHERE id = :id;';
    $query = $pdo->prepare($sql);
    $query->bindValue('id', $id, PDO::PARAM_INT);
    $query->execute();
    $book = $query->fetch();

    if(!$book){
        $_SESSION['erreur'] = "Livre introuvable";
        header('Location: index.php');
    }
    $sql = 'DELETE FROM book WHERE id = :id;';
    $query = $pdo->prepare($sql);
    $query->bindValue('id', $id, PDO::PARAM_INT);
    $query->execute();

    $_SESSION['message'] = "Livre supprimé";
    header('Location: index.php');


}else{
    $_SESSION['erreur'] = "URL Invalide";
    header('Location: index.php');
}
?>
