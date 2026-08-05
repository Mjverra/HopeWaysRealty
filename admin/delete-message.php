<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include "../includes/db_connect.php";

if (isset($_GET['id'])) {

    $id = intval($_GET['id']);

    $stmt = $conn->prepare("DELETE FROM contact_messages WHERE id = ?");

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {

        header("Location: view-messages.php?deleted=1");

    } else {

        echo "Unable to delete message.";

    }

    $stmt->close();
}

$conn->close();
?>