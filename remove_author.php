<?php

require_once('./connection.php');

$book_id = $_POST['book_id'];
$author_id = $_POST['author_id'];
var_dump($author_id);

$stmt = $pdo->prepare('DELETE FROM book_authors WHERE book_id= :book_id AND author_id= :author_id');
$stmt->execute(['book_id' => $book_id, 'author_id' => $author_id]);

header('Location: editBooks.php?id=' . $book_id);