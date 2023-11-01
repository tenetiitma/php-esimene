<?php

require_once('./connection.php');

if($_POST) {
    $id = $_POST['id'];
    $field = $_POST['field'];
    $value = $_POST['value'];

    $stmt = $pdo->prepare("UPDATE books SET $field = :value WHERE id = :id");
    $stmt->execute([
        'id' => $id,
        'value' => $value
    ]);

    header('Location: editBooks.php?id=' . $id);
}
?>