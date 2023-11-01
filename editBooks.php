<?php

require_once('./connection.php');

$id = $_GET['id'] ?? $_POST['id'];

$stmt = $pdo->prepare('SELECT * FROM books WHERE id = :id');
$stmt->execute(['id' => $id]);
$book = $stmt->fetch();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $book['title']; ?></title>
</head>
<body>
    <h1>Muuda raamatut: <?= $book['title']; ?> </h1>

    Pealkiri:
    <form action="update_field.php" method="post">
        <input type="hidden" name="id" value="<?= $id; ?>">
        <input type="hidden" name="field" value="title">
        <input type="text" name="value" value="<?= $book['title']; ?>">
        <input type="submit" value="Update">
    </form>

    Ilmumisaasta:
    <form action="update_field.php" method="post">
        <input type="hidden" name="id" value="<?= $id; ?>">
        <input type="hidden" name="field" value="release_date">
        <input type="text" pattern="\d{4}" title="Enter a valid year" name="value" value="<?= $book['release_date']; ?>">
        <input type="submit" value="Update">
    </form>

    Keel:
    <form action="update_field.php" method="post">
        <input type="hidden" name="id" value="<?= $id; ?>">
        <input type="hidden" name="field" value="language">
        <input type="text" name="value" value="<?= $book['language']; ?>">
        <input type="submit" value="Update">
    </form>

    Pages:
    <form action="update_field.php" method="post">
        <input type="hidden" name="id" value="<?= $id; ?>">
        <input type="hidden" name="field" value="pages">
        <input type="number" name="value" value="<?= $book['pages']; ?>">
        <input type="submit" value="Update">
    </form>

    <h2>Autorid:</h2>
    <ul>
        <?php
        $authorStmt = $pdo->prepare('SELECT * FROM book_authors ba LEFT JOIN authors a ON a.id=ba.author_id WHERE book_id=:book_id');
        $authorStmt->execute(['book_id' => $id]);
        while ($author = $authorStmt->fetch()){
        ?>
            <li>
                <?= $author['first_name']; ?> <?= $author['last_name']; ?>
                <form action="remove_author.php" method="post" style="display:inline;">
                    <input type="hidden" name="book_id" value="<?= $id; ?>">
                    <input type="hidden" name="author_id" value="<?= $author['id']; ?>">
                    <input type="submit" value="Kustuta">
                </form>
            </li>
        <?php
        }
        ?>
    </ul>
    
    <h2>Lisa autor: </h2>
    <form action="add_author.php" method="post">
        <input type="hidden" name="book_id" value="<?= $id; ?>">
        <select name="author_id">
            <?php
            $allAuthorsStmt = $pdo->query('SELECT * FROM authors');
            while ($author = $allAuthorsStmt->fetch())
            {
            ?>
                <option value="<?= $author['id']; ?>"><?= $author['first_name']; ?> <?= $author['last_name']; ?></option>
            <?php
            }
            ?>
        </select>
        <input type="submit" value="Lisa">
    </form>

    <form action="book.php" method="get">
        <input type="hidden" name="id" value="<?= $id; ?>">
        <input type="submit" value="Tagasi">
    </form>
</body>
</html>