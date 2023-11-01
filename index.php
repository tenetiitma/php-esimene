<?php

require_once('./connection.php');

$stmt = $pdo->query('SELECT * FROM books WHERE is_deleted <>1');

//$stmt = $pdo->query('SELECT * FROM books');
//$stmt = $pdo->query('SELECT * FROM book_authors ba LEFT JOIN authors a ON a.id=ba.author_id WHERE book_id= :id');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    $searchTerm = $_GET['search'] ?? '';

    if ($searchTerm) {
        $stmt = $pdo->prepare('SELECT * FROM books WHERE is_deleted <> 1 AND title LIKE :searchTerm');
        $stmt->execute(['searchTerm' => '%' . $searchTerm . '%']);
    } else {
        $stmt = $pdo->query('SELECT * FROM books WHERE is_deleted <> 1');
        
    }
?>

    <form action="index.php" method="get">
        <input type="text" name="search" placeholder="Search for a book...">
        <input type="submit" value="Search">
    </form>

    <?php
    if (!empty($_POST['first_name']) && !empty($_POST['last_name'])) {
        $stmtAuthor = $pdo->prepare('INSERT INTO authors (first_name, last_name) VALUES (:firstName, :lastName)');
        $stmtAuthor->execute(['firstName' => $_POST['first_name'], 'lastName' => $_POST['last_name']]);
    }
    ?>
    <form action="index.php" method="post">
        <input type="text" name="first_name" placeholder="Autori eesnimi">
        <input type="text" name="last_name" placeholder="Autori perekonnanimi">
        <input type="submit" value="Lisa autor">
    </form>
</body>
</html>

<?php

echo "<ul>";

while ($row = $stmt->fetch())
{
?>
    <li>
        <a href="./book.php?id=<?= $row['id']; ?>">
            <?= $row['title']; ?>
        </a>
    </li>

<?php
}

echo "</ul>";