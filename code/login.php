<?php
session_start();
include 'config.php';
include 'Manger.php';
 

if (isset($_SESSION['manger_id'])) {
    header("Location: view_employees.php?manger_id=" . $_SESSION['manger_id']);
    exit();
}

$db = (new Database())->getConnection();
$manger = new Manger($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $manger->email = $_POST['email'];
    $manger->password = $_POST['password'];

    $result = $manger->login();
    if ($result) {
        $_SESSION['manger_id'] = $result['id'];
        $_SESSION['name'] = $result['name'];
        header("Location: view_employees.php?manger_id=" . $result['id']);
        exit();
    } else {
        echo "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form method="post" action="">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="Login">
    </form>
    <a href="register.php">Register</a>
</body>
</html>
