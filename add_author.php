<?php

require_once('./connection.php');

$book_id = $_POST['book_id'];
$author_id = $_POST['author_id'];

$stmt = $pdo->prepare('INSERT INTO book_authors (book_id, author_id) VALUES (:book_id, :author_id)');
$stmt->execute(['book_id' => $book_id, 'author_id' => $author_id]);

header('Location: editBooks.php?id=' . $book_id);