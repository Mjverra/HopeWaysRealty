<?php
include "db_connect.php";

// Get data from the form
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$subject = $_POST['subject'];
$message = $_POST['message'];

// Prepare SQL statement
$sql = "INSERT INTO contact_messages (fullname, email, phone, subject, message)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

// Bind the values here
$stmt->bind_param(
    "sssss",
    $fullname,
    $email,
    $phone,
    $subject,
    $message
);

// Execute the query
if ($stmt->execute()) {
    echo "<script>
            alert('Message sent successfully!');
            window.location='contact.html';
          </script>";
} else {
    echo "Error: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();
?>