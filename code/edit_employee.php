<?php
session_start();
include 'config.php';
include 'Employee.php';

if (!isset($_SESSION['manger_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$db = (new Database())->getConnection();
$employee = new Employee($db);
$emp = $employee->getById($id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee->id = $id;
    $employee->name = $_POST['name'];
    $employee->email = $_POST['email'];
    $employee->phone = $_POST['phone'];
    $employee->picture = $_POST['current_picture'];
    
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $tmp_name = $_FILES['picture']['tmp_name'];
        $basename = basename($_FILES['picture']['name']);
        $upload_file = $upload_dir . $basename;
        move_uploaded_file($tmp_name, $upload_file);
        $employee->picture = $upload_file;
    }

    if ($employee->update()) {
        header("Location: view_employees.php?manger_id=" . $_SESSION['manger_id']);
        exit();
    } else {
        echo "Failed to update employee.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Employee</title>
</head>
<body>
    <h1>Edit Employee</h1>
    <a href="logout.php">Logout</a>
    <form method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="current_picture" value="<?php echo htmlspecialchars($emp['picture']); ?>">
        
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($emp['name']); ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($emp['email']); ?>" required><br>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($emp['phone']); ?>"><br>

        <label for="picture">Picture:</label>
        <input type="file" id="picture" name="picture"><br>
        <?php if ($emp['picture']): ?>
        <img src="<?php echo htmlspecialchars($emp['picture']); ?>" alt="Picture" width="100"><br>
        <?php endif; ?>

        <input type="submit" value="Update Employee">
    </form>
    <a href="view_employees.php?manger_id=<?php echo htmlspecialchars($_SESSION['manger_id']); ?>">Back to Employee List</a>
</body>
</html>
