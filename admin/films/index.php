<?php 
require_once '../includes/header.php';

if (!isAdminLoggedIn()) {
    redirect('../login.php');
}

$films = [];
if ($db) {
    $stmt = $db->query("SELECT * FROM films ORDER BY year DESC, created_at DESC");
    $films = $stmt->fetchAll();
}
?>

<div class="sidebar">
    <div class="p-4 mb-3 border-bottom border-secondary border-opacity-25">
        <h4 class="fw-bold mb-0">IBIFF <span class="gold">INDIA</span></h4>
        <small class="text-muted">Admin Panel</small>
    </div>
    <nav class="nav flex-column">
        <a class="nav-link" href="../dashboard.php"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
        <a class="nav-link active" href="index.php"><i class="fas fa-film me-2"></i> Manage Films</a>
        <a class="nav-link" href="../gallery/index.php"><i class="fas fa-images me-2"></i> Manage Gallery</a>
        <a class="nav-link" href="../festival/index.php"><i class="fas fa-calendar-alt me-2"></i> Festival Schedule</a>
        <a class="nav-link" href="../messages.php"><i class="fas fa-envelope me-2"></i> Messages</a>
        <a class="nav-link" href="../settings.php"><i class="fas fa-cog me-2"></i> Settings</a>
        <div class="mt-auto p-4">
            <a class="btn btn-outline-danger btn-sm w-100" href="../logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
        </div>
    </nav>
</div>

<main class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Manage Films</h2>
        <a href="add.php" class="btn btn-gold"><i class="fas fa-plus me-2"></i> Add New Film</a>
    </div>

    <?php if($msg = getFlash('success')): ?>
        <div class="alert alert-success"><?php echo $msg; ?></div>
    <?php endif; ?>

    <div class="card admin-card p-4">
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
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
