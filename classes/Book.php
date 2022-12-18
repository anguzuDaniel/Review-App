<?php

function addBook($conn, $name, $author, $file, $description, $category)
{
    $sql = "INSERT INTO book VALUES (':name', ':author', ':file', ':description', ':category') ";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':author', $author);
    $stmt->bindParam(':file', $file);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':category', $category);

    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    return $stmt->execute();
}
