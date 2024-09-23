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
    $manger->name = $_POST['name'];
    $manger->email = $_POST['email'];
    $manger->password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    if ($manger->register()) {
        header("Location: login.php");
        exit();
    } else {
        echo "Failed to register. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>
    <form method="post" action="">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="Register">
    </form>
    <a href="login.php">Login</a>
</body>
</html>
