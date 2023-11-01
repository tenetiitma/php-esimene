<?php

require_once('./connection.php');

$id = $_GET['id'];

$stmt = $pdo->prepare('SELECT * FROM books WHERE id = :id');
$stmt->execute(['id' => $id]);
$book = $stmt->fetch();

$stmt = $pdo->prepare('SELECT * FROM book_authors ba LEFT JOIN authors a ON a.id=ba.author_id WHERE book_id=:book_id;');
$stmt->execute(['book_id' => $id]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $book['title']; ?></title>
</head>
<body>
    <h1><?= $book['title']; ?></h1>
    <ul>

<?php
    while ( $author = $stmt->fetch() ) {
?>

        <li><?= $author['first_name']; ?> <?= $author['last_name']; ?></li>

<?php
    }
?>
    </ul>
    <p>Ilmumisaasta: <?= $book['release_date']; ?> </p>
    <p>Keel: <?= $book['language']; ?> </p>
    <p>Lehekülgi: <?= $book['pages']; ?> lk</p>
    <img src="<?= $book['cover_path']; ?>">
    <p>Hind: <?= round($book['price'], 2); ?> €</p>
    <p><?= $book['summary']; ?> </p>

    <form action="delete.php" method="post" id="delete">
        <input type="hidden" name="id" value="<?= $id; ?>">
        <button form="delete">Kustuta</button>
    </form>

    <a href="./editBooks.php?id=<?= $book['id']; ?>"><button>Muuda andmeid</button></a>

</body>
</html>