<?php
include '../config.php'; include '../navbar.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$student = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM students WHERE id = $id"));
if (!$student) { header("Location: index.php"); exit(); }
$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim(mysqli_real_escape_string($conn, $_POST['name']));
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    if ($name && $email) {
        if (mysqli_query($conn, "UPDATE students SET name='$name', email='$email' WHERE id=$id")) {
            header("Location: index.php?msg=Student updated successfully!&type=warning");
            exit();
        } else { $error = "Something went wrong."; }
    } else { $error = "All fields are required."; }
}
?>
<div class="page-content">
    <div class="page-header"><h1><i class="bi bi-pencil-fill me-2"></i>Edit Student</h1><p>Update student information</p></div>
    <div class="row justify-content-center"><div class="col-md-7">
        <div class="card">
            <div class="card-header-green"><i class="bi bi-pencil-fill"></i> Edit: <?= htmlspecialchars($student['name']) ?></div>
            <div class="card-body p-4">
                <?php if ($error): ?><div class="alert alert-danger rounded-3 mb-3"><?= $error ?></div><?php endif; ?>
                <form method="POST">
                    <div class="mb-3"><label class="form-label">Full Name</label><input type="text" name="name" class="form-control" value="<?= htmlspecialchars($student['name']) ?>" required></div>
                    <div class="mb-4"><label class="form-label">Email Address</label><input type="email" name="email" class="form-control" value="<?= htmlspecialchars($student['email']) ?>" required></div>
                    <div class="d-flex justify-content-between">
                        <a href="index.php" class="btn btn-outline-green">← Back</a>
                        <button type="submit" class="btn btn-green"><i class="bi bi-check-lg me-1"></i> Update Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div></div>
</div>
<?php include '../footer.php'; ?>