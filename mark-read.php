<?php
include "db_connect.php";

if (isset($_POST['id'])) {

    $id = intval($_POST['id']);

    $stmt = $conn->prepare("
        UPDATE contact_messages
        SET is_read = 1
        WHERE id = ?
    ");

    $stmt->bind_param("i", $id);
    $stmt->execute();

    echo "success";
}

$conn->close();
?>