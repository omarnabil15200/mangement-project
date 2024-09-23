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
$employee->id = $id;

if ($employee->delete()) {
    header("Location: view_employees.php?manger_id=" . $_SESSION['manger_id']);
    exit();
} else {
    echo "Failed to delete employee.";
}
?>
