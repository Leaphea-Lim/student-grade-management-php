<?php 
$base = '../';
include '../config.php'; 
include '../navbar.php';
$result = mysqli_query($conn, "
    SELECT g.id, g.grade, g.created_at, s.name AS student_name, sub.subject_name
    FROM grades g
    JOIN students s ON g.student_id = s.id
    JOIN subjects sub ON g.subject_id = sub.id
    ORDER BY g.id DESC
"); ?>

<div class="page-content">
    <div class="page-header"><h1><i class="bi bi-bar-chart-fill me-2"></i>Grades</h1><p>View and manage all student grades</p></div>
    <?php if (isset($_GET['msg'])):
    $type = isset($_GET['type']) ? htmlspecialchars($_GET['type']) : 'success';
    $icon = match($type) {
        'warning' => 'bi-pencil-circle-fill',
        'danger'  => 'bi-trash-fill',
        default   => 'bi-check-circle-fill'
    };
?>
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index:9999;">
        <div id="successToast" class="toast align-items-center text-bg-<?= $type ?> border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body fw-semibold">
                    <i class="bi <?= $icon ?> me-2"></i>
                    <?= htmlspecialchars($_GET['msg']) ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
<?php endif; ?>
    <div class="card">
        <div class="card-header-green">
            <i class="bi bi-bar-chart-fill"></i> All Grades
            <a href="create.php" class="ms-auto btn-green btn" style="padding:6px 16px;font-size:0.82rem;"><i class="bi bi-plus-lg me-1"></i> Record Grade</a>
        </div>
        <div class="card-body p-0">
            <table class="table table-custom mb-0">
                <thead><tr><th>#</th><th>Student</th><th>Subject</th><th>Grade</th><th>Date</th><th>Actions</th></tr></thead>
                <tbody>
                <?php $no = 1;
                if (mysqli_num_rows($result) > 0):
                    while ($row = mysqli_fetch_assoc($result)):
                        $badge = match(true) {
                            in_array($row['grade'], ['A+','A']) => 'background:#d1fae5;color:#065f46;',
                            $row['grade'] === 'B' => 'background:#dbeafe;color:#1e40af;',
                            $row['grade'] === 'C' => 'background:#fef9c3;color:#854d0e;',
                            default => 'background:#fee2e2;color:#991b1b;'
                        }; ?>
                    <tr>
                        <td style="color:var(--text-light);font-size:0.8rem;"><?= $no++ ?></td>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div style="width:32px;height:32px;background:var(--green-pale);border-radius:50%;display:flex;align-items:center;justify-content:center;color:var(--green-main);font-weight:700;font-size:0.85rem;">
                                    <?= strtoupper(substr($row['student_name'],0,1)) ?>
                                </div>
                                <?= htmlspecialchars($row['student_name']) ?>
                            </div>
                        </td>
                        <td style="color:var(--text-light);"><?= htmlspecialchars($row['subject_name']) ?></td>
                        <td><span class="grade-badge" style="<?= $badge ?>"><?= $row['grade'] ?></span></td>
                        <td style="color:var(--text-light);font-size:0.85rem;"><?= date('d M Y', strtotime($row['created_at'])) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="action-btn action-btn-edit"><i class="bi bi-pencil-fill"></i> Edit</a>
                            <a href="delete.php?id=<?= $row['id'] ?>" class="action-btn action-btn-delete ms-1" onclick="return confirm('Delete this grade?')"><i class="bi bi-trash-fill"></i> Delete</a>
                        </td>
                    </tr>
                <?php endwhile; else: ?>
                    <tr><td colspan="6"><div class="empty-state"><i class="bi bi-bar-chart d-block"></i><p>No grades yet. <a href="create.php" style="color:var(--green-main);">Record first grade →</a></p></div></td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include '../footer.php'; ?>