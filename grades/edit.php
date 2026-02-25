<?php
include '../config.php'; include '../navbar.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$grade_row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM grades WHERE id = $id"));
if (!$grade_row) { header("Location: index.php"); exit(); }
$students = mysqli_query($conn, "SELECT id, name FROM students ORDER BY name ASC");
$subjects = mysqli_query($conn, "SELECT id, subject_name FROM subjects ORDER BY subject_name ASC");
$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = (int)$_POST['student_id'];
    $subject_id = (int)$_POST['subject_id'];
    $grade      = trim(mysqli_real_escape_string($conn, $_POST['grade']));
    if ($student_id && $subject_id && $grade) {
        if (mysqli_query($conn, "UPDATE grades SET student_id=$student_id, subject_id=$subject_id, grade='$grade' WHERE id=$id")) {
           header("Location: index.php?msg=Grade updated successfully!&type=warning"); exit();
        } else { $error = "Something went wrong."; }
    } else { $error = "All fields are required."; }
}
?>
<div class="page-content">
    <div class="page-header"><h1><i class="bi bi-pencil-fill me-2"></i>Edit Grade</h1><p>Update the grade record</p></div>
    <div class="row justify-content-center"><div class="col-md-7">
        <div class="card">
            <div class="card-header-green"><i class="bi bi-pencil-fill"></i> Edit Grade Record</div>
            <div class="card-body p-4">
                <?php if ($error): ?><div class="alert alert-danger rounded-3 mb-3"><?= $error ?></div><?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Student <span style="color:red;">*</span></label>
                        <select name="student_id" class="form-select" required>
                            <option value="">-- Select Student --</option>
                            <?php while ($s = mysqli_fetch_assoc($students)): ?>
                                <option value="<?= $s['id'] ?>" <?= $grade_row['student_id'] == $s['id'] ? 'selected' : '' ?>><?= htmlspecialchars($s['name']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subject <span style="color:red;">*</span></label>
                        <select name="subject_id" class="form-select" required>
                            <option value="">-- Select Subject --</option>
                            <?php while ($sub = mysqli_fetch_assoc($subjects)): ?>
                                <option value="<?= $sub['id'] ?>" <?= $grade_row['subject_id'] == $sub['id'] ? 'selected' : '' ?>><?= htmlspecialchars($sub['subject_name']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Grade <span style="color:red;">*</span></label>
                        <select name="grade" class="form-select" required>
                            <?php foreach (['A+'=>'Excellent','A'=>'Very Good','B'=>'Good','C'=>'Average','D'=>'Below Average','F'=>'Fail'] as $g => $label): ?>
                                <option value="<?= $g ?>" <?= $grade_row['grade'] === $g ? 'selected' : '' ?>><?= $g ?> (<?= $label ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="index.php" class="btn btn-outline-green">← Back</a>
                        <button type="submit" class="btn btn-green"><i class="bi bi-check-lg me-1"></i> Update Grade</button>
                    </div>
                </form>
            </div>
        </div>
    </div></div>
</div>
<?php include '../footer.php'; ?>