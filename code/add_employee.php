<?php
session_start();
include 'config.php';
include 'Employee.php';


if (!isset($_SESSION['manger_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee = new Employee((new Database())->getConnection());
    $employee->name = $_POST['name'];
    $employee->email = $_POST['email'];
    $employee->phone = $_POST['phone'];
    $employee->manger_id = $_SESSION['manger_id'];

    if (isset($_FILES['picture']) && $_FILES['picture']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $tmp_name = $_FILES['picture']['tmp_name'];
        $basename = basename($_FILES['picture']['name']);
        $upload_file = $upload_dir . $basename;
        move_uploaded_file($tmp_name, $upload_file);
        $employee->picture = $upload_file;
    }

    if ($employee->create()) {
        header("Location: view_employees.php?manger_id=" . $_SESSION['manger_id']);
        exit();
    } else {
        echo "Failed to add employee.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Employee</title>
</head>
<body>
    <h1>Add Employee</h1>
    <a href="logout.php">Logout</a>
    <form method="post" action="" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone"><br>

        <label for="picture">Picture:</label>
        <input type="file" id="picture" name="picture"><br>

        <input type="submit" value="Add Employee">
    </form>
    <a href="view_employees.php?manger_id=<?php echo htmlspecialchars($_SESSION['manger_id']); ?>">Back to Employee List</a>
</body>
</html>
