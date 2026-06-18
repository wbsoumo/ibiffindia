<?php 
require_once '../includes/header.php';



$films = [];
if ($db) {
    $stmt = $db->query("SELECT * FROM films ORDER BY year DESC, created_at DESC");
    $films = $stmt->fetchAll();
}
?>

<section class="content"><div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Manage Films</h2>
        <a href="add.php" class="btn btn-gold"><i class="fas fa-plus me-2"></i> Add New Film</a>
    </div>

    <?php if($msg = getFlash('success')): ?>
        <div class="alert alert-success"><?php echo $msg; ?></div>
    <?php endif; ?>

    <div class="card card p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Poster</th>
                        <th>Title</th>
                        <th>Director</th>
                        <th>Year</th>
                        <th>Genre</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($films)): ?>
                        <tr><td colspan="6" class="text-center text-muted py-4">No films found.</td></tr>
                    <?php else: foreach($films as $film): ?>
                    <tr>
                        <td><img src="<?php echo strpos($film['poster'], 'http') === 0 ? $film['poster'] : '../../assets/uploads/posters/'.$film['poster']; ?>" class="rounded" width="50" height="70" style="object-fit: cover;" onerror="this.src='../../assets/images/hero-bg.png'"></td>
                        <td class="fw-bold"><?php echo htmlspecialchars($film['title']); ?></td>
                        <td><?php echo htmlspecialchars($film['director']); ?></td>
                        <td><?php echo $film['year']; ?></td>
                        <td><span class="badge bg-secondary"><?php echo htmlspecialchars($film['genre']); ?></span></td>
                        <td>
                            <a href="edit.php?id=<?php echo $film['id']; ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <a href="delete.php?id=<?php echo $film['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this film?');"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div></section>
<?php require_once '../includes/footer.php'; ?>
