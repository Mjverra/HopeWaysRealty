<?php
include "../includes/db_connect.php";

if (isset($_POST['id'])) {

    $id = intval($_POST['id']);

    $stmt = $conn->prepare("
        UPDATE contact_messages
        SET is_read = IF(is_read = 0, 1, 0)
        WHERE id = ?
    ");

    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Return the new value
    $result = $conn->query("
        SELECT is_read
        FROM contact_messages
        WHERE id = $id
    ");

    $row = $result->fetch_assoc();

    echo json_encode($row);
}

$conn->close();
?>