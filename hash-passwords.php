<?php

include "includes/db_connect.php";

$result = $conn->query("SELECT id, username, password FROM admins");

while ($admin = $result->fetch_assoc()) {

    // Skip if password already looks hashed
    if (password_get_info($admin['password'])['algo'] !== null) {
        echo $admin['username'] . " is already hashed.<br>";
        continue;
    }

    $hashedPassword = password_hash($admin['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("
        UPDATE admins
        SET password = ?
        WHERE id = ?
    ");

    $stmt->bind_param("si", $hashedPassword, $admin['id']);
    $stmt->execute();

    echo "Updated password for: " . htmlspecialchars($admin['username']) . "<br>";
}

echo "<br><strong>Migration completed.</strong>";
