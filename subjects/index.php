<?php 
$base = '../';
include '../config.php'; 
include '../navbar.php';
$result = mysqli_query($conn, "SELECT * FROM subjects ORDER BY id DESC"); ?>

<div class="page-content">
    <div class="page-header"><h1><i class="bi bi-book-fill me-2"></i>Subjects</h1><p>Manage all subjects offered</p></div>
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
            <i class="bi bi-book-fill"></i> All Subjects
            <a href="create.php" class="ms-auto btn-green btn" style="padding:6px 16px;font-size:0.82rem;"><i class="bi bi-plus-lg me-1"></i> Add Subject</a>
        </div>
        <div class="card-body p-0">
            <table class="table table-custom mb-0">
                <thead><tr><th>#</th><th>Subject Name</th><th>Description</th><th>Date Added</th><th>Actions</th></tr></thead>
                <tbody>
                <?php $no = 1;
                if (mysqli_num_rows($result) > 0):
                    while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td style="color:var(--text-light);font-size:0.8rem;"><?= $no++ ?></td>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div style="width:36px;height:36px;background:var(--green-pale);border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--green-main);">
                                    <i class="bi bi-book-fill"></i>
                                </div>
                                <strong><?= htmlspecialchars($row['subject_name']) ?></strong>
                            </div>
                        </td>
                        <td style="color:var(--text-light);"><?= htmlspecialchars($row['description'] ?: '—') ?></td>
                        <td style="color:var(--text-light);font-size:0.85rem;"><?= date('d M Y', strtotime($row['created_at'])) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="action-btn action-btn-edit"><i class="bi bi-pencil-fill"></i> Edit</a>
                            <a href="delete.php?id=<?= $row['id'] ?>" class="action-btn action-btn-delete ms-1" onclick="return confirm('Delete this subject?')"><i class="bi bi-trash-fill"></i> Delete</a>
                        </td>
                    </tr>
                <?php endwhile; else: ?>
                    <tr><td colspan="5"><div class="empty-state"><i class="bi bi-book d-block"></i><p>No subjects yet. <a href="create.php" style="color:var(--green-main);">Add your first subject →</a></p></div></td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include '../footer.php'; ?>