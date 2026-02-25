<?php
include '../config.php'; include '../navbar.php';
$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject_name = trim(mysqli_real_escape_string($conn, $_POST['subject_name']));
    $description  = trim(mysqli_real_escape_string($conn, $_POST['description']));
    if ($subject_name) {
        if (mysqli_query($conn, "INSERT INTO subjects (subject_name, description) VALUES ('$subject_name', '$description')")) {
            header("Location: index.php?msg=Subject added successfully!&type=success");
            exit();
        } else { $error = "Something went wrong."; }
    } else { $error = "Subject name is required."; }
}
?>
<div class="page-content">
    <div class="page-header"><h1><i class="bi bi-book-fill me-2"></i>Add New Subject</h1><p>Fill in the form to add a new subject</p></div>
    <div class="row justify-content-center"><div class="col-md-7">
        <div class="card">
            <div class="card-header-green"><i class="bi bi-book-fill"></i> Subject Information</div>
            <div class="card-body p-4">
                <?php if ($error): ?><div class="alert alert-danger rounded-3 mb-3"><?= $error ?></div><?php endif; ?>
                <form method="POST">
                    <div class="mb-3"><label class="form-label">Subject Name <span style="color:red;">*</span></label><input type="text" name="subject_name" class="form-control" placeholder="e.g. Mathematics" required></div>
                    <div class="mb-4"><label class="form-label">Description <span style="color:var(--text-light);">(optional)</span></label><textarea name="description" class="form-control" rows="3" placeholder="Brief description..."></textarea></div>
                    <div class="d-flex justify-content-between">
                        <a href="index.php" class="btn btn-outline-green">← Back</a>
                        <button type="submit" class="btn btn-green"><i class="bi bi-plus-lg me-1"></i> Add Subject</button>
                    </div>
                </form>
            </div>
        </div>
    </div></div>
</div>
<?php include '../footer.php'; ?>