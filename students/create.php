<?php
include '../config.php';
include '../navbar.php';
$base = '../';
$error = "";
// Handle form FIRST before any HTML output
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim(mysqli_real_escape_string($conn, $_POST['name']));
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    if ($name && $email) {
        if (mysqli_query($conn, "INSERT INTO students (name, email) VALUES ('$name', '$email')")) {
            header("Location: index.php?msg=Student added successfully!&type=success");
            exit();
        } else { $error = "Something went wrong."; }
    } else { $error = "All fields are required."; }
}

// Only include navbar AFTER redirect logic
include '../navbar.php';
?>
<div class="page-content">
    <div class="page-header"><h1><i class="bi bi-person-plus-fill me-2"></i>Add New Student</h1><p>Fill in the form to register a new student</p></div>
    <div class="row justify-content-center"><div class="col-md-7">
        <div class="card">
            <div class="card-header-green"><i class="bi bi-person-plus-fill"></i> Student Information</div>
            <div class="card-body p-4">
                <?php if ($error): ?>
                    <div class="alert alert-danger rounded-3 mb-3"><?= $error ?></div><?php endif; ?>
                <form method="POST">
                    <div class="mb-3"><label class="form-label">Full Name</label><input type="text" name="name" class="form-control" placeholder="e.g. John Doe" required></div>
                    <div class="mb-4"><label class="form-label">Email Address</label><input type="email" name="email" class="form-control" placeholder="e.g. john@email.com" required></div>
                    <div class="d-flex justify-content-between">
                        <a href="index.php" class="btn btn-outline-green">← Back</a>
                        <button type="submit" class="btn btn-green"><i class="bi bi-plus-lg me-1"></i> Add Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div></div>
</div>
<?php include '../footer.php'; ?>