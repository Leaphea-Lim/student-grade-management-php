<?php
include '../config.php'; include '../navbar.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$subject = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM subjects WHERE id = $id"));
if (!$subject) { header("Location: index.php"); exit(); }
$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject_name = trim(mysqli_real_escape_string($conn, $_POST['subject_name']));
    $description  = trim(mysqli_real_escape_string($conn, $_POST['description']));
    if ($subject_name) {
        if (mysqli_query($conn, "UPDATE subjects SET subject_name='$subject_name', description='$description' WHERE id=$id")) {
            header("Location: index.php?msg=Subject updated successfully!&type=warning");
             exit();
        } else { $error = "Something went wrong."; }
    } else { $error = "Subject name is required."; }
}
?>
<div class="page-content">
    <div class="page-header"><h1><i class="bi bi-pencil-fill me-2"></i>Edit Subject</h1><p>Update subject information</p></div>
    <div class="row justify-content-center"><div class="col-md-7">
        <div class="card">
            <div class="card-header-green"><i class="bi bi-pencil-fill"></i> Edit: <?= htmlspecialchars($subject['subject_name']) ?></div>
            <div class="card-body p-4">
                <?php if ($error): ?><div class="alert alert-danger rounded-3 mb-3"><?= $error ?></div><?php endif; ?>
                <form method="POST">
                    <div class="mb-3"><label class="form-label">Subject Name <span style="color:red;">*</span></label><input type="text" name="subject_name" class="form-control" value="<?= htmlspecialchars($subject['subject_name']) ?>" required></div>
                    <div class="mb-4"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($subject['description']) ?></textarea></div>
                    <div class="d-flex justify-content-between">
                        <a href="index.php" class="btn btn-outline-green">← Back</a>
                        <button type="submit" class="btn btn-green"><i class="bi bi-check-lg me-1"></i> Update Subject</button>
                    </div>
                </form>
            </div>
        </div>
    </div></div>
</div>
<?php include '../footer.php'; ?>