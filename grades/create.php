<?php
include '../config.php'; include '../navbar.php';
$students = mysqli_query($conn, "SELECT id, name FROM students ORDER BY name ASC");
$subjects = mysqli_query($conn, "SELECT id, subject_name FROM subjects ORDER BY subject_name ASC");
$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = (int)$_POST['student_id'];
    $subject_id = (int)$_POST['subject_id'];
    $grade      = trim(mysqli_real_escape_string($conn, $_POST['grade']));
    if ($student_id && $subject_id && $grade) {
        if (mysqli_query($conn, "INSERT INTO grades (student_id, subject_id, grade) VALUES ($student_id, $subject_id, '$grade')")) {
           header("Location: index.php?msg=Grade recorded successfully!&type=success"); exit();
        } else { $error = "Something went wrong."; }
    } else { $error = "All fields are required."; }
}
?>
<div class="page-content">
    <div class="page-header"><h1><i class="bi bi-bar-chart-fill me-2"></i>Record Grade</h1><p>Assign a grade to a student for a subject</p></div>
    <div class="row justify-content-center"><div class="col-md-7">
        <div class="card">
            <div class="card-header-green"><i class="bi bi-bar-chart-fill"></i> Grade Information</div>
            <div class="card-body p-4">
                <?php if ($error): ?><div class="alert alert-danger rounded-3 mb-3"><?= $error ?></div><?php endif; ?>
                <?php if (mysqli_num_rows($students) === 0 || mysqli_num_rows($subjects) === 0): ?>
                    <div class="alert alert-warning rounded-3">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        Please add <a href="../students/create.php">students</a> and <a href="../subjects/create.php">subjects</a> first!
                    </div>
                <?php else: ?>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Student <span style="color:red;">*</span></label>
                        <select name="student_id" class="form-select" required>
                            <option value="">-- Select Student --</option>
                            <?php mysqli_data_seek($students, 0); while ($s = mysqli_fetch_assoc($students)): ?>
                                <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['name']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subject <span style="color:red;">*</span></label>
                        <select name="subject_id" class="form-select" required>
                            <option value="">-- Select Subject --</option>
                            <?php mysqli_data_seek($subjects, 0); while ($sub = mysqli_fetch_assoc($subjects)): ?>
                                <option value="<?= $sub['id'] ?>"><?= htmlspecialchars($sub['subject_name']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Grade <span style="color:red;">*</span></label>
                        <select name="grade" class="form-select" required>
                            <option value="">-- Select Grade --</option>
                            <option value="A+">A+ (Excellent)</option>
                            <option value="A">A (Very Good)</option>
                            <option value="B">B (Good)</option>
                            <option value="C">C (Average)</option>
                            <option value="D">D (Below Average)</option>
                            <option value="F">F (Fail)</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="index.php" class="btn btn-outline-green">← Back</a>
                        <button type="submit" class="btn btn-green"><i class="bi bi-check-lg me-1"></i> Record Grade</button>
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div></div>
</div>
<?php include '../footer.php'; ?>