<?php
session_start();

include "includes/db_connect.php";

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM admins
        WHERE username='$username'
        AND password='$password'";

$result = $conn->query($sql);

if ($result->num_rows == 1) {

    $admin = $result->fetch_assoc();

    $_SESSION['admin'] = $admin['username'];
    $_SESSION['role'] = $admin['role'];

    header("Location: admin/admin-dashboard.php");
    exit();

}
} else {

    echo "<script>
    alert('Invalid Username or Password');
    window.location='login.php';
    </script>";
}
