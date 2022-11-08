<?php
try{
    $pdo = new \PDO('mysql:host=localhost;dbname=library', 'root', '********');
    $pdo->exec('SET NAMES "UTF8"');
} catch (PDOException $e){
    echo 'Erreur : '. $e->getMessage();
    die(); 
}

$booksQuery = $pdo->query("SELECT book.*, author.fullname FROM book LEFT JOIN author ON author.id=book.author_id ORDER BY author.id");
$books = $booksQuery->fetchAll(PDO::FETCH_ASSOC);
$authorsQuery = $pdo->query("SELECT * FROM author");
$authors = $authorsQuery->fetchAll(PDO::FETCH_ASSOC);
$searchinbooks = $pdo->query("SELECT book.*, author.fullname FROM book LEFT JOIN author ON author.id=book.author_id ORDER BY author.id");