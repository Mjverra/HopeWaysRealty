<?php
session_start();

include "db_connect.php";

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM admins
        WHERE username='$username'
        AND password='$password'";

$result = $conn->query($sql);

if($result->num_rows == 1){

    $_SESSION['admin'] = $username;

    header("Location: admin/view-messages.php");

}else{

    echo "<script>
    alert('Invalid Username or Password');
    window.location='login.php';
    </script>";

}
?>