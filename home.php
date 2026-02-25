<?php
$base = ''; 
include 'config.php';
include 'navbar.php';

$total_students = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM students"))[0];
$total_subjects = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM subjects"))[0];
$total_grades   = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM grades"))[0];
$avg_grade_row  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT grade, COUNT(*) as cnt FROM grades GROUP BY grade ORDER BY cnt DESC LIMIT 1"));
$top_grade = $avg_grade_row ? $avg_grade_row['grade'] : 'N/A';

$recent_students = mysqli_query($conn, "SELECT * FROM students ORDER BY created_at DESC LIMIT 5");
$recent_grades   = mysqli_query($conn, "
    SELECT g.grade, s.name AS student_name, sub.subject_name
    FROM grades g
    JOIN students s ON g.student_id = s.id
    JOIN subjects sub ON g.subject_id = sub.id
    ORDER BY g.created_at DESC LIMIT 5
");
?>

<div class="page-content">

    <!-- HERO -->
    <div class="page-header mb-4" style="padding: 2.5rem 3rem;">
        <div style="position:relative; z-index:1;">
            <p style="color:var(--green-accent);font-weight:700;font-size:0.8rem;text-transform:uppercase;letter-spacing:2px;margin-bottom:8px;">
                Welcome to Student Tracker
            </p>
            <h1 style="font-family:'DM Serif Display',serif;font-size:2.4rem;margin-bottom:10px;">
                Student Grade Management
            </h1>
            <p style="color:rgba(255,255,255,0.7);font-size:1rem;max-width:520px;margin-bottom:1.8rem;">
                Manage your students, subjects, and grades all in one place. Simple, fast, and organized.
            </p>
            <div class="d-flex gap-3 flex-wrap">
                <a href="students/create.php" class="btn" style="background:var(--green-accent);color:var(--green-dark);font-weight:700;border-radius:8px;padding:10px 24px;">
                    <i class="bi bi-plus-lg me-2"></i>Add Student
                </a>
                <a href="grades/create.php" class="btn" style="background:rgba(255,255,255,0.12);color:white;font-weight:600;border-radius:8px;padding:10px 24px;border:1px solid rgba(255,255,255,0.2);">
                    <i class="bi bi-bar-chart me-2"></i>Record Grade
                </a>
            </div>
        </div>
    </div>

    <!-- STATS -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card h-100 border-0" style="background:linear-gradient(135deg,#1a4731,#2d7a4f);color:white;border-radius:14px;">
                <div class="card-body p-4">
                    <div style="width:44px;height:44px;background:rgba(255,255,255,0.15);border-radius:10px;display:flex;align-items:center;justify-content:center;margin-bottom:12px;">
                        <i class="bi bi-people-fill" style="font-size:1.3rem;"></i>
                    </div>
                    <div style="font-size:2.2rem;font-weight:800;line-height:1;"><?= $total_students ?></div>
                    <div style="color:rgba(255,255,255,0.7);font-size:0.85rem;margin-top:4px;">Total Students</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 border-0" style="background:linear-gradient(135deg,#2d7a4f,#3a9e68);color:white;border-radius:14px;">
                <div class="card-body p-4">
                    <div style="width:44px;height:44px;background:rgba(255,255,255,0.15);border-radius:10px;display:flex;align-items:center;justify-content:center;margin-bottom:12px;">
                        <i class="bi bi-book-fill" style="font-size:1.3rem;"></i>
                    </div>
                    <div style="font-size:2.2rem;font-weight:800;line-height:1;"><?= $total_subjects ?></div>
                    <div style="color:rgba(255,255,255,0.7);font-size:0.85rem;margin-top:4px;">Total Subjects</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 border-0" style="background:linear-gradient(135deg,#3a9e68,#5bbf85);color:white;border-radius:14px;">
                <div class="card-body p-4">
                    <div style="width:44px;height:44px;background:rgba(255,255,255,0.15);border-radius:10px;display:flex;align-items:center;justify-content:center;margin-bottom:12px;">
                        <i class="bi bi-bar-chart-fill" style="font-size:1.3rem;"></i>
                    </div>
                    <div style="font-size:2.2rem;font-weight:800;line-height:1;"><?= $total_grades ?></div>
                    <div style="color:rgba(255,255,255,0.7);font-size:0.85rem;margin-top:4px;">Grades Recorded</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 border-0" style="background:linear-gradient(135deg,#00c96e,#3a9e68);color:white;border-radius:14px;">
                <div class="card-body p-4">
                    <div style="width:44px;height:44px;background:rgba(255,255,255,0.15);border-radius:10px;display:flex;align-items:center;justify-content:center;margin-bottom:12px;">
                        <i class="bi bi-star-fill" style="font-size:1.3rem;"></i>
                    </div>
                    <div style="font-size:2.2rem;font-weight:800;line-height:1;"><?= $top_grade ?></div>
                    <div style="color:rgba(255,255,255,0.7);font-size:0.85rem;margin-top:4px;">Most Common Grade</div>
                </div>
            </div>
        </div>
    </div>

    <!-- RECENT TABLES -->
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header-green">
                    <i class="bi bi-people-fill"></i> Recent Students
                    <a href="students/index.php" class="ms-auto" style="color:rgba(255,255,255,0.7);font-size:0.8rem;text-decoration:none;">View all →</a>
                </div>
                <div class="card-body p-0">
                    <table class="table table-custom mb-0">
                        <thead><tr><th>Name</th><th>Email</th><th>Date</th></tr></thead>
                        <tbody>
                        <?php if (mysqli_num_rows($recent_students) > 0):
                            while ($s = mysqli_fetch_assoc($recent_students)): ?>
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:10px;">
                                        <div style="width:32px;height:32px;background:var(--green-pale);border-radius:50%;display:flex;align-items:center;justify-content:center;color:var(--green-main);font-weight:700;font-size:0.85rem;">
                                            <?= strtoupper(substr($s['name'],0,1)) ?>
                                        </div>
                                        <?= htmlspecialchars($s['name']) ?>
                                    </div>
                                </td>
                                <td style="color:var(--text-light);"><?= htmlspecialchars($s['email']) ?></td>
                                <td style="color:var(--text-light);font-size:0.8rem;"><?= date('d M Y', strtotime($s['created_at'])) ?></td>
                            </tr>
                        <?php endwhile; else: ?>
                            <tr><td colspan="3"><div class="empty-state"><i class="bi bi-people d-block"></i><p>No students yet</p></div></td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header-green">
                    <i class="bi bi-bar-chart-fill"></i> Recent Grades
                    <a href="grades/index.php" class="ms-auto" style="color:rgba(255,255,255,0.7);font-size:0.8rem;text-decoration:none;">View all →</a>
                </div>
                <div class="card-body p-0">
                    <table class="table table-custom mb-0">
                        <thead><tr><th>Student</th><th>Subject</th><th>Grade</th></tr></thead>
                        <tbody>
                        <?php if (mysqli_num_rows($recent_grades) > 0):
                            while ($g = mysqli_fetch_assoc($recent_grades)):
                                $badge = match(true) {
                                    in_array($g['grade'], ['A+','A']) => 'background:#d1fae5;color:#065f46;',
                                    $g['grade'] === 'B' => 'background:#dbeafe;color:#1e40af;',
                                    $g['grade'] === 'C' => 'background:#fef9c3;color:#854d0e;',
                                    default => 'background:#fee2e2;color:#991b1b;'
                                }; ?>
                            <tr>
                                <td><?= htmlspecialchars($g['student_name']) ?></td>
                                <td style="color:var(--text-light);"><?= htmlspecialchars($g['subject_name']) ?></td>
                                <td><span class="grade-badge" style="<?= $badge ?>"><?= $g['grade'] ?></span></td>
                            </tr>
                        <?php endwhile; else: ?>
                            <tr><td colspan="3"><div class="empty-state"><i class="bi bi-bar-chart d-block"></i><p>No grades yet</p></div></td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>