$stmt = $conn->prepare("
SELECT *
FROM admins
WHERE username = ?
");

$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 1) {

$admin = $result->fetch_assoc();

if (password_verify($password, $admin['password'])) {

$_SESSION['admin_id'] = $admin['id'];
$_SESSION['admin'] = $admin['username'];
$_SESSION['role'] = $admin['role'];

header("Location: admin/admin-dashboard.php");
exit();

}

}

echo "<script>
    alert('Invalid Username or Password');
    window.location = 'login.php';
</script>";