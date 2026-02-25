<?php
include '../config.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
    mysqli_query($conn, "DELETE FROM grades WHERE id = $id");
    header("Location: index.php?msg=Grade deleted successfully!&type=danger");
} else { header("Location: index.php"); }
exit();
?>
