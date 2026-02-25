<?php
include '../config.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
    mysqli_query($conn, "DELETE FROM grades WHERE student_id = $id");
    mysqli_query($conn, "DELETE FROM students WHERE id = $id");
    header("Location: index.php?msg=Student deleted successfully!&type=danger");
} else { header("Location: index.php"); }
exit();
?>