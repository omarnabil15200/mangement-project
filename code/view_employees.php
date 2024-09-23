<?php
session_start();
include 'config.php';
include 'Employee.php';

if (!isset($_SESSION['manger_id'])) {
    header("Location: login.php");
    exit();
}

$manger_id = $_SESSION['manger_id'];
$db = (new Database())->getConnection();
$employee = new Employee($db);
$employees = $employee->getAllByManger($manger_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee List</title>
</head>
<body>
    <h1>Employee List</h1>
    <a href="logout.php">Logout</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Picture</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($employees as $emp): ?>
        <tr>
            <td><?php echo htmlspecialchars($emp['id']); ?></td>
            <td><?php echo htmlspecialchars($emp['name']); ?></td>
            <td><?php echo htmlspecialchars($emp['email']); ?></td>
            <td><?php echo htmlspecialchars($emp['phone']); ?></td>
            <td><img src="<?php echo htmlspecialchars($emp['picture']); ?>" alt="Picture" width="100"></td>
            <td>
                <a href="edit_employee.php?id=<?php echo htmlspecialchars($emp['id']); ?>">Edit</a>
                <a href="delete_employee.php?id=<?php echo htmlspecialchars($emp['id']); ?>">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="add_employee.php">Add New Employee</a>
</body>
</html>
